<?php

class Media extends Filedb
{
	public static $table = 'media';

	public static $model = array(	'id' => '', 
									'created_at' => '0000-00-00 00:00:00', 
									'updated_at' => '0000-00-00 00:00:00', 
									'url' => '', 
									'thumbnail' => '',
									'name' => '',
									'route' => '');
	
}