<?php

class Lang_Controller extends Base_Controller {
	
	public function action_index($lang=null)
	{
		if($lang)
		{ 
			Session::put('lang', $lang);
			Cookie::forever('lang', $lang);
			return Redirect::to(Session::get('href.previous'));
		}
	}

}