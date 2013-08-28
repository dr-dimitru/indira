<?php

class Admin_Schema_Home_Controller extends Base_Controller {


	/**
	 * Directory with models files usually application/models
	 *
	 * @var string
	 */
	static $models_dir = 'application/models';


	/**
	 * Directory with migration files usually application/migrations
	 *
	 * @var string
	 */
	static $migrations_dir = 'application/migrations';


	/**
	 * Show listing table with all Eloquent nested models
	 * 
	 * @return Laravel\View
	 */
	public function action_index(){

		Session::put('href.previous', URL::full());

		$data 					= 	array();

		//Data used to build table
		$data['models'] 		= 	static::get_models();
		$data['migrations'] 	= 	static::get_migrations();

		$data['sql_tables'] 	= 	(Config::get('database.connections.'.Config::get('database.default').'.host')) ? DB::query('SELECT * FROM information_schema.tables WHERE table_schema = database()') : array();
		
		//Data used to build listing table
		$data["page"] 			= 	'admin.schema.listing';
		
		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('admin.assets.no_ajax', $data);
	}


	/**
	 * Get array of all tables names
	 *
	 * @return array
	 */
	static function get_models(){

		$tables_by_model = array_diff(scandir(strtolower(static::$models_dir), 0), array('..', '.'));

		foreach ($tables_by_model as &$table) {

			if(stripos(File::get(static::$models_dir.'/'.$table), 'Eloquent'))
			{
				$table_model_name = substr($table, 0, -4);
				$models[] = $table_model_name;
			}

			unset($table);
		}
		
		return (isset($models)) ? $models : null;
	}


	/**
	 * Get array of all migration tables names
	 *
	 * @return array
	 */
	static function get_migrations(){

		$tables_by_migrations = array_diff(scandir(strtolower(static::$migrations_dir), 0), array('..', '.'));

		foreach ($tables_by_migrations as &$table) {

			$name = explode('_', $table);

			if(count($name) > 4){

				$table_name = '';
				if(count($name) > 7) {
					
					for ($i=5; $i < count($name) - 1; $i++) { 

						$table_name .= ($i > 5) ? '_'.$name[$i] : $name[$i];
					}

				}else{

					$table_name = $name[5];
				}

				$tables[substr($table, 0, -4)] = $table_name;
			}

			unset($table, $name, $i);
		}
		
		return (isset($tables)) ? $tables : null;
	}
}