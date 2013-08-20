<?php
class Admin_Media_Action_Controller extends Base_Controller {


	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 600;


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Upload image via Input::get('pic')
	 * Creating thumbnail
	 * 
	 * @return Laravel\Redirect|Laravel\Response|JSON|string
	 */
	public function post_index(){

		$result = Utilites::uploadimage();

		if($result["move_uploaded_file"]){

			$image_id = Media::insert(array('original' => 'uploads/'.$result["img_name"], 'name' => $result["pic"]["name"]));

			if($image_formats = Modules::where('name', '=', 'media')->only('settings')){

				foreach ($image_formats->formats as $name => $data) {

					imagejpeg(Utilites::resize_image('public/uploads/'.$result["img_name"], $result["img_name"], $data->width, $data->height, $data->crop), 'public/uploads/'.$name.'_'.$result["img_name"], 75);

					$update_data[$name] = 'uploads/'.$name.'_'.$result["img_name"];
				}

				Media::where_id($image_id)->update(array('formats' => $update_data));
			}
			
			if(Input::get('viabutton') == 'true'){

				return Redirect::to_action('admin.media.home@index');

			}elseif(Input::get('return_id') == 'true'){

				return $image_id;

			}elseif(Input::get('return_holder') == 'true'){

				$holder = '<div id="holder_'.$image_id.'" class="preview">';
				$holder .= '<span class="imageHolder">';
				$holder .= '<img class="lazy" style="max-height: 150px; height: 150px;" src="'.asset('uploads/gallery_thumbnail_'.$result["img_name"]).'" />';
				$holder .= '<span class="uploaded" onclick="addimage(\''.$image_id.'\', \''.asset('uploads/gallery_thumbnail_'.$result["img_name"]).'\')"></span></span></div>';

				return $holder;
				
			}elseif(Input::get('viaredactor') == 'true'){

				$json = array();
				$json["filelink"] = asset('uploads/'.$result["img_name"]);

				return Response::json($json, 200);

			}else{

				Utilites::exit_status('File was uploaded successfuly!');
			}
		}
	}


	/**
	 * Deleting picture and it's thumbnail
	 * By provided id
	 * 
	 * @return string
	 */
	public function post_delete(){

		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$media 	= 	Media::find($data["id"]);

		if($data["delete"] == 'delete'){

			$name = str_replace('uploads/', '', $media->original);

			foreach (glob("public/uploads/*".$name) as $filename) {

				File::delete($filename);
			}

			Media::delete($data["id"]);
			return Utilites::alert(__('forms.deleted_notification', array("item" => $media->name)), "success");

		}else{

			return __('forms_errors.undefined');
		}
	}


	/**
	 * Deleting pictures and theirs thumbnails
	 * By provided array of ids
	 * 
	 * @return Laravel\Redirect
	 */
	public function post_delete_many(){

		$data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if(!empty($data["id"])){

			$data["id"] = explode(' ', $data["id"]);
		
		}else{

			return 'no pictures selected';
		}


		$media 	= 	Media::where('id', '=', $data["id"])->get();

		if($data["delete"] == 'delete' && $media){

			foreach ($media as $file_is => $row) {

				$name = str_replace('uploads/', '', $row->original);

				foreach (glob("public/uploads/*".$name) as $filename) {

					File::delete($filename);
				}

			}
			
			Media::where('id', '=', $data["id"])->delete();

		}else{

			return __('forms_errors.undefined');
		}


		return Redirect::to_action('admin.media.home@index');
	}
}