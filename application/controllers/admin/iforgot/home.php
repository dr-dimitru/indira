<?php
class Admin_Iforgot_Home_Controller extends Base_Controller {


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;
	

	/**
	 * Reset Admin's password
	 * 
	 * @return string
	 */
	public function post_index(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		return Utilites::password_recovery($income_data["email"], true);
	}
}