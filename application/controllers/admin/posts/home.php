<?php

class Admin_Posts_Home_Controller extends Base_Controller {

	/**
	 * Field settings received via Modules::where('name', '=', 'Module_Name')->only('settings')
	 * 
	 * @var array $fields_settings
	 */
	public static $fields_settings = array();


	/**
	 * Columns shown in table listing
	 * 
	 * @var array $fields_settings
	 */
	public static $listing_fields;


	/**
	 * Fields shown in editor
	 * 
	 * @var array $fields_settings
	 */
	public static $editor_fields; 


	/**
	 * Additions for dropdowns
	 * 
	 * @var array $fields_settings
	 */
	public static $additions = array(	'lang' 		=> 'langtable', 
										'access' 	=> 'useraccess', 
										'published' => 'publishing', 
										'section' 	=> 'sections');


	/**
	 * Show listing table with pagination
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();

		//Data used to build Pagination
		$data["page_num"] 		= 	Input::get('page', 1);
		$data["take"] 			= 	Input::get('show', 4);

		$data["table_name"]		= 	'posts';
		$data["table_records"]	= 	Filedb::get_table_records('Posts');
		$data 					= 	array_merge($data, Utilites::show_by_logic($data["table_records"]));
		$pag_res		 		= 	Posts::left_join('*', 'posts.section', '=', 'sections.id')->group('section', array('order', 'ASC'), array('order', 'max', 'max_order'))->paginate($data["take"]);
		$data["pagination"] 	= 	$pag_res->appends(array('show' => $data["take"]))->links();
		$data['posts_by_'.$data["take"].'_disabled'] = 'disabled';
		
		//Data used to build listing table
		$data["page"] 			= 	'admin.posts.listing';
		$data["posts"] 			= 	$pag_res->results;
		ksort($data["posts"]);

		//Listing table settings
		$data["listing_columns"] = static::$listing_fields;
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Load more rows
	 * 
	 * @return Laravel\View
	 */
	public function action_load_more(){

		$data 					= 	array();
		$data["page"] 			= 	'admin.posts.row';
		$data["table_records"]	= 	Filedb::get_table_records('Posts');

		$data["page_num"] 		= 	Input::get('page', 1);
		$data["take"] 			= 	Input::get('show', 4);

		$pag_res		 		= 	Posts::where_in('section', Input::get('section', null))->add('order', 'max', 'max_order')->order_by('order')->paginate($data["take"]);
		$data["pagination"] 	= 	$pag_res->appends(array('show' => $data["take"]))->links();
		$data["post_group"] 	= 	$pag_res->results;

		$data["listing_columns"] = static::$listing_fields;

		return View::make($data["page"], $data);
	}



	/**
	 * Show post editor
	 * 
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.posts.home@index');
		}

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"]			= 	'admin.posts.edit';
		$data["post"] 			= 	Posts::find($id);

		static::$fields_settings['related']["options"] = Posts::where('lang', '<>', $data["post"]->lang)->group('lang')->get();
		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["post"]));
		$data["json"]			= 	static::$editor_fields;
		
		if(static::$fields_settings['related']["options"]){
			
			foreach(static::$fields_settings['related']["options"] as $group => $row){

				$related['related_'.$group] = null;
			}

			$data["json"]["related"] = $related;
		}

		$data["json_save"]		= 	Utilites::json_with_js_encode($data["json"], $data["post"]->id);
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show post new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"]			= 	'admin.posts.new';

		$data["no_json"]["id"] 	= '';
		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $data["no_json"]);

		static::$fields_settings['related']["options"] = Posts::group('lang')->get();
		
		if(static::$fields_settings['related']["options"]){

			foreach (static::$fields_settings['related']["options"] as $group => $row){

				$related['related_'.$group] = null;
			}

			$data["fields"]["related"] = $related;
		}

		$data["json_save"]		= 	Utilites::json_with_js_encode($data["fields"]);
		$data["fields"] 		= 	static::prepare_fields($data["fields"]);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Prepare fields for Utilites::html_form_build() method
	 * 
	 * @param  array $fields
	 * @return array
	 */
	private static function prepare_fields($fields){

		$result = array();
		$default_attr = array('class' => 'span12');

		foreach($fields as $key => $value) {
			
			if(isset(static::$fields_settings[$key]) && in_array($key, array_keys(static::$editor_fields))){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => (Lang::has('placeholders.'.$key)) ? __('placeholders.'.$key) : __('forms.'.$key.'_word') )));
			}
		}

		return $result;
	}
}