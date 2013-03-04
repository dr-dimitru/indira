<?php

class Utilites{
	public static function send_email($email, $message, $subject)
	{
		$default_files_encoding = Config::get('application.encoding');
		
		$site_noreply_email = Config::get('application.no-reply_email');
		$site_email = Config::get('application.site_email');
		$site_title = Config::get('application.name');
		
		$headers = 'Content-type: text/html; charset='.$default_files_encoding."\r\n";
		$headers .= 'From: '.$site_title.' <'.$site_noreply_email.'>' . "\r\n";
		$headers .= 'Bcc: '.$site_title.' <'.$site_email.'>' . "\r\n";
		
		mail($email, $subject, $message, $headers);
	}

	public static function generate_password(){

		$pass = mt_rand(100000, 900000);
		$pass = md5($pass + time());
		$pass = mb_strcut($pass, 1, 7);

		return $pass;

	}

	public static function password_recovery($email, $admin=null)
	{

		if(empty($email) || !preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email))
		{
			die(View::make('assets.errors')->with('uni_error', 'incorrect_email_message'));
		}
		else
		{
			//CHECK USER
			if($admin){
				$user_data = Admin::where('email', '=', $email)->get();
			}else{
				$user_data = Users::where('email', '=', $email)->get();
			}
			if(!empty($user_data))
			{
				$new_pass = Utilites::generate_password();
				$new_pass_md5 = md5($new_pass);
				
				//SETUP NEW PASSWORD
				if($admin){
					Admin::where('email', '=', $email)->update(array('password'=>$new_pass_md5));
				}else{
					Users::where('email', '=', $email)->update(array('password'=>$new_pass_md5));
				}
				
				//SEND EMAIL WITH NEW PASSWORD
				$message = sprintf(Lang::line('content.password_recovery_email_text')->get(Session::get('lang')), $email, $new_pass);
				$subject = Lang::line('content.password_recovery_email_subject')->get(Session::get('lang'));
				Utilites::send_email($email, $message, $subject);
				
				//SHOW SUCCESS MESSAGE
				return View::make('assets.errors')->with('uni_error', 'user_success_recovery');
			}
			else
			{
				return View::make('assets.errors')->with('uni_error', 'incorrect_login_message');
			}
		}
	}

	public static function single_array_to_object($array){
		foreach ($array as $key => $value);
		$object = $value;
		return $object;
	}

	public static function userLogin($login, $level=null, $remember)
	{	
		$user_data = Users::where('email', '=', $login)->get();
		foreach($user_data as $user)
		{
			if(empty($level))
			{
				Session::put('user.access_level', $user->access);
			}
			else
			{
				Session::put('user.access_level', $level);
			}
			Session::put('user.name', $user->name);
			Session::put('user.email', $user->email);
			Session::put('userdata.login', $user->email);
			Session::put('userdata.pass', $user->password);
			
			if($remember){
				Cookie::forever('userdata_id', $user->id);
				Cookie::forever('userdata_login', Crypter::encrypt($user->email));
				Cookie::forever('userdata_pass', Crypter::encrypt($user->password));
				Cookie::forever('user_name', Crypter::encrypt($user->name));
				if(empty($level))
					{
						Cookie::forever('user_access_level', Crypter::encrypt($user->access));
					}
					else
					{
						Cookie::forever('user_access_level', Crypter::encrypt($level));
					}
			}else{
				Cookie::forget('userdata_login');
				Cookie::forget('userdata_pass');
				Cookie::forget('user_name');
				Cookie::forget('user_access_level');
			}
		}
		
	}

	public static function adminLogin($login, $remember)
	{	
		$admin_data = Admin::where('name', '=', $login)->get();
		foreach($admin_data as $admin)
		{
			
			Session::put('admin.id', $admin->id);
			Session::put('admin.login', $admin->name);
			Session::put('admin.password', $admin->password);
			Session::put('admin.access', $admin->access);
			Session::put('user.access_level', $admin->access);
			
			if($remember){

				Cookie::forever('admin_id', $admin->id);
				Cookie::forever('admin_login', Crypter::encrypt($admin->name));
				Cookie::forever('admin_password', Crypter::encrypt($admin->password));
				Cookie::forever('admin_access', Crypter::encrypt($admin->access));
				
			}else{

				Cookie::forget('admin_id');
				Cookie::forget('admin_login');
				Cookie::forget('admin_password');
				Cookie::forget('admin_access');

			}
		}
		
	}

	public static function revokeAdmin()
	{
		
		Session::put('admin.id', Cookie::get('admin_id', null));
		Session::put('admin.login', Crypter::decrypt(Cookie::get('admin_login', null)));
		Session::put('admin.password', Crypter::decrypt(Cookie::get('admin_password', null)));
		Session::put('admin.access', Crypter::decrypt(Cookie::get('admin_access', null)));

	}

	public static function revokeUser()
	{
		
		Session::put('user.name', Crypter::decrypt(Cookie::get('user_name', null)));
		Session::put('user.email', Crypter::decrypt(Cookie::get('userdata_login', null)));
		Session::put('userdata.login', Crypter::decrypt(Cookie::get('userdata_login', null)));
		Session::put('userdata.pass', Crypter::decrypt(Cookie::get('userdata_pass', null)));
		Session::put('user.access_level', Crypter::decrypt(Cookie::get('user_access_level', null)));

	}
}