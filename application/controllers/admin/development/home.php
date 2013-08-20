<?php

class Admin_Development_Home_Controller extends Base_Controller {

	/**
	 * Make view of dev mode control panel
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data = array();
		$data["page"] = 'admin.development.index';

		if(Indira::get('under_development')){

			$data["on"] = 'active';
			$data["off"] = null;
		
		}else{

			$data["on"] = null;
			$data["off"] = 'active';
		}

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}