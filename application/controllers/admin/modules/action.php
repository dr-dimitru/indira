<?php

class Admin_Modules_Action_Controller extends Base_Controller {

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
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$module 			= 	Modules::prepare_results_to_model($income_data);
		$module->settings 	= 	json_decode($module->settings, true);
		$required_fields 	= 	Utilites::prepare_validation('modules');

		if($module->settings === null){

			return Utilites::alert(__('forms_errors.json', array('field' => __('forms.settings_word'))), 'error');
		}

		if(isset($income_data["link"])){
			
			$income_data["link"] = $module->link = preg_replace('/[\s~@#$^*()+=[\]{}"\'|\\\\,.?:;<>\/ ]/', '', str_replace(' ', '_', $income_data["link"]));
		}

		if(Input::get('new')){

			$required_fields['name'] = Utilites::add_to_validation($required_fields['name'], 'unique:Modules');
		}

		if(isset($module->id)){

			$required_fields['name'] = Utilites::add_to_validation($required_fields['name'], 'unique:Modules,name,'.$module->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$module->save();

		if($module->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $module->name)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.modules.home@edit', array($module->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.modules_word', $module->name));

				return View::make('assets.message_redirect', $data); 

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Activate or Deactivate Module
	 * 
	 * @return string
	 */
	public function post_activate(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$module 		= 	Modules::find($income_data['id']);

		if($module->active == 'true'){

			$module->active = 'false';
			$return = '<i class="icon-off" title="'.__('forms.no_word').'"></i> <span class="label label-inverse">'.$module->active.'</span>';

		}else{

			$module->active = 'true';
			$return = '<i class="icon-ban-circle red" title="'.__('forms.yes_word').'"></i> <span class="label label-inverse">'.$module->active.'</span>';
		}

		$module->save();

		return $return;
	}


	/**
	 * Restore default Settings
	 * 
	 * @return string
	 */
	public function post_restore_default(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$module 		= 	Modules::find($income_data['id']);

		if(!empty($module->default_settings)){

			$module->settings = $module->default_settings;
			$module->save();

			return Utilites::alert(__('forms.saved_notification', array('item' => $module->name)), 'success');

		}else{

			return Utilites::alert(__('modules.empty_default_error', array('module' => $module->name)), 'error');
		}
	}


	/**
	 * Set current settings as default Settings
	 * 
	 * @return string
	 */
	public function post_set_default(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$module 		= 	Modules::find($income_data['id']);

		if(!empty($module->settings)){
			
			$module->default_settings = $module->settings;
			$module->save();

			return Utilites::alert(__('forms.saved_notification', array('item' => $module->name)), 'success');

		}else{

			return Utilites::alert(__('modules.empty_settings_error', array('module' => $module->name)), 'error');
		}
	}


	/**
	 * Delete post by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){

			$status = Modules::delete($data["id"]);

			if($status){

				return Utilites::alert(__('forms.deleted_word'), 'success');

			}else{

				return Utilites::alert(__('forms_errors.undefined'), 'error');
			}
		}
	}
}