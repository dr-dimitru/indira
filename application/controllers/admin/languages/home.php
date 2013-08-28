<?php

class Admin_Languages_Home_Controller extends Base_Controller {


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
	 * Make view with listing table
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::current());

		$data 				= 	array();
		$data["page"] 		= 	'admin.languages.listing';
		$data["languages"] 	= 	Langtable::all();
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show lang editor by provided $id
	 * 
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($id){

		Session::put('href.previous', URL::current());

		$data 				= 	array();
		$data["page"] 		= 	'admin.languages.edit';
		$data["language"] 	= 	Langtable::find($id);

		$data["fields"] 	= 	static::prepare_fields(Filedb::object_to_array($data["language"]));
		$data["json_save"]	= 	Utilites::json_with_js_encode(static::$editor_fields, $data["language"]->id);
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show lang new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){

		Session::put('href.previous', URL::current());

		$data 				= 	array();
		$data["page"] 		= 	'admin.languages.new';
		$no_json["id"] 		= '';

		$data["fields"] 	= 	array_diff_key(static::$editor_fields, $no_json);
		$data["json_save"]	= 	Utilites::json_with_js_encode($data["fields"]);
		$data["fields"] 	= 	static::prepare_fields($data["fields"]);
		
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

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => __('languages.'.$key.'_annotation'))));
			}
		}

		return $result;
	}
}