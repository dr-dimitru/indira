<?php

class Admin_Newsletter_Action_Controller extends Base_Controller {

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
	 * Send Newsletter by provided id
	 * 
	 * @param  int|string $id
	 * @param  string     $return field to return
	 * @return string
	 */
	static function send_newsletter($id, $return = null){

		$newsletter 	= 	Newsletter::find($id);
		$to 			= 	(stripos($newsletter->to, ',')) ? explode(',', $newsletter->to) : array($newsletter->to);

		Utilites::send_email($to, $newsletter->text, $newsletter->subject, false, array($newsletter->from, $newsletter->from_name), true);

		$newsletter->send_count = strval((int) $newsletter->send_count + 1);
		$newsletter->is_sent = 'true';
		$newsletter->sent_on = strval(time());

		$newsletter->save();

		if($return){

			if(isset($newsletter->{$return})){

				return $newsletter->{$return};
			}
		}

		return Utilites::alert(__('newsletter.sent_notification', array('letter' => $newsletter->title)), 'success');
	}


	/**
	 * Receive data via Input::get('data') as JSON
	 * Check provided data via Laravel\Validator
	 * Save
	 * 
	 * @return string
	 */
	public function post_save(){
			
		$income_data 		= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$newsletter 		= 	Newsletter::prepare_results_to_model($income_data);
		$required_fields 	= 	Utilites::prepare_validation('newsletter');

		if(Input::get('new')){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Newsletter');
			$newsletter->send_count = '0';
		}

		if(isset($newsletter->id)){

			$required_fields['title'] = Utilites::add_to_validation($required_fields['title'], 'unique:Newsletter,title,'.$newsletter->id);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			return Utilites::compose_error($validation, 'newsletter.%s');
		}

		$newsletter->save();

		if($newsletter->id !== 0){

			$send_status = '';

			if(Input::get('send') == 'true'){

				$send_status = static::send_newsletter($newsletter->id);
			}

			$success_message = Utilites::alert(__('forms.saved_notification', array('item' => $newsletter->title)), 'success');

			if(Input::get('new')){

				$data 				= 	array();
				$data["text"] 		= 	$success_message.$send_status;
				$data["data_out"] 	= 	'work_area';
				$data["data_link"] 	= 	action('admin.newsletter.home@edit', array($newsletter->id));
				$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.newsletter', $newsletter->title));

				return View::make('assets.message_redirect', $data); 

			}else{

				return $success_message;
			}

		}else{

			return Utilites::alert(__('forms_errors.undefined'), 'error');
		}
	}


	/**
	 * Show newsletter preview
	 * 
	 * @return Laravel\View
	 */
	public function post_preview(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		$data["subject"] = $income_data["subject"];
		$data["message"] = $income_data["text"];
		$data["lang"] 	 = Session::get('lang');

		return View::make('admin.assets.email_pattern', $data);
	}


	/**
	 * Send newsletter by provided id in POST
	 * 
	 * @return string
	 */
	public function post_send(){

		$income_data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		return static::send_newsletter($income_data['id'], 'send_count');
	}


	/**
	 * Delete newsletter by provided id
	 * 
	 * @return string
	 */
	public function post_delete(){
			
		$data 	= 	Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		if($data["delete"] == 'delete'){

			foreach(Newsletter::where_id($data["id"])->get() as $file_id => $row);
			$status = Newsletter::delete($data["id"]);

			if($status){

				return Utilites::alert(__('forms.deleted_notification', array('item' => $row->title)), 'success');

			}else{

				return Utilites::alert(__('forms_errors.undefined'), 'error');
			}
		}
	}
}