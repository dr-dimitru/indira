<?php

class Admin_Qrcode_Action_Controller extends Base_Controller {
	
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
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return Laravel\View
	 */
	public function post_save(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$qrcode 			= 	Qrcodegen::prepare_results_to_model($income_data);
		$required_fields 	= 	Utilites::prepare_validation('qrcode');
		$validation 		= 	Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$qrcode->url = str_replace('public/', '', Utilites::qrcode($income_data["data"], md5(time().$qrcode->title), $income_data["size"], 'public/qrcodes/', strtoupper($income_data["ecc"])));

		$qrcode->save();

		if($qrcode->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $qrcode->title)), 'success');

			$data 				= 	array();
			$data["text"] 		= 	$success_message;
			$data["data_out"] 	= 	'work_area';
			$data["data_link"] 	= 	action('admin.qrcode.home@index');
			$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.qrcode_generator'));

			return View::make('assets.message_redirect', $data);

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Delete QRCode by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){

			$status = Qrcodegen::delete($data["id"]);

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}