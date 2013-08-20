<?php

class Templates_Iforgot_Controller extends Templates_Base_Controller {


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
	public function post_recover(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		return Utilites::password_recovery($income_data["email"]);
	}
}