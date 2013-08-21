<?php

class Templates_User_Controller extends Templates_Base_Controller {

	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;

	/**
	 * Log in user.
	 * 
	 * @return string
	 */
	public function post_login(){

		$income_data 	=   Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$user 			=   Users::prepare_results_to_model($income_data);
		$required_fields= 	array(	'email' 	=> 'required|email|exists:Users,email', 
									'password' 	=> 'required|exists:Users');

		if(strlen($user->password) !== 32 && !empty($user->password)){

			$user->password = $income_data["password"] = md5($user->password);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails()){

			$iforgot = '<button onclick="$(\'#user_login_form\').slideToggle();$(\'#user_iforgot\').slideToggle()" class="btn btn-block" type="button">'.__("content.pass_recovery_word").'</button>';
				
			return Utilites::compose_error($validation).$iforgot;
		}

		$user = Users::find($income_data['email'], 'email');
			
		$status = Utilites::user_login($user->email, $user->access, $income_data["remember"]);

		if($status == 'success'){

			$data 						= 	array();
			$data["data_link"] 			= 	Session::get('href.previous');
			$data["success"] 			= 	true;
			$data["text"] 				= 	__('templates::content.success_login');
			$data["location_replace"]	= 	true;

			return View::make('assets.message_redirect', $data); 

		}else{

			return $status;
		}
	}


	/**
	 * Reset Admin's password
	 * 
	 * @return string
	 */
	public function post_signup(){

		return Controller::call('admin.users.action@save');
	}


	/**
	 * Logout user.
	 * 
	 * @return string
	 */
	public function get_logout(){

		Session::forget('user');
		Cookie::forget('user_id');
		Cookie::forget('user_access');

		$data 						= 	array();
		$data["data_link"] 			= 	Session::get('href.previous');
		$data["success"] 			= 	true;
		$data["text"] 				= 	__('templates::content.success_logout');
		$data["location_replace"]	= 	true;
		return View::make('assets.message_redirect', $data); 
	}
}