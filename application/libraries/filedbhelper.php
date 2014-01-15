<?php

class Filedbhelper{


	/**
	 * Add result as object's values
	 *
	 * @param  array|string $columns
	 * @return Filedb
	 */
	protected function add_to_object($columns = null){
		
		if($t = $this->_t()){

			foreach($t as $file_id => &$row) {

				foreach ($row as $key => &$value) {
					
					if($columns){

						if(is_string($columns)){

							if($key == $columns){

								$this->{$key} = $value;
							}
						}

						if(is_array($columns)){

							if(in_array($key, $columns)){

								$this->{$key} = $value;
							}
						}


					}else{

						$this->{$key} = $value;
					}

					unset($key, $value);
				}

				unset($key, $row);
			}

			unset($t);
		}

		if(!$columns){

			$model = static::get_model(true, false);

			foreach($model as $key => &$value){

				if(!isset($this->{$key}) && empty($this->{$key})){

					$this->{$key} = $value;
				}

				unset($key, $value);
			}

			unset($model);
		}

		return $this;
	}


	/**
	 * Return result of find() method
	 * as Object without full_table_* 
	 * arrays and other additional data
	 *
	 * @return Object(stdClass)
	 */
	protected function return_as_stdclass(){

		$res = new stdClass();

		foreach($this as $key => $value) {
                    
            if(!stristr($key, 'full_table_')){

                $res->{$key} = $value;
            }

            unset($key, $value);
        }

		return $res;
	}


	/**
	 * Prepare POST data to model
	 *
	 * @param  array 		$income_data
	 * @return Filedb
	 */
	protected function prepare_results_to_model($income_data = array()){

		if(isset($income_data["id"])){

			$this->find($income_data["id"]);
		}
		
		$model = static::get_model();

		foreach($model as $model_key => &$default_value){

			if(array_key_exists($model_key, $income_data)){

				if($model_key == 'updated_at' || $model_key == 'created_at'){

					if(!is_numeric($income_data[$model_key])){ 

						$income_data[$model_key] = (string) (strtotime($income_data[$model_key])) ? strtotime($income_data[$model_key]) : $income_data[$model_key];
					}
				}

				$this->{$model_key} = $income_data[$model_key];
			}

			unset($model_key, $default_value);
		}

		$this->__destruct();

		return $this;
	}


	/**
	 * Get table name
	 *
	 * @param  string 	$table
	 * @return string
	 */
	protected static function get_table($table=null){

		if(!empty(static::$table)){

			return static::$table;

		}elseif($table != null){

			return strtolower(Str::plural(class_basename($table)));
		}
	}


	/**
	 * Get model as array or object with default values
	 *
	 * @param  bool 	$to_object 		Return model's object
	 * @param  bool 	$empty_model	Return model with empty default value
	 * @return array|object
	 */
	protected static function get_model($to_object = false, $empty_model = false){

		$model = static::$model;

		if($empty_model){

			foreach ($model as $key => &$value) {
				
				$model[$key] = null;

				unset($key, $value);
			}
		}

		if($to_object){

			$model = static::array_to_object($model);
		}

		return $model;
	}


	/**
	 * Get array of all tables names
	 *
	 * @return array
	 */
	protected static function get_tables(){

		$tables_by_model = static::_scandir(static::path(null, '', static::$models_dir));

		foreach ($tables_by_model as &$table) {

			if(stripos(File::get(static::$models_dir.'/'.$table), 'Filedb'))
			{
				$table_model_file = substr($table, 0, -4);
				$tables[] = $table_model_file::get_table($table_model_file);
			}

			unset($table);
		}
		
		return $tables;
	}


	/**
	 * Get array of all Eloquent tables names
	 *
	 * @return array
	 */
	protected static function get_eloquent_tables(){

		$tables_by_model = static::_scandir(static::path(null, '', static::$models_dir));

		foreach ($tables_by_model as &$table) {

			if(stripos(File::get(static::$models_dir.'/'.$table), 'Eloquent'))
			{
				$table_model_file = substr($table, 0, -4);
				$tables[] = $table_model_file::get_table($table_model_file);
			}

			unset($table);
		}
		
		return $tables;
	}


