<?php

class Admin_Logout_Controller extends Base_Controller {
	
	public function action_index()
	{
		Session::forget('admin');
		Cookie::forget('admin_id');
		return Redirect::to('admin');
	}

}