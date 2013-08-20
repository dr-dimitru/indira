<?php

class Admin_Blog_Action_Controller extends Base_Controller {

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
		$blog 				= 	Blog::prepare_results_to_model($income_data);
		$blog->text 		= 	preg_replace('#<br>#i', "\n", $blog->text);
		$required_fields 	= 	Utilites::prepare_validation('blog');

		if(isset($income_data["link"])){
			
			$income_data["link"] = $blog->link = preg_replace('/[\s~@#$^*()+=[\]{}"\'|\\\\,.?:;<>\/ ]/', '', str_replace(' ', '_', $income_data["link"]));
		}

		if(Input::get('new')){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Blog');
		}

		if(isset($blog->id)){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Blog,title,'.$blog->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation);
		}

		if(Input::get('new')){

			Blog::increment('order');
			$blog->order = '1';
		}

		$blog->save();

		if(empty($blog->qr_code)){

			$blog->qr_code = str_replace('public/', '', Utilites::qrcode(URL::to_asset(Indira::get('modules.blog.link').'/'.$blog->id), $blog->id.'_blog', 4));
			$blog->save($blog);
		}


		if($blog->id !== 0){

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $blog->title)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.blog.home@edit', array($blog->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.post_word', $blog->title));

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
		$blog 			= 	Blog::find($income_data['id']);

		if($blog->published == 'true'){

			$blog->published = 'false';
			$return = '<i class="icon-cloud-upload" title="'.__('forms.publish_word').'"></i>';

		}else{

			$blog->published = 'true';
			$return = '<i class="icon-minus-sign red" title="'.__('forms.unpublish_word').'"></i>';
		}

		$blog->save();

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

			foreach(Blog::where_id($data["id"])->get() as $file_id => $row);
			$status = Blog::delete($data["id"]);

			if(Blog::max('order') > $row->order){

				Blog::where('order', '>', (string) $row->order)->decrement('order');
			}

			if($status){

				return Utilites::alert(__('forms.deleted_notification', array('item' => $row->title)), 'success');

			}else{

				return Utilites::alert(__('forms_errors.undefined'), 'error');
			}
		}
	}
}