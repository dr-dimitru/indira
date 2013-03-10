<?php

class Admin_Post_Area_Controller extends Base_Controller {

	public $restful = true;

	public function post_index()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');
		
		}else{
			
			$id 	= 	stripcslashes(Input::get('data'));

			if (Request::ajax())
			{
				return View::make('admin.posts.post_area')
							->with('post', Posts::find($id));
			}else{
				return View::make('admin.assets.no_ajax')
							->with('post', Posts::find($id))
							->with('page', 'admin.posts.post_area');
			}
		}
	}

	public function get_new()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');
		
		}else{
		
			$post 				= 	new stdClass;
			$post->id 			= 	'new';
			$post->title 		= 	null;

			$post->text 		= 	null;

			$post->section 		= 	null;
			$post->access 		= 	null;
			$post->media 		= 	null;
			$post->tags 		= 	null;
			$post->lang 		= 	null;

			$post->created_at 	= 	null;
			$post->updated_at 	= 	null;

			if (Request::ajax())
			{
				return View::make('admin.posts.post_area_new')
							->with('post', $post);
			}else{
				return View::make('admin.assets.no_ajax')
							->with('post', $post)
							->with('page', 'admin.posts.post_area_new');
			}
		}
	}

	public function post_save()
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

			$post 				= 	new stdClass;
			$post->id 			= 	$json_arr["id"];
			$post->title 		= 	rawurldecode($json_arr["title"]);

			$post_text 			= 	rawurldecode($json_arr["text"]);
			$post->text 		= 	preg_replace('#<br>#i', "\n", $post_text);

			$post->section 		= 	$json_arr["section"];
			$post->access 		= 	$json_arr["access"];
			$post->media 		= 	$json_arr["media"];
			$post->tags 		= 	rawurldecode($json_arr["tags"]);
			$post->lang 		= 	$json_arr["lang"];


			if(!empty($post->media))
			{
				$post->media 	= 	trim($post->media);
				$media_arr 		= 	explode(" ", $post->media);
				$post->media 	= 	implode(",", $media_arr);
			}
			else{
				$post->media = null;
			}

			if(	empty($post->title) || empty($post->section) || empty($post->text) || empty($post->access))
			{

				$errors = '';
				if(empty($post->title))
				{
					$errors .= '<li>'.Lang::line('forms.post_title_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->text))
				{
					$errors .= '<li>'.Lang::line('forms.post_text_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->section))
				{
					$errors .= '<li>'.Lang::line('forms.post_section_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->access))
				{
					$errors .= '<li>'.Lang::line('forms.post_access_err')
										->get(Session::get('lang')).'</li>';
				}
				
				return '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';
			
			}else{

				$status = Posts::where('id', '=', $post->id)->update(array(	'title' 	=> 	$post->title,
																			'text' 		=> 	$post->text,
																			'section' 	=> 	$post->section,
																			'access' 	=> 	$post->access,
																			'tags' 		=> 	$post->tags,
																			'lang' 		=> 	$post->lang,
																			'media' 	=> 	$post->media));

				if($status !== 0){
					
					return Lang::line('content.saved_word')
							->get(Session::get('lang'));
				
				}else{
				
					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
				
				}
			}
		}
	}

	public function post_add()
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

			$post 				= 	new stdClass;
			$post->id 			= 	'new';
			$post->title 		= 	rawurldecode($json_arr["title"]);

			$post_text 			= 	rawurldecode($json_arr["text"]);
			$post->text 		= 	preg_replace('#<br>#i', "\n", $post_text);

			$post->section 		= 	$json_arr["section"];
			$post->access 		= 	$json_arr["access"];
			$post->tags 		= 	rawurldecode($json_arr["tags"]);
			$post->lang 		= 	$json_arr["lang"];

			//CHECK SAME TITLE
			$sTitle = Posts::where('title', '=', $post->title)
						->only('title');
			

			if(	empty($post->title) 
				|| empty($post->section) 
				|| empty($post->text) 
				|| empty($post->access))
			{

				if(empty($post->title))
				{
					$errors .= '<li>'.Lang::line('forms.post_title_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->text))
				{
					$errors .= '<li>'.Lang::line('forms.post_text_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->section))
				{
					$errors .= '<li>'.Lang::line('forms.post_section_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($post->access))
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
				$newId = Posts::insert(array(	'title' 	=> 	$post->title,
												'text' 		=> 	$post->text,
												'access' 	=> 	$post->access,
												'section' 	=> 	$post->section,
												'media' 	=> 	null,
												'qr_code'	=> 	null,
												'lang' 		=> 	$post->lang,
												'tags' 		=> 	$post->tags));

				if($newId !== 0){

					return View::make('admin.posts.post_area')
							->with('post', Posts::find($newId))
							->with('status', Lang::line('content.saved_word')
								->get(Session::get('lang'))
							);

				}else{

					return View::make('admin.posts.post_area_new')
							->with('post', $post)
							->with('status', Lang::line('content.saved_word')
								->get(Session::get('lang'))
							);

				}

			}else{

				return View::make('admin.posts.post_area_new')
						->with('post', $post)
						->with('status', $errors);

			}

		}
	}


	public function post_delete(){

		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$post 				= 	new stdClass;
			$post->id 			= 	$json_arr["id"];
			$post->delete 		= 	$json_arr["delete"];

			if($post->delete == 'delete'){
				
				$status = Posts::delete($post->id);

				if($status){

					return View::make('admin.posts.posts_list');

				}else{

					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
					
				}

			}
		}

	}

}