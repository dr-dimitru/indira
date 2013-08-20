<?php

class Admin_Development_Action_Controller extends Base_Controller {

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
	 * Turn ON dev mode
	 * 
	 * @return Laravel\View
	 */
	public function post_on(){

		Settings::where_in('type', 'indira')->and_where('param', '=', 'under_development')->update(array('value' => 'true'));

		$data = array();
		$data["on"] = 'active';
		$data["off"] = null;

		Indira::set('indira.under_development');

		return View::make('admin.development.thumbler', $data);
	}


	/**
	 * Turn OFF dev mode
	 * 
	 * @return Laravel\View
	 */
	public function post_off(){

		Settings::where_in('type', 'indira')->and_where('param', '=', 'under_development')->update(array('value' => 'false'));

		$data = array();
		$data["on"] = null;
		$data["off"] = 'active';

		Indira::set('indira.under_development');

		return View::make('admin.development.thumbler', $data);
	}
}