<?php

class Admin_Login_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index()
	{	
        if (Admin::check()){
            return Redirect::to('admin/home');
        }

        if(strpos(Session::get('href.previous'), 'admin') === false)
        {
            Session::put('href.previous', URL::current());
        }

        $admin = array();
        $admin["admin_login"] = null;
        $admin["admin_password"] = null;

        if(Cookie::get('admin_login')){
            $admin["admin_login"] = trim(Crypter::decrypt(Cookie::get('admin_login', null)));
        }
        if(Cookie::get('admin_password')){
            $admin["admin_password"] = trim(Crypter::decrypt(Cookie::get('admin_password', null)));
        }

        if (Request::ajax()){
            return View::make('admin.login_session_ended', $admin);
        }else{
            return View::make('admin.not_logged_in', $admin);
        }
	}


	public function post_index()
	{

		$json = stripcslashes(Input::get('data'));
		$json_arr = json_decode($json, true);

		$login = rawurldecode($json_arr["login"]);
		$password = rawurldecode($json_arr["password"]);
		$remember = $json_arr["remember"];

		if(strlen($password) !== 32){

			$password = md5($password);
		}
			
		if($login){

        	$admin_data = Admin::where('name', '=', $login)
                                ->or_where('email', '=', $login)
                                ->get();

        	if(!empty($admin_data))
        	{
        		//FETCH USER DATA
        		foreach($admin_data as $admin){

        			$admin_password = $admin->password;
        			$admin_level = $admin->access;
        		}

        	}else{
        		die(View::make('assets.errors')->with('uni_error', 'incorrect_login_message'));
        	}

        }else{
	       
               die( View::make('assets.errors')->with('uni_error', 'empty_login_message'));;
        }


        //CHECK PASSWORD
        if($password){
        	
                if($password !== $admin_password){
                        
        		die( View::make('assets.errors')->with('uni_error', 'incorrect_pass_message'));
        	}
        }else{
        	
                die( View::make('assets.errors')->with('uni_error', 'incorrect_pass_message'));
        }


        Utilites::adminLogin($login, $remember); //PROCEED LOGIN
			
		return View::make('assets.errors')->with('uni_error', 'admin_success_login');

	}

}