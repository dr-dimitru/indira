<?php

class Langtable extends Filedb
{
	public static $table = 'langtable';

	public static $model = array(	'id' => '', 
									'lang' => '', 
									'fb_lang' => '', 
									'text_lang' => '');

	
	
	public static function get_lang_params(){
	    $languages = Langtable::all();
	    
	    foreach($languages as $value)
	    {
	    	$langs[$value->lang] = array('fb_lang' => $value->fb_lang, 'text_lang' => $value->text_lang );
	    }
	    
	    return $langs;
	}
	
	public static function get_lang_list(){
		
	    $languages = Langtable::get('lang');	    
	    
	    foreach($languages as $value)
	    {
	    	$value = $value->to_array();
	    	$langs[] = $value['lang'];
	    }
	    
	    return $langs;
	}
}