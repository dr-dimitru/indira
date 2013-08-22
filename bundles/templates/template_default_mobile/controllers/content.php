<?php

class Templates_Content_Controller extends Templates_Base_Controller {


	/**
	 * Make view of post by provided id or "pretty link"
	 * 
	 * @param  string|int  $name
	 * @return Laravel\View
	 */
	public function action_posts($name)
	{	

		if(Indira::get('modules.posts.active')){

			Session::put('href.previous', URL::current());

			$data 			= array();
			$data["post"] 	= (is_numeric($name)) ? Posts::find($name) : Posts::find(rawurldecode($name), 'link');
			$data["page"]	= 'templates::posts.main';

			if($data["post"]->id){

				if($data["post"]->published !== 'true' && !Admin::check()){
					
					return parent::_404();
				}

				if((int) $data["post"]->access > (int) Session::get('user.access')){

					return parent::_401();
				}

				if($data["post"]->lang !== Session::get('lang')){

					if(isset($data["post"]->related->{'related_'.Session::get('lang')})){
						
						if($data["post"]->related->{'related_'.Session::get('lang')} !== 'false'){

							$data["post"] = Posts::find($data["post"]->related->{'related_'.Session::get('lang')});

						}
					}
				}

				if($data["post"]->image){
					
					$image   			= 	Media::find($data["post"]->image);
					$data["post_image"] = 	$image->formats->mobile_header;
					$data["image"] 		= 	asset($image->formats->social);
				}

				$data["keywords"] 		= 	$data["post"]->tags;
				$data["description"] 	= 	($data["post"]->short) ? $data["post"]->short : ucfirst(strtolower(substr(strip_tags($data["post"]->text), 0, 600)));
				$data["section"] 		= 	Sections::find($data["post"]->section);
				$data["title"] 			= 	Utilites::build_title(array(Indira::get('name'), $data["section"]->title, $data["post"]->title));
				$link 					= 	($data["post"]->link) ? $data["post"]->link : $data["post"]->id;
				$data["canonical_url"] 	= 	URL::to_asset(Indira::get('modules.posts.link')).'/'.$link;

			}else{

				return parent::_404();
			}

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return parent::_404();
		}
	}


