<?
class Sign_Up_Controller extends Base_Controller {

	public $restful = true;
	
	public function post_index()
	{
		$reg_level = 1; //DEFAULT USER ACESS LEVEL

		$json = stripcslashes(Input::get('data'));
		$json_arr = json_decode($json, true);

		$login = rawurldecode($json_arr["login"]);
		$name = rawurldecode($json_arr["name"]);
		$orig_password = rawurldecode($json_arr["password"]);
		$re_password = rawurldecode($json_arr["re_password"]);
		$password = md5($orig_password);

		$promo_active = Promosettings::get_settings('active');
		$promo_on_signup = Promosettings::get_settings('on_registration');

		if(empty($login) || !preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $login))
		{
			return View::make('assets.errors')->with('uni_error', 'incorrect_email_message');
		}
		else
		{
			$user_data = Users::where('email', '=', $login)->only('id');
			if(!empty($user_data))
			{
				die(View::make('assets.errors')->with('uni_error', 'registered_message'));
			}
		}

		if(empty($name) || strlen($name) < 3)
		{
			die(View::make('assets.errors')->with('uni_error', 'name_error_message'));
		}

		if(empty($orig_password) || strlen($orig_password) < 5)
		{
			die(View::make('assets.errors')->with('uni_error', 'password_error'));
		}

		if($re_password !== $orig_password)
		{
			die(View::make('assets.errors')->with('uni_error', 'incorrect_pass_repass'));
		}

		if($promo_active == 1 && $promo_on_signup == 1)
		{
			$promo = rawurldecode($json_arr["promo"]);
			if(!empty($promo))
			{
				$promo_code = Promocodes::where('owner', '=', $login)->get();
				
				if(!empty($promo_code->owner))
				{
					foreach($promo_code as $value)
					{
						if($promo !== $value->code)
						{
							die(View::make('assets.errors')->with('uni_error', 'others_promo_message'));
						}
						elseif($value->used == 0){
	        				Promocodes::where('code', '=', $promo)->update(array('used'=>1));
	        			}
						else
						{
							$reg_level = Promosettings::get_settings('user_level');
						}
					}
				}
				else
				{
					$promo_code_data = Promocodes::where('code', '=', $promo)->get();
					
					if(!empty($promo_code_data))
					{
						Promocodes::where('code', '=', $promo)->update(array('owner'=>$login, 'used'=>1));
						$reg_level = Promosettings::get_settings('user_level');
					}
					else
					{
						die(View::make('assets.errors')->with('uni_error', 'non_exsist_promo_message'));
					}
				}
			}
		}


		Users::userRegistration($name, $login, $password, $reg_level);

		$message = sprintf(Lang::line('forms.registration_email_text')->get(Session::get('lang')), $login, $orig_password);
		$subject = Lang::line('forms.registration_email_subject')->get(Session::get('lang'));
		Utilites::send_email($login, $message, $subject);

		Utilites::userLogin($login, $reg_level, 1); //PROCEED LOGIN
		return View::make('assets.errors')->with('uni_error', 'user_success_signup');
	}
}