<?php 


class Show_Controller extends Base_Controller {

	public function action_index()
	{	


		// $data = Filedb::where('sections', 'id', '==', '11');
		// var_dump(Sections::where_id('10')->get());
		// echo '<hr>';

		//$data = Promocodes::where('code', '=', 'FJWEPO0909WEUF09')->get();
		// $password = 'password' => '7816287';
		//$update_data = Blog::where('id', '=', '1')->get();
		$section = new stdClass;
		$section->title = 'not just talk';
		$section->sectionid = ucwords($section->title);
		$section->sectionid = str_replace(array(' ','.', '\'', '-','"', '/', '\\', '_', '. ', '\' ', '" ', '/ ', '\\ ', '_ ', ' .', ' \'', ' "', ' /', ' \\', ' _'), '', $section->sectionid);
		$section->sectionid = lcfirst($section->sectionid).'Section';
		//update(array(	'access' => '34',
													//'something_else' => '',
													//'something_else2' => 'bla bla'));
		// $tags = array();
		// foreach ($update_data as $key => $value) {
		//  	$ptags = explode(",", $value->tags);
		//  	foreach ($ptags as $key => $value) {
		//  		$ptags[$key] = trim($value);
		//  	}
		//  	$tags = array_merge($tags, $ptags);
		//  	$tags = array_unique($tags);
		//  } 
		// if(!empty($password)){
		// 	array_push($update_data, $password);
		// }
		echo '<pre>';

		var_dump($section->sectionid);
		echo '</pre>';

		// $data = Promocodes::where('code', '=', '412139728989787774192884447444423')->update(array('used'=>0, 'owner'=>'', 'code'=>'FJWEPO0909WEUF09'));
		// $users = new Users;
		// $users->name = 'Dima';
		// $users->email = 'Login';
		// $users->password = 'MyPass';
		// $users->access = '+100500';
		// $users->save();

		// $sTitle = Posts::where('lang', '=', 'ru')->where('section', '=', '8')->get();
		// echo '<hr><pre>';
		// var_dump($sTitle);
		// echo '</pre><hr>';

		// $data = Promocodes::where('code', '=', 'FJWEPO0909WEUF09')->get();
		// echo '<hr>';

		// var_dump($data);
		// echo '<hr>';

		// var_dump(Users::find(15));
		// echo '<hr>';

		// var_dump(Users::where('email', '=', 'ceo@veliov.com')->where('id', '=', '15')->get());
		// echo '<hr>';

		// var_dump(Users::where('email', '=', 'ceo@veliovgroup.com')->get());
		// echo '<hr>';

		// foreach ($data as $row) {
		// 	//echo $row->title.'<br>';
		// 	//var_dump($row);
		// }
	}

}

// class foo
// {
// 	private static $_counter = 0;
// 	private static $_inst = NULL;

// 	public function __construct()
// 	{
// 		print('foo created<br>');

// 		static::$_counter = 0;
// 	}


//     private function  __clone() { 

    	

//     }

// 	public static function __callStatic($method, $parameters) 
// 	{
// 		$model = get_called_class();
// 		if ($model::$_inst === NULL)
// 		{
// 			$model::$_inst = new $model;
// 		}
// 		return call_user_func_array(array(new static, $method), $parameters);
// 	}

// 	public function __call($method, $parameters) 
// 	{
// 		$model = get_called_class();
// 		return call_user_func_array(array($model, $method), $parameters);
// 	}

// 	private function fooz()
// 	{
// 		self::$_counter++;
// 		print('fooz called '. self::$_counter .' times<br>');

// 		return $this;
// 	}
// }


// foo::fooz()->fooz()->fooz();
// foo::fooz()->fooz()->fooz();