	/**
	 * Get database size in bytes
	 *
	 * @return int
	 */
	protected static function get_db_size(){

		$size = 0;
		$tables = static::get_tables();

		foreach ($tables as &$table) {

			$size += static::get_table_size($table);

			unset($table);
		}

		return $size;
	}


	/**
	 * Get table size by given name
	 *
	 * @param  string 	$table
	 * @return int
	 */
	protected static function get_table_size($table){

		if(!is_dir(static::path(null, $table))){

			File::mkdir(static::path(null, $table), 0755);
		}

		$size = 0;
		$records = static::_scandir(static::path(null, $table));
		
		foreach ($records as &$record) {
			
			$size += filesize(static::path($record, $table));

			unset($record);
		}

		return $size;
	}


	/**
	 * Get quantity of rows in table by given name
	 *
	 * @param  string 	$table
	 * @return int
	 */
	protected static function get_table_records($table){

		return count(static::_scandir(static::path(null, $table)));
	}


	/**
	 * Get quantity of rows in database
	 *
	 * @return int
	 */
	protected static function get_db_records(){

		$records = 0;
		$tables = static::get_tables();

		foreach ($tables as &$table) {

			$records += static::get_table_records($table);

			unset($table);
		}

		return $records;
	}


	/**
	 * @todo  Get array with table information
	 *
	 * @return array
	 */
	protected static function get_table_info(){

		if(file_exists(static::path('table_info.php'))){

			return static::_rawurldecode(require static::path('table_info'));

		}else{

			//CREATE FILE HERE

		}
	}


	/**
	 * Retreive path (route) to root of table or row's file
	 *
	 * @param  string 	$file  		ID of row
	 * @param  string 	$table 		Name of table
	 * @param  string 	$directory 	Directory to DB
	 * @return string
	 */
	protected static function path($file = null, $table = null, $directory = null){

		if(!$file){

			$file = '';

		}elseif(strpos($file,EXT) == false){
				
			$file = $file.EXT;
		}

		if($table === null){

			$table = static::$table;
		}

		if($directory === null){

			$directory = static::$directory;
		}

		return (string) $directory.'/'.$table.'/'.$file;
	}


	/**
	 * Get model file
	 *
	 * @return array
	 */
	protected static function model_file(){

		return (static::$encrypt) ? static::_rawurldecode(eval(trim(str_replace(array('<?php', '?>'), '', static::_rawurldecode(Crypter::decrypt(File::get(static::path('model')))))))) : static::_rawurldecode(require static::path('model'));
	}


	/**
	 * Retreive array with all files excerpt system files in given directory
	 *
	 * @param  string 	$path
	 * @return array
	 */
	protected static function _scandir($path){

		return array_diff(scandir(strtolower($path), 0), array('..', '.', 'table_info.php', 'model.php'));
	}


	/**
	 * Get row
	 *
	 * @param  int|string 	$id
	 * @return array
	 */
	protected static function get_file($id){

		return (static::$encrypt) ? static::array_to_object(static::_rawurldecode(eval(trim(str_replace(array('<?php', '?>'), '', static::_rawurldecode(Crypter::decrypt(File::get(static::path($id))))))))) : static::array_to_object(static::_rawurldecode(require static::path($id)));
	}


	/**
	 * Encode string|array|object|mixed by rawurlencode() method
	 *
	 * @param  string|array|object|mixed 	$data
	 * @return string|array|object|mixed
	 */
	protected static function _rawurlencode($data){

		if(is_object($data)){

			$result = (object) static::_rawurlencode_object($data);

		}elseif(is_array($data)){

			$result = (array) static::_rawurlencode_array($data); 

		}else{

			$result = rawurlencode($data);
		}

		return $result;
	}


