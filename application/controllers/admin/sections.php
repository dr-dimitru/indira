<?php

class Admin_Sections_Controller extends Base_Controller {

	public function action_index()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');

		}else{

			return View::make('admin.sections.sections')
					->with('sections', Sections::all());

		}
	}

}