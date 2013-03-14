<?php

class Admin_Sections_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');

		}else{

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.sections.sections')
					->with('sections', Sections::all());
			}else{
				return View::make('admin.assets.no_ajax')
					->with('sections', Sections::all())->with('page', 'admin.sections.sections');
			}

		}
	}

}