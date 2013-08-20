<?php

class Admin_Admins_Home_Controller extends Base_Controller {


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
	public static $additions = array('access' => 'adminaccess');


	/**
	 * Show listing table with all admins
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::current());

		$admin 			= 	Admin::init();
		$data 			= 	array();
		$data["admins"] = 	$admin->all();
		$data["min_id"] = 	$admin->min('id');
		$data["page"] 	= 	'admin.admins.listing';

		foreach($data["admins"] as $row => $column) {
				
			if(Admin::check() != 777){

				if(isset($column->email)){

					if(stripos($column->email, "@")){
					 	
					 	list($uemail, $domain) 			= 	explode("@", $column->email);
						$data["admins"][$row]->email 	= 	"******@".$domain;
						$data["admins"][$row]->name 	= 	"***in";
					}
				}
			}
		}

		$data["listing_columns"] = static::$listing_fields;

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show admin's editor by provided id
	 * 
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.admins.home@index');
		}

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"] 			= 	'admin.admins.edit';
		$data["admin"] 			= 	Admin::find($id);

		if(Admin::check() != 777){

			if(stripos($data["admin"]->email, "@")){
				
				list($uemail, $domain) 	= 	explode("@", $data["admin"]->email);
				$data["admin"]->email 	= 	"******@".$domain;
				$data["admin"]->name 	= 	"***in";
			}
		}

		$no_json["notify_via_email"] =	'';

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["admin"]));
		$data["json_save"]		= 	Utilites::json_with_js_encode(array_diff_key(static::$editor_fields, $no_json), $data["admin"]->id);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show admin's new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"] 			= 	'admin.admins.new';
 
		$no_json["id"] 			=	'';

		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $no_json);
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