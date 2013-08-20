<?php

class Admin_Schema_Action_Controller extends Base_Controller {
    
    /**
     * Admin access level for this controller
     * 
     * @var int $access
     */
    public $access = 777;


    /**
     * Laravel restful controller
     * 
     * @var bool $restful
     */
    public $restful = true;


    /**
	 * Model's file pattern.
	 * Must be one line
	 *
	 * @var string
	 */
	static $model_pattern = '<?php class %1$s extends Eloquent{ public static $table = "%2$s";}';


	/**
	 * Migration's file pattern.
	 * Must be one line
	 *
	 * @var string
	 */
	protected static $migration_pattern = '<?php class Create_%3$s_Table { public function up() { Schema::table("%1$s", function($table) { %2$s });}  public function down(){ Schema::drop("%1$s"); } }';


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
	* Make changes to the database.
	*
	* @var string $table_name
	* @return Laravel\Redirect
	*/
	public function get_up($table_name){

		$migrations = static::get_migrations();

		if(in_array($table_name, $migrations)){

			static::create_model($table_name);

			foreach ($migrations as $file_name => $table) {
			    
				if(strtolower($table) == strtolower($table_name)){

					require_once static::$migrations_dir.'/'.$file_name.EXT;

					$class_name = "Create_".ucfirst($table)."_Table";

					$migration = new $class_name;

					$migration->up();

					var_dump($class_name);
				}
			}

			return Redirect::to_action('admin.schema.home@index');

		}else{

		    return "No such migration file for table ". $table_name ."!";
		}
	}


	/**
	* Migrate table and it's 
	* content from NoSQL (FileDB) 
	* into current SQL connection
	*
	* @return Laravel\Redirect
	*/
	public function post_migrate_in(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$table_name = $income_data["table"];

		$migrations = static::get_migrations();

		if(in_array($table_name, $migrations)){

			foreach ($migrations as $file_name => $table) {
			    
				if(strtolower($table) == strtolower($table_name)){

					$migration_file_name = $file_name.EXT;

					require_once static::$migrations_dir.'/'.$file_name.EXT;

					$class_name = "Create_".$table."_Table";

					$migration = new $class_name;

					if(DB::connect()){

						$migration->up();

						static::create_model($table_name);

						$nosql_table = str_replace('nosqlfiledb', '', $table);

						$nosql_model = $nosql_table::model();
						$table_contents = $nosql_table::all();
						if($table_contents){

							foreach($table_contents as $id => &$row) {
									
								$sqltable = new $table_name;

								foreach ($row as $column => &$value) {
									
									$sqltable->{$column} = (is_array($value) || is_object($value)) ? json_encode($value) : $value;

									unset($column, $value);
								}

								$sqltable->save();
								unset($sqltable, $id, $row);
							}
						}

					}else{

						die('No SQL Connection!!!');
					}
				}
			}
			
			Schema::rename($table, $nosql_table);
			static::create_model($nosql_table);

			static::drop($table);
			File::delete(static::$migrations_dir.'/'.$migration_file_name);

			static::generate_migration_file($nosql_model, $nosql_table);

			return Redirect::to_action('admin.schema.home@index');

		}else{

		    return "No such migration file for table ". $table_name ."!";
		}
	}


	/**
	* Migrate table and it's 
	* content from current SQL connection 
	* into NoSQL (FileDB) 
	*
	* @return Laravel\Redirect
	*/
	public function post_migrate_out(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$table_name = $income_data["table"];

		list($sql_model, $sql_columns) = Utilites::sql_table_model($income_data["table"], true);
		static::generate_migration_file($sql_model, $income_data["table"], $sql_columns);

		$temp_table_name = $income_data["table"].'fromsql';
		Filedb::create_table($temp_table_name, $sql_model);

		$sql_table = $table_name::all();

		if ($sql_table) {
			
			foreach ($sql_table as $id => &$row){
				
				$nosql_table = $temp_table_name::init();

				foreach ($row->attributes as $column => &$value) {

					if($column !== 'id'){
					
						$nosql_table->{$column} = (Utilites::is_json($value)) ? json_decode($value) : $value;
					}

					unset($column, $value);
				}

				$nosql_table->save();
				unset($nosql_table, $id, $row);
			}

			unset($sql_table);
		}
			
		static::drop($table_name);
		Schema::drop(strtolower($table_name));

		$temp_table_name::rename($table_name);

		return Redirect::to_action('admin.schema.home@index');
	}


	/**
	* Revert the changes to the database.
	*
	* @param  string $table_name
	* @return Laravel\Redirect
	*/
	public function get_down($table_name)
	{
		static::drop($table_name);
		Schema::drop(strtolower($table_name));

		return Redirect::to_action('admin.schema.home@index');
	}


    /**
	 * Create table's model
	 *
	 * @param  string $table_name
	 * @return void
	 */
	static function create_model($table_name){

		File::put(static::$models_dir.'/'.strtolower($table_name).EXT, sprintf(static::$model_pattern, ucwords($table_name), strtolower($table_name)));
	}


