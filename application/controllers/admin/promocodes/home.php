<?php

class Admin_Promocodes_Home_Controller extends Base_Controller {

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
	public static $additions = array('level' => 'useraccess');


	/**
	 * Show listing table with pagination
	 * 
	 * @return Laravel\View
	 */
	public function action_table(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();

		//Data used to build Pagination
		$data["page_num"] 		= 	Input::get('page', 1);
		$data["take"] 			= 	Input::get('show', 50);

		$data["table_name"]		= 	'promocodes';
		$data["table_records"]	= 	Filedb::get_table_records('Promocodes');
		$data 					= 	array_merge($data, Utilites::show_by_logic($data["table_records"]));
		$pag_res		 		= 	Promocodes::order_by('created_at')->paginate($data["take"]);
		$data["pagination"] 	= 	$pag_res->appends(array('show' => $data["take"]))->links();
		$data['promocodes_by_'.$data["take"].'_disabled'] = 'disabled';
		
		//Data used to build listing table
		$data["page"] 			= 	'admin.promocodes.table';
		$data["promocodes"] 	= 	$pag_res->results;
		$data["useraccess"] 	= 	Useraccess::get(array('id', 'level', 'name'));

		foreach ($data["useraccess"] as $file_id => $row) {
				
			if(Admin::check() < $this->access){

				if($row->owner && stripos($row->owner, "@")){
					
					list($email, $domain) 	= 	explode("@", $data["user"]->owner);
					$data["useraccess"]["$file_id"]->owner = "******@".$domain;

				}
			}
		}
		

		//Listing table settings
		$data["listing_columns"] = static::$listing_fields;
		
		return View::make($data["page"], $data)->render();
	}


	/**
	 * Show listing table with pagination
	 * 
	 * @return Laravel\View
	 */
	public function action_generator(){

		$data["page"] = 'admin.promocodes.generator';
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show post editor
	 * 
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.promocodes.home@index');
		}

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"]			= 	'admin.promocodes.edit';
		$data["promocode"] 		= 	Promocodes::find($id);

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["promocode"]));
		$data["json"]			= 	static::$editor_fields;
		$data["json_save"]		= 	Utilites::json_with_js_encode($data["json"], $data["promocode"]->id);
		
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
		$data["page"]			= 	'admin.promocodes.new';

		$data["no_json"]["id"] 	= '';

		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $data["no_json"]);
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
		$default_attr = array('class' => 'span6');

		foreach($fields as $key => $value) {
			
			if(isset(static::$fields_settings[$key]) && in_array($key, array_keys(static::$editor_fields))){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => __('promocode.'.$key) )));
			}
		}

		return $result;
	}
}