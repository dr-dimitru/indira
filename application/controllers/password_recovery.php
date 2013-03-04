<?php
class Password_Recovery_Controller extends Base_Controller {

	public $restful = true;
	
	public function post_index()
	{
		$json = stripcslashes(Input::get('data'));
		$json_arr = json_decode($json, true);

		$email = $json_arr["email"];

		return Utilites::password_recovery($email);
	}
}