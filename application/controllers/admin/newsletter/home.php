<?php

class Admin_Newsletter_Home_Controller extends Base_Controller {

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

	// public $module_name = 'newsletter';


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
		$take 					= 	Input::get('show', 25);

		$data["table_name"]		= 	'newsletter';
		$data["table_records"]	= 	Filedb::get_table_records('newsletter');
		$data 					= 	array_merge($data, Utilites::show_by_logic($data["table_records"]));
		$pag_res 				= 	Newsletter::order_by('created_at')->paginate($take);
		$data["max_order"] 		= 	Newsletter::max('id');
		$data["pagination"] 	= 	$pag_res->appends(array('show' => $take))->links();
		$data['newsletter_by_'.$take.'_disabled'] = 'disabled';

		//Data used to build listing table
		$data["page"] 			= 	'admin.newsletter.listing';
		$data["newsletter"] 	= 	$pag_res->results;

		//Listing table settings
		$data["listing_columns"]= static::$listing_fields;
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show newsletter editor
	 * 
	 * @param  string|int $id
	 * @return Laravel\View
	 */
	public function action_edit($id=null){

		if(is_null($id)){

			return Redirect::to_action('admin.newsletter.home@index');
		}

		Session::put('href.previous', URL::full());

		$data 					= 	array();
		$data["page"]			= 	'admin.newsletter.edit';
		$data["letter"] 		= 	Newsletter::find($id);

		$data["fields"] 		= 	static::prepare_fields(Filedb::object_to_array($data["letter"]));
		$data["json_save"]		= 	Utilites::json_with_js_encode(static::$editor_fields, $data["letter"]->id);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show newsletter new editor
	 * 
	 * @return Laravel\View
	 */
	public function action_new(){
			
		Session::put('href.previous', URL::full());

		$data 					= 	array();
		$data["page"]			= 	'admin.newsletter.new';

		$no_json["id"] 			= '';

		$data["fields"] 		= 	array_diff_key(static::$editor_fields, $no_json);
		$data["fields"]["from"] = 	Indira::get('email.no-reply');
		$data["fields"]["from_name"] = 	Indira::get('name');
		$data["json_save"]		= 	Utilites::json_with_js_encode($data["fields"]);
		$data["fields"] 		= 	static::prepare_fields($data["fields"]);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Show newsletter preview
	 * 
	 * @param  int|string $id
	 * @return Laravel\View
	 */
	public function action_preview($id){

		$newsletter = Newsletter::find($id);

		$data["subject"] = $newsletter->subject;
		$data["message"] = $newsletter->text;
		$data["lang"] 	 = Session::get('lang');

		return View::make('admin.assets.email_pattern', $data);
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

				$result[$key] = array('type' => static::$fields_settings[$key]['type'], 'data' => array($key, $value, $options), 'attributes' => array_merge($attributes, $default_attr));
			}
		}

		return $result;
	}
}