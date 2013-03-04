<?php

class Admin_Admins_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			return View::make('admin.admins.admins_list');

		}
	}

	public function action_new(){
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			$admin 				= 	new stdClass;
			$admin->id 			= 	'new';
			$admin->name 		= 	null;
			$admin->password 	= 	null;
			$admin->access 		= 	null;
			$admin->email 		= 	null;

			return View::make('admin.admins.admins_new')->with('admin', $admin);

		}
	}

}