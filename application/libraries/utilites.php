<?php

class Utilites{

	/**
	 * Separator for page tag <title>
	 *
	 * @var $title_separator
	**/
	static $title_separator = '';


	/**
	 * All used tags
	 *
	 * @var $all_tags
	**/
	static $all_tags = array();


	/**
	* Prepare POST data to model
	* 
	*
	* @param Laravel\Eloquent|Filedb $table
	* @param string                  $table_name
	* @param array                   $income_data
	* @return Laravel\Eloquent|Filedb
	*/
	public static function prepare_results_to_model($table, $table_name, $income_data){

		if(get_parent_class($table) !== 'Filedb'){

			if(isset($income_data["id"])){

				$table = $table->find(intval($income_data["id"]));
			}
			
			$model = static::sql_table_model(strtolower($table_name));

			foreach($model as $model_key => &$default_value){

				if(array_key_exists($model_key, $income_data)){

					if($model_key == 'updated_at' || $model_key == 'created_at'){

						if(!is_numeric($income_data[$model_key])){ 

							$income_data[$model_key] = (string) (strtotime($income_data[$model_key])) ? strtotime($income_data[$model_key]) : $income_data[$model_key];
						}
					}

					$table->{$model_key} = $income_data[$model_key];
				}

				unset($model_key, $default_value);
			}

			return $table;

		}else{

			return $table::prepare_results_to_model($income_data);
		}
	}


	/**
	* Run php artisan commands
	*
	* @param string $method ex.: 'migration:make'
	* @param string $param  ex.: 'create_tablename_table'
	* @return string
	*/
	public static function run_artisan($method, $param){

		require_once path('sys') . 'cli' . DS . 'dependencies' . EXT;
		return Command::run(array($method, $param));
	}


	/**
	* Check if provide string is JSON
	*
	* @param string $string
	* @return boolean
	*/
	public static function is_json($string){

		if(is_string($string)){

			json_decode($string);
			return (json_last_error() == JSON_ERROR_NONE);
		
		}else{

			return false;
		}
	}


	/**
	* Get array of SQL table's columns
	* and it's settings
	*
	* @param string $table_name
	* @param boolean $with_columns
	* @return array
	*/
	public static function sql_table_model($table_name, $with_columns = false){

		$table = DB::query('SELECT * FROM information_schema.columns WHERE table_schema = database() AND table_name = ?', array(strtolower($table_name)));

		foreach ($table as $key => &$value) {
		
			$model[$value->column_name] = '';

			$columns[$value->column_name] = array('data_type' => $value->data_type, 'character_maximum_length' => $value->character_maximum_length, 'numeric_precision' => $value->numeric_precision, 'numeric_scale' => $value->numeric_scale);

			unset($key, $value);
		}

		unset($table);

		if($with_columns){

			return array($model, $columns);
		
		}else{

			return $model;
		}
	}

	/**
	* Get array of all tags used in CMS
	*
	* @return JSON
	*/
	public static function get_all_tags(){

		if(empty(static::$all_tags)){

			$all_tags = array();

			if($posts = Posts::get(array('tags'))){

				foreach ($posts as $file_id => &$row) {
				
					$all_tags = array_merge($all_tags, explode(',', $row->tags));

					unset($file_id, $row);
				}
			}

			if($blog = Blog::get(array('tags'))){
				
				foreach ($blog as $file_id => &$row) {
				
					$all_tags = array_merge($all_tags, explode(',', $row->tags));

					unset($file_id, $row);
				}
			}

			if($pages = Pages::get(array('tags'))){

				foreach ($pages as $file_id => &$row) {
				
					$all_tags = array_merge($all_tags, explode(',', $row->tags));

					unset($file_id, $row);
				}
			}

			if(!empty($all_tags)){
				
				foreach ($all_tags as $key => &$value) {
					
					$all_tags[$key] = trim($value);

					unset($key, $value);
				}
			
				static::$all_tags = array_unique($all_tags);
			}
		}

		return json_encode(array_values(static::$all_tags));
	}


