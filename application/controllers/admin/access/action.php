<?php

class Admin_Access_Action_Controller extends Base_Controller {

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
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$required_fields 	= 	Utilites::prepare_validation('access_control');

		if(isset($income_data['id'])){
			
			$required_fields['name'] = Utilites::add_to_validation($required_fields['name'], 'unique:'.ucfirst($income_data['access']).',name,'.$income_data['id']);

		}else{

			$required_fields['name'] = Utilites::add_to_validation($required_fields['name'], 'unique:'.ucfirst($income_data['access']));
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$access = $income_data['access']::prepare_results_to_model($income_data);

		$access->save();

		if($access->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $access->name)), 'success');

			$data 				= 	array();
			$data["text"] 		= 	$success_message;
			$data["data_out"] 	= 	'work_area';
			$data["data_link"] 	= 	action('admin.access.home@index');
			$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.access_levels'));

			return View::make('assets.message_redirect', $data); 

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Delete Access level by 
	 * provided id and access type
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$required_fields 	= 	array('access' => 'required|in:useraccess,adminaccess');
		$validation 		= 	Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		if($income_data["delete"] == 'delete'){

			$status = $income_data['access']::delete($income_data["id"]);

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}