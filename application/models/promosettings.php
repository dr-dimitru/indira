<?php

class Promosettings extends Filedb
{
	public static $table = 'promo_settings';

	public static $model = array(	'id' => '', 
									'name' => '', 
									'value' => '');
	
	public static function get_settings($key)
	{
		
		$arr = Promosettings::where('name', '=', $key)->only('value');

		foreach ($arr as $value) {
			return intval($value);
		}
		 
	}
}