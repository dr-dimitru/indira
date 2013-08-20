<?php

class Admin_Filedb_Action_Controller extends Base_Controller {

	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 777;


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Update full $table with
	 * default values for empty cells.
	 *
	 * Use this method to apply 
	 * changes in model to table
	 * 
	 * @param  string $table Table name
	 * @return Laravel\Redirect
	 */
	public function get_update($table){

		$table::update();
		return Redirect::to('/admin/filedb/home/table/'.$table);
	}


	/**
	 * Encrypt $table
	 * 
	 * @param  string $table Table name
	 * @return Laravel\Redirect
	 */
	public function post_encrypt($table){

		$table::encrypt_table();
		return Redirect::to(Session::get('href.previous'));
	}


	/**
	 * Decrypt $table
	 * 
	 * @param  string $table Table name
	 * @return Laravel\Redirect
	 */
	public function post_decrypt($table){

		$table::decrypt_table();
		return Redirect::to(Session::get('href.previous'));
	}


	/**
	 * Delete row from table by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($income_data["delete"] == 'delete'){

			$income_data["table"]::delete($income_data["id"]);

			return Utilites::alert(__('forms.deleted_notification', array("item" => $income_data["id"])), 'success');

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Drop (remove) table
	 * 
	 * @return string
	 */
	public function post_drop_table(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($income_data["drop"] == 'drop'){

			$income_data["table"]::drop();

			return Utilites::alert(__('filedb.dropped_table', array('t' => $income_data["table"])), 'success');

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Truncate (dalete all records) table
	 * 
	 * @return string
	 */
	public function post_truncate_table(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($income_data["trunc"] == 'truncate'){

			$income_data["table"]::truncate();

			return "0";

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Rename table
	 * 
	 * @return Laravel\View
	 */
	public function post_rename_table(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		Filedb::get_tables();

		if(in_array(strtolower($income_data["name"]), array_map('strtolower', get_declared_classes()))){

			return Utilites::alert(__('validation.unique', array('attribute' => $income_data["name"])), 'error');
		}

		if($income_data["rename"] == 'rename'){

			$income_data["table"]::rename($income_data["name"]);

			$data 				= 	array();
			$data["text"] 		= 	__('forms.saved_word');
			$data["data_out"] 	= 	'work_area';
			$data["success"] 	= 	true;
			$data["data_link"] 	= 	action('admin.filedb.home@table', array($income_data["name"]));
			$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'filedb.filedb'));

			return View::make('assets.message_redirect', $data);

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Update record in table
	 * 
	 * @return string
	 */
	public function post_save(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		foreach($income_data["data_arr"] as $key => $value){

			$income_data["to_save"][str_replace('_'.$income_data["id"], '', $key)] = $value;
		}

		$upd = $income_data["table"]::where('id', '=', $income_data["id"])->update($income_data["to_save"]);

		return ($upd !== 0) ? Utilites::alert(__('forms.saved_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
	}


	/**
	 * Inset new row in table
	 * 
	 * @return Laravel\View
	 */
	public function post_create_row(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		foreach($income_data["data_arr"] as $key => $value){

			$income_data["to_save"][str_replace('_'.$income_data["table"], '', $key)] = $value;
		}

		$id = $income_data["table"]::insert($income_data["to_save"]);

		if($id !== 0){

			$data 				= 	array();
			$data["text"] 		= 	Utilites::alert(__('forms.saved_notification', array('item' => $id)), 'success');
			$data["data_out"] 	= 	'work_area';
			$data["data_link"] 	= 	action('admin.filedb.home@table', array($income_data["table"]));
			$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'filedb.filedb', 'forms.edit_word', $id));

			return View::make('assets.message_redirect', $data);
		
		}else{
		
			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Create new table
	 * 
	 * @return Laravel\View
	 */
	public function post_create_table(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		

		for ($i=1; $i < $income_data["data_arr"]["qty"]+1; $i++) { 

			if(!empty($income_data["data_arr"]["names"][$i])){

				$model[$income_data["data_arr"]["names"][$i]] = $income_data["data_arr"]["values"][$i];
			}
		}


		if(Input::get('edit', 'false') !== 'true'){

			Filedb::get_tables();
			
			if(in_array(strtolower($income_data["table_name"]), array_map('strtolower', get_declared_classes()))){

				return Utilites::alert(__('validation.unique', array('attribute' => $income_data["table_name"])), 'error');
			}
		}


		Filedb::create_table($income_data["table_name"], $model, $income_data["encrypt"]);
		
		$data 				= 	array();
		$data["text"] 		= 	Utilites::alert(__('forms.saved_notification', array('item' => $income_data["table_name"])), 'success');
		$data["data_out"] 	= 	'work_area';
		$data["data_link"] 	= 	action('admin.filedb.home@table', array($income_data["table_name"]));
		$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'filedb.filedb', $income_data["table_name"]));

		return View::make('assets.message_redirect', $data);
	}


	/**
	 * Update table's model
	 * 
	 * @return string
	 */
	public function post_save_model(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		
		for ($i=1; $i < $income_data["data_arr"]["qty"]+1; $i++) { 

			if(!empty($income_data["data_arr"]["names"][$i])){

				$model[$income_data["data_arr"]["names"][$i]] = $income_data["data_arr"]["values"][$i];
			}
		}

		Filedb::create_model($income_data["table_name"], $model, $income_data["encrypt"]);

		return Utilites::alert(__('forms.saved_notification', array('item' => $income_data["table_name"])), 'success');
	}


	/**
	 * Add a column to table's model
	 * 
	 * @return Laravel\View
	 */
	public function post_add_column(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$data["page"] 	= 	(Input::get('edit')) ? 'admin.filedb.model' : 'admin.filedb.new_table';
		$data["edit"] 	= 	(Input::get('edit')) ? 'true' : false;

		if($data["edit"]){
			$data["file_lines"] = $income_data["table_name"]::get_model_lines();
		}
		$data["table_name"] = $income_data["table_name"];
		$data["encrypt"] = $income_data["encrypt"];
		$data["json_save"]["table_name"] = 'encodeURI($(\'#table_name_\').val())';
		$data["json_save"]["encrypt"] = 'encodeURI($(\'#encrypt\').val())';

		$qty = 0;

		for ($i=1; $i < $income_data["data_arr"]["qty"]+1; $i++) { 

			$data["columns"][$i] = array('name' => $income_data["data_arr"]["names"][$i], 'default' => $income_data["data_arr"]["values"][$i]);

			$data["json_save"]["data_arr"]["names"][$i] = 'encodeURI($(\'#'.$i.'_name\').val())'; 
			$data["json_save"]["data_arr"]["values"][$i] = 'encodeURI($(\'#'.$i.'_default\').val())';
		}

		$data["json_save"]["data_arr"]["qty"] = $i; 
		$data["columns"][$i] =	array('name' => '', 'default' => '');
		$data["json_save"]["data_arr"]["names"][$i] = 'encodeURI($(\'#'.$i.'_name\').val())'; 
		$data["json_save"]["data_arr"]["values"][$i] = 'encodeURI($(\'#'.$i.'_default\').val())';

		foreach($data["columns"] as $key => $val){

			$data["json_delete_".$key] = Utilites::json_with_js_encode(array_merge($data["json_save"], array('id' => $key)));
		}

		$data["json_save"] = Utilites::json_with_js_encode($data["json_save"]);

		return View::make($data["page"], $data);
	}


	/**
	 * Remove column from table's model
	 * 
	 * @return Laravel\View
	 */
	public function post_remove_column(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$data["page"] 	= 	(Input::get('edit')) ? 'admin.filedb.model' : 'admin.filedb.new_table';
		$data["edit"] 	= 	(Input::get('edit')) ? 'true' : false;

		if($data["edit"]){
			$data["file_lines"] = $income_data["table_name"]::get_model_lines();
		}
		$data["table_name"] = $income_data["table_name"];
		$data["encrypt"] = $income_data["encrypt"];
		$data["json_save"]["table_name"] = 'encodeURI($(\'#table_name_\').val())';
		$data["json_save"]["encrypt"] = 'encodeURI($(\'#encrypt\').val())';

		$qty = 1;

		for ($i=1; $i <= $income_data["data_arr"]["qty"]; $i++) { 

			if($i == $income_data["id"]){

				if($income_data["data_arr"]["qty"] !== $income_data["id"]){

					$data["columns"][$qty] = array('name' => $income_data["data_arr"]["names"][$i], 'default' => $income_data["data_arr"]["values"][$i]);

					$data["json_save"]["data_arr"]["names"][$qty] = 'encodeURI($(\'#'.$qty.'_name\').val())'; 
					$data["json_save"]["data_arr"]["values"][$qty] = 'encodeURI($(\'#'.$qty.'_default\').val())';
				}

			}else{

				$data["columns"][$qty] = array('name' => $income_data["data_arr"]["names"][$i], 'default' => $income_data["data_arr"]["values"][$i]);

				$data["json_save"]["data_arr"]["names"][$qty] = 'encodeURI($(\'#'.$qty.'_name\').val())'; 
				$data["json_save"]["data_arr"]["values"][$qty] = 'encodeURI($(\'#'.$qty.'_default\').val())';
				++$qty;
			}
		}

		$data["json_save"]["data_arr"]["qty"] = --$qty;

		foreach($data["columns"] as $key => $val){

			$data["json_delete_".$key] = Utilites::json_with_js_encode(array_merge($data["json_save"], array('id' => $key)));
		}

		$data["json_save"] = Utilites::json_with_js_encode($data["json_save"]);

		return View::make($data["page"], $data);
	}


	/**
	 * Create database dump.
	 * Save and return to user's browser.
	 * 
	 * @return Laravel\Response
	 */
	public function get_dbmakedump(){

		$zip = Utilites::zip('storage/db', 'storage/filedb_dumps/FileDB_dump_'.time().'.zip');

		return ($zip) ? Response::download('storage/filedb_dumps/FileDB_dump_'.time().'.zip') : 'check permissions on "storage/filedb_dumps/" folder, set to 777 to create and download dumps';
	}
}