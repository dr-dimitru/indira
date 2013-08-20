<?php

class Templates_Pages_Controller extends Templates_Base_Controller {


	/**
	 * Make view of index page.
	 * If no page is set as main
	 * We will make an listing of
	 * all sections and posts
	 * 
	 * @return Laravel\View
	 */
	public function action_index()
	{	

		Session::put('href.previous', URL::current());

		$data 					= array();
		$data["canonical_url"]	= URL::to('/');

		$page 	= 	Pages::where('main', '=', 'true')
					->and_where('lang', '=', Session::get('lang'))
					->and_where('published', '=', 'true');
		
		if(TMPLT_TYPE == 'mobile' && DEVICE_TYPE == 'phone'){

			$page->and_where('is_mobile', '=', 'true');
		
		}else{

			$page->and_where('is_mobile', '=', 'false');
		}

		$page = $page->get();

		if($page){

			foreach ($page as $page_data) {

				$data["page_data"] = $page_data;

				if((int) $page_data->access > (int) Session::get('user.access')){

					return parent::_401();
				}

				if(TMPLT_TYPE == 'mobile' && $page_data->template_mobile && $page_data->template_mobile !== 'false'){

					Indira::set_template($page_data->template_mobile);
					parent::set_assets();
				
				}elseif($page_data->template){

					Indira::set_template($page_data->template);
					parent::set_assets();
				}
				
				if($page_data->content){

					$data["pattern"] = $page_data->content;
				
				}else{

					$data["pattern"] = View::make('page_patterns.'.$page_data->pattern, $data);
				}
			}

		}else{

			return static::content_listing();
		}

		return (Request::ajax()) ? $data["pattern"] : View::make('templates::main', $data);
	}


	/**
	 * Make view of Page by provided "pretty link"
	 * 
	 * @param  string $page
	 * @return Laravel\View
	 */
	public function action_page($page_link)
	{	
		Session::put('href.previous', URL::current());

		$data = array();

		$page = Pages::where('link', '=', rawurldecode($page_link))->and_where('published', '=', 'true')->get();

		if($page){

			foreach ($page as $page_data) {

				$data["page_data"] = $page_data;

				if((int) $page_data->access > (int) Session::get('user.access')){

					return parent::_401();
				}

				
				if(TMPLT_TYPE == 'mobile' && $page_data->template_mobile && $page_data->template_mobile !== 'false'){

					Indira::set_template($page_data->template_mobile);
					parent::set_assets();
				
				}elseif($page_data->template && $page_data->template !== 'false'){

					Indira::set_template($page_data->template);
					parent::set_assets();
				}

				$data["canonical_url"] 	= 	URL::to_asset($page_data->link);
				$data["title"] 			= 	Utilites::build_title(array(Indira::get('name'), $page_data->title));
				
				if($page_data->content){

					$data["pattern"] 	= 	$page_data->content;
				
				}else{

					$data["pattern"] 	= 	View::make('page_patterns.'.$page_data->pattern, $data);
				}
			}

			return (Request::ajax()) ? $data["pattern"] : View::make('templates::main', $data);

		}else{

			$data["page"] = 'templates::assets.page_not_exists';
			return (Request::ajax()) ? Response::view($data["page"], $data) : Response::view('templates::main', $data)->status(404);
		}
	}


	/**
	 * Make view of all sections and posts
	 * for current language. If sections and posts
	 * module is turned on. And last 10 blog posts.
	 * If Blog module is turned on.
	 * 
	 * @return Laravel\View
	 */
	static function content_listing(){

		if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active') || Indira::get('modules.blog.active')){


			if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active')){
				
				$data["sections"] 	= 	Sections::where('lang', '=', Session::get('lang'))
										->order_by('order')
										->add('id', 'count', 'qty')
										->get();

				$data["posts"] 		= 	Posts::where('lang', '=', Session::get('lang'))
										->and_where('published', '=', 'true')
										->and_where('access', '<=', Session::get('user.access'))
										->group('section', array('order', 'ASC'))
										->get();
			}

			if(Indira::get('modules.blog.active')){

				$data["blogs"] 		= 	Blog::where('lang', '=', Session::get('lang'))
										->and_where('published', '=', 'true')
										->and_where('access', '<=', Session::get('user.access'))
										->order_by('order')
										->limit(0, 10)
										->get();
			}

			if(isset($data["sections"]) && isset($data["posts"]) && $data["sections"] && $data["posts"]){

				
				$data["posts_link"] 	= 	Indira::get('modules.posts.link');
				$data["sections_link"] 	= 	Indira::get('modules.sections.link');
				$data["page"] 			= 	'templates::content_listing';

			}elseif(isset($data["blog"]) && $data["blog"]){

				$data["blog_link"] 		= 	Indira::get('modules.blog.link');
				$data["page"] 			= 	'templates::content_listing';
			
			}else{

				$data["page"] = 'templates::assets.no_content';
			}

			$data["images"] = Media::get(array('id', 'formats'));

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return void;
		}
	}
}