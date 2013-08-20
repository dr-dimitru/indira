<?php

class Admin_Cli_Action_Controller extends Base_Controller {

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
	public function post_run(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		$text 	= array();
		$text[] = '<br /><strong> '.Session::get('admin.login').' $ </strong> '.$income_data["command"].'<br />';

		if(stripos($income_data["command"], ' ')){

			list($method, $param) = explode(' ', $income_data["command"]);

		}else{

			$method = $income_data["command"];
			$param = '';
		}

		try
		{
			$text[] = nl2br(Utilites::run_artisan($method, $param));
		}
		catch (\Exception $e)
		{
			$text[] = $e->getMessage();
		}
		
		return implode('', $text);
	}
}