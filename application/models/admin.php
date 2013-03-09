<?php

class Admin extends Filedb
{
	public static $table = 'admin';

	public static $model = array(	'id' => '',
									'created_at' => '0000-00-00 00:00:00', 
									'updated_at' => '0000-00-00 00:00:00', 
									'name' => '', 
									'password' => '', 
									'access' => '400', 
									'email' => '');

	public static function check(){

		if(Session::get('admin')){

			return Session::get('admin.access');

		}else{

			return false;

		}

	}
}