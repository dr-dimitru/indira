<?php

class Admin_Blog_List_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			return View::make('admin.blog.blog_list')->with('posts', Blog::all());

		}
	}

}