	/**
	 * Encode object by rawurlencode() method
	 *
	 * @param  object 	$data
	 * @return object
	 */
	protected static function _rawurlencode_object($data){

		$result = new stdClass;

		foreach ($data as $key => &$value) {

			if(is_array($value) || is_object($value)){

				$result->{$key} = static::_rawurlencode($value);

			}else{

				if(!empty($value)){

					$result->{$key} = rawurlencode($value);

				}else{

					$result->{$key} = '';
				}
			}

			unset($key, $value);
		}

		return (object) $result;
	}


	/**
	 * Encode array by rawurlencode() method
	 *
	 * @param  array 	$data
	 * @return array
	 */
	protected static function _rawurlencode_array($data){
		
		$result = array();

		foreach ($data as $key => &$value) {

			if(is_array($value) || is_object($value)){

				$result[$key] = static::_rawurlencode($value);

			}else{
				
				if(!empty($value)){

					$result[$key] = rawurlencode($value);

				}else{

					$result[$key] = '';

				}	
			}

			unset($key, $value);
		}

		return (array) $result;
	}


	/**
	 * Decode string|array|object|mixed by rawurldecode() method
	 *
	 * @param  string|array|object|mixed 	$data
	 * @return string|array|object|mixed
	 */
	protected static function _rawurldecode($data){

		if(is_object($data)){

			$result = (object) static::_rawurldecode_object($data);

		}elseif(is_array($data)){

			$result = (array) static::_rawurldecode_array($data); 

		}else{

			$result = rawurldecode($data);
		}

		return $result;
	}


	/**
	 * Decode object by rawurldecode() method
	 *
	 * @param  object 	$data
	 * @return object
	 */
	protected static function _rawurldecode_object($data){

		$result = new stdClass;

		foreach ($data as $key => &$value) {

			if(is_array($value) || is_object($value)){

				$result->{$key} = static::_rawurldecode($value);

			}else{

				if(!empty($value)){

					$result->{$key} = rawurldecode($value);

				}else{

					$result->{$key} = '';
				}
			}

			unset($key, $value);
		}

		return (object) $result;
	}


	/**
	 * Decode array by rawurldecode() method
	 *
	 * @param  array 	$data
	 * @return array
	 */
	protected static function _rawurldecode_array($data){
		
		$result = array();

		foreach ($data as $key => &$value) {

			if(is_array($value) || is_object($value)){

				$result[$key] = static::_rawurldecode($value);

			}else{
				
				if(!empty($value)){

					$result[$key] = rawurldecode($value);

				}else{

					$result[$key] = '';
				}
			}

			unset($key, $value);
		}

		return (array) $result;
	}


	/**
	 * Prepare row for table
	 *
	 * @param  string|int 					$key
	 * @param  string|array|object|mixed 	$value
	 * @param  string 	 					$timestamp
	 * @param  boolean 						$encode
	 * @return string
	 */
	protected static function _row($key, $value, $timestamp=null, $encode=true){

		if(is_array($value) || is_object($value)){

			return static::_row_array($key, $value, $timestamp, $encode);

		}else{

			if($key === $timestamp){

				return "'".$key."' => '".static::_rawurlencode(time())."', ";

			}elseif($key === 'id'){

				return (empty($value)) ? "'".$key."' => '', " : "'".$key."' => ".$value.", ";
				
			}else{

				return "'".$key."' => '".static::_rawurlencode($value)."', ";
			}
		}
	}


	/**
	 * Prepare array to row for table
	 *
	 * @param  string|int 		$key
	 * @param  array|object 	$value
	 * @param  string 	 		$timestamp
	 * @param  boolean 			$encode
	 * @return string
	 */
	protected static function _row_array($key, $value, $timestamp=null, $encode=true){

		$file = '';
		$file .= "'".$key."' => array(";

			foreach($value as $key1 => &$val){

				if(is_array($val)){

					$file .= static::_row_array($key1, $val, $timestamp, $encode);

				}else{

					$file .= static::_row($key1, $val, $timestamp, $encode);
				}

				unset($key1, $val);
			}

		$file .= "), ";
		return $file;
	}


