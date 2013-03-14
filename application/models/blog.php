<?php

class Blog extends Filedb
{
	public static $table = 'blog';

	public static $model = array(	'id' => '', 
									'created_at' => '0000-00-00 00:00:00', 
									'updated_at' => '0000-00-00 00:00:00', 
									'title' => '', 
									'text' => '', 
									'access' => '1', 
									'qr_code' => '', 
									'lang' => '', 
									'tags' => '',
									'published' => '0');
}