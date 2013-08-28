<?php

class Admin_Users_Home_Controller extends Base_Controller {


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
	public static $additions = array('access' => 'useraccess');


	/**
	 * Show listing table with all admins
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		//Data used to build Pagination
		$data["page_num"] 		= 	Input::get('page', 1);
		$take 					= 	Input::get('show', 30);

		$data["table_name"]		= 	'users';
		$data["table_records"]	= 	Filedb::get_table_records('users');
		$data 					= 	array_merge($data, Utilites::show_by_logic($data["table_records"]));
		$pag_res 				= 	Users::order_by('created_at', 'DESC')->paginate($take);

		$data["users"] 			= 	$pag_res->results;
		$data["page"] 			= 	'admin.users.listing';

		$data["pagination"] 	= 	$pag_res->appends(array('show' => $take))->links();
		$data['users_by_'.$take.'_disabled'] = 'disabled';

		if($data["users"] && Admin::check() != 777){
			
			foreach($data["users"] as $row => $column) {
					

				if(isset($column->email)){

				 	list($uemail, $domen) 			= 	explode("@", $column->email);
					$data["users"][$row]->email 	= 	"******@".$domen;
					$data["users"][$row]->name 		= 	"***in";
				}
			}
		}

		$data["listing_columns"] = static::$listing_fields;

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show user's settings
	 * 
	 * @return Laravel\View
	 */
	public function action_settings(){

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"] 			= 	'admin.users.settings';

		foreach (Userssettings::get(array('param', 'value', 'id')) as $file_id => $row) {
			
			$data['settings'][$row->param]['value'] = $row->value;
			$data['settings'][$row->param]['id'] = $row->id;
		}

		if($data['settings']['promocodes_active']['value'] == 'true'){

			$data["promocodes_table"] = Controller::call('admin.promocodes.home@table');
		}

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show admin's editor by provided id
	 * 
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.users.home@index');
		}

		Session::put('href.previous', URL::current());

		$data 					= 	array();
		$data["page"] 			= 	'admin.users.edit';
		$data["user"] 			= 	Users::find($id);

		if(Admin::check() != 777){

			list($uemail, $domen) 	= 	explode("@", $data["user"]->email);
			$data["user"]->email 	= 	"******@".$domen;
			$data["user"]->name 	= 	"***in";
		}

		$no_json["notify_via_email"] =	'';

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["user"]));
		$data["json_save"]		= 	Utilites::json_with_js_encode(array_diff_key(static::$editor_fields, $no_json), $data["user"]->id);

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
		$data["page"] 			= 	'admin.users.new';
 
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
			
			if(isset(static::$fields_settings[$key]) && in_array($key, array_keys(static::$editor_fields))){
				
				$options = (isset(static::$fields_settings[$key]['options'])) ? static::$fields_settings[$key]['options'] : null;
				$attributes = (isset(static::$fields_settings[$key]['attributes'])) ? static::$fields_settings[$key]['attributes'] : array();

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr, array('placeholder' => (Lang::has('placeholders.'.$key)) ? __('placeholders.'.$key) : __('forms.'.$key.'_word') )));
			}
		}

		return $result;
	}
}