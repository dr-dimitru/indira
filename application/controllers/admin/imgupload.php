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

			$result = Utilites::uploadimage();

			if($result["move_uploaded_file"]){

				Media::insert(array('url' => URL::to('uploads/'.$result["img_name"]), 'thumbnail'=> URL::to('uploads/thumbnail_'.$result["img_name"]), 'name' => $result["pic"]["name"], 'route' => 'uploads/'.$result["img_name"]));


				$thumbnail = Utilites::resize_image('public/uploads/'.$result["img_name"], $result["img_name"], 190, 190, true);

				imagepng($thumbnail, 'public/uploads/thumbnail_'.$result["img_name"], 9);
				
				if(Input::get('viabutton') == 'true'){

					return Redirect::to('admin/imgupload');

				}elseif(Input::get('viaredactor') == 'true'){

					$json = array();
					$json["filelink"] = URL::to('uploads/'.$result["img_name"]);

					return Response::json($json, 200);

				}else{

					Utilites::exit_status('File was uploaded successfuly!');
				}
			}
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