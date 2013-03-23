<?php

class Admin_Db_Controller extends Base_Controller {

	public function action_index($table=null)
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			Session::put('href.previous', URL::current());

			if(!$table){

				if (Request::ajax())
				{
					return View::make('admin.db.db_info');
				}else{
					return View::make('admin.assets.no_ajax')
								->with('page', 'admin.db.db_info');
				}

			}else{

				if (Request::ajax())
				{
					return View::make('admin.db.table_info')
								->with('table_name', $table)
								->with('table', Filedb::object_to_array($table::order_by('id')->get(), true));
				}else{
					return View::make('admin.assets.no_ajax')
								->with('page', 'admin.db.table_info')
								->with('table_name', $table)
								->with('table', Filedb::object_to_array($table::order_by('id')->get(), true));
				}
			}
		}
	}


	public function action_sort($table, $field, $order=null)
	{	
		if(!Admin::check()){

			return View::make('admin.login_area');

		}else{

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.db.table_info')
							->with('table_name', $table)
							->with('order', array('field' => $field, 'order' => $order))
							->with('table', Filedb::object_to_array($table::order_by($field, $order)->get(), true));
			}else{
				return View::make('admin.assets.no_ajax')
							->with('page', 'admin.db.table_info')
							->with('table_name', $table)
							->with('order', array('field' => $field, 'order' => $order))
							->with('table', Filedb::object_to_array($table::order_by($field, $order)->get(), true));
			}
		}
	}
	

	public function action_update($table){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			$table::update();
			return View::make('admin.db.table_info')
						->with('table_name', $table)
						->with('table', Filedb::object_to_array($table::order_by('id')->get(), true));
		}
	}

	public function action_edit($table, $id){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			if (Request::ajax())
			{
				return View::make('admin.db.table_edit')
							->with('table_name', $table)
							->with('table', $table::where('id', '=', $id)->get());
			}else{
				return View::make('admin.assets.no_ajax')
							->with('table_name', $table)
							->with('table', $table::where('id', '=', $id)->get())
							->with('page', 'admin.db.table_edit');
			}
		}
	}

	public function action_delete(){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{


			$json 		= 	stripcslashes(Input::get('data'));
			$json_arr 	= 	json_decode($json, true);

			$db 		= 	new stdClass;
			$id 		= 	$json_arr["id"];
			$delete 	= 	$json_arr["delete"];
			$table 		= 	$json_arr["table"];

			if($delete == 'delete'){

				$table::delete($id);
				return View::make('admin.db.table_info')
							->with('table_name', $table)
							->with('table', Filedb::object_to_array($table::order_by('id')->get(), true));

			}else{

				return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));

			}
		}
	}

	public function action_save(){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{


			$json 		= 	stripcslashes(Input::get('data'));
			$json_arr 	= 	json_decode($json, true);

			$db 		= 	new stdClass;
			$id 		= 	$json_arr["id"];
			$data_arr 	= 	$json_arr["data_arr"];
			$table 		= 	$json_arr["table"];

			foreach($data_arr as $key => $value){

				$data_arr[$key] = rawurldecode($value);

			}
			

			$upd = $table::where('id', '=', $id)->update($data_arr);

			if($upd !== 0){
					
				return View::make('admin.db.table_edit')
							->with('table_name', $table)
							->with('status', Lang::line('content.updated_word')->get(Session::get('lang')))
							->with('table', $table::where('id', '=', $id)->get());
			
			}else{
			
				return Lang::line('forms.undefined_err_word')
						->get(Session::get('lang'));
			
			}
		}
	}
}