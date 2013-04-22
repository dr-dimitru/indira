<?php

class Utilites{

	public static function resize_image($file, $file_name, $w, $h, $crop=false) {

	    list($width, $height) = getimagesize($file);

	    $r = $width / $height;

	    if ($crop) {

	        if ($width > $height) {

	            //$width = ceil($width-($width*($r-$w/$h)));
	            $width = $height;
	        } else {

	            //$height = ceil($height-($height*($r-$w/$h)));
	            $height = $width;
	        }

	        $newwidth = $w;
	        $newheight = $h;

	    } else {

	        if ($w/$h > $r) {

	            $newwidth = $h*$r;
	            $newheight = $h;

	        } else {

	            $newheight = $w/$r;
	            $newwidth = $w;

	        }
	    }

		$extension = Utilites::get_extension($file_name);

	    if($extension == 'jpg' || $extension == 'jpeg'){

	    	$src = imagecreatefromjpeg($file);

	    }elseif($extension == 'png'){

	    	$src = imagecreatefrompng($file);

	    }elseif($extension == 'gif'){

	    	$src = imagecreatefromgif($file);

	    }

	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    imagealphablending($dst, false);
	    imagesavealpha($dst, true);

	    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	    return $dst;
	}

	public static function uploadimage(){

		$result 		= 	array();
		$demo_mode 		= 	false;
		$upload_dir 	= 	'public/uploads/';
		$allowed_ext 	= 	array('jpg','jpeg','png','gif');


		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){

			Utilites::exit_status('Error! Wrong HTTP method!');

		}

		if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
			
			$result["pic"] = $_FILES['pic'];

			if(!in_array(Utilites::get_extension($result["pic"]['name']),$allowed_ext)){

				Utilites::exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
			}	

			if($demo_mode){
				
				// File uploads are ignored. We only log them.
				
				$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $result["pic"]['size'], $result["pic"]['name']));
				file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
				
				Utilites::exit_status('Uploads are ignored in demo mode.');
			}
			
			
			// Move the uploaded file from the temporary 
			// directory to the uploads folder:
			$result["img_name"] = md5($result["pic"]['name'].mt_rand()).'.'.Utilites::get_extension($result["pic"]['name']);
			
			$result["move_uploaded_file"] = move_uploaded_file($result["pic"]['tmp_name'], $upload_dir.$result["img_name"]);

			return $result;
			
		}

		Utilites::exit_status('Something went wrong with your upload!');

	}


	public static function exit_status($str){

		echo json_encode(array('status'=>$str));
		exit;
	}

	public static function get_extension($file_name){

		$ext = explode('.', $file_name);
		$ext = array_pop($ext);

		return strtolower($ext);
	}

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
		$admin_data = Admin::where('name', '=', $login)->or_where('email', '=', $login)->get();
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

	public static function qrcode($QR_data, $name, $matrixPointSize){		
		//QR-Code SETTINGS
			$filename = $name.'.png';
			$errorCorrectionLevel = 'Q';
			$PNG_WEB_DIR = 'public/uploads/';
			$filename = $PNG_WEB_DIR.$filename;
			
		//RUN QR-Code GENERATION
			QRcode::png($QR_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		return URL::to($filename);
		
	}

	public static function echo_object($object){

		$file = '<div class="well span10">';
		foreach($object as $key => $value){

			$file .= '<table class="table table-bordered"><tr>';
				$file .= '<td style="width: 60px">';
					 $file .= $key.' :';
				$file .= '</td>';
				$file .= '<td>';
					
					if(is_object($value) || is_array($value)){
						
						$file .= static::echo_object($value);
					}else{

						$file .= $value;
					}

				$file .= '</td>';
			$file .= '</tr></table>';

		}
		$file .= '</div>';
		return $file;
	}

	public static function print_type($value){

		if(is_bool($value)){

			return 'boolean';
		}

		if(is_string($value)){

			return 'string';
		}

		if(is_numeric($value)){

			return 'int';
		}

		if(is_object($value)){

			return 'object';
		}

		if(is_array($value)){

			return 'array';
		}
	}
}