	/**
	 * Resizing image to given width and height, optionally - image cropping
	 *
	 * @param  string   $file
	 * @param  string   $file_name
	 * @param  string   $w
	 * @param  string   $h
	 * @param  boolean  $crop
	 * @param  int  	$rotate degrees anticlockwise to gotate the image
	 * @return resource $dst
	 */
	public static function resize_image($file, $file_name, $w, $h, $crop=false, $rotate=false) {

	    list($width, $height) = getimagesize($file);

	    $r = $width / $height;
	    $x = 0;
	    $y = 0;

	    if ($crop) {

	    	$ratio_width = $width / $w;
	    	$ratio_height = $height / $h;

	    	$constrict_orig = $height / $width;
        	$constrict_crop = $h / $w;
        	$height_new = $h;
        	$width_new = $w;

	        if($constrict_crop == $constrict_orig){

	        	$constrict_height = true;
	        	$constrict_width = true;
        		$height_new = $h;
        		$width_new = $w;
	        	
        	}else{

        		if($ratio_height < $ratio_width){

        			$width_new = ($h * $width) / $height;
        			$height_new = $h;

        			$x = -($width_new - $w) / 2;
        		}

        		if($ratio_height > $ratio_width){

        			$width_new = $w;
        			$height_new = ($w * $height) / $width;

        			$y = -($height_new - $h) / 2;
        		}
	        }

	    } else {

	        if($w / $h > $r){

	            $w = $width_new = $h * $r;
	            $height_new = $h;

	        }else{

	            $h = $height_new = $w / $r;
	            $width_new = $w;

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

		$dst = imagecreatetruecolor($w, $h);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		if($rotate){

			$dst = imagerotate($dst, $rotate, 0);
		}

		imagecopyresampled($dst, $src, $x, $y, 0, 0, $width_new, $height_new, $width, $height);

	    return $dst;
	}

	/**
	 * Uploading image, function search $_FILES array for 'pic' key.
	 *
	 * @return array $result
	 */
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

	/**
	 * Helper class for uploadimage method
	 *
	 * @return JSON
	 */
	public static function exit_status($str){

		echo json_encode(array('status'=>$str));
		exit;
	}

	/**
	 * Getting extention of provided file
	 *
	 * @param  string $file_name
	 * @return string $ext
	 */
	public static function get_extension($file_name){

		$ext = explode('.', $file_name);
		$ext = array_pop($ext);

		return strtolower($ext);
	}


	/**
	 * Indenting JSON string (Prettify)
	 *
	 * @param  JSON $json
	 * @return string|JSON
	 */
	static function prettify_json($json) {

	    $result      = '';
	    $pos         = 0;
	    $strLen      = strlen($json);
	    $indentStr   = '  ';
	    $newLine     = "\n";
	    $prevChar    = '';
	    $outOfQuotes = true;

	    for ($i=0; $i<=$strLen; $i++) {

	        // Grab the next character in the string.
	        $char = substr($json, $i, 1);

	        // Are we inside a quoted string?
	        if ($char == '"' && $prevChar != '\\') {
	            $outOfQuotes = !$outOfQuotes;
	        
	        // If this character is the end of an element, 
	        // output a new line and indent the next line.
	        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
	            $result .= $newLine;
	            $pos --;
	            for ($j=0; $j<$pos; $j++) {
	                $result .= $indentStr;
	            }
	        }
	        
	        // Add the character to the result string.
	        $result .= $char;

	        // If the last character was the beginning of an element, 
	        // output a new line and indent the next line.
	        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
	            $result .= $newLine;
	            if ($char == '{' || $char == '[') {
	                $pos ++;
	            }
	            
	            for ($j = 0; $j < $pos; $j++) {
	                $result .= $indentStr;
	            }
	        }
	        
	        $prevChar = $char;
	    }

	    return $result;
	}

	/**
	 * Prepare show by logic element based quantity of table records
	 *
	 * @param  int $table_records
	 * @return array $data
	 */
	public static function show_by_logic($table_records){

		$data = array();

		if(($table_records / 4) <= 10){

			$data["show_by_hop"] = 5;

		}elseif(($table_records / 4) <= 80){

			$data["show_by_hop"] = ceil(($table_records / 4) / 10) * 10;

		}else{

			$data["show_by_hop"] = 30;
		}

		if($table_records < 80){

			$data["show_by_limit"] = $table_records;
		
		}else{

			$data["show_by_limit"] = 80;
		}

		return $data;
	}

	/**
	 * Sending email using site settings.
	 *
	 * @param  array  $to        array(email => name)|array(email1, email2,...)
	 * @param  string $message
	 * @param  string $subject
	 * @param  bool   $get_copy
	 * @param  array  $from      array(email, name)
	 * @param  bool   $via_bcc
	 * @return void
	 */
	public static function send_email($to, $message, $subject, $get_copy = false, $from = array(), $via_bcc = false){

		$charset 		= Config::get('application.encoding');
		$admin_email 	= Config::get('indira.email.admin');
		$site_title 	= Config::get('indira.name');

		if(!$from){

			$from[0] 	= Config::get('indira.email.no-reply');
			$from[1] 	= Config::get('indira.name');
		}

		$data["subject"] = $subject;
		$data["message"] = $message;
		$data["lang"] 	 = Session::get('lang');

		$message_body = View::make('admin.assets.email_pattern', $data)->render();

		if(Config::get('indira.email.smtp.host') && Config::get('indira.email.smtp.password') && Config::get('indira.email.smtp.username')){

			Config::set('messages::config.transports.smtp.host', Config::get('indira.email.smtp.host'));
			Config::set('messages::config.transports.smtp.port', (Config::get('indira.email.smtp.port')) ? (int) Config::get('indira.email.smtp.port') : 25);
			Config::set('messages::config.transports.smtp.username', Config::get('indira.email.smtp.username'));
			Config::set('messages::config.transports.smtp.password', Config::get('indira.email.smtp.password'));

			$message = Message::instance();

			if($via_bcc){

				if($get_copy){

					$message->bcc(array_merge($to, array($admin_email => $site_title)));

				}else{

					$message->bcc($to);
				}

			}else{

				$message->to($to);
			}

			$message->from($from[0], $from[1]);
			$message->subject($subject);
			$message->body($message_body);
			$message->html(true);

			if($get_copy && !$via_bcc){

				$message->bcc(array($admin_email => $site_title));
			}

			$message->send();

			if(Message::was_sent()){

				//die(var_dump("sent via Messages"));
			}

		}else{

			foreach ($to as $email => $name) {
			
				$headers = 'Content-type: text/html; charset='.$charset."\r\n";
				$headers .= 'From: '.$from[1].' <'.$from[0].'>' . "\r\n";

				if($get_copy){

					$headers .= 'Bcc: '.$site_title.' <'.$admin_email.'>' . "\r\n";
				}
				
				mail((stripos($email, '@')) ? $email : $name, $subject, $message_body, $headers);
			}
		}
	}

	/**
	 * Generating random 6 symbols length password.
	 *
	 * @return string $pass
	 */
	public static function generate_password(){

		$pass = mt_rand(100000, 900000);
		$pass = md5($pass + time());
		$pass = mb_strcut($pass, 1, 7);

		return $pass;

	}

	/**
	 * Saving new user data and sending email.
	 *
	 * @param  Users  $user
	 * @return string
	 */
	public static function user_registration($user){

		$subject = __('emails.registration_subject');
		$message = __('emails.registration_text', array('password' => $user->password, 'login' => $user->email));
		Utilites::send_email(array($user->email => $user->name), $message, $subject);

		$user->password = md5($user->password);

		return $user->save();
	}

	/**
	 * Recovering and sending confirmation email to user or admin.
	 *
	 * @param  string $email
	 * @param  bool   $admin
	 * @return string
	 */
	public static function password_recovery($email, $admin=false){

		$table = ($admin) ? 'Admin' : 'Users';
		$validation = Validator::make(array('email' => $email), array('email' => 'required|email|exists:'.$table.',email'));

		if($validation->fails()){
					
			return Utilites::compose_error($validation);
		}

		$new_pass 		= Utilites::generate_password();
		$new_pass_md5 	= md5($new_pass);

		// $table::where('email', '=', $email)->update(array('password'=>$new_pass_md5));
		$user = $table::find($email, 'email');
		$user->password = $new_pass_md5;

		$subject = __('emails.password_recovery_subject');
		$message = __('emails.password_recovery_text', array('password' => $new_pass, 'login' => $email));

		Utilites::send_email(array($email => $user->name), $message, $subject);

		$user->save();
		
		return Utilites::success_message(__('content.success_recovery'));
	}

	/**
	 * Logging user in via email with given access level
	 *
	 * @param  string $login
	 * @param  string $level
	 * @param  bool   $remember
	 * @return void
	 */
	public static function user_login($login, $level=null, $remember)
	{	
		$user = Users::find($login, 'email');

		if($user){

			Session::put('user.id', $user->id);
			Session::put('user.name', $user->name);
			Session::put('user.email', $user->email);
			Session::put('user.login', $user->email);
			Session::put('user.password', $user->password);
			Session::put('user.access', (empty($level)) ? $user->access : $level);
			
			if($remember){

				Cookie::forever('user_id', $user->id);
				Cookie::forever('user_name', Crypter::encrypt($user->name));
				Cookie::forever('user_email', Crypter::encrypt($user->email));
				Cookie::forever('user_login', Crypter::encrypt($user->email));
				Cookie::forever('user_password', Crypter::encrypt($user->password));
				Cookie::forever('user_access', Crypter::encrypt((empty($level)) ? $user->access : $level));

			}else{

				Cookie::forget('user_id');
				Cookie::forget('user_name');
				Cookie::forget('user_email');
				Cookie::forget('user_login');
				Cookie::forget('user_password');
				Cookie::forget('user_access');
			}

			return 'success';
		
		}else{

			return 'fail';
		}		
	}

	/**
	 * Logging admin in via email or name.
	 *
	 * @param  string $admin
	 * @param  bool   $remember
	 * @return void
	 */
	public static function admin_login($admin, $remember){

			
		Session::put('admin.id', $admin->id);
		Session::put('admin.login', $admin->name);
		Session::put('admin.password', $admin->password);
		Session::put('admin.access', $admin->access);
		Session::put('user.access', $admin->access);
		Cookie::forever('user_access', Crypter::encrypt($admin->access));
		
		if($remember){

			Cookie::forever('admin_id', $admin->id);
			Cookie::forever('admin_login', Crypter::encrypt($admin->name));
			Cookie::forever('admin_password', Crypter::encrypt($admin->password));
			Cookie::forever('admin_access', Crypter::encrypt($admin->access));
			
		}
	}

	/**
	 * Updates admin data in session from cookies.
	 *
	 * @return void
	 */
	public static function revokeAdmin(){
		
		if(Cookie::get('admin_id')){
			Session::put('admin.id', Cookie::get('admin_id', null));
			Session::put('admin.login', Crypter::decrypt(Cookie::get('admin_login', null)));
			Session::put('admin.password', Crypter::decrypt(Cookie::get('admin_password', null)));
			Session::put('admin.access', Crypter::decrypt(Cookie::get('admin_access', null)));
			Session::put('user.access', Crypter::decrypt(Cookie::get('admin_access', null)));
		}
	}

	/**
	 * Updates user data in session from cookies.
	 *
	 * @return void
	 */
	public static function revokeUser(){
		
		if(Cookie::get('user_id')){
			Session::put('user.id', Cookie::get('user_id', null));
			Session::put('user.name', Crypter::decrypt(Cookie::get('user_name', null)));
			Session::put('user.email', Crypter::decrypt(Cookie::get('user_login', null)));
			Session::put('user.login', Crypter::decrypt(Cookie::get('user_login', null)));
			Session::put('user.password', Crypter::decrypt(Cookie::get('user_password', null)));
			Session::put('user.access', Crypter::decrypt(Cookie::get('user_access', null)));
		}
	}

	/**
	 * Generate QRCode.
	 * Copyright Dominik Dzienia
	 * Read more about PHPQrcode libriary: http://phpqrcode.sourceforge.net/
	 * http://sourceforge.net/p/phpqrcode/wiki/Home/
	 *
	 * @param  string $QR_data
	 * @param  string $name
	 * @param  int    $matrixPointSize
	 * @param  string $directory
	 * @param  string $errorCorrectionLevel  ECC
	 * @return string
	 */
	public static function qrcode($QR_data, $name, $matrixPointSize, $directory='public/uploads/', $errorCorrectionLevel = 'Q'){		
		//QR-Code SETTINGS
		$filename = $name.'.png';
		$PNG_WEB_DIR = $directory;
		$filename = $PNG_WEB_DIR.$filename;

		//RUN QR-Code GENERATION
		QRcode::png($QR_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		return asset($filename);
	}

	/**
	 * Creates user readable table with object's contents.
	 *
	 * @param  object $object
	 * @return string
	 */
	public static function echo_object($object){

		$file = '<div class="well span10">';
		foreach($object as $key => &$value){

			$file .= '<table class="table table-bordered"><tr>';
				$file .= '<td style="width: 17%">';
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

			unset($key, $value);
		}
		$file .= '</div>';
		return $file;
	}


	/**
	 * Creates user editable form with object's contents.
	 *
	 * @param  object $object
	 * @param  string $postfix
	 * @return string
	 */
	public static function echo_objects_form($object, $postfix=null, $semantical_postfix=false){

		if($postfix === 'SEMANTICAL'){

			$postfix = null;
			$semantical_postfix = true;
		}

		if($postfix){

			$postfix = '_'.$postfix;
			$postfix = str_replace('__', '_', $postfix);
		}

		$file = '<div class="well well-small" style="margin-bottom:1px">';
		foreach($object as $key => &$value){

			if($semantical_postfix){

				$postfix = ($postfix) ? $postfix.'_'.$key : $key;
			}

			$file .= '<label class="control-label" for="'.$key.$postfix.'"><h6>'.$key.':</h6></label>';
			$file .= '<div class="controls">';
					
			if(is_object($value) || is_array($value)){
				
				$file .= static::echo_objects_form($value, $postfix, $semantical_postfix);

			}else{
				
				$file .= '<input type="text" class="span12" id="'.$key.$postfix.'" value="'.htmlspecialchars($value).'" />';
			}

			$file .= '</div>';

			unset($key, $value);
		}
		$file .= '</div>';
		return $file;
	}


	/**
	 * Empty values in object or array
	 *
	 * @param  object|array $data
	 * @return string
	 */
	public static function empty_values($data){

		foreach($data as $key => &$value){
					
			if(is_object($value) || is_array($value)){
				
				$result[$key] = static::empty_values($value);

			}else{

				$result[$key] = null;
			}

			unset($key, $value);
		}

		$result = (is_object($data)) ? Filedb::array_to_object($result) : $result;

		return $result;
	}


	/**
	 * Returns string with type of given value 
	 *
	 * @param  mixed $value
	 * @return string
	 */
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


	/**
	 * Building string from array, separated by static::$title_separator
	 * Using values from array as value for get() method of Lang class
	 *
	 * @param  array $data
	 * @return string
	 */
	public static function build_title($data = array()){

		if(empty(static::$title_separator)){
			
			static::$title_separator = Template::where('type', '=', 'title_separator')->only('value');
		}

		$title = '';

		end($data);
		$last_key = key($data);

		foreach ($data as $key => &$value) {

			if(Lang::has($value)){

				$line = ucfirst(e(__($value)));
			
			}else{

				$line = ucfirst(e($value));
			}

			if($key != $last_key){

				$title .= $line.' '.static::$title_separator.' ';

			}else{

				$title .= $line;
			}

			unset($key, $value);
		}

		return $title;
	}

	/**
	 * Alias for alert method.
	 * Returns div with alert class according to Twitter Bootstrap
	 *
	 * @param  string $message
	 * @return string
	 */
	public static function fail_message($message){

		return self::alert($message, 'error');
	}

	/**
	 * Alias for alert method.
	 * Returns div with alert class according to Twitter Bootstrap
	 *
	 * @param  string $message
	 * @return string
	 */
	public static function success_message($message){

		return self::alert($message, 'success');
	}

	/**
	 * Returns div with alert class according to Twitter Bootstrap
	 *
	 * @param  string $message
	 * @param  string $type 	According to TWBS alert-(info|error|danger|success|warning)
	 * @return string
	 */
	public static function alert($message, $type=null){

		if(!$type){

			$type = "info";
		}

		return '<div class="alert alert-'.$type.'">'.$message.'</div>';
	}

	/**
	 * Building ul list with errors.
	 * Using Validator class result of make() method
	 *
	 * @param  Validator $validation
	 * @param  string  $lang_line_pattern
	 * @return string
	 */
	public static function compose_error($validation, $lang_line_pattern = 'forms.%s_word'){

		$errors[] = '<ul>';

		$validation = Filedb::object_to_array($validation->errors);

		foreach ($validation["messages"] as $field => &$validation_errors) {
			
			$fields[strlen($field)] = $field;

			unset($field, $validation_errors);
		}

		foreach ($validation["messages"] as $field => &$messages) {

			foreach ($messages as $message) {

				$line = str_ireplace($fields, '<strong>'.__(sprintf($lang_line_pattern, $field)).'</strong>', $message);
				
				$errors[] = '<li><i class="icon-li icon-warning-sign"></i> '.$line.'</li>';
			}

			unset($field, $messages);
		}

		$errors[] = '</ul>';
		return static::alert(implode('', $errors), 'error');
	}

	/**
	 * Encodes array to JSONed string.
	 * But do not put into brackets if value contains jQuery objects
	 *
	 * @param  array|object  $data
	 * @param  string $postfix 
	 * @return string
	 */
	public static function json_with_js_encode($data = array(), $postfix = null, $semantical_postfix=false){

		$json = array();

		if($postfix === 'SEMANTICAL'){

			$postfix = null;
			$semantical_postfix = true;
		}

		if($postfix){

			$postfix = '_'.$postfix;
			$postfix = str_replace('__', '_', $postfix);
		}

		foreach($data as $key => $value){

			if($semantical_postfix){

				$postfix = ($postfix) ? $postfix.'_'.$key : $key;
			}

			if($key == 'text'){

				$get_type = '.html()';

			}else{

				$get_type = '.val()';
			}

			if(is_array($value) || is_object($value)){

				if(strpbrk($key, "$")){

					$json[] = $key.':'.Utilites::json_with_js_encode($value, $postfix, $semantical_postfix);

				}else{

					$json[] = '"'.$key.'": '.Utilites::json_with_js_encode($value, $postfix, $semantical_postfix);
				}

			}else{

				if(strpbrk($key, "$") && strpbrk($value, "$")){

					$json[] = $key.':'.$value;

				}else{

					if(!is_null($value) && !strpbrk($value, "$")){

						$json[] = '"'.$key.'": "'.Filedb::_rawurlencode($value).'"';

					}elseif(strpbrk($value, "$")){

						$json[] = '"'.$key.'": '.$value;

					}else{

						$json[] = '"'.$key.'": encodeURI($(\'#'.$key.$postfix.'\')'.$get_type.')';
					}
				}
			}
		}

		return (string) '{ '.implode(',', $json).' }';
	}

	/**
	 * Prepare validation rules from module settings by given module name
	 *
	 * @param  string $module
	 * @return string
	 */
	public static function prepare_validation($module){

		foreach(Modules::where('name', '=', $module)->only('settings') as $key => $value){

			if(isset($value->editor) && isset($value->validator)){
				
				if($value->validator !== 'predetermined' && $value->validator !== 'false' && $value->editor == 'true'){

					$validation_rules[$key] = $value->validator;
				}
			}
		}

		return $validation_rules;
	}


	public static function add_to_validation($rules, $add_on){

		return implode('|', array_merge(explode('|', $rules), array($add_on)));
	}


	/**
	 * Prepare module settings by given module name
	 *
	 * @param  string $module
	 * @param  array  $additions array with additions names
	 * @return array
	 */
	public static function prepare_module_settings($module, $additions = null){
		
		$editor_fields 		=
		$fields_settings 	=
		$listing_fields 	= 
		$frontend_fields 	=	array();
		
		if($additions){

			foreach($additions as $key => &$value){
				
				$option[$key] = Utilites::prepare_additions($value);

				unset($key, $value);
			}
		}

		if($module_settings = Modules::where('name', '=', $module)->only('settings')){

			foreach($module_settings as $key => &$value){

				if(isset($value->table)){

					if($value->table == 'true'){

						$listing_fields[] = $key;
					}
				}

				if(isset($value->editor)){

					if($value->editor == 'true'){

						$editor_fields[$key] = null;
					
						if(isset($value->field)){

							$fields_settings[$key] = Filedb::object_to_array($value->field);

							if(isset($option[$key])){

								$fields_settings[$key]["options"] = $option[$key];
							}
						}
					}
				}

				if(isset($value->frontend)){

					if($value->frontend == 'true'){

						$frontend_fields[] = $key;

						if(isset($value->field)){

							$fields_settings[$key] = Filedb::object_to_array($value->field);

							if(isset($option[$key])){

								$fields_settings[$key]["options"] = $option[$key];
							}
						}
					}
				}

				unset($key, $value);
			}
		}

		return array($listing_fields, $fields_settings, $editor_fields, $frontend_fields);
	}


	/**
	 * Prepare array for Form::select $options parameter
	 *
	 * @param  string $table
	 * @return string
	 */
	public static function prepare_additions($table){

		switch ($table) {
			case 'langtable':

				$option[false] = __('placeholders.lang');
				
				foreach(Langtable::all() as $key => $param){

					$option[$param->lang] = $param->text_lang;

					unset($key, $param);
				}	

				return $option;

			case 'access':

				foreach(Accesstypes::all() as $key => $param){

					$option[$param->option] = __('access.'.$param->option);

					unset($key, $param);
				}	

				return $option;

			case 'useraccess':
				
				foreach(Useraccess::all() as $key => $param){

					$option[$param->level] = __('useraccess.'.$param->name);

					unset($key, $param);
				}	

				return $option;

			case 'adminaccess':
				
				foreach(Adminaccess::all() as $key => $param){

					$option[$param->level] = __('adminaccess.'.$param->name);

					unset($key, $param);
				}	

				return $option;

			case 'publishing':
				
				foreach(Publishing::all() as $key => $param){

					$option[$param->option] = ($param->option == 'true') ? __('forms.yes_word') : __('forms.no_word');

					unset($key, $param);
				}	

				return $option;

			case 'ecc':

				$option["l"] 	= 	__('qrcode.ecc_l');
				$option["m"] 	= 	__('qrcode.ecc_m');
				$option["q"] 	= 	__('qrcode.ecc_q');
				$option["h"] 	= 	__('qrcode.ecc_h');

				return $option;

			case 'page_patterns':

				foreach(array_diff(scandir('application/views/page_patterns/', 0), array('..', '.')) as $name){

					$name = str_replace('.blade.php', '', $name);

					$option[$name] = $name;
				}

				return $option;

			case 'yes_no':

				$option["false"] 	= 	__('forms.no_word');
				$option["true"] 	= 	__('forms.yes_word');

				return $option;

			default:

				$option["false"] = __('placeholders.'.$table);

				$t = $table::init();
				$model = $t->get_model();

				$table_content = (array_key_exists('published', $model)) ? $t->where('published', '=', 'true')->get() : $t->all();

				if($table_content){
					
					foreach($table_content as $key => &$param){

						$option[$param->id] = (isset($param->name)) ? ucfirst($param->name) : ucfirst($param->title);

						unset($key, $param);
					}
				}

				unset($t, $model, $table_content);
				return $option;
		}
	}


	/**
	 * Building form in dependence of field $column
	 * Using additions to build select and other multi-select elements
	 *
	 * @param  string $type       select|text|textarea|password|hidden|number|email
	 * @param  array  $data       array('column', 'value', only for select -> array('value' => 'text'))
	 * @param  string $pattern    HTML sprintf pattern
	 * @param  string $label 	
	 * @param  array  $attributes array('attribute' => 'value');
	 * @param  string $postfix    element id postfix
	 * @return string
	 */
	public static function html_form_build($type, $data, $pattern, $label = null, $attributes = array(), $postfix = null){

		if($postfix){

			$postfix = '_'.$postfix;
		}

		switch ($type){

			case 'select':
				($data[2] == null) ? var_dump($data) : null;
				$input = Form::select($data[0].$postfix, $data[2], $data[1], array_merge(array('id' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);

			case 'hidden':

				return Form::$type($data[0].$postfix, $data[1], array_merge(array('id' => $data[0].$postfix), $attributes));

			case 'tel':
				$type = 'telephone';
			case 'text':
			case 'textarea':
			case 'email':
			case 'date':
			case 'url':
			case 'number':
			case 'telephone':
			case 'search':

				$input = Form::$type($data[0].$postfix, $data[1], array_merge(array('id' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);

			case 'file':

				$input = Form::$type($data[0].$postfix, array_merge(array('id' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);

			case 'password':

				$input = Form::$type($data[1], array_merge(array('id' => $data[0].$postfix, 'name' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);

			case 'datetime':

				$input = Form::datetime($data[0].$postfix, (is_numeric($data[1])) ? date('Y-m-d\Th:i', $data[1]) : $data[1], array_merge(array('id' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);


			//BELOW WE ADD SPECIAL FORM ELEMENTS
			case 'pretty_multiselect':

				$input = Form::text($data[0].$postfix.'_fake_multiselect', '', array_merge(array('id' => $data[0].$postfix.'_fake_multiselect', 'data-id' => $data[0].$postfix ), $attributes));


				if(!empty($data[1])){

					$values = explode(',', $data[1]);
					$pretty_values = '';

					foreach ($values as $key => &$data[1]) {
						
						$data[1] = trim($data[1]);
						$pretty_values .= '<span class="label">'.$data[1].' <i class="icon-remove" style="cursor: pointer" data-pretty-multiselect="'.e($data[1]).'" onclick="removePrettyMultiselect($(this), \''.$data[0].$postfix.'\')"></i></span> ';

						$prepared_values[] = $data[1];

						unset($key, $data[1]);
					}

				}else{

					$pretty_values = '';
					$prepared_values = array();
				}

				$input .= Form::hidden($data[0].$postfix, implode(',', $prepared_values), array('id' => $data[0].$postfix, 'style' => 'display:none', 'class' => 'hidden'));

				$input = '<div id="'.$data[0].'_fake_multiselect_container">'.$input.'</div><div class="well well-small" id="pretty_multiselect_area_'.$data[0].$postfix.'">'.$pretty_values.'</div>';
				$pattern = sprintf($pattern, $label, $input, $data[0].$postfix);
				return $pattern;

			case 'image_selector':

				$view = array();

				$input = Form::hidden($data[0].$postfix, $data[1], array_merge(array('id' => $data[0].$postfix, 'style' => 'display:none', 'class' => 'hidden'), $attributes));

				$view["selected_images"] = ($data[1]) ? explode(',',$data[1]) : null;
				$view["images"] = Media::all();
				$view["column"] = $data[0].$postfix;

				return sprintf(View::make('admin.assets.images_select', $view)->render(), $label, $input, $data[0].$postfix);

			case 'pretty_checkbox':

				if(!$data[1]){

					if(isset($attributes['value'])){

						$data[1] = $attributes['value'];
					}
				}

				$text = ($data[1] == 'false') ?  __('forms.no_word') : __('forms.yes_word');
				$class = ($data[1] == 'false') ? 'icon-check-empty' : 'icon-check';

				$check_box = '<i style="cursor: pointer" onclick="if($(\'#'.$data[0].$postfix.'\').val() !== \'true\'){$(\'#'.$data[0].$postfix.'\').val(\'true\'); $(this).removeClass().addClass(\'icon-check icon-large\').html(\' '.__('forms.yes_word').'\'); }else{$(\'#'.$data[0].$postfix.'\').val(\'false\'); $(this).removeClass().addClass(\'icon-check-empty icon-large\').html(\' '.__('forms.no_word').'\'); } ; $(\'button[id^='.e('"ajax_save_button"').']\').attr(\'disabled\', false);" id="pretty_checkbox_icon" class="'.$class.' icon-large" title="'.$label.'"> '.$text.'</i>';

				$input = Form::hidden($data[0].$postfix, ($data[1]) ? $data[1] : 'true', array('id' => $data[0].$postfix));
				return sprintf($pattern, $label, $check_box.$input, $data[0].$postfix);

			case 'related':

				$forms = array();

				$section = Sections::get(array('id', 'title'));

				foreach ($data[2] as $group_key => &$group){

					$option[$group_key]['false'] = __('forms.no_word');

					foreach ($group as $file_id => &$row) {

						$option[$group_key][$section->{$row->section}->title][$row->id] = $row->title;

						unset($file_id, $row);
					}

					if(!$data[1]){

						$data[1] = null;
					
					}elseif(is_array($data[1])){

						$data[1] = (isset($data[1]["related_".$group_key])) ? $data[1]["related_".$group_key] : null;
					}

					$input = Form::select($data[0].$postfix, $option[$group_key], $data[1], array_merge(array('id' => $data[0].'_'.$group_key.$postfix), $attributes));
					${'label'.$group_key} = $label.' <span class="label label-inverse">'.$group_key.'</span>';
					$forms[] = sprintf($pattern, ${'label'.$group_key}, $input, $data[0].$postfix);

					unset($group_key, $group);
				}

				unset($section);

				return implode('', $forms);

			case 'json':

				$input = Form::textarea($data[0].$postfix, static::prettify_json(stripslashes(json_encode($data[1]))), array_merge(array('id' => $data[0].$postfix), $attributes));
				return sprintf($pattern, $label, $input, $data[0].$postfix);

			case 'content_editable':

				return null;

			default:
			default_form:

				return 'Failed: '.var_dump($type).' | With: '.var_dump($data);
		}
	}


	/**
	 * Put full folder to ZIP archive
	 *
	 * @param  string $source
	 * @param  string $destination
	 * @return bool
	 */
	public static function zip($source, $destination){

		$za = new FlxZipArchive;

		$res = $za->open($destination, ZipArchive::CREATE);

		if($res === TRUE) {
		    
		    $za->addDir($source, basename($source));
		    return $za->close();

		}else{

		    return 'Could not create a zip archive';
		}
	}
}