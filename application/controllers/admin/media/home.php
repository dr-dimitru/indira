<?php
class Admin_Media_Home_Controller extends Base_Controller {


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Make view with upload area 
	 * and all libriary contents as 
	 * thumbnails with lazyload
	 * 
	 * @return Laravel\View
	 */
	public function get_index(){

		Session::put('href.previous', URL::current());

		$data = array();
		$data["page"] = 'admin.media.main';
		$data["media"] = Media::order_by('created_at', 'desc')->get();

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Make view for select images
	 * from redactor.js
	 * 
	 * @return Laravel\View
	 */
	public function post_select(){

		$income_data 		= Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$data 				= array();
		$data["media"] 		= Media::order_by('created_at', 'desc')->get();
		$data["selected"] 	= (isset($income_data["selected"]) && !empty($income_data["selected"])) ? explode(',', $income_data["selected"]) : array();
		$data["column"] 	= (isset($income_data["column"])) ? $income_data["column"] : null;

		return View::make(($income_data['page']) ? $income_data['page'] : 'admin.media.select', $data);
	}


	/**
	 * Download image by provided $id
	 * 
	 * @param  string|int $id
	 * @return Laravel\Response
	 */
	public function get_download($id){

		$data = Media::find($id);

		return Response::download('public/'.$data->original, $data->name);
	}


	/**
	 * Make view with additional
	 * info about picture and it's thumbnail
	 * 
	 * @param  string|int $id
	 * @return Laravel\Response
	 */
	public function get_view($id){

		Session::put('href.previous', URL::current());

		$data 			= 	array();
		$data["page"] 	= 	'admin.media.view';
		$data["image"] 	= 	Media::find($id);
		$data["img"] 	= 	HTML::image(asset($data["image"]->original), $data["image"]->name);
		$data["size"] 	= 	filesize('public/'.$data["image"]->original);
		$data["base64"] = 	base64_encode(file_get_contents('public/'.$data["image"]->original));
		$data["mime"] 	= 	File::mime(File::extension('public/'.$data["image"]->original));

		list($data["width"], $data["height"]) = getimagesize('public/'.$data["image"]->original);

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}
}