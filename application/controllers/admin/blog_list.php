<?php

class Admin_Blog_List_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{
			
			Session::put('href.previous', URL::current());
			
			if (Request::ajax())
			{
				return View::make('admin.blog.blog_list')->with('posts', Blog::order_by('created_at', 'DESC')->get());
			}else{
				return View::make('admin.assets.no_ajax')
							->with('posts', Blog::order_by('created_at', 'DESC')->get())
							->with('page', 'admin.blog.blog_list');
			}

		}
	}

}