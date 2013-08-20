<?php

class Admin_Promocodes_Action_Controller extends Base_Controller {

	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 600;


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Generate random promocode 
	 * based on provided pattern
	 * 
	 * @return Laravel\View
	 */
	public function post_generator(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		$code			= 	str_split($income_data["code_pattern"]);
		$a_z_low 		= 	"abcdefghijklmnopqrstuvwxyz";
		$a_z_capital 	= 	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		for ($i=0; $i < (int) $income_data["code_qty"]; $i++) { 

			$promocode 		= 	array();

			foreach ($code as $symbol) {
				
				if(ctype_alpha($symbol)){

					$int = rand(0,25); 
	    			$promocode[] = (ctype_upper($symbol)) ? $a_z_capital[$int] : $a_z_low[$int];

				}elseif(ctype_digit($symbol)){

					$promocode[] = rand(0,9);
				
				}else{

					$promocode[] = $symbol;
				}
			}

			Promocodes::create(array('code' => implode('', $promocode), 'level' => $income_data["code_access_level"]));

			unset($promocode);
		}

		return Redirect::to_action('admin.users.home@settings');
	}


	/**
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return Laravel\View
	 */
	public function post_save(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$promocode 			= 	Promocodes::prepare_results_to_model($income_data);
		$required_fields 	= 	Utilites::prepare_validation('promocodes');
		$validation 		= 	Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$promocode->save();

		if($promocode->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $promocode->code)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.users.home@settings');
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.users_word', 'content.settings_word'));

				return View::make('assets.message_redirect', $data);

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Delete promocode by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){
			
			$status  = Promocodes::find($data["id"])->delete();

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}