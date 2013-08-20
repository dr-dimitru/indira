<?php

class Admin_Sections_Action_Controller extends Base_Controller {

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
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){	
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$section 			= 	Sections::prepare_results_to_model($income_data);
		$required_fields 	= 	Utilites::prepare_validation('sections');

		$section->parent 		=
		$income_data["parent"] 	= 	(!$income_data["parent"]) ? "false" : $income_data["parent"];

		if(isset($income_data["link"])){
			
			$income_data["link"] = $section->link = preg_replace('/[\s~@#$^*()+=[\]{}"\'|\\\\,.?:;<>\/ ]/', '', str_replace(' ', '_', $income_data["link"]));
		}

		if(Input::get('new')){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Sections');
		}

		if(isset($section->id)){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Sections,title,'.$section->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		if(Input::get('new')){

			Sections::where_in('lang', $section->lang)->increment('order');
			$section->order = '1';
		}

		$section->save();


		if($section->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification',  array('item' => $section->title)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.sections.home@edit', array($section->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.section_word', $section->title));

				return View::make('assets.message_redirect', $data); 

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Delete Section by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){
			
			$section = Sections::find($data["id"]);
			$status  = $section->delete();

			Sections::where('order', '>', $section->order)->and_where('lang', '=', $section->lang)->decrement('order');

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}