	/**
	 * Make view of blog-post by provided id or "pretty link"
	 * 
	 * @param  string|int  $name
	 * @return Laravel\View
	 */
	public function action_blog($name)
	{	
		if(Indira::get('modules.blog.active')){

			Session::put('href.previous', URL::current());

			$data 			= array();
			$data["blog"] 	= (is_numeric($name)) ? Blog::find($name) : Blog::find(rawurldecode($name), 'link');
			$data["page"]	= 'templates::blog.main';

			if($data["blog"]->id){

				if((int) $data["blog"]->access > (int) Session::get('user.access')){

					return parent::_401();
				}

				if($data["blog"]->published !== 'true' && !Admin::check()){
					
					return parent::_404();
				}

				if($data["blog"]->image){
					
					$image   			= 	Media::find($data["blog"]->image);
					$data["post_image"] = 	$image->formats->mobile_header;
					$data["image"] 		= 	asset($image->formats->social);
				}

				$data["previous"] 	= 	Blog::where('order', '<', $data["blog"]->order)
										->and_where('lang', '=', Session::get('lang'))
										->order_by('order', 'DESC')
										->first(array('id', 'title', 'link', 'order'));
				
				if(!isset($data["previous"]->id) || empty($data["previous"]->id)){

					unset($data["previous"]);
				}

				$data["next"] 		= 	Blog::where('order', '>', $data["blog"]->order)
										->and_where('lang', '=', Session::get('lang'))
										->order_by('order', 'ASC')
										->first(array('id', 'title', 'link', 'order'));

				if(!isset($data["next"]->id) || empty($data["next"]->id)){

					unset($data["next"]);
				}

				$data["keywords"] 		= 	$data["blog"]->tags;
				$data["description"] 	= 	($data["blog"]->short) ? $data["blog"]->short : ucfirst(strtolower(substr(strip_tags($data["blog"]->text), 0, 600)));
				$data["title"] 			= 	Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $data["blog"]->title));
				$link 					= 	($data["blog"]->link) ? $data["blog"]->link : $data["blog"]->id;
				$data["canonical_url"] 	= 	URL::to_asset(Indira::get('modules.blog.link')).'/'.$link;

			}else{

				return parent::_404();
			}

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return parent::_404();
		}
	}


	/**
	 * Make view of section by provided id or "pretty link"
	 * 
	 * @param  string|int  $name
	 * @return Laravel\View
	 */
	public function action_sections($name)
	{	

		if(Indira::get('modules.sections.active')){

			Session::put('href.previous', URL::current());
			$data 			= array();
			$data["section"]= (is_numeric($name)) ? Sections::find($name) : Sections::find(rawurldecode($name), 'link');
			$data["page"]	= 'templates::sections.main';

			if($data["section"]->id){

				$data["posts"] 			= 	Posts::where('section', '=', $data["section"]->id)
											->and_where('published', '=', 'true')
											->and_where('access', '<=', Session::get('user.access'))
											->order_by('order')
											->add('id', 'count', 'qty')
											->get();

				$data["images"] 		= 	Media::get(array('id', 'formats'));

				$data["title"] 			= 	Utilites::build_title(array(Indira::get('name'), $data["section"]->title));
				$link 					= 	($data["section"]->link) ? $data["section"]->link : $data["section"]->id;
				$data["canonical_url"] 	= 	URL::to_asset(Indira::get('modules.sections.link')).'/'.$link;

			}else{

				return parent::_404();
			}

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return parent::_404();
		}
	}


	/**
	 * Make view of all sections and posts
	 * for current language. If sections and posts
	 * module is turned on.
	 * 
	 * @return Laravel\View
	 */
	static function action_posts_listing()
	{

		if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active')){

			Session::put('href.previous', URL::current());

			$data["title"]			= 	Utilites::build_title(array(Indira::get('name'), 'templates::content.posts_word'));
			$data["canonical_url"]	= 	URL::to(Indira::get('modules.posts.link'));

			$data["sections"] 		= 	Sections::where('lang', '=', Session::get('lang'))
										->order_by('order')
										->add('id', 'count', 'qty')
										->get();

			$data["posts"] 			= 	Posts::where('lang', '=', Session::get('lang'))
										->and_where('published', '=', 'true')
										->and_where('access', '<=', Session::get('user.access'))
										->group('section', array('order', 'ASC'))
										->get();

			$data["images"] 		= 	Media::get(array('id', 'formats'));

			$data["page"] = ($data["sections"] && $data["sections"]) ? 'templates::posts.listing' : 'templates::assets.no_content';

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return parent::_404();
		}
	}


	/**
	 * Get last 10 blog-posts 
	 * with pagination.
	 * 
	 * @return Laravel\View
	 */
	static function action_blog_listing()
	{

		if(Indira::get('modules.blog.active')){

			Session::put('href.previous', URL::current());

			$data 					= 	array();
			$data["page_num"] 		= 	Input::get('page', 1);
			$take 					= 	Input::get('show', 10);
			$data["title"]			= 	Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word'));
			$data["canonical_url"]	= 	URL::to(Indira::get('modules.blog.link'));
			$data["images"] 		= 	Media::get(array('id', 'formats'));

			$pag_res 				= 	Blog::where('lang', '=', Session::get('lang'))
										->and_where('published', '=', 'true')
										->and_where('access', '<=', Session::get('user.access'))
										->order_by('order')
										->add('id', 'count', 'qty')
										->paginate($take);

			$data["blogs"] 			= 	$pag_res->results;
			$data["pagination"] 	= 	$pag_res->appends(array('show' => $take))->links();

			$data["page"] = ($data["blogs"]) ? 'templates::blog.listing' :'templates::assets.no_content';

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);

		}else{

			return parent::_404();
		}
	}


	/**
	 * Prepare data and return
	 * Sidebar view
	 * 
	 * @return Laravel\View
	 */
	static function action_sidebar(){

		//Main data
		$data 				= 	array();
		$data["posts"] 		= 	Posts::where('lang', '=', Session::get('lang'))
								->and_where('access', '<=', Session::get('user.access'))
								->and_where('published', '=', 'true')
								->group('section', array('order', 'ASC'))
								->get();

		$data["sections"] 	= 	Sections::where('lang', '=', Session::get('lang'))
								->order_by('order')
								->get();

		foreach (Userssettings::get(array('param', 'value', 'id')) as $file_id => $row) {
				
			$settings[$row->param] = $row->value;
		}

		$data["user_id"] = Session::get('user.id');
		list($listing_fields, $fields_settings, $editor_fields, $frontend_fields) = Utilites::prepare_module_settings('users');
		$deafult_attributes = array('class' => 'form-control');


		//Included views data
		//templates::user.edit
		if(Session::get('user.id')){

			if($user = Users::where_id($data["user_id"])->get($frontend_fields)){

				$user_fields = array();
				$user_fields = Filedb::object_to_array($user->$data["user_id"]);

				if($settings["promocodes_active"] == 'true' && $settings["promocodes_on_signup"] == 'true'){

					$user_fields = array_merge($user_fields, array('promocode' => Promocodes::where('owner', '=', Session::get('user.email'))->only('code')));
				}

				foreach($user_fields as $key => &$value) {
						
					if(in_array($key, $frontend_fields)){

						$options = (isset($fields_settings[$key]['options'])) ? $fields_settings[$key]['options'] : null;
						$attributes = (isset($fields_settings[$key]['attributes'])) ? $fields_settings[$key]['attributes'] : array();

						$data["edit_user_form_fields"][$key] = array('type' => $fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $deafult_attributes, array('placeholder' => (Lang::has('templates::content.'.$key)) ? __('templates::content.'.$key) : __('forms.'.$key.'_word') )));

						$data["json_edit_user_form"][$key] = null;
					}

					unset($key, $value);
				}
				unset($user_fields);
			
			}else{

				$data["edit_user_form_fields"] = $frontend_fields;
			}
		}


		//Templates::user.sign
		$fields = array();
		$model = Users::get_model(false, true);

		if($settings["promocodes_active"] == 'true' && $settings["promocodes_on_signup"] == 'true'){

			$model = array_merge($model, array('promocode' => ''));
		}

		foreach($model as $key => &$value) {
				
			if(in_array($key, $frontend_fields)){

				$options = (isset($fields_settings[$key]['options'])) ? $fields_settings[$key]['options'] : null;
				$attributes = (isset($fields_settings[$key]['attributes'])) ? $fields_settings[$key]['attributes'] : array();

				$data["user_sign_form_fields"][$key] = array('type' => $fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $deafult_attributes, array('placeholder' => (Lang::has('templates::content.'.$key)) ? __('templates::content.'.$key) : __('forms.'.$key.'_word') )));

				$json_user_sign_form[$key] = null;
			}

			unset($key, $value);
		}
		unset($model);

		$json_user_sign_form['notify_via_email'] = 'true';
		$data["json_user_sign_form"] = array_diff_key($json_user_sign_form, array('id' => ''));


		//Templates::assets.language_selector
		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		if(isset($income_data["uri"])){
			
			$data["language_selector_url"] = $income_data["uri"];
		}

		return View::make('templates::assets.sidebar', $data);
	}
}