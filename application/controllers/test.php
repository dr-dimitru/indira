<?php

class Test_Controller extends Base_Controller {

	public function action_index()
	{	
		
		$user = Filedb::insert('users', array('name' => 'Amid'));

		return var_dump($user);
		
	}

}