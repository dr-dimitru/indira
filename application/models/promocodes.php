<?php

class Promocodes extends Filedb
{
	
	public static $table = 'promocodes';

	public static $model = array(	'id' => '', 
									'code' => '', 
									'used' => '0', 
									'owner' => '');

}