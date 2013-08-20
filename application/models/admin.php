<?php 

class Admin extends Filedb{ 

	public static $table = "admin"; 

	public static $model; 

	public static $encrypt = false;
	

	public static function check(){

		if(Session::has('admin')){

			return (int) Session::get('admin.access');

		}else{

			return false;
		}
	}

	protected function login($admin, $remember){

		$admin_check = $this->where('name', '=', $admin->name)->or_where('email', '=', $admin->name)->get();

		if(empty($admin_check)){

    		return Utilites::fail_message(Lang::line('content.incorrect_login_message'));
    	}

    	foreach($admin_check as $row => $admin_data)

        if($admin_data->password != $admin->password){
                
    		return Utilites::fail_message(Lang::line('content.incorrect_pass_message'));
    	}

	    Utilites::admin_login($this->find($row), $remember);

		return 'success';
	}
}