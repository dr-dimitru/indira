<?php
class Admin_Template_Settings_Action_Controller extends Base_Controller {

	/**
	 * Admin access level for this controller
	 * 
	 * @var int $access
	 */
	public $access = 777;


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Upload icon.
	 * Create multiply sizes for all devices
	 * 
	 * @return Laravel\Redirect
	 */
	public function post_upload_icons(){

		$result = Utilites::uploadimage();

		if($result["move_uploaded_file"]){

			foreach(Template::where('type', '=', 'icon')->only(array('additions')) as $sizes){
				
				$size = $sizes['additions'];

				list($width, $height) = explode('x', $size);

				$icon = Utilites::resize_image('public/uploads/'.$result["img_name"], $result["img_name"], $width, $height, true);
				imagepng($icon, 'public/uploads/icon_'.$size.'.png', 4);

				Template::where('type', '=', 'icon')->and_where('additions', '=', $size)->update(array('value' => 'uploads/icon_'.$size.'.png'));
			}
			
			return Redirect::to_action('admin.template_settings.home@index');
		}
	}


	/**
	 * Upload apple startup image (splash scree for iOS-web app).
	 * Create multiply sizes for all devices
	 * 
	 * @return Laravel\Redirect
	 */
	public function post_upload_startup_image(){

		$result = Utilites::uploadimage();

		if($result["move_uploaded_file"]){

			foreach(Template::where('type', '=', 'apple-touch-startup-image')->get() as $row){
				
				list($size, $media_query) = explode(',', $row->additions);

				list($width, $height) = explode('x', $size);

				$rotate = false;

				$icon = Utilites::resize_image('public/uploads/'.$result["img_name"], $result["img_name"], $width, $height, true, $rotate);
				imagepng($icon, 'public/uploads/'.$row->name.'.png', 9);

				Template::where('type', '=', 'apple-touch-startup-image')->and_where('name', '=', $row->name)->update(array('value' => 'uploads/'.$row->name.'.png'));

				unset($icon, $row, $width, $height, $size, $media_query);
			}
			
			return Redirect::to_action('admin.template_settings.home@index');
		}
	}


	/**
	 * Upload shortcut icon (Favicon).
	 * Create multiply sizes and formats for all devices
	 * 
	 * @return Laravel\Redirect
	 */
	public function post_upload_favicon(){

		$result = Utilites::uploadimage();

		if($result["move_uploaded_file"]){

			$ico_lib = new Phpico('public/uploads/'.$result["img_name"], array(array(16, 16),array(24, 24), array(32, 32), array(57, 57), array(64, 64), array(72, 72), array(128, 128)));

			$ico_lib->save_ico('public/uploads/favicon.ico');
			Template::where('type', '=', 'shortcut icon')->and_where('name', '=', 'image/x-icon')->update(array('value' => 'uploads/favicon.ico'));

			list($width, $height) = explode('x', Template::where('type', '=', 'shortcut icon')->and_where('name', '=', 'image/png')->only('additions'));
			$faviconpng = Utilites::resize_image('public/uploads/'.$result["img_name"], $result["img_name"], $width, $height, true);
			imagepng($faviconpng, 'public/uploads/favicon.png');

			Template::where('type', '=', 'shortcut icon')->and_where('name', '=', 'image/png')->update(array('value' => 'uploads/favicon.png'));
			
			return Redirect::to_action('admin.template_settings.home@index');
		}
	}


	/**
	 * Receive data via Input::get('data') as JSON
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$setting 		= 	Template::prepare_results_to_model($income_data);

		$setting->save();

		return Utilites::alert(__('forms.saved_notification', array('item' => $setting->type.': '.$setting->name)), 'success');
	}


	/**
	 * Set default template
	 * 
	 * @return string
	 */
	public function post_save_default_template(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$template 		= 	Templates::find($income_data["value"]);

		$template->active = 'true';
		$template->save();

		Templates::where('id', '<>', $template->id)->and_where('is_mobile', '=', 'false')->update(array('active' => 'false'));

		return Utilites::alert(__('forms.saved_notification', array('item' => __('template_settings.default_template'))), 'success');
	}


	/**
	 *Set default Mobile template
	 * 
	 * @return string
	 */
	public function post_save_default_mobile_template(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$template 		= 	Templates::find($income_data["value"]);

		$template->active = 'true';
		$template->save();

		Templates::where('id', '<>', $template->id)->and_where('is_mobile', '=', 'true')->update(array('active' => 'false'));

		return Utilites::alert(__('forms.saved_notification', array('item' => __('template_settings.default_mobile_template'))), 'success');
	}


	/**
	 * Toggle mobile template on/off
	 * 
	 * @return string
	 */
	public function post_mobile_toggle(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$mobile 		= 	Templates::where('is_mobile', '=', 'true')->first();
		$mobile->active = 	$income_data["turn"];
		$mobile->save();

		$templates 				= 	Templates::init();
		$data["d_templates"]	= 	$templates->where('is_mobile', '=', 'false')->get();
		$data["m_templates"]	= 	$templates->where('is_mobile', '=', 'true')->get();
		$data["mobile_active"]	= 	($templates->where('is_mobile', '=', 'true')->and_where('active', '=', 'true')->get()) ? true : false;

		return View::make('admin.template_settings.control_panel', $data);
	}
}