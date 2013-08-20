<?php

class Admin_Cache_Home_Controller extends Base_Controller {

	/**
	 * Make view of dev mode control panel
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data = array();
		$data["page"] 	= 'admin.cache.index';
		$data["driver"]	= Config::get('cache.driver');
		$data["cached"] = Cache::count();
		$data["blades"] = count(array_diff(scandir('storage/views/', 0), array('..', '.')));;

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}