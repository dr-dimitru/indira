<?php

class Admin_Home_Controller extends Base_Controller {

	public function action_index()
	{	
		Session::put('href.previous', URL::current());

		if(!Admin::check()){

		 	return Redirect::to('admin/login');

		}else{

			return View::make('admin.logged_in');

		}
	}

}