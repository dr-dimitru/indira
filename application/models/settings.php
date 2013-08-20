<?php 

class Settings extends Filedb{ 

	public static $table = "settings"; 

	public static $model; 

	public static $encrypt = false; 

	public function param($param){

		return $this->where('param', '=', $param)->only('value');
	}
}