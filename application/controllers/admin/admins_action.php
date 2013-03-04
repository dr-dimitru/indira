<?php

class Admin_Admins_Action_Controller extends Base_Controller {

	public $restful = true;

	public function post_save()
	{	
		if(!Admin::check()){
			
			return View::make('admin.login_area');
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$admin 				= 	new stdClass;
			$admin->id 			= 	$json_arr["id"];
			$admin->name 		= 	rawurldecode($json_arr["name"]);
			$admin->password 	= 	rawurldecode($json_arr["password"]);
			$admin->access 		= 	$json_arr["access"];
			$admin->email 		= 	rawurldecode($json_arr["email"]);

			if(	empty($admin->name) || empty($admin->access) || !preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $admin->email))
			{

				$errors = '';
				if(empty($admin->name))
				{
					$errors .= '<li>'.Lang::line('content.name_error_message')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($admin->access))
				{
					$errors .= '<li>'.Lang::line('forms.admin_access_err')
										->get(Session::get('lang')).'</li>';
				}
				if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $admin->email))
				{
					$errors .= '<li>'.Lang::line('content.incorrect_email_message')
										->get(Session::get('lang')).'</li>';
				}
			
				$errors = '<tr><td colspan="5"><div class="alert alert-error compact"><ul>'.$errors.'</ul></div></td></tr>';

				return View::make('admin.admins.admins_list')
						->with('error'.$admin->id, $errors);
			
			}else{

				$update_data = array(	'name' 		=> 	$admin->name,
										'access' 	=> 	$admin->access,
										'email' 	=> 	$admin->email);

				if(!empty($admin->password)){
					$admin->password = md5($admin->password);
					$password = array('password' 	=> 	$admin->password,);
					$update_data = array_merge($update_data, $password);
				}

				$status = Admin::where('id', '=', $admin->id)->update($update_data);

				if($status !== 0){
					
					return View::make('admin.admins.admins_list');
				
				}else{
				
					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
				
				}
			}
		}
	}


	public function post_add(){

		if(!Admin::check()){

			return View::make('admin.login_area');

		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));

		}else{

			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$admin 				= 	new stdClass;
			$admin->id 			= 	'new';
			$admin->name 		= 	rawurldecode($json_arr["name"]);
			$admin->password 	= 	rawurldecode($json_arr["password"]);
			$admin->access 		= 	$json_arr["access"];
			$admin->email 		= 	rawurldecode($json_arr["email"]);


			if(	empty($admin->name) || empty($admin->access) || !preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $admin->email) || empty($admin->password))
			{

				$errors = '';
				if(empty($admin->name))
				{
					$errors .= '<li>'.Lang::line('content.name_error_message')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($admin->access))
				{
					$errors .= '<li>'.Lang::line('forms.admin_access_err')
										->get(Session::get('lang')).'</li>';
				}
				if(empty($admin->password))
				{
					$errors .= '<li>'.Lang::line('content.password_error')
										->get(Session::get('lang')).'</li>';
				}
				if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $admin->email))
				{
					$errors .= '<li>'.Lang::line('content.incorrect_email_message')
										->get(Session::get('lang')).'</li>';
				}
			
				$errors = '<tr><td colspan="5"><div class="alert alert-error compact"><ul>'.$errors.'</ul></div></td></tr>';

				return View::make('admin.admins.admins_new')
						->with('error'.$admin->id, $errors)->with('admin', $admin);
			
			}else{

				$admin->password = md5($admin->password);
				$insert_data = array(	'name' 		=> 	$admin->name,
										'access' 	=> 	$admin->access,
										'password' 	=> 	$admin->password,
										'email' 	=> 	$admin->email);


				$status = Admin::insert($insert_data);

				if($status !== 0){
					
					return View::make('admin.admins.admins_list');
				
				}else{
				
					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
				
				}
			}

			return View::make('admin.admins.admins_new')->with('admin', $admin);

		}
	}

	public function post_delete(){

		if(!Admin::check()){
			
			return Lang::line('content.logged_out_warning')
					->get(Session::get('lang'));
		
		}elseif(Admin::check() != '777'){
			
			return Lang::line('content.permissions_denied')
					->get(Session::get('lang'));
		
		}else{
			
			$json 				= 	stripcslashes(Input::get('data'));
			$json_arr 			= 	json_decode($json, true);

			$admin 				= 	new stdClass;
			$admin->id 			= 	$json_arr["id"];
			$admin->delete 		= 	$json_arr["delete"];

			if($admin->delete == 'delete'){
				
				$status = Admin::delete($admin->id);

				if($status){

					return View::make('admin.admins.admins_list');

				}else{

					return Lang::line('forms.undefined_err_word')
							->get(Session::get('lang'));
					
				}

			}
		}

	}

}