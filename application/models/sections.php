<?php

class Sections extends Filedb
{
	public static $table = 'section';

	public static $model = array(	'id' => '', 
									'title' => '', 
									'lang' => '');
	
	public static function get_sections()
	{
		$sections = Sections::where('lang', '=', Session::get('lang'))->get();
			
		return $sections;
	}
	
}