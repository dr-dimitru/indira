<?php

class Admin_Posts_List_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.posts.posts_list');
			}else{
				return View::make('admin.assets.no_ajax')
							->with('page', 'admin.posts.posts_list');
			}

		}
	}

}