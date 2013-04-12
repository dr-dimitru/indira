<?php

class Users extends Filedb
{

	public static $table = 'users';

	public static $model = array(	'id' => '', 
									'name' => '', 
									'email' => '', 
									'password' => '', 
									'access' => '', 
									'created_at' => '', 
									'updated_at' => '');

	public static function userRegistration($name, $login, $password, $level=null){

		$user = array(
			'name' =>$name,
			'email' => $login,
			'password' => $password,
			'access' => $level
		);

		return Users::insert($user);
	}
	
	public static function retreiveCurrentUserData() {
	    if(!is_null(Cookie::get('userdata_pass'))){
	        $user_pass = trim(Crypter::decrypt(Cookie::get('userdata_pass')));
	    }else{
	        if(Session::get('userdata.pass')){
	            $user_pass = Session::get('userdata.pass');
	        }else{
	            $user_pass = null;
	        }
	    }
	    
	    if(!is_null(Cookie::get('userdata_login'))){
	        $user_login = trim(Crypter::decrypt(Cookie::get('userdata_login')));
	    }else{
	        if(Session::get('userdata.login')){
	            $user_login = Session::get('userdata.login');
	        }else{
	            $user_login = null;
	        }
	    }
	    
	    $userdata['user_login'] = $user_login;
	    $userdata['user_pass'] = $user_pass;
	    
	    return $userdata;
	}
}