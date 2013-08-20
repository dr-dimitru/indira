<?php

class Admin_Pages_Action_Controller extends Base_Controller {
	
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
		$page 				= 	Pages::prepare_results_to_model($income_data);
		$required_fields 	= 	Utilites::prepare_validation('pages');

		if(isset($income_data["link"])){
			
			$income_data["link"] = $page->link = preg_replace('/[\s~@#$^*()+=[\]{}"\'|\\\\,.?:;<>\/ ]/', '', str_replace(' ', '_', $income_data["link"]));
		}

		if(Input::get('new')){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Pages');
		}

		if(isset($page->id)){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Pages,title,'.$page->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		$page->save();

		if($page->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $page->title)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.pages.home@edit', array($page->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.pages_word', $page->title));

				return View::make('assets.message_redirect', $data); 

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Publish or Unpublish page
	 * 
	 * @return string
	 */
	public function post_publish(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$page 			= 	Pages::find($income_data['id']);

		if($page->published == 'true'){

			$page->published = 'false';
			$return = '<i class="icon-cloud-upload" title="'.__('forms.publish_word').'"></i>';

		}else{

			$page->published = 'true';
			$return = '<i class="icon-minus-sign red" title="'.__('forms.unpublish_word').'"></i>';
		}

		$page->save();

		return $return;
	}


	/**
	 * Delete page by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){
			
			$status = Pages::delete($data["id"]);

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}