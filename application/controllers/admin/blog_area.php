<?php

class Admin_Blog_Area_Controller extends Base_Controller {

	public function action_index($id=null)
	{	
		if(!Admin::check()){

			return Redirect::to('admin/login');

		}else{

			if(is_null($id)){
				return Redirect::to('admin/blog_list');
			}

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.blog.blog_area')
							->with('post', Blog::find($id));
			}else{
				return View::make('admin.assets.no_ajax')
							->with('post', Blog::find($id))
							->with('page', 'admin.blog.blog_area');
			}
		}
	}

	public function action_new()
	{	
		if(!Admin::check()){

			return Redirect::to('admin/login');

		}else{
			
			Session::put('href.previous', URL::current());

			$blog 				= 	new stdClass;
			$blog->id 			= 	'new';
			$blog->title 		= 	null;

			$blog->text 		= 	null;

			$blog->section 		= 	null;
			$blog->access 		= 	null;
			$blog->media 		= 	null;
			$blog->tags 		= 	null;
			$blog->lang 		= 	null;

			$blog->created_at 	= 	null;
			$blog->updated_at 	= 	null;

			if (Request::ajax())
			{
				return View::make('admin.blog.blog_area_new')->with('post', $blog);
			}else{
				return View::make('admin.assets.no_ajax')
							->with('post', $blog)
							->with('page', 'admin.blog.blog_area_new');
			}
		}
	}

	public function action_save()
	{	
		
		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$blog 				= 	new stdClass;
			$blog->id 			= 	$json_arr["id"];
			$blog->title 		= 	rawurldecode($json_arr["title"]);

			$blog_text 			= 	rawurldecode($json_arr["text"]);
			$blog->text 		= 	preg_replace('#<br>#i', "\n", $blog_text);

			$blog->access 		= 	$json_arr["access"];
			$blog->tags 		= 	rawurldecode($json_arr["tags"]);
			$blog->lang 		= 	$json_arr["lang"];
			$blog->published 	= 	$json_arr["published"];


			if(	empty($blog->title) || empty($blog->text) || empty($blog->access))
			{

				$errors = '';
				if(empty($blog->title))
				{
					$errors .= '<li>'.Lang::line('forms.post_title_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($blog->text))
				{
					$errors .= '<li>'.Lang::line('forms.post_text_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($blog->access))
				{
					$errors .= '<li>'.Lang::line('forms.post_access_err')
										->get(Session::get('lang')).'</li>';
				}
				
				$error_area = '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';

				$blog_default 		= 	Blog::find($blog->id);
				$blog->created_at 	= 	$blog_default->created_at;
				$blog->updated_at 	= 	$blog_default->updated_at;

				return View::make('admin.blog.blog_area')
							->with('post', $blog)
							->with('status', $error_area);
			
			}else{

				$status = Blog::where('id', '=', $blog->id)->update(array(	'title' 	=> 	$blog->title,
																			'text' 		=> 	$blog->text,
																			'access' 	=> 	$blog->access,
																			'tags' 		=> 	$blog->tags,
																			'published' => 	$blog->published,
																			'lang' 		=> 	$blog->lang));

				if($status !== 0){
					
					return View::make('admin.blog.blog_area')
								->with('post', Blog::find($blog->id ))
								->with('status', Lang::line('content.saved_word')->get(Session::get('lang')));
				
				}else{

					return View::make('admin.blog.blog_area')
								->with('post', Blog::find($blog->id ))
								->with('status', Lang::line('forms.undefined_err_word')->get(Session::get('lang')));		
				}
			}
		}
	}

	public function action_add()
	{	
		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$errors 			= 	null;
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$blog 				= 	new stdClass;
			$blog->id 			= 	'new';
			$blog->title 		= 	rawurldecode($json_arr["title"]);

			$blog_text 			= 	rawurldecode($json_arr["text"]);
			$blog->text 		= 	preg_replace('#<br>#i', "\n", $blog_text);

			$blog->access 		= 	$json_arr["access"];
			$blog->tags 		= 	rawurldecode($json_arr["tags"]);
			$blog->lang 		= 	$json_arr["lang"];
			$blog->published 	= 	$json_arr["published"];

			//CHECK SAME TITLE
			$sTitle = Blog::where('title', '=', $blog->title)
						->only('title');
			

			if(	empty($blog->title)  
				|| empty($blog->text) 
				|| empty($blog->access))
			{

				if(empty($blog->title))
				{
					$errors .= '<li>'.Lang::line('forms.post_title_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($blog->text))
				{
					$errors .= '<li>'.Lang::line('forms.post_text_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($blog->access))
				{
					$errors .= '<li>'.Lang::line('forms.post_access_err')
										->get(Session::get('lang')).'</li>';
				}
				
				$errors = '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';
			
			}
			elseif(isset($sTitle)){
				
				$errors .= '<li>'.Lang::line('forms.same_title_err')->get(Session::get('lang')).'</li>';
				$errors = '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';

			}
			
			if($errors == null){
				$newId = Blog::insert(array(	'title' 	=> 	$blog->title,
												'text' 		=> 	$blog->text,
												'access' 	=> 	$blog->access,
												'qr_code'	=> 	null,
												'lang' 		=> 	$blog->lang,
												'tags' 		=> 	$blog->tags,
												'published' => 	$blog->published));

				if($newId !== 0){

					return Redirect::to('admin/blog_area/'.$newId);

				}else{

					return View::make('admin.blog.blog_area_new')
							->with('post', $blog)
							->with('status', Lang::line('forms.undefined_err_word')
													->get(Session::get('lang'))
								);

				}

			}else{

				return View::make('admin.blog.blog_area_new')
						->with('post', $blog)
						->with('status', $errors);

			}

		}
	}


	public function action_publish(){

		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$blog 				= 	new stdClass;
			$blog->id 			= 	$json_arr["id"];

			if(Blog::find($blog->id)->published){

				Blog::where('id', '=', $blog->id)->update(array('published' => 0));

			}else{

				Blog::where('id', '=', $blog->id)->update(array('published' => 1));

			}


			return View::make('admin.blog.blog_list')->with('posts', Blog::order_by('created_at', 'DESC')->get());
		}

	}


	public function action_delete(){

		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$blog 				= 	new stdClass;
			$blog->id 			= 	$json_arr["id"];
			$blog->delete 		= 	$json_arr["delete"];

			if($blog->delete == 'delete'){
				
				$status = Blog::delete($blog->id);

				if($status){

					return View::make('admin.blog.blog_list')->with('posts', Blog::order_by('created_at', 'DESC')->get());

				}else{

					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
					
				}

			}
		}

	}

}