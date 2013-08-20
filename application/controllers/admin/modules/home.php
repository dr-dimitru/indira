<?php

class Admin_Modules_Home_Controller extends Base_Controller {

	/**
	 * Field settings received via Modules::where('name', '=', 'blog')->only('settings')
	 * 
	 * @var array $fields_settings
	 */
	static $fields_settings = array();


	/**
	 * Columns shown in table listing
	 * 
	 * @var array $fields_settings
	 */
	static $listing_fields;


	/**
	 * Fields shown in editor
	 * 
	 * @var array $fields_settings
	 */
	static $editor_fields; 


	/**
	 * Show listing table
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();

		//Data used to build listing
		$data["modules"] 		= 	Modules::all();

		//Data used to build listing table
		$data["page"] 			= 	'admin.modules.listing';

		//Listing table settings
		$data["listing_columns"]= static::$listing_fields;
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show Modules editor
	 * 
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.modules.home@index');
		}

		Session::put('href.previous', URL::full());

		$data 					= 	array();
		$data["page"]			= 	'admin.modules.edit';
		$data["module"] 		= 	Modules::find($id);

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["module"]));
		$data["json_save"]		= 	Utilites::json_with_js_encode(static::$editor_fields, $data["module"]->id);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show Modules new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){
			
		Session::put('href.previous', URL::full());

		$data 					= 	array();
		$data["page"]			= 	'admin.modules.new';

		$no_json["id"] 			= '';

		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $no_json);
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
			
			if(isset(static::$fields_settings[$key])){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => (Lang::has('placeholders.'.$key)) ? __('placeholders.'.$key) : __('forms.'.$key.'_word') )));
			}
		}

		return $result;
	}


	/**
	 * Get all necessary data
	 * For above views
	 * 
	 * @return void
	 */
	public function __construct(){

		$additions = array('access' => 'adminaccess', 'view_access' => 'adminaccess', 'active' => 'yes_no');

		list(static::$listing_fields, static::$fields_settings, static::$editor_fields) = Utilites::prepare_module_settings('modules', $additions);
	}
}