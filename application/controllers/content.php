<?php

class Content_Controller extends Base_Controller {

	public function action_index()
	{	
		$content = Content::get_values(Session::get('lang'));
		return View::make('assets.content')->with('content', $content);
	}

}