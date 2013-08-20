<?php

class Admin_Admins_Action_Controller extends Base_Controller {


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
	 * Save new admin
	 * 
	 * @var Laravel\View
	 */
	public function post_save(){

		$data 				= 	array();
		$errors 			=	array();
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$admin 				= 	Admin::prepare_results_to_model($income_data);
		$original_password	= 	$income_data["password"];

		$required_fields 	= 	Utilites::prepare_validation('admins');

		if(strlen($income_data["password"]) == 0 && !Input::get('new')){

			$admin->password = $income_data["password"] = Admin::where('id', '=', $income_data["id"])->only('password');
		}

		if(strlen($income_data["password"]) > 28 && strlen($income_data["password"]) < 32 || strlen($income_data["password"]) > 33){

			$required_fields["password"] = 'required|max:28|min:5';
		}

		$validations[] = Validator::make($income_data, $required_fields);

		if(strlen($income_data["password"]) !== 32 && !empty($income_data["password"])){
			
			$admin->password = $income_data["password"] = md5($admin->password);
		}


		if(Input::get('new')){

			$required_fields['name'] = 'unique:Admin';
			$required_fields['email'] = 'unique:Admin';
			$required_fields['password'] = 'unique:Admin';

			$validations[] = Validator::make($income_data, $required_fields);
		}


		if(isset($admin->id)){

			$required_fields['name'] = 'unique:Admin,name,'.$admin->id;
			$required_fields['email'] = 'unique:Admin,email,'.$admin->id;
			$required_fields['password'] = 'unique:Admin,password,'.$admin->id;

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

			$admin->save();
		}

		if(isset($income_data["notify_via_email"]) && $income_data["notify_via_email"] == 'true'){

			Utilites::send_email(array($admin->email => $admin->name), __('emails.new_admin_text', array('name' => $admin->name, 'password' => $original_password, 'email' => $admin->email)), __('emails.new_admin_subject'));
		}

		if($admin->id !== 0){
			
			if(Input::get('new')){

				$data 				= 	array();
				$data["lang_line"] 	= 	Utilites::alert(__('admins.created', array('n' => $admin->name)), 'success');
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.admins.home@index');
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.admins_word'));

				return View::make('assets.message_redirect', $data); 

			}else{

				return Utilites::alert(__('forms.saved_notification', array('item' => $admin->name)), 'success');
			}
		
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
			
			$status = Admin::delete($data["id"]);

			return ($status) ? Utilites::success_message(__('forms.deleted_word')) : Utilites::fail_message(__('forms_errors.undefined'));
		}
	}
}