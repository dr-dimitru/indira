<?php

class Admin_Sections_Home_Controller extends Base_Controller {

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
	public static $additions = array('lang' => 'langtable', 'parent' => 'sections');


	/**
	 * Show listing table with pagination
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();

		if(in_array('parent', static::$listing_fields) || in_array('parent_of', static::$listing_fields)){

			$data['all_sections'] = Sections::all();
		}

		//Data used to build Pagination
		$data["page_num"] 		= 	Input::get('page', 1);
		$data["take"] 			= 	Input::get('show', 2);

		$data["table_records"]	= 	Filedb::get_table_records('sections');
		$data 					= 	array_merge($data, Utilites::show_by_logic($data["table_records"]));

		$pag_res 				= 	Sections::order_by('order')
									->group('lang', array('order', 'ASC'), array('order', 'max', 'max_order'))
									->paginate($data["take"]);

		$data["pagination"] 	= 	$pag_res->appends(array('show' => $data["take"]))->links();
		$data['sections_by_'.$data["take"].'_disabled'] = 'disabled';

		//Data used to build listing table
		$data["page"] 			= 	'admin.sections.listing';
		$data["sections"] 		= 	$pag_res->results;
		ksort($data["sections"]);

		//Listing table settings
		$data["listing_columns"]= static::$listing_fields;

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Load more rows
	 * 
	 * @return Laravel\View
	 */
	public function action_load_more(){

		$data 					= 	array();
		$data["page"] 			= 	'admin.sections.row';
		$data["table_records"]	= 	Filedb::get_table_records('sections');

		$data["page_num"] 		= 	Input::get('page', 1);
		$data["take"] 			= 	Input::get('show', 2);
		$data["lang_key"] 		= 	Input::get('section', null);

		$pag_res		 		= 	Sections::where_in('lang', $data["lang_key"])
									->add('order', 'max', 'max_order')
									->order_by('order')
									->paginate($data["take"]);

		$data["pagination"] 	= 	$pag_res->appends(array('show' => $data["take"]))->links();
		$data["rows"] 			= 	$pag_res->results;

		$data["listing_columns"] = static::$listing_fields;

		return View::make($data["page"], $data);
	}


	/**
	 * Show section editor
	 * 
	 * @return Laravel\View
	 */
	public function action_edit($id=null){	

		if(is_null($id)){

			return Redirect::to_action('admin.sections.home@index');
		}

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"]			= 	'admin.sections.edit';
		$data["section"] 		= 	Sections::find($id);

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["section"]));
		$data["json_save"]		= 	Utilites::json_with_js_encode(static::$editor_fields, $data["section"]->id);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show section new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"]			= 	'admin.sections.new';

		$data["no_json"]["id"] 	= '';

		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $data["no_json"]);
		$data["json_save"]		= 	Utilites::json_with_js_encode($data["fields"]);
		$data["fields"] 		= 	static::prepare_fields($data["fields"]);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Prepare fields for Utilites::html_form_build() method
	 * 
	 * @return array
	 */
	private static function prepare_fields($fields){

		$result = array();
		$default_attr = array('class' => 'span12');

		foreach($fields as $key => $value) {
			
			if(isset(static::$fields_settings[$key])){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => (Lang::has('placeholders.'.$key)) ? __('placeholders.'.$key) : __('forms.'.$key.'_word') )));
			}
		}

		return $result;
	}
}