<?php

class Admin_Cli_Home_Controller extends Base_Controller {

	/**
	 * Show CLI window
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 			= 	array();
		$data["page"] 	= 	'admin.cli.main';

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}