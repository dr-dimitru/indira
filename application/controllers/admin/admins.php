<?php

class Admin_Admins_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.admins.admins_list');
			}else{
				return View::make('admin.assets.no_ajax')
							->with('page', 'admin.admins.admins_list');
			}

		}
	}

	public function action_new(){
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			Session::put('href.previous', URL::current());
			
			$admin 				= 	new stdClass;
			$admin->id 			= 	'new';
			$admin->name 		= 	null;
			$admin->password 	= 	null;
			$admin->access 		= 	null;
			$admin->email 		= 	null;

			if (Request::ajax())
			{
				return View::make('admin.admins.admins_new')->with('admin', $admin);
			}else{
				return View::make('admin.assets.no_ajax')
							->with('admin', $admin)
							->with('page', 'admin.admins.admins_new');
			}
		}
	}
}