	/**
	 * Create stdClass from array
	 *
	 * @param  array 	$array
	 * @return object
	 */
	protected static function array_to_object($array){
		
		$object = new stdClass;

		foreach($array as $key => &$value) {

			if(is_array($value)){

				$object->{$key} = static::array_to_object($value);

			}else{

				$object->{$key} = $value;
			}

			unset($key, $value);
		}

		return $object;
	}


	/**
	 * Creat array from object
	 *
	 * @param  array|object $data
	 * @param  boolean 		$once  If set only first level prepared to array
	 * @return array
	 */
	protected static function object_to_array($data, $once=false){

	    if (is_array($data) || is_object($data)){

	        $result = array();
	        foreach ($data as $key => &$value){

	        	if($once){

	        		$result[$key] = $value;

	        	}else{

	        		$result[$key] = static::object_to_array($value);
	        	}

	        	unset($key, $value);
	        }

	        return $result;
	    }

	    return $data;
	}


	/**
	 * Retreive max id from table
	 *
	 * @return int
	 */
	protected static function max_id(){

		$rows = static::_scandir(static::path());

		if($rows){

			foreach ($rows as &$value) {

				$row[] = str_replace(EXT, '', $value);

				unset($value);
			}

		}else{

			$row = array(0);
		}

		return intval(max($row));
	}


	/**
	 * Get qty of lines in model file
	 *
	 * @return int
	 */
	protected static function get_model_lines(){

		return count(file(static::$models_dir.'/'.static::$table.EXT));
	}


	/**
	 * Check if table has encryption
	 *
	 * @return bool
	 */
	protected static function has_encryption(){

		return static::$encrypt;
	}


	/**
	 * Join new column with $table content on $column
	 *
	 * @param  string|*|array $new_column Searchable column, on output will be like: Table_name.Column_name => $value. 
	 * Set to * to join all columns
	 *
	 * @param  string 	$column 	Column in first table Ex.: table_name.Column_name
	 * @param  string 	$operator	Any supported operator Ex.: =|!=|<>|<|>|<=|>=|like|similar|soundex
	 * @param  string 	$column2	Column in second table Ex.: table_name.Column_name
	 * @return $this
	 */
	protected function left_join($new_column, $column, $operator, $column2){

		list($this_table, $this_table_coulmn) = explode('.', $column);
		list($second_table, $second_table_column)  = explode('.', $column2);

		$this_results = $this->_t();

		if($this_results){

			foreach($this_results as $file_id => &$row){
				
				if($new_column == '*'){

					$selection = $second_table::where($second_table_column, $operator, $row->$this_table_coulmn)->get();

					if($selection){

						$selection_qty = count(static::object_to_array($selection));

						foreach ($selection as $selected_file_id => &$selected_row) {
							
							foreach ($selected_row as $column => $value) {

								if($selection_qty > 1){

									$this_results[$file_id]->{$second_table.'.'.$column}[$selected_file_id] = $value;

								}else{

									$this_results[$file_id]->{$second_table.'.'.$column} = $value;
								}
							}

							unset($selected_file_id, $selected_row);
						}
					}

				}else{

					if(is_array($new_column)){

						$selection = $second_table::where($second_table_column, $operator, $row->$this_table_coulmn)->only($new_column);

						if($selection){

							$selection_qty = count(static::object_to_array($selection));

							foreach ($selection as $key => &$selected_array){

								foreach ($selected_array as $column => &$value) {
									
									$this_results[$file_id]->{$second_table.'.'.$column}[$key] = $selected_array[$column];

									unset($column, $value);
								}

								unset($key, $selected_array);
							}
						}

					}else{

						$selection = $second_table::where($second_table_column, $operator, $row->$this_table_coulmn)->only($new_column);

						if($selection){
						
							$this_results[$file_id]->{$second_table.'.'.$new_column} = $selection;
						}
					}
				}

				unset($file_id, $row);
			}
		}

		if($this_results){

			$this->_t_set($this_results);
		}

		unset($this_results);

		return $this;
	}
}