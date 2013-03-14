<?php

class Promosettings extends Filedb
{
	public static $table = 'promosettings';

	public static $model = array(	'id' => '', 
									'name' => '', 
									'value' => '');
	
	public static function get_settings($key)
	{
		
		$res = Promosettings::where('name', '=', $key)->only('value');
		
		return intval($res);
	}
}