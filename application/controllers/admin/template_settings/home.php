<?php

class Admin_Template_Settings_Home_Controller extends Base_Controller {


	/**
	 * Show listing table
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();
		$data["page"] 			= 	'admin.template_settings.listing';
		$data["settings"] 		= 	Template::group('type', array('order', 'ASC'))->get();
		$templates 				= 	Templates::init();
		$data["d_templates"]	= 	$templates->where('is_mobile', '=', 'false')->get();
		$data["m_templates"]	= 	$templates->where('is_mobile', '=', 'true')->get();
		$data["mobile_active"]	= 	($templates->where('is_mobile', '=', 'true')->and_where('active', '=', 'true')->get()) ? true : false;

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}



	/**
	 * Show edit form by provided setting's $type
	 * 
	 * @param  string $type
	 * @return Laravel\View
	 */
	public function action_edit($type){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["type"] 		= 	rawurldecode($type);
		$data["page"] 		= 	'admin.template_settings.edit';
		$data["setting"] 	= 	Template::where('type', '=', $data["type"])->get();

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}