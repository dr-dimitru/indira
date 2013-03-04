<?

class Admin_Section_Area_Controller extends Base_Controller {

	public $restful = true;

	public function post_index()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');
		
		}else{
			
			$id 		= 	stripcslashes(Input::get('data'));

			return View::make('admin.sections.section_area')
					->with('section', Sections::find($id));
		}
	}


	public function get_new()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');
		
		}else{
		
			$section 			= 	new stdClass;
			$section->id 		= 	'new';
			$section->title 	= 	null;
			$section->lang 		= 	null;


			return View::make('admin.sections.section_area_new')->with('section', $section);
		}
	}


	public function post_save()
	{	
		
		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$section 			= 	new stdClass;
			$section->id 		= 	$json_arr["id"];
			$section->title 	= 	rawurldecode($json_arr["title"]);
			$section->lang 		= 	$json_arr["lang"];

			if(empty($section->title))
			{

				$errors = null;
				$errors .= '<li>'.Lang::line('forms.post_title_err')
									->get(Session::get('lang')).'</li>';
				
				return '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';
			
			}else{

				$status = Sections::where('id', '=', $section->id)->update(array(	'title' 	=> 	$section->title,
																					'lang' 		=> 	$section->lang));

				if($status !== 0){
					
					return Lang::line('content.saved_word')
							->get(Session::get('lang'));
				
				}else{
				
					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));

				}
			}
		}
	}


	public function post_add()
	{	
		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$section 			= 	new stdClass;
			$section->id 		= 	'new';
			$section->title 	= 	rawurldecode($json_arr["title"]);
			$section->lang 		= 	$json_arr["lang"];

			//CHECK SAME TITLE
			$sTitle = Sections::where('title', '=', $section->title)
						->only('title');
			$errors = 	null;
			

			if(empty($section->title))
			{
				$errors .= '<li>'.Lang::line('forms.post_title_err')
									->get(Session::get('lang')).'</li>';
			
				$errors = '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';
			
			}
			elseif(isset($sTitle)){
				
				$errors .= '<li>'.Lang::line('forms.same_title_err')->get(Session::get('lang')).'</li>';
				$errors = '<div class="alert alert-error compact"><ul>'.$errors.'</ul></div>';

			}
			
			if($errors == null){
				$newId = Sections::insert(array('title' 	=> 	$section->title,
												'lang' 		=> 	$section->lang));

				if($newId !== 0){

					return View::make('admin.sections.section_area')
							->with('section', Sections::find($newId))
							->with('status', Lang::line('content.saved_word')
								->get(Session::get('lang'))
							);

				}else{

					return View::make('admin.sections.section_area_new')
							->with('section', $section)
							->with('status', Lang::line('content.saved_word')
								->get(Session::get('lang'))
							);

				}

			}else{

				return View::make('admin.sections.section_area_new')
						->with('section', $section)
						->with('status', $errors);

			}
		}
	}



	public function post_delete(){

		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$section 			= 	new stdClass;
			$section->id 		= 	$json_arr["id"];
			$section->delete 	= 	$json_arr["delete"];

			if($section->delete == 'delete'){
				
				$status = Sections::delete($section->id);

				if($status){

					return View::make('admin.sections.sections')->with('sections', Sections::all());

				}else{

					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
					
				}

			}
		}

	}


}