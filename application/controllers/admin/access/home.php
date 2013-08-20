<?php

class Admin_Access_Home_Controller extends Base_Controller {


	/**
	 * Associate controller with module
	 * 
	 * @var string|bool $module_name
	 */
	public $module_name = 'access_control';

	/**
	 * Field settings received via Modules::where('name', '=', 'module_name')->only('settings')
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
	public static $additions = array('access' => 'access');


	/**
	 * Make view with listing table
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["page"] 		= 	'admin.access.listing';
		$data["adminaccess"]=	Adminaccess::all();
		$data["useraccess"]	=	Useraccess::all();
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view for lang editor
	 * 
	 * @param  string     $type  (adminaccess|useraccess)
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($type, $id){

		Session::put('href.previous', URL::full());

		if(!in_array($type, array('adminaccess', 'useraccess'))){

			die('Unregistered action!');
		}

		$data 				= 	array();
		$data["page"] 		= 	'admin.access.edit';
		$data["access"] 	= 	$type::find($id);
		$data["fields"] 	= 	static::prepare_fields(Filedb::object_to_array($data["access"]));

		static::$editor_fields["access"] = $type;

		$data["json_save"]	= 	Utilites::json_with_js_encode(static::$editor_fields, $data["access"]->id);
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view for new lang editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["page"] 		= 	'admin.access.new';
		$no_json["id"] 		= 	'';
		
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
			
			if(isset(static::$fields_settings[$key])){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => __('access.'.$key.'_word') )));
			}
		}

		return $result;
	}
}