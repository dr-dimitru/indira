<?php

class Admin extends Filedb
{
	public static $table = 'admin';

	public static $model = array(	'id' => '', 
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