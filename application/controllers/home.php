<?php

class Home_Controller extends Base_Controller {

	public function action_index()
	{	
		Session::put('href.previous', URL::current());
		return View::make('index.main')->with('title', null);
	}

}