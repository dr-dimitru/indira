<?php

class Importdb_Controller extends Base_Controller {

	public function action_index()
	{	
		
		Filedb::import_from_db();

		return 'DB successfuly imported<br>Now your project powered by noSQL idea';
		
	}

}