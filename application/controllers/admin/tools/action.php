<?php

class Admin_Tools_Action_Controller extends Base_Controller {


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
	 * Change order for item in module.
	 * Like in Blog, Posts, Sections, etc...
	 * 
	 * @param  string  $case  (up|down)
	 * @return Laravel\Redirect
	 */
	public static function post_order($case){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		switch ($case) {
			case 'up':

				if(isset($income_data["group"])){

					$income_data["table"]::find($income_data["table"]::where('order', '<', $income_data["order"])->and_where($income_data["group"]["column"], '=', $income_data["group"]["value"])->order_by('order', 'DESC')->first('id')->id)->increment('order');

				}else{

					if($income_data["order"] > $income_data["table"]::min('order')){

						$income_data["table"]::find($income_data["table"]::where('order', '<', $income_data["order"])->order_by('order', 'DESC')->first('id')->id)->increment('order');

					}
				}

				$income_data["table"]::find($income_data["id"])->decrement('order');

				return Redirect::to(Session::get('href.previous'));

				break;
			
			case 'down':

				if(isset($income_data["group"])){

						$income_data["table"]::find($income_data["table"]::where('order', '>', $income_data["order"])->and_where($income_data["group"]["column"], '=', $income_data["group"]["value"])->order_by('order')->first('id')->id)->decrement('order');

				}else{
					
					if($income_data["order"] < $income_data["table"]::max('order')){

						$income_data["table"]::find($income_data["table"]::where('order', '>', $income_data["order"])->order_by('order')->first('id')->id)->decrement('order');
					}
				}

				$income_data["table"]::find($income_data["id"])->increment('order');

				return Redirect::to(Session::get('href.previous'));

				break;
		}
	}


	/**
	 * Reset order of items in module
	 * 
	 * @return Laravel\Redirect
	 */
	public static function post_order_reset(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if(isset($income_data["group"])){

			foreach($income_data["table"]::order_by('created_at')->group($income_data["group"]["column"])->get() as $key => $value) {

				$i = 0;
				foreach($income_data["table"]::where($income_data["group"]["column"], '=', (string) $key)->order_by('created_at')->get() as $key => $value) {

					$income_data["table"]::where_id($key)->update(array('order'=> ++$i));
				}
			}

		}else{

			$i = 0;
			foreach($income_data["table"]::order_by('created_at')->get() as $key => $value) {

				$income_data["table"]::where_id($key)->update(array('order'=> ++$i));
			}
		}

		return Redirect::to(Session::get('href.previous'));
	}


	/**
	 * Show big Indira CMS's Logo
	 * 
	 * @return Laravel\Redirect
	 */
	public static function get_show_logo(){

		return View::make('admin.assets.logotype');
	}


	/**
	 * Return view with all module settings.
	 * For modules like Blog, Posts, Sections, etc...
	 * 
	 * @param  string  $module  Module name
	 * @return Laravel\View
	 */
	public function get_module_settings($module){

		foreach(Modules::only(array('name')) as $key => $value){

			$modules[] = $value["name"];
		}

		if(in_array(strtolower($module), $modules)){

			$data 					= 	array();
			$data["page"]			= 	'admin.assets.module_settings';
			$data["settings"] 		= 	Modules::where('name', '=', strtolower($module))->only('settings');
			$data["module"] 		= 	$module;

			return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
		}else{

			return 'Undeclared module '.$module;
		}
	}


	/**
	 * Save setting.
	 * For modules like Blog, Posts, Sections, etc...
	 * 
	 * @return string
	 */
	public function post_module_settings_save(){

		foreach(Modules::only(array('name')) as $key => $value){

			$modules[] = $value["name"];
		}

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if(in_array(strtolower($income_data["module"]), $modules)){

			$module = Modules::find(Modules::where('name', '=', strtolower($income_data["module"]))->only('id'));
			$module->settings->$income_data["setting"]->$income_data["option"] = $income_data["value"];
			$module->save();

			return Utilites::alert(__('forms.saved_notification', array('item' => __('forms.'.$income_data["setting"].'_word'))), 'success');

		}else{

			return 'Undeclared module '.$module;
		}
	}
}