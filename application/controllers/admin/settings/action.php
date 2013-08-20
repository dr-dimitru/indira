<?php
class Admin_Settings_Action_Controller extends Base_Controller {


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
	 * Receive data via Input::get('data') as JSON.
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){

		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$setting 			= 	Settings::prepare_results_to_model($income_data);

		if(is_array($income_data['value'])){

			$setting->value = $income_data['value'][$setting->param];
		}
		$setting->save();

		return Utilites::alert(__('forms.saved_notification', array('item' => $setting->type.': '.$setting->param)), 'success');
	}
}