	/**
	 * Drop (Deleta) table's Eloquent model
	 *
	 * @param  string $table_name
	 * @return void
	 */
	static function drop($table_name){

		File::delete(static::$models_dir.'/'.strtolower($table_name).EXT);
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
            $table_name = '';
            if(count($name) > 7) {
                
                for ($i=5; $i < count($name) - 1; $i++) { 

                    $table_name .= ($i > 5) ? '_'.$name[$i] : $name[$i];
                }

            }else{

                $table_name = $name[5];
            }

            $tables[substr($table, 0, -4)] = $table_name;

            unset($table, $name, $i);
        }
        
        return (isset($tables)) ? $tables : null;
    }


	/**
	* Generate migration's file
	*
	* @return void
	*/
    static function generate_migration_file($model, $name, $columns = null){

		$fields = array();
		$fields[] = '$table->create();';
		$fields[] = '$table->increments("id");';
		$fields[] = '$table->timestamps();';

		foreach ($model as $column => &$default_value) {
			
			if(!in_array($column, array('id', 'created_at', 'updated_at'))){

				$type = (isset($columns[$column]["data_type"])) ? static::prepare_column($columns[$column]["data_type"]) : 'text';
				$length = (isset($columns[$column]["character_maximum_length"])) ? $columns[$column]["character_maximum_length"] : '100';
				$numeric_precision = (isset($columns[$column]["numeric_precision"])) ? $columns[$column]["numeric_precision"] : '10';
				$numeric_scale = (isset($columns[$column]["numeric_scale"])) ? $columns[$column]["numeric_scale"] : '0';
				
				if(in_array($type, array('decimal'))){

					$fields[] = '$table->'.$type.'("'.$column.'", '.$numeric_precision.', '.$numeric_scale.');';

				}elseif($type == 'text'){

					$fields[] = '$table->'.$type.'("'.$column.'");';

				}else{

					$fields[] = '$table->'.$type.'("'.$column.'", '.$length.');';
				}

			}

			unset($column, $default_value);
		}

		$file = sprintf(static::$migration_pattern, strtolower($name), implode('', $fields), ucwords($name));

		File::put(static::$migrations_dir.'/'.date("Y_m_d_His").'_create_'.strtolower($name.'_table').EXT, $file);

		unset($model);
    }


    /**
	* Fix for column types in according to Laravel
	*
	* @return void
	*/
    static function prepare_column($type){

    	if(in_array($type, array('datetime', 'year', 'bool', 'time', 'longblob', 'mediumblob', 'tinyblob', 'longtext', 'mediumtext', 'tinytext', 'bigint', 'mediumint', 'smallint', 'tinyint', 'int', 'numeric', 'fixed', 'dec', 'double', 'double precision', 'real', 'char', 'varchar'))){

				$type = (in_array($type, array('char', 'varchar'))) ? 'string' : $type;
				$type = (in_array($type, array('datetime', 'year'))) ? 'date' : $type;
				$type = (in_array($type, array('bool'))) ? 'boolean' : $type;
				$type = (in_array($type, array('time'))) ? 'timestamp' : $type;
				$type = (in_array($type, array('longblob', 'mediumblob', 'tinyblob'))) ? 'blob' : $type;
				$type = (in_array($type, array('longtext', 'mediumtext', 'tinytext'))) ? 'text' : $type;
				$type = (in_array($type, array('bigint', 'mediumint', 'smallint', 'tinyint', 'int'))) ? 'integer' : $type;
				$type = (in_array($type, array('numeric', 'fixed', 'dec', 'double', 'double precision', 'real'))) ? 'decimal' : $type;
		}

		return $type;
    }


    /**
	 * Create migration's file from FileDB's model
	 *
	 * @return Laravel\View
	 */
	public function post_create_migration(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		$columns = null;

		if(get_parent_class($income_data["table"]) !== 'Filedb'){

			$table_name = $income_data["table"];
			list($model, $columns) = Utilites::sql_table_model($income_data["table"], true);
		
		}else{

			$model = $income_data["table"]::model();
			$table_name = $income_data["table"].'nosqlfiledb';
		}


		static::generate_migration_file($model, $table_name, $columns);

		$data 				= 	array();
		$data["data_link"] 	= 	action('admin.schema.home');
		$data["location_replace"] = true;

		return View::make('assets.message_redirect', $data); 
	}

	/**
	* Receive and run php artisan command
	*
	* @return string
	*/
	public function post_artisan(){

		$in = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));

		Utilites::run_artisan($in["method"], $in["param"]);


		$data 				= 	array();
		$data["text"] 		= 	Utilites::alert('<strong>'.$in["method"].' '.$in["param"].'</strong> is successfully done!', 'success');
		$data["data_out"] 	= 	'work_area';
		$data["data_link"] 	= 	action('admin.schema.home').'?rndm='.time();
		$data["data_title"] = 	Utilites::build_title(array('content.application_name', 'content.sql_migrations'));

		return View::make('assets.message_redirect', $data); 
	}

	

	/**
	* Delete migration file
	*
	* @return string
	*/
	public function post_delete_migration(){

		$income_data = Filedb::_rawurldecode(json_decode(stripcslashes(Input::get('data')), true));
		
		File::delete(static::$migrations_dir.'/'.$income_data["file_name"].EXT);

		return Utilites::alert(__('forms.deleted_word'), 'success');
	}
}