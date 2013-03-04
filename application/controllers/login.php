<?php

class Login_Controller extends Base_Controller {

	public $restful = true;
	
	public function post_index()
	{       
            $json = stripcslashes(Input::get('data'));
			$json_arr = json_decode($json, true);
			
			$login = rawurldecode($json_arr["login"]);
			$password = rawurldecode($json_arr["password"]);
			$remember = $json_arr["remember"];
			
	        if(strlen($password) !== 32)
	        {
	        	$password = md5($password);
	        }
	        
	        $promo_active = Promosettings::get_settings('active');
	        $promo_on_login = Promosettings::get_settings('on_login');
	        
	        
	        //CHECK LOGIN
	        if($login)
	        {
	        	$user_data = Users::where('email', '=', $login)->get();

	        	if(!empty($user_data))
	        	{
	        		//FETCH USER DATA
	        		foreach($user_data as $user)
	        		{
	        			$user_password = $user->password;
	        			$user_level = $user->access;
	        		}
	        	}
	        	else
	        	{
	        		die(View::make('assets.errors')->with('uni_error', 'incorrect_login_message'));
	        	}
	        }
	        else
	        {
	        	die( View::make('assets.errors')->with('uni_error', 'empty_login_message'));;
	        }
	        
	        //CHECK PASSWORD
	        if($password)
	        {
	        	if($password !== $user_password)
	        	{
	        		die( View::make('assets.errors')->with('uni_error', 'incorrect_pass_message'));
	        	}
	        }
	        else
	        {
	        	die( View::make('assets.errors')->with('uni_error', 'incorrect_pass_message'));
	        }
	        
	        //IF PROMO CODES FEATURE IS ACTIVE AND 'ON LOGIN' ACTIVE
	        if($promo_active == 1 && $promo_on_login == 1)
	        {
	        	$promo = rawurldecode($json_arr["promo"]);
	        	if(!empty($promo))
	        	{
	        		$promo_code = Promocodes::where('owner', '=', $login)->get();
	        		//Promocodes::where('owner', '=', $login)->get();
	        		
	        		if(!empty($promo_code))
	        		{
	        			foreach($promo_code as $value)
	        			{
	        				if($promo !== $value->code){
	        					die( View::make('assets.errors')->with('uni_error', 'others_promo_message'));
	        				}
	        				elseif($value->used == 0){
	        					Promocodes::where('code', '=', $promo)->update(array('used'=>1));
	        					//Promocodes::where('code', '=', $promo)->update(array('used'=>1));
	        				}
	        				else{
	        					$user_level = Promosettings::get_settings('user_level');
	        					//Filedb::where_only('promo_settings', 'name', 'user_level', 'value');
	        				}
	        			}
	        		}
	        		else
	        		{
	        			$promo_code_data = Promocodes::where('code', '=', $promo)->get();
	        			//Filedb::where('promocodes', 'code', $promo);
	        			//$promo_code_data = Promocodes::where('code', '=', $promo)->get();
	        			
	        			if(!empty($promo_code_data))
	        			{
	        				foreach($promo_code_data as $value)
	        				{
	        					if(empty($value->owner))
	        					{
	        						//Filedb::update('promocodes', 'code', $promo, array('owner'=>$login, 'used'=>1));
	        						Promocodes::where('code', '=', $promo)->update(array('owner'=>$login, 'used'=>1));
	        						//$user_level = Filedb::where_only('promo_settings', 'name', 'user_level', 'value');
	        						$user_level = Promosettings::get_settings('user_level');
	        					}
	        					else
	        					{
	        						die( View::make('assets.errors')->with('uni_error', 'non_exsist_promo_message'));
	        					}
	        				}
	        			}
	        			else
	        			{
	        				die( View::make('assets.errors')->with('uni_error', 'non_exsist_promo_message'));
	        			}
	        		}

	        		//UPDATE USERS LEVEL IN DB
	        		if($user->access !== $user_level){

	        			//Filedb::update('users', 'email', $login, array('access'=>$user_level));
	        			Users::where('email', '=', $login)->update(array('access'=>$user_level));
	        		}
	        	}
	        }
	        //IF PROMO CODE FEATURE IS INACTIVE SET USER LEVEL
	        //DO NOTHING OR ELSE STATEMENT HERE
	        
	        Utilites::userLogin($login, $user_level, $remember); //PROCEED LOGIN
	        
	        //ECHO SUCCESS LOGIN MESSAGE
	        return View::make('assets.errors')->with('uni_error', 'user_success_login');
	}

}