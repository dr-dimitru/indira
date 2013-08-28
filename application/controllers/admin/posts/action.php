<?php

class Admin_Posts_Action_Controller extends Base_Controller {
	
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
		$post 				= 	Posts::prepare_results_to_model($income_data);
		$post->text 		= 	preg_replace('#<br>#i', "\n", $post->text);
		$required_fields 	= 	Utilites::prepare_validation('posts');

		if(isset($income_data["link"])){
			
			$income_data["link"] = $post->link = preg_replace('/[\s~@#$^*()+=[\]{}"\'|\\\\,.?:;<>\/ ]/', '', str_replace(' ', '_', $income_data["link"]));
		}

		if(Input::get('new')){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Posts');
		}

		if(isset($post->id)){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Posts,title,'.$post->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		if(Input::get('new')){

			if(!isset($post->lang)){
				
				$post->lang = (isset($income_data["lang"])) ? $income_data["lang"] : Config::get('application.language');
			}

			Posts::where_in('section', $post->section)->increment('order');
			$post->order = '1';
		}

		$post->save();

		if(empty($post->qr_code)){

			$post->qr_code = str_replace('public/', '', Utilites::qrcode(URL::to_asset(Indira::get('modules.posts.link').'/'.$post->id), $post->id.'_post', 4));
			$post->save($post);
		}

		if($post->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $post->title)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.posts.home@edit', array($post->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.post_word', $post->title));

				return View::make('assets.message_redirect', $data); 

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Publish or Unpublish post
	 * 
	 * @return string
	 */
	public function post_publish(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$post 			= 	Posts::find($income_data['id']);

		if($post->published == 'true'){

			$post->published = 'false';
			$return = '<i class="icon-cloud-upload" title="'.__('forms.publish_word').'"></i>';

		}else{

			$post->published = 'true';
			$return = '<i class="icon-minus-sign red" title="'.__('forms.unpublish_word').'"></i>';
		}

		$post->save();

		return $return;
	}


	/**
	 * Delete post by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){
			
			$posts  = Posts::find($data["id"]);
			$status = $posts->delete();

			Posts::where('order', '>', $posts->order)->and_where('section', '=', $posts->section)->decrement('order');

			return ($status) ? Utilites::alert(__('forms.deleted_word'), 'success') : Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}
}