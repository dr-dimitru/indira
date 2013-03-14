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
								->with('table', $table::all());
				}else{
					return View::make('admin.assets.no_ajax')
								->with('page', 'admin.db.table_info')
								->with('table_name', $table)
								->with('table', $table::all());
				}

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
						->with('table', $table::all());
		}
	}

	public function action_delete($id){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			$table::delete($id);
			return View::make('admin.db.table_info')
						->with('table_name', $table)
						->with('table', $table::all());
		}
	}
}