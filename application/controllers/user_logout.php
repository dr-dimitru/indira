<?php

class User_logout_Controller extends Base_Controller {
	
	public function action_index()
	{
	    Session::forget('user');
	    Cookie::forget('userdata_id');
	    return View::make('assets.auth')->with(array('redirect' => true));
	}

}