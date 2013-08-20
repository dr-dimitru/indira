<?php

class Admin_Users_Action_Controller extends Base_Controller {


	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 777;


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Columns shown in table listing
	 * 
	 * @var array $fields_settings
	 */
	public static $listing_fields;


	/**
	 * Serch throught Users table
	 * 
	 * @var Laravel\View
	 */
	public function post_search(){

		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$data 				= 	array();
		$data["page"] 		= 	'admin.users.search';
		$data["listing_columns"] = static::$listing_fields;
		$data["users"] 		= 	array();

		if($income_data["value"] && $income_data["field"]){

			$type = (in_array($income_data["type"], array('all', 'equal', 'like', 'soundex', 'similar'))) ? $income_data["type"] : 'all';
			$type = ($type == 'equal') ? '=' : $type;

			if($type == 'all'){
				
				$data["users"] 	= 	Users::where($income_data["field"], 'like', $income_data["value"])
									->or_where($income_data["field"], 'soundex', $income_data["value"])
									->or_where($income_data["field"], 'similar', $income_data["value"])
									->get(array_merge(static::$listing_fields, array('id')));
			
			}else{

				$data["users"] 	= 	Users::where($income_data["field"], $type, $income_data["value"])
									->get(array_merge(static::$listing_fields, array('id')));
			}


			if(Admin::check() != 777 && $data["users"]){
				
				foreach($data["users"] as $row => $column) {

					if(isset($column->email)){

					 	list($uemail, $domen) 			= 	explode("@", $column->email);
						$data["users"][$row]->email 	= 	"******@".$domen;
						$data["users"][$row]->name 		= 	"***in";
					}
				}
			}

			if(!$data["users"]){

				$data["message"] =  Utilites::fail_message(__('forms_errors.search.empty_result'));
			}

		}else{

			$data["message"] = Utilites::fail_message(__('forms_errors.search.empty_request'));
		}

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}

	/**
	 * Update User's setting
	 * 
	 * @var Laravel\View
	 */
	public function post_save_settings(){

		$data 				= 	array();
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$setting 			= 	Userssettings::find($income_data["id"]);
		$setting->value 	= 	$income_data["value"];
		$setting->save();

		return Redirect::to(action('admin.users.home@settings'));
	}


	/**
	 * Save new user
	 * 
	 * @var Laravel\View
	 */
	public function post_save(){

		$data 				= 	array();
		$errors 			=	array();
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$user 				= 	Users::prepare_results_to_model($income_data);
		$original_password	= 	$income_data["password"];
		$required_fields 	= 	Utilites::prepare_validation('users');

		foreach (Userssettings::get(array('param', 'value', 'id')) as $file_id => $row) {
			
			$settings[$row->param] = $row->value;
		}

		if($settings["promocodes_active"] == 'true'){

			if(isset($income_data["promocode"]) && !empty($income_data["promocode"]) && $settings["promocodes_on_signup"] == 'true'){

				if(Promocodes::where('code', '=', $income_data["promocode"])->get()){

					$promo = Promocodes::find($income_data["promocode"], 'code');
					$promo->used = 'true';

					if($promo->owner){

						if($promo->owner !== $income_data["email"]){

							return Utilites::fail_message('This is others promocode!');
						}

					}else{

						$promo->owner = $income_data["email"];
					}

					$income_data["access"] = $user->access = $promo->level;

					$promo->save();
				
				}else{

					return Utilites::fail_message('Wrong promocode provided!');
				}
			}
		}

		if(!isset($income_data["access"])){

			$income_data["access"] = $settings["default_access_level"];
		}
		
		if(strlen($income_data["password"]) == 0 && !Input::get('new')){

			$user->password = $income_data["password"] = Users::where('id', '=', $income_data["id"])->only('password');
		}

		if(strlen($income_data["password"]) > 28 && strlen($income_data["password"]) < 32 || strlen($income_data["password"]) > 33){

			$required_fields["password"] = 'required|max:28|min:5';
		}

		$validations[] = Validator::make($income_data, $required_fields);

		if(strlen($income_data["password"]) !== 32 && !empty($income_data["password"])){
			
			$user->password = $income_data["password"] = md5($user->password);
		}

		if(Input::get('new')){

			$required_fields['name'] = 'unique:Users';
			$required_fields['email'] = 'unique:Users';

			$validations[] = Validator::make($income_data, $required_fields);
		}


		if(isset($user->id)){

			$required_fields['name'] = 'unique:Users,name,'.$user->id;
			$required_fields['email'] = 'unique:Users,email,'.$user->id;

			$validations[] = Validator::make($income_data, $required_fields);
		}


		foreach ($validations as $validation) {
			
			if($validation->fails()){
					
				$errors[] = Utilites::compose_error($validation);
			}
			
			if(count($errors) > 1){
			
				return implode('', $errors);
			
			}elseif(!empty($errors)){

				return $errors[0];
			}
		}


		if(empty($errors)){

			$user->save();
		}

		if(isset($income_data["notify_via_email"]) && $income_data["notify_via_email"] == 'true'){

			Utilites::send_email(array($user->email => ucfirst($user->name)), __('emails.user_registration_text', array('name' => ucfirst($user->name), 'password' => $original_password, 'login' => $user->email)), __('emails.user_registration_subject'));
		}

		if($user->id !== 0){
			
			if(Input::get('new') && Input::get('frontend')){

				$data 						= 	array();
				$data["data_link"] 			= 	Session::get('href.previous');
				$data["success"] 			= 	true;
				$data["text"] 				= 	Utilites::alert(__('emails.user_registration_text', array('name' => ucfirst($user->name), 'password' => $original_password, 'login' => $user->email)), 'success');
				$data["location_replace"]	= 	true;
				Utilites::user_login($user->email, null, true);

			}elseif(Input::get('frontend')){

				$data 						= 	array();
				$data["data_link"] 			= 	Session::get('href.previous');
				$data["success"] 			= 	true;
				$data["text"] 				= 	Utilites::alert(__('forms.saved_word'), 'success');
				$data["location_replace"]	= 	true;
				Utilites::user_login($user->email, null, true);

			}elseif(Input::get('new')){

				$data 				= 	array();
				$data["lang_line"] 	= 	Utilites::alert(__('users.created', array('n' => $user->name)), 'success');
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.users.home@index');
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.users_word'));

			}else{

				return Utilites::alert(__('forms.saved_notification', array('item' => $user->name)), 'success');
			}

			return View::make('assets.message_redirect', $data); 
		
		}else{
		
			return Utilites::fail_message(__('forms_errors.undefined'));
		}
	}


	/**
	 * Delete user by provided id
	 * in Input::get('data') as JSON
	 * 
	 * @var string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){
			
			$status = Users::delete($data["id"]);

			return ($status) ? Utilites::success_message(__('forms.deleted_word')) : Utilites::fail_message(__('forms_errors.undefined'));
		}
	}
}