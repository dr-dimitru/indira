<?php

class AccessLevels extends Filedb
{
	public static $table = 'accessLevels';

	public static $model = array(	'id' => '',
									'level' => '',
									'description_ru' => '',
									'description_en' => '',);

	public static function get_accesslevels($key=null)
	{
		if(!$key) {

    		$accessLevels = AccessLevels::all();

    	}
    	else {

    	    $access_levels = AccessLevels::where('name', '=', $key)->get();

    	}
    	
		return $accessLevels;
	}
}