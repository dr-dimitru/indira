<?php
class Admin_Imgupload_Controller extends Base_Controller {

	public $restful = true;
	
	public function post_index()
	{
		if(!Admin::check()){

			return Redirect::to('admin/login');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{

			$demo_mode = false;
			$upload_dir = 'public/uploads/';
			$allowed_ext = array('jpg','jpeg','png','gif');


			if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
				Utilites::exit_status('Error! Wrong HTTP method!');
			}


			if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
				
				$pic = $_FILES['pic'];

				if(!in_array(Utilites::get_extension($pic['name']),$allowed_ext)){
					Utilites::exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
				}	

				if($demo_mode){
					
					// File uploads are ignored. We only log them.
					
					$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
					file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
					
					Utilites::exit_status('Uploads are ignored in demo mode.');
				}
				
				
				// Move the uploaded file from the temporary 
				// directory to the uploads folder:
				$img_name = md5($pic['name'].mt_rand()).'.'.Utilites::get_extension($pic['name']);
				
				if(move_uploaded_file($pic['tmp_name'], $upload_dir.$img_name)){
					Media::insert(array('url' => URL::to('uploads/'.$img_name), 'name' => $pic['name'], 'route' => 'uploads/'.$img_name));
					
					if(Input::get('viabutton') == 'true')
					{
						return Redirect::to('admin/imgupload');

					}elseif(Input::get('viaredactor') == 'true'){

						$json = array();
						$json['filelink'] = URL::to('uploads/'.$img_name);

						return Response::json($json, 200);
					}else{
						Utilites::exit_status('File was uploaded successfuly!');
					}

				}
				
			}

			Utilites::exit_status('Something went wrong with your upload!');

		}
	}


	public function get_index(){

		if(!Admin::check()){

			return Redirect::to('admin/login');

		}else{

			Session::put('href.previous', URL::current());

			if (Request::ajax())
			{
				return View::make('admin.imgupload.main')
							->with('media', Media::order_by('created_at', 'desc')->get());
			}else{
				return View::make('admin.assets.no_ajax')
							->with('media', Media::order_by('created_at', 'desc')->get())
							->with('page', 'admin.imgupload.main');
			}
		}
	}

	public function get_select(){

		if(!Admin::check()){

			return Redirect::to('admin/login');

		}else{

			return View::make('admin.imgupload.select')
						->with('media', Media::order_by('created_at', 'desc')->get());
		}
	}

	public function post_delete(){

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

			$url = Media::where('id', '=', $id)->only('route');

			if($delete == 'delete'){

				File::delete('public/'.$url);
				Media::delete($id);
				return Redirect::to('admin/imgupload');

			}else{

				return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));

			}
		}
	}
}