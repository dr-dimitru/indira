<?php

class Admin_Filedb_Home_Controller extends Base_Controller {


	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 777;


	/**
	 * Make view of fileDB control panel
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		return (Request::ajax()) ? View::make('admin.filedb.database') : View::make('admin.assets.no_ajax')->with('page', 'admin.filedb.database');
	}


	/**
	 * Make view of row editor
	 * 
	 * @param  string     $table table name
	 * @param  string|int $id    row's id
	 * @return Laravel\View
	 */
	public function action_edit($table, $id){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["table_name"] = 	$table;
		$data["row_id"] 	=	$id;
		$data["table"] 		= 	$table::where('id', '=', $id)->get();
		$data["page"] 		= 	'admin.filedb.edit';

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view of model editor
	 * 
	 * @param  string $table table name
	 * @return Laravel\View
	 */
	public function action_model($table){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["model"] 		= 	$table::get_model();
		$data["edit"] 		= 	'true';
		$data["page"] 		= 	'admin.filedb.model';
		$data["file_lines"] = 	$table::get_model_lines();
		$data["table_name"] =
		$data["json_save"]["table_name"] = 	$table;
		$data["json_save"]["encrypt"] = 'encodeURI($(\'#encrypt\').val())';
		$data["encrypt"] = $table::has_encryption();

		$i = 0;

		foreach ($data["model"] as $name => $default) {
			
			++$i;

			$data["columns"][$i] =	array('name' => $name, 'default' => $default);

			$data["json_save"]["data_arr"]["names"][$i] = 'encodeURI($(\'#'.$i.'_name\').val())'; 
			$data["json_save"]["data_arr"]["values"][$i] = 'encodeURI($(\'#'.$i.'_default\').val())'; 
		}

		$data["json_save"]["data_arr"]["qty"] = $i;

		foreach($data["columns"] as $key => $val){

			$data["json_delete_".$key] = Utilites::json_with_js_encode(array_merge($data["json_save"], array('id' => $key)));
		}

		$data["json_save"] = Utilites::json_with_js_encode($data["json_save"]);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view of new table editor
	 * 
	 * @return Laravel\View
	 */
	public function action_add_table(){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["edit"] 		= 	false;
		$data["columns"][1] =	array('name' => 'id', 'default' => '1');
		$data["columns"][2] =	array('name' => 'created_at', 'default' => '');
		$data["columns"][3] =	array('name' => 'updated_at', 'default' => '');
		$data["columns"][4] =	array('name' => '', 'default' => '');
		$data["page"] 		= 	'admin.filedb.new_table';

		$data["table_name"] = '';
		$data["json_save"]["table_name"] = 'encodeURI($(\'#table_name_\').val())';
		$data["json_save"]["encrypt"] = 'encodeURI($(\'#encrypt\').val())';
		$data["encrypt"] = false;

		$qty = 0;

		foreach($data["columns"] as $key => $val){

			$data["json_save"]["data_arr"]["names"][$key] = 'encodeURI($(\'#'.$key.'_name\').val())'; 
			$data["json_save"]["data_arr"]["values"][$key] = 'encodeURI($(\'#'.$key.'_default\').val())';
			$data["json_save"]["data_arr"]["qty"] = ++$qty; 
		}

		foreach($data["columns"] as $key => $val){

			$data["json_delete_".$key] = Utilites::json_with_js_encode(array_merge($data["json_save"], array('id' => $key)));
		}

		$data["json_save"] = Utilites::json_with_js_encode($data["json_save"]);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view of new row editor
	 * 
	 * @param  string $table table name
	 * @return Laravel\View
	 */
	public function action_add_row($table){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["table_name"] = 	$table;
		$data["table"] 		= 	$table::get_model(false, true);
		$data["page"] 		= 	'admin.filedb.new_row';

		$data["no_json"]['created_at'] 	= 
		$data["no_json"]['updated_at'] 	= 
		$data["no_json"]['id'] 			= '';
		$data["json_save"]["table"] 	= $table;

		$data["table"] 		= 	Filedb::array_to_object(array_diff_key($data["table"], $data["no_json"]));
	
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view with $table contents
	 * with pagination
	 * 
	 * @param  string $table table name
	 * @return Laravel\View
	 */
	public function action_table($table){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["page"] 		= 	'admin.filedb.table';
		$data["page_num"] 	= 	Input::get('page', 1);
		$data["query"] 		= 	null;
		$data["table_name"] = 	$table;
		$data["table_records"] = Filedb::get_table_records($table);
		$data["encryption"] = $table::has_encryption();

		$data = array_merge($data, Utilites::show_by_logic($data["table_records"]));

		$take = Input::get('show', 10);

		$data[$table.'_by_'.$take.'_disabled'] = 'disabled';


		if(Input::get('show') || Input::get('page')){

			$data["query"] 		= 	'?'.http_build_query(Input::all());
		}

		$pag_res		 	= 	$table::order_by('id')->paginate($take);
		$data["pagination"] = 	$pag_res->appends(array('show' => $take))->links();
		$data["table"]		= 	Filedb::object_to_array($pag_res->results, true);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view and sort $table contents
	 * by provided $field in selected $order
	 * 
	 * @param  string     $table table name
	 * @param  string     $field column name
	 * @param  string     $field (ASC|DESC)
	 * @return Laravel\View
	 */
	public function action_sort($table, $field, $order=null){

		Session::put('href.previous', URL::full());

		$data 				= 	array();
		$data["page"] 		= 	'admin.filedb.table';
		$data["page_num"] 	= 	Input::get('page', 1);
		$data["query"] 		= 	null;
		$data["table_name"] = 	$table;
		$data["order"] 		= 	array('field' => $field, 'order' => $order);
		$data["table_records"] = Filedb::get_table_records($table);
		$data["encryption"] = $table::has_encryption();
		
		$data = array_merge($data, Utilites::show_by_logic($data["table_records"]));

		$take = Input::get('show', 10);

		$data[$table.'_by_'.$take.'_disabled'] = 'disabled';
	

		if(Input::get('show') || Input::get('page')){

			$data["query"] 		= 	'?'.http_build_query(Input::all());
		}

		$pag_res		 	= 	$table::order_by($field, $order)->paginate($take);
		$data["pagination"] = 	$pag_res->appends(array('show' => $take))->links();
		$data["table"]		= 	Filedb::object_to_array($pag_res->results, true);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}