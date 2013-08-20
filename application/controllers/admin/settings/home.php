<?php

class Admin_Settings_Home_Controller extends Base_Controller {


	/**
	 * Make view with listing table
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["page"] 		= 	'admin.settings.listing';
		$data["settings"] 	= 	Settings::group_by('type')->get();

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view with editor
	 * 
	 * @param  string $type setting type
	 * @return Laravel\View
	 */
	public function action_edit($type){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["type"] 		= 	rawurldecode($type);
		$data["page"] 		= 	'admin.settings.edit';
		$data["setting"] 	= 	Settings::where('type', '=', $data["type"])->get();

		foreach($data["setting"] as $row){

			if(is_object($row->value)){

				${$row->id}[$row->param] = $row->value;
				$data['form_'.$row->id] = Utilites::echo_objects_form(${$row->id}, 'SEMANTICAL');
				$data['json_save_'.$row->id] = Utilites::json_with_js_encode(Utilites::empty_values(${$row->id}), 'SEMANTICAL');
			}
		}

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}