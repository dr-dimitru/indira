<?php

class Admin_Home_Controller extends Base_Controller {


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Return view with welcome message.
	 * Or login form
	 * 
	 * @return Laravel\View
	 */
	public function get_index(){

        if(strpos(Session::get('href.previous'), 'admin') === false){

            Session::put('href.previous', URL::current());
        }

        if(Admin::check()){

	        return (Request::ajax()) ? View::make('admin.login.on_login') : View::make('admin.login.logged_in');
        }

        $admin 					=   array();
        $admin["admin_login"] 	= 	$admin["admin_password"] 	= 	null;
        $admin["json_query"] 	= 	Utilites::json_with_js_encode(array('name' 		=> 	null, 
					        											'password' 	=> 	null, 
					        											'remember' 	=> 	null));

		$admin["login_query"] 	= 	'{ "name": "\'+$(\'#name\').val()+\'", "password": "\'+$(\'#password\').val()+\'", "remember": "\'+$(\'#remember\').val()+\'" }';

        if(Cookie::get('admin_login')){

            $admin["admin_login"] = trim(Crypter::decrypt(Cookie::get('admin_login', null)));
        }

        if(Cookie::get('admin_password')){

            $admin["admin_password"] = trim(Crypter::decrypt(Cookie::get('admin_password', null)));
        }

        return (Request::ajax()) ? View::make('admin.login.session_ended', $admin) : View::make('admin.login.not_logged_in', $admin);
	}


	/**
	 * Log in admin.
	 * 
	 * @return string
	 */
	public function post_login(){

		$income_data 	=   Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
        $admin 			=   Admin::prepare_results_to_model($income_data);
        $required_fields= 	array(	'name' 		=> 'required|email|exists:Admin,email', 
									'password' 	=> 'required|exists:Admin');

		if(strlen($admin->password) !== 32 && !empty($admin->password)){

			$admin->password = $income_data["password"] = md5($admin->password);
		}

		$validation = Validator::make($income_data, $required_fields);

		if($validation->fails() && $validation->errors->has('name')){
					
			$validation = Validator::make($income_data, array('name' => 'required|exists:Admin,name', 'password' => 'required|exists:Admin'));
		}

		if($validation->fails()){
				
			return Utilites::compose_error($validation);
		}
			
		$status = $admin->login($admin, $income_data["remember"]);

		if($status == 'success'){

			$data = array();

			if(strpos(Session::get('href.previous'), 'admin') !== false){

	        	$data["data_link"] 	= Session::get('href.previous');

	        }else{

	       		$data["data_link"] 	= action('admin.home@index');
	        }

			$data["success"] 			= 	true;
			$data["text"] 				= 	__('content.admin_success_login');
			$data["location_replace"]	= 	true;

			return View::make('assets.message_redirect', $data); 

		}else{

			return $status;
		}
	}


	/**
	 * Return view of admin.assets.navbar
	 * We use it to update titles on language switch
	 * 
	 * @return Laravel\View
	 */
	public function post_get_navbar(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$data["url_for_langbar"] = $income_data["uri"];

		return View::make('admin.assets.navbar', $data);
	}


	/**
	 * Return view of admin.assets.password_recovery
	 * 
	 * @return Laravel\View
	 */
	public function get_password_recovery(){

		return View::make('admin.assets.password_recovery');
	}


	/**
	 * Log out admin.
	 * 
	 * @return Laravel\Redirect
	 */
	public function get_logout(){
		
		Session::forget('admin');
		Cookie::forget('admin_id');
		return Redirect::to('admin/home');
	}
}