<?php

class Admin_Languages_Action_Controller extends Base_Controller {


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
		$required_fields 	= 	Utilites::prepare_validation('languages');
		$validation 		= 	Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$language = Langtable::prepare_results_to_model($income_data);

		$language->save();

		if($language->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $language->text_lang)), 'success');

			$data 				= 	array();
			$data["text"] 		= 	$success_message;
			$data["data_out"] 	= 	'work_area';
			$data["data_link"] 	= 	action('admin.languages.home@index');
			$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.locales'));

			return View::make('assets.message_redirect', $data); 

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Delete language by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){

			$status = Langtable::delete($data["id"]);

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}