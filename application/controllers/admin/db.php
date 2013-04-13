<?php

class Admin_Db_Controller extends Base_Controller {

	public function action_index($table=null)
	{	
		if(!Admin::check()){

			return Redirect::to('admin/login');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			Session::put('href.previous', URL::full());

			if(!$table){

				if (Request::ajax())
				{
					return View::make('admin.db.db_info');
				}else{
					return View::make('admin.assets.no_ajax')
								->with('page', 'admin.db.db_info');
				}

			}else{

				if($take = Input::get('show')){

				}else{
					$take = 10;
				}
				$page = Input::get('page');

				if($page == 'all'){

					$table_content = $table::order_by('id')->get();
					$pag = null;

				}elseif($page < 2 || !$page){
				
					$pag = $table::paginate($take);
					$page = 1;
					$start = 0;
					$table_content = $table::order_by('id')->limit($start, $take)->get();
				
				}else{

					$pag = $table::paginate($take);
					$start = ($page - 1) * $take;
					$table_content = $table::order_by('id')->limit($start, $take)->get();

				}

				$query = null;
				if(Input::get('show') || Input::get('page')){
					$query = '?'.http_build_query(Input::all());
				}

				if (Request::ajax())
				{
					return View::make('admin.db.table_info')
								->with('table_name', $table)
								->with('pag_res', $pag)
								->with('query', $query)
								->with('table', Filedb::object_to_array($table_content, true));
				}else{
					return View::make('admin.assets.no_ajax')
								->with('page', 'admin.db.table_info')
								->with('table_name', $table)
								->with('pag_res', $pag)
								->with('query', $query)
								->with('table', Filedb::object_to_array($table_content, true));
				}
			}
		}
	}


	public function action_sort($table, $field, $order=null)
	{	
		if(!Admin::check()){

			return Redirect::to('admin/login');

		}else{

			Session::put('href.previous', URL::full());

			if($take = Input::get('show')){

			}else{
				$take = 10;
			}
			$page = Input::get('page');

			if($page == 'all'){

				$table_content = $table::order_by($field, $order)->get();
				$pag = null;

			}elseif($page < 2 || !$page){
			
				$pag = $table::paginate($take);
				$page = 1;
				$start = 0;
				$table_content = $table::order_by($field, $order)->limit($start, $take)->get();
			
			}else{

				$pag = $table::paginate($take);
				$start = ($page - 1) * $take;
				$table_content = $table::order_by($field, $order)->limit($start, $take)->get();

			}

			$query = null;
			if(Input::get('show') || Input::get('page')){
				$query = '?'.http_build_query(Input::all());
			}

			if (Request::ajax())
			{
				return View::make('admin.db.table_info')
							->with('table_name', $table)
							->with('pag_res', $pag)
							->with('query', $query)
							->with('order', array('field' => $field, 'order' => $order))
							->with('table', Filedb::object_to_array($table_content, true));
			}else{
				return View::make('admin.assets.no_ajax')
							->with('page', 'admin.db.table_info')
							->with('table_name', $table)
							->with('pag_res', $pag)
							->with('query', $query)
							->with('order', array('field' => $field, 'order' => $order))
							->with('table', Filedb::object_to_array($table_content, true));
			}
		}
	}
	

	public function action_update($table){

		if(!Admin::check()){

			return Redirect::to('admin/login');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			$table::update();
			return Redirect::to(Session::get('href.previous'));
		}
	}

	public function action_edit($table, $id){

		if(!Admin::check()){

			return Redirect::to('admin/login');

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

			return Redirect::to('admin/login');

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
				return Redirect::to(Session::get('href.previous'));

			}else{

				return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));

			}
		}
	}

	public function action_save(){

		if(!Admin::check()){

			return Redirect::to('admin/login');

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

				$data_arr[$key] = Filedb::_rawurldecode($value);

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