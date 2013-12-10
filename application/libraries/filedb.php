<?php
	
class Filedb extends Filedbhelper{


	/**
	 * Row's file pattern
	 *
	 * @var string
	 */
	protected static $file_pattern = "<?php 
	return array( %s );";


	/**
	 * Model's file pattern.
	 * Must be one line
	 *
	 * @var string
	 */
	protected static $model_pattern = '<?php class %1$s extends Filedb{ public static $table = "%2$s"; public static $model; %3$s}';


	/**
	 * Directory for importing data from SQL, Postrgess etc. othet Laravel's drivers
	 *
	 * @var string
	 */
	private static $import_dir = 'storage/db';


	/**
	 * Table name
	 *
	 * @var string
	 */
	protected static $table;


	/**
	 * Directory with models files usually application/models
	 *
	 * @var string
	 */
	protected static $models_dir = 'application/models';


	/**
	 * FileDB root directory
	 *
	 * @var string
	 */
	protected static $directory = 'storage/db';


	/**
	 * Model
	 *
	 * @var array
	 */
	private static $model;


	/**
	 * Is table encrypted?
	 *
	 * @var bool
	 */
	public static $encrypt = false;


	/**
	 * Instance
	 *
	 * @var this
	 */
	protected static $_inst = NULL;


	/**
	 * Set table name and run Initialization.
	 *
	 * @return void
	 */
	public function __construct(){

		if(!isset(static::$table)){

			$this->table();
		}

		return $this->init();
	}


	/**
	 * Find table name
	 *
	 * @param  string  $table  Set to change table on the fly.
	 * @return void
	 */
	protected function table($table=null){

		($table) ? static::$table = strtolower($table) : static::$table = strtolower(Str::plural(class_basename($this)));

		return (strtolower(get_called_class()) == static::$table) ? $this : $this->init();
	}


	/**
	 * Initialize FileDB. Get all records from table to array.
	 * Prepare model. Check if table exists.
	 *
	 * @return Filedb
	 */	
	private function init(){

		$path = static::path(null, static::$table);

		if(!isset($this->{'full_table_'.static::$table}) || empty($this->{'full_table_'.static::$table})){

			if(is_dir($path)){

				$rows = static::_scandir($path);

			}else{

				return 'No such table ('.$path.')!';

			}

			foreach ($rows as $key => &$value) {

				if(strpos($value,EXT) !== false){

					$file_id = substr($value, 0, -4);

					$this->{'full_table_'.static::$table}[$file_id] = static::get_file($file_id);
				}

				unset($key, $value);
			}

			unset($rows);
		}

		if(!isset(static::$model) || empty(static::$model) ){

			static::$model = static::model_file();
		}

		return $this;
	}


	/**
	 * Get full table
	 *
	 * @param  string $path
	 * @return Filedb
	 */
	private function get_full_table($path){

		if(is_dir($path)){

			$rows = static::_scandir($path);

		}else{

			return 'No such table ('.$path.')!';

		}

		foreach ($rows as $key => &$value) {

			if(strpos($value,EXT) !== false){

				$file_id = substr($value, 0, -4);

				$table[$file_id] = static::get_file($file_id);
			}

			unset($key, $value);
		}


		return $table;
	}


	/**
	 * Set full table instead of result for further selection
	 *
	 * @return Filedb
	 */
	protected function use_all(){

		$path = static::path(null, static::$table);
		$this->_t_set($this->get_full_table($path));

		return $this;
	}


	/**
	 * Retreive array of rows from selection or full table
	 *
	 * @param  string|null 	$columns
	 * @return array
	 */
	private function get($columns=null){

		if($columns){

			$this->_only($columns);
		}

		if(isset($this->grouped)){

			return $this->grouped;

		}elseif(isset($this->result) && !empty($this->result)){ 

			return static::array_to_object($this->result);

		}else{

			return $this->_t();
		}
	}


	/**
	 * Retreive JSON of rows from selection or full table
	 *
	 * @param  string|null 	$columns
	 * @return array
	 */
	protected function json($columns=null){

		return json_encode($this->get($columns), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
	}


	/**
	 * Get row by id (or unuque field), and put data into object
	 *
	 * @param  int|string $id	  unique value
	 * @param  string	  $field  field name
	 * @return Filedb
	 */
	private function find($id = null, $field = null){

		if(!$id){

			die("Missing argument 1 for Filedb::find($id) OR provided $id is not numeric");
		}

		if(is_numeric($id)){

			$id = intval($id);
			$this->where_id($id);

		}elseif($field){

			$this->where($field, '=', $id);
		}

		$this->add_to_object();

		$this->{'find_'.Config::get('application.key')} = true;

		self::__destruct();

		return $this;
	}


	/**
	 * Take first row from end of selection or full table.
	 *
	 * @param  string $columns
	 * @return array 			Selected row
	 */
	public function first($columns=null){

		return ($columns) ? $this->limit(0,1)->add_to_object($columns) : $this->limit(0,1)->add_to_object();
	}


	/**
	 * Prepare data for make() method of Laravel's Paginator class.
	 * Retreive pagination from Laravel's Paginator class.
	 *
	 * @param  int 			$per_page 	Quantity of shown rows per page
	 * @param  array|null 	$array_data
	 * @return Paginator
	 */
	private function paginate($per_page, $array_data=null){

		if(Input::get('page', 1) < 2){

			$start = 0;

		}else{

			$start = (Input::get('page') - 1) * $per_page;
		}

		if(isset($this->grouped)){

			$groups = array_keys($this->grouped);
			$groups_qty = count($groups);
			$qty = count($this->grouped);

			ksort($this->grouped);
			$this->grouped = array_slice($this->grouped, $start, $per_page);


		}else{

			$qty = $this->count();
			$this->limit($start, $per_page);
		}

		if($array_data){

			return Paginator::make($this->get($array_data), $qty, $per_page);

		}else{

			return Paginator::make($this->get(), $qty, $per_page);
		}
	}


	/**
	 * Cut form start and end provided quantity of rows from selection of full table
	 *
	 * @param  int 	$start
	 * @param  int 	$take
	 * @return Filedb
	 */
	protected function limit($start, $take){

		if($this->_t()){

			$this->result = array_slice($this->_t(), $start, $take);
		}

		return $this;
	}


	/**
	 * Cut form start provided quantity of rows from selection of full table
	 *
	 * @param  int 	$num
	 * @return Filedb
	 */
	protected function skip($num){

		$this->limit($num, null);
		return $this;
	}


	/**
	 * Cut form end provided quantity of rows from selection of full table
	 *
	 * @param  int 	$num
	 * @return Filedb
	 */
	protected function take($num){

		$this->limit(0, $num);
		return $this;
	}


	/**
	 * Retreive average value of values in provided column in selection or full table
	 *
	 * @param  string 	$field
	 * @return int
	 */
	protected function avg($field){

		if($this->count() == 0){
			return 0;
		}

		return $this->sum($field) / $this->count();
	}


	/**
	 * Retreive sum of values in provided column in selection or full table
	 *
	 * @param  string 	$field
	 * @return int
	 */
	protected function sum($field){

		$column = $this->only(array($field));

		if(isset($column)){

			$num = array_values($column);
			$num = intval(array_shift($num));

			if(is_numeric($num)){

				foreach ($column as &$value) {

					$res[] = $value[$field];

					unset($value);
				}

				return array_sum($res);

			}else{

				die('Non numeric field "'.$field.'" is provided!');
			}

		}else{
			return null;
		}

	}


	/**
	 * Retreive quantity of rows in selection or full table
	 *
	 * @param  boolean 	$or	If set to TRUE search will be thru full table
	 * @return int
	 */
	protected function count(){

		$rows = static::object_to_array($this->_t());

		if(isset($rows) && !empty($rows)){

			return count($rows);

		}else{

			return 0;
		}

	}


	/**
	 * Retreive maximum value of provided column in selection or full table
	 *
	 * @param  string 	$field
	 * @return string|int
	 */
	protected function max($field){

		$column = $this->only(array($field));

		if(isset($column)){

			$num = array_values($column);
			$num = intval(array_shift($num));

			if(is_numeric($num)){

				foreach ($column as &$value) {

					$result[] = $value;

					unset($value);
				}

				$max = max($result);

				return $max[$field];

			}else{

				die('Non numeric field "'.$field.'" is provided!');
			}

		}else{

			return null;
		}
	}


	/**
	 * Retreive minimum value of provided column in selection or full table
	 *
	 * @param  string 	$field
	 * @return string
	 */
	private function min($field){

		$column = $this->only(array($field));

		if(isset($column)){

			$num = array_values($column);
			$num = intval(array_shift($num));

			if(is_numeric($num)){

				foreach ($column as &$value) {

					$result[] = $value;

					unset($value);
				}

				$min = min($result);

				return $min[$field];

			}else{

				die('Non numeric field "'.$field.'" is provided!');
			}

		}else{

			return null;
		}
	}


	/**
	 * Increment value of provided column(s) in selection
	 *
	 * @param  string|array $field
	 * @param  int 			$on 	increment value on $on
	 * @return Filedb
	 */
	private function increment($field, $on = null){

		if($this->_t()){

			$rows = count($this->_t());
			$preserved = $this->_t();
			$cycle = 0;

			$add = ($on) ? $on : 1;

			foreach ($preserved as $file_id => &$row) {

				++$cycle;

				if(is_array($field)){

					foreach ($field as &$column) {

						(isset($row->{$column})) ? is_numeric($row->{$column}) ? $this->where_id($row->id)->update(array($column => floatval($row->{$column}) + $add)) : die('Non numeric column "'.$column.'" is provided! Or select has many results') : 'Nothing to increment! -> Column: "'.$column.'" is not found in table: '.static::$table;

						unset($column);
					}

				}else{

					(isset($row->{$field})) ? is_numeric($row->{$field}) ? $this->where_id($row->id)->update(array($field => floatval($row->{$field}) + $add)) : die('Non numeric column "'.$field.'" is provided! Or select has many results') : 'Nothing to increment! -> Column: "'.$field.'" is not found in table: '.static::$table;
				}

				if($rows <= $cycle){

					$this->_t_set($preserved);
				}

				unset($file_id, $row);
			}
		}

		return $this;
	}


	/**
	 * Decrement value of provided column(s) in selection
	 *
	 * @param  string|array $field
	 * @param  int 			$on 	decrement value on $on
	 * @return Filedb
	 */
	private function decrement($field, $on = null){

		if($this->_t()){

			$rows = count($this->_t());
			$preserved = $this->_t();
			$cycle = 0;

			$take = ($on) ? $on : 1;

			foreach ($preserved as $file_id => &$row) {

				++$cycle;

				if(is_array($field)){

					foreach ($field as &$column) {

						(isset($row->{$column})) ? is_numeric($row->{$column}) ? $this->where_id($row->id)->update(array($column => floatval($row->{$column}) - $take)) : die('Non numeric column "'.$column.'" is provided! Or select has many results') : 'Nothing to increment! -> Column: "'.$column.'" is not found in table: '.static::$table;

						unset($column);
					}

				}else{

					(isset($row->{$field})) ? is_numeric($row->{$field}) ? $this->where_id($row->id)->update(array($field => floatval($row->{$field}) - $take)) : die('Non numeric column "'.$field.'" is provided! Or select has many results') : 'Nothing to increment! -> Column: "'.$field.'" is not found in table: '.static::$table;
				}

				if($rows <= $cycle){

					$this->_t_set($preserved);
				}

				unset($file_id, $row);
			}
		}

		return $this;
	}


	/**
	 * Ordering array from result or full table by provided column
	 *
	 * @param  string 	$field
	 * @param  string(ASC|DESC|asc|desc) $type
	 * @param  sort_flags $flags see: http://www.php.net/manual/en/function.sort.php
	 * @return Filedb
	 */
	private function order_by($field, $type='ASC', $flags=SORT_REGULAR){

		if($this->_t()){

			$t = $this->_t();

			foreach ($t as $file_id => &$row) {

				$res[$file_id] = (isset($row->{$field})) ? $row->{$field} : $row->created_at;

				unset($file_id, $row);
			}

			if($type == 'ASC' || $type == 'asc'){

				asort($res, $flags);
			}

			if($type == 'DESC' || $type == 'desc'){

				arsort($res, $flags);
			}

			foreach ($res as $id => &$value) {

				$res[$id] = $t[$id];

				unset($value);
			}

			$this->result = $res;

			unset($t);

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Add coulmn to table
	 *
	 * @param  string 		$column
	 * @param  string|null 	$function 	MAX|MIN|COUNT|SUM|AVG
	 * @param  string 		$new_column New column name
	 * @return Filedb
	 */
	private function add($column, $function, $new_column){

		$value = (!is_null($function) && in_array($function, array('max', 'min', 'count', 'sum', 'avg'))) ? $this->$function($column) : $function;

		if($this->_t()){

			$t = $this->_t();

			foreach ($t as $file_id => &$row) {

				$row->{$new_column} = $value;

				unset($row);
			}
		}

		return $this;
	}


	/**
	 * Run BETWEEN selecton
	 *
	 * @param  string 		$column
	 * @param  string|array $data1 	Searchable value
	 * @param  string|array $data2 	Searchable value
	 * @return Filedb
	 */
	private function between($column, $data1, $data2){

		$this->where($column, '>=', $data1)->and_where($column, '<=', $data2);

		return $this;
	}


	/**
	 * Run NOT BETWEEN selecton
	 *
	 * @param  string 		$column
	 * @param  string|array $data1 	Searchable value
	 * @param  string|array $data2 	Searchable value
	 * @return Filedb
	 */
	private function not_between($column, $data1, $data2){

		$this->where($column, '<', $data1)->or_where($column, '>', $data2);

		return $this;
	}


	/**
	 * Run selecton
	 *
	 * @param  string 		$column
	 * @param  string(=|!=|<>|<|>|<=|>=|like|similar|soundex) $operator
	 * @param  string|array $data 	Searchable value
	 * @return Filedb
	 */
	private function where($column, $operator, $data){

		$this->__sleep();
		$this->_switch_select($column, $operator, $data, false, false);

		return $this;
	}


	/**
	 * Select rows where provided $column is null value.
	 *
	 * @param  string 	$column
	 * @return Filedb
	 */
	private function where_null($column){

		$this->__sleep();
		$this->_switch_select($column, '=', null, false, false);

		return $this;
	}


	/**
	 * Select rows where provided $column is not null value.
	 *
	 * @param  string 	$column
	 * @return Filedb
	 */
	private function where_not_null($column){

		$this->__sleep();
		$this->_switch_select($column, '!=', null, false, false);

		return $this;
	}


	/**
	 * Select rows where provided $column is equal to $data_array.
	 *
	 * @param  string 		$column
	 * @param  string|array $data_array
	 * @return Filedb
	 */
	private function where_in($column, $data_array){

		$this->__sleep();
		$this->_switch_select($column, '=', $data_array, false, false);

		return $this;
	}


	/**
	 * Select rows where provided $column is not equal to $data_array.
	 *
	 * @param  string 		$column
	 * @param  string|array $data_array
	 * @return Filedb
	 */
	private function where_not_in($column, $data_array){

		$this->__sleep();
		$this->_switch_select($column, '!=', $data_array, false, false);

		return $this;
	}


	/**
	 * Run second selection in selected rows
	 *
	 * @param  string 		$column
	 * @param  string(=|!=|<>|<|>|<=|>=|like|similar|soundex) $operator
	 * @param  string|array $data 	Searchable value
	 * @return Filedb
	 */
	private function and_where($column, $operator, $data){

		$this->_switch_select($column, $operator, $data, true, false);

		return $this;
	}


	/**
	 * Run second selection in full table
	 *
	 * @param  string 		$column
	 * @param  string(=|!=|<>|<|>|<=|>=|like|similar|soundex) $operator
	 * @param  string|array $data 	Searchable value
	 * @return Filedb
	 */
	private function or_where($column, $operator, $data){

		$this->_switch_select($column, $operator, $data, false, true);

		return $this;
	}


	/**
	 * Second selection from full table where provided $column is equal to $data_array.
	 *
	 * @param  string 		$column
	 * @param  string|array $data_array
	 * @return Filedb
	 */
	private function or_where_in($column, $data_array){

		$this->_switch_select($column, '=', $data_array, false, true);

		return $this;
	}


	/**
	 * Second selection from full table where provided $column's value is null.
	 *
	 * @param  string 	$column
	 * @return Filedb
	 */
	private function or_where_null($column){

		$this->_switch_select($column, '=', null, false, true);

		return $this;
	}


	/**
	 * Second selection from full table where provided $column is not equal to $data_array.
	 *
	 * @param  string 		$column
	 * @param  string|array $data_array
	 * @return Filedb
	 */
	private function or_where_not_in($column, $data_array){

		$this->_switch_select($column, '!=', $data_array, false, true);

		return $this;
	}


	/**
	 * Second selection from full table where provided $column's value is not null.
	 *
	 * @param  string 	$column
	 * @return Filedb
	 */
	private function or_where_not_null($column){

		$this->_switch_select($column, '!=', null, false, true);

		return $this;
	}


	/**
	 * Retreive row where id is equal to $id
	 *
	 * @param  int|string $id
	 * @return Filedb
	 */
	private function where_id($id){

		$id = intval($id);
		// $this->result = array($id => static::get_file($id));
		$this->where('id', '=', $id);

		return $this;
	}


	/**
	 * Retreive rows where id is not equal to $id
	 *
	 * @param  int|string $id
	 * @return Filedb
	 */
	private function where_not_id($id){

		$id = intval($id);
		$this->_switch_select('id', '!=', $id, false, false);

		return $this;
	}


	/**
	 * Switch between selection types
	 *
	 * @param  string 		$column
	 * @param  string(=|!=|<>|<|>|<=|>=|like|similar|soundex) $operator
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function _switch_select($column, $operator, $data, $and, $or){

		if($and || $or){
			if(!isset($this->result)){
				$this->result = '';
			}
		}

		switch ($operator) {
			case '=':
				$this->where_equal($column, $data, $and, $or);
				break;
			case '<>':
			case '!=':
				$this->where_not($column, $data, $and, $or);
				break;
			case 'like':
				$this->where_like($column, $data, $and, $or);
				break;
			case 'similar':
				$this->where_similar($column, $data, $and, $or);
				break;
			case 'soundex':
				$this->where_soundex($column, $data, $and, $or);
				break;
			case '>':
				$this->where_compare($column, $data, $and, $or, 'greater');
				break;
			case '<':
				$this->where_compare($column, $data, $and, $or, 'less');
				break;
			case '>=':
				$this->where_compare($column, $data, $and, $or, 'greater_or_equal');
				break;
			case '<=':
				$this->where_compare($column, $data, $and, $or, 'less_or_equal');
				break;
			default:
				die('Wrong operator ('. $operator .') provided or this operator is not supported');

		}

		return $this;
	}


	/**
	 * Run compare selection
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @param  string(greater|less|greater_or_equal|less_or_equal) $type
	 * @return Filedb
	 */
	private function where_compare($column, $data, $and=false, $or=false, $type){

		if($t_where = $this->_t_where($and, $or)){

			switch ($type) {
				case 'greater':
					$this->order_by('id');
					break;

				case 'less':
					$this->order_by('id', 'DESC');
					break;

				case 'greater_or_equal':
					$this->order_by('id');
					break;

				case 'less_or_equal':
					$this->order_by('id', 'DESC');
					break;
			}

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						die('Arrays is not supported in "Greater than", "Less than" and other similar operations');

					}else{

						$data = intval($data);

						switch ($type) {
							case 'greater':
								$result = $this->greater($row->{$column}, $data, $or, $file_id, $row);
								($result) ? $res[$file_id] = $result : false;
								break;

							case 'less':
								$result = $this->less($row->{$column}, $data, $or, $file_id, $row);
								($result) ? $res[$file_id] = $result : false;
								break;

							case 'greater_or_equal':
								$result = $this->greater_or_equal($row->{$column}, $data, $or, $file_id, $row);
								($result) ? $res[$file_id] = $result : false;
								break;

							case 'less_or_equal':
								$result = $this->less_or_equal($row->{$column}, $data, $or, $file_id, $row);
								($result) ? $res[$file_id] = $result : false;
								break;
						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Check if value is greater than
	 *
	 * @param  mixed 		$value
	 * @param  string|array $data
	 * @param  int 			$file_id
	 * @param  array 		$row
	 * @return array|void
	 */
	protected function greater($value, $data, $or=false, $file_id, $row){

		return ($value > $data) ? ($or) ? $this->result[$file_id] = $row : $row : false;
	}


	/**
	 * Check if value is less than
	 *
	 * @param  mixed 		$value
	 * @param  string|array $data
	 * @param  int 			$file_id
	 * @param  array 		$row
	 * @return array|void
	 */
	protected function less($value, $data, $or=false, $file_id, $row){

		return ($value < $data) ? ($or) ? $this->result[$file_id] = $row : $row : false;
	}


	/**
	 * Check if value is greater than or equal
	 *
	 * @param  mixed 		$value
	 * @param  string|array $data
	 * @param  int 			$file_id
	 * @param  array 		$row
	 * @return array|void
	 */
	protected function greater_or_equal($value, $data, $or=false, $file_id, $row){

		return ($value >= $data) ? ($or) ? $this->result[$file_id] = $row : $row : false;
	}


	/**
	 * Check if value is less than or equal
	 *
	 * @param  mixed 		$value
	 * @param  string|array $data
	 * @param  int 			$file_id
	 * @param  array 		$row
	 * @return array|void
	 */
	protected function less_or_equal($value, $data, $or=false, $file_id, $row){

		return ($value <= $data) ? ($or) ? $this->result[$file_id] = $row : $row : false;
	}


	/**
	 * Run equal selection
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function where_equal($column, $data, $and=false, $or=false){

		if($t_where = $this->_t_where($and, $or)){

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						if(in_array($row->{$column}, $data)){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}
						}

					}else{

						if($row->{$column} ==  $data){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}
						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Run where not selection
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function where_not($column, $data, $and=false, $or=false){

		if($t_where = $this->_t_where($and, $or)){

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						if(!in_array($row->{$column}, $data)){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}

						}

					}else{

						if($row->{$column} !==  $data){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}

						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Run like selection.
	 * To find out how method works please see: http://www.php.net/manual/en/function.strripos.php
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function where_like($column, $data, $and=false, $or=false){

		if($t_where = $this->_t_where($and, $or)){

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						foreach($data as &$needle){

							if(strripos($row->{$column}, $needle) !== false){

								if($or){
									$this->result[$file_id] = $row;
								}else{
									$res[$file_id] = $row;
								}

							}

							unset($needle);
						}

					}else{

						if(strripos($row->{$column}, $data) !== false){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}

						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Run similar selection.
	 * To find out how method works please see: http://www.php.net/manual/en/function.similar-text.php
	 * In Indira FileDB Driver where_similar method accepts all results with similarity greater or equal to 80%
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function where_similar($column, $data, $and=false, $or=false){

		if($t_where = $this->_t_where($and, $or)){

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						foreach($data as &$needle){

							similar_text($row->{$column}, $needle, $similarity);

							if(number_format($similarity, 0) >= 80){

								if($or){
									$this->result[$file_id] = $row;
								}else{
									$res[$file_id] = $row;
								}

							}

							unset($needle);
						}

					}else{

						similar_text($row->{$column}, $data, $similarity);
						if(number_format($similarity, 0) >= 80){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}

						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Run soundex selection.
	 * To find out how method works please see: http://www.php.net/manual/en/function.soundex.php
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return Filedb
	 */
	private function where_soundex($column, $data, $and=false, $or=false){

		if($t_where = $this->_t_where($and, $or)){

			foreach ($t_where as $file_id => &$row) {

				if(isset($row->{$column})){

					if(is_array($data)){

						foreach($data as &$needle){

							if(soundex($row->{$column}) == soundex($needle)){

								if($or){
									$this->result[$file_id] = $row;
								}else{
									$res[$file_id] = $row;
								}

							}

							unset($needle);
						}

					}else{

						if(soundex($row->{$column}) == soundex($data)){

							if($or){
								$this->result[$file_id] = $row;
							}else{
								$res[$file_id] = $row;
							}

						}
					}
				}

				unset($file_id, $row);
			}

			unset($t_where);

			if($and || $or){
				if(isset($res)){
					$this->result = $res;
				}elseif($and && !$or){
					$this->result = '';
				}
			}else{
				if(isset($res)){
					$this->result = $res;
				}else{
					$this->result = '';
				}
			}

		}else{

			$this->result = '';
		}

		return $this;
	}


	/**
	 * Group by implementation
	 * Results will be available as $object->$group->$file_id->$column
	 *
	 * @param  string $column
	 * @return array
	 */
	private function groupBy($column){

		return $this->group($column);
	}

	private function group_by($column){

		return $this->group($column);
	}


	/**
	 * Group selection by one column
	 * This method will return array($column[$value] => array(array $row, [, array $... ]))
	 * This method must be final in query builder as it returns non-typical array
	 * Results will be available as $object->$group->$file_id->$column
	 *
	 * @param  string $column
	 * @param  array  $order 		array(column, type(ASC|DESC))
	 * @param  array  $aggregate 	array(column, type(sum|min|avg|count), (optional)new_column_name)
	 * @return array
	 */
	private function group($column, $order = null, $aggregate = null){

		$result = array();
		$number = 0;
		$previous_selection = $this->_t();

		if($this->_t()){

			($order) ? $this->order_by($order[0], $order[1]) : $this->order_by($column);

			$t = $this->_t();

			foreach ($t as $file_id => &$row) {

				if(isset($row->{$column})){

					$previous 	= 	(!isset($previous)) ? $row->{$column} : $previous;

					if($previous != $row->{$column} || !isset($num) || array_key_exists($num, $result)){

						$num = (is_string($row->{$column})) ? $row->{$column} : ++$number;
					}

					$result[$num][$file_id] = $row;
				}

				unset($file_id, $row);
			}

			unset($t);

			if($aggregate){

				foreach ($result as $grouped_by => &$selection) {

					if(!isset(${'aggregated'.$grouped_by})){

						$this->_t_set($previous_selection);

						${'aggregated'.$grouped_by} = $this->and_where($column, '=', $grouped_by)->$aggregate[1]($aggregate[0]);
					}

					foreach ($selection as $file_id => &$row) {

						$column_name = ($aggregate[2]) ? $aggregate[2] : $aggregate[0];

						$result[$grouped_by][$file_id]->{$column_name} = ${'aggregated'.$grouped_by};

						unset($file_id, $row);
					}

					unset($grouped_by, $selection);
				}
			}
		}

		$this->_t_set($previous_selection);
		$this->grouped = $result;

		unset($result, $previous_selection);

		return $this;
	}


	/**
	 * Retreive all rows from table.
	 *
	 * @return array
	 */
	private function all(){

		return $this->_t();
	}


	/**
	 * Retreive all rows from table.
	 *
	 * @return array
	 */
	private function model(){

		return $this->get_model();
	}


	/**
	 * Retreive current selection.
	 *
	 * @return array
	 */
	private function _t(){

		if(isset($this->result)){

			return $this->result;

		}elseif(isset($this->id)){

			$table = array();
			$table[$this->id] = static::get_file($this->id);

			foreach (static::$model as $column => &$default_value) {

				if(isset($this->{$column})){

					$table[$this->id]->{$column} = $this->{$column};

				}

				unset($column, $default_value);
			}

			return $table;

		}elseif(isset($this->{'full_table_'.static::$table})){

			return $this->{'full_table_'.static::$table};
		}
	}


	/**
	 * Set new value to result.
	 *
	 * @var mixed $data
	 * @return void
	 */
	private function _t_set($data){

		if(isset($this->result)){

			$this->result = $data;

		}elseif(isset($this->{'full_table_'.static::$table})){

			$this->{'full_table_'.static::$table} = $data;
		}
	}


	/**
	 * Retreive current selection for different selection methods.
	 *
	 * @return array
	 */
	private function _t_where($and, $or){

		if($and){

			if(isset($this->result)){

				$table = $this->result;

			}else{

				die('"and_where" or "or_where" must be at least as second parameter!');
			}

		}elseif($or){

			if(isset($this->{'full_table_'.static::$table})){

				$table = $this->{'full_table_'.static::$table};

			}else{

				die('"and_where" or "or_where" must be at least as second parameter! | Something went wrong please check $this object above.'.var_dump($this));
			}

		}else{

			if(isset($this->{'full_table_'.static::$table})){

				$table = $this->{'full_table_'.static::$table};

			}else{

				$table = null;
			}
		}

		return $table;
	}


	/**
	 * Retreive value(s) of provided column(s).
	 *
	 * @param  string|array $column
	 * @return Filedb|null
	 */
	private function _only($column){

		if($t = $this->_t()){

			foreach($t as $file_id => &$row) {

				if(is_array($column)){

					$mid_res = array();

					foreach ($column as &$value) {

						if(isset($row->{$value})){

							$mid_res = array_merge($mid_res, array($value => $row->{$value}));
						}

						unset($value);
					}

					if($mid_res){
						$res[$file_id] = $mid_res;
					}

				}else{

					if(isset($row->{$column})){

						$res[$file_id] = array($column => $row->{$column});

					}
				}

				unset($file_id, $row);
			}

			unset($t);

			if(isset($res)){
				$this->result = $res;
			}else{
				$this->result = '';
			}

			return $this;

		}else{

			return null;
		}
	}


	/**
	 * Retreive value(s) of provided column(s).
	 *
	 * @param  string|array 		$column
	 * @param  boolean 		$and
	 * @param  boolean 		$or
	 * @return string|array|null
	 */
	protected function only($column){

		if($t = $this->_t()){

			foreach ($t as $file_id => &$row) {

				if(is_array($column)){

					foreach ($column as &$value) {

						if(isset($row->{$value})){

							$res[$file_id][$value] = $row->{$value};
						}

						unset($value);
					}

				}else{

					if(isset($row->{$column})){

						$res = $row->{$column};
					}
				}

				unset($file_id, $row);
			}

			unset($t);

			return (isset($res)) ? $res : null;

		}else{

			return null;
		}
	}


	/**
	 * Retreive value(s) of provided column(s) in according to .
	 *
	 * @param  string 		$column
	 * @param  string|array $data
	 * @param  string|array $only
	 * @return Filedb
	 */
	protected function where_only($column, $data, $only=null){

		if($t = $this->_t()){

			foreach ($t as $file_id => &$row) {

				if(isset($row->{$column})){

					if($row->{$column} == $data){

						if(is_array($only)){

							foreach ($only as &$value) {

								$res[$value] = $row->{$value};

								unset($value);
							}

						}elseif($only){

							$res[$file_id] = $row->{$only};

						}else{

							$res[$file_id] = $row->{$column};
						}
					}
				}

				unset($file_id, $row);
			}

			unset($t);
		}

		$this->result = (isset($res)) ? $res : '';

		return $this;
	}


	/**
	 * Save data from object(TableClass)
	 *
	 * @return Filedb
	 */
	public function save(){

		$data = array();

		foreach (static::$model as $model_key => &$default_value) {

			if(isset($this->$model_key)){

				$data[$model_key] = $this->{$model_key};

			}

			unset($model_key, $default_value);			
		}

		if(isset($data["id"]) && !empty($data["id"]) && !is_null($data["id"])){

			$result = $this->update($data);

		}else{

			$result = $this->create($data);
		}

		return $this;
	}


	/**
	 * Update data in selection or full table
	 *
	 * @param  array|object $data
	 * @return array
	 */
	private function update($data=null){

		if(is_array($data) || is_object($data) || is_null($data)){

			$data = $this->update_helper($data);

			$result = array();
			$table_dir = static::path();

			if($t = $this->_t()){

				foreach($t as &$row) {

					$file_dir = static::path($row->id);
					$file = array();

					foreach (static::$model as $model_key => &$default_value) {

						if(array_key_exists($model_key, $data)){

							$this->{$model_key} = $data[$model_key];

							$file[] = static::_row($model_key, $data[$model_key], 'updated_at');

						}elseif(isset($row->$model_key)){

							$this->{$model_key} = $row->$model_key;

							$file[] = static::_row($model_key, $row->$model_key, 'updated_at');

						}else{

							$file[] = static::_row($model_key, $default_value);
						}

						unset($model_key, $default_value);
					}

					sleep(0.1);

					if(static::$encrypt){

						$file = Crypter::encrypt(static::_rawurlencode(sprintf(static::$file_pattern, implode('', $file))));

					}else{

						$file = sprintf(static::$file_pattern, implode('', $file));
					}

					File::mkdir($table_dir, 0777);

					$result[] = File::put($file_dir, $file);

					unset($row);
				}

				unset($t);
			}

			return $result;

		}else{

			return 'To update row use array or object ONLY!';
		}
	}


	/**
	 * Help to retreive saving data
	 *
	 * @param  array|object $data
	 * @return array
	 */
	private function update_helper($data){

		if(!is_null($data) || !empty($data)){

			if(is_object($data)){

				$data = static::object_to_array($data);
			}

			if(!isset($this->result) && isset($data["id"]) || empty($this->result) && isset($data["id"])){

				if(!isset($this->id)){

					die('Nothing to update! -> Trying to update -> '.static::$table.'::update(...) with data: <pre><code> "id" => '.htmlspecialchars($data["id"]).'</pre>');
				}
			}

		}else{

			$data = array();
		}

		return $data;
	}


	/**
	 * Duplicate row by id
	 *
	 * @param  int|string $id
	 * @return Filedb
	 */
	private function duplicate($id){

		$this->create($this->{'full_table_'.static::$table}[$id]);

		return $this;
	}


	/**
	 * Alias for insert() method
	 *
	 * @param  array|object $data
	 * @return Filedb
	 */
	private function create($data){

		$id = $this->insert($data);

		return $this;
	}


	/**
	 * Insert new row with provided $data
	 *
	 * @param  array|object $data
	 * @return int
	 */
	private function insert($data){

		if(is_array($data) || is_object($data)){

			if(is_object($data)){

				$data = static::object_to_array($data);
			}

			$table_dir = static::path();
			$file = "";

			File::mkdir($table_dir, 0777);


			$new_id 	= 	static::max_id();
			$file_dir 	= 	static::path(++$new_id);

			$file = array();

			foreach (static::$model as $model_key => &$default_value) {

				if($model_key == 'id'){

					$this->{$model_key} = $new_id;

					$file[] = static::_row($model_key, $new_id);

				}elseif(array_key_exists($model_key, $data)){

					$this->{$model_key} = $data[$model_key];

					$file[] = static::_row($model_key, $data[$model_key], 'created_at');

				}else{

					$file[] = static::_row($model_key, $default_value, 'created_at');
				}

				unset($model_key, $default_value);
			}

			if(static::$encrypt){

				$file = Crypter::encrypt(static::_rawurlencode(sprintf(static::$file_pattern, implode('', $file))));

			}else{

				$file = sprintf(static::$file_pattern, implode('', $file));
			}

			File::put($file_dir, $file);

			$this->{'full_table_'.static::$table}[$new_id] = static::get_file($new_id);

			return $new_id;

		}else{

			return 'To insert a new row use array or object ONLY!';
		}
	}


	/**
	 * Create table
	 *
	 * @param  string 		$name
	 * @param  array|object $model
	 * @param  boolean 		$encrypt
	 * @return void
	 */
	private function create_table($name, $model, $encrypt=false){

		if(is_array($model) || is_object($model)){

			if(is_object($model)){

				$model = static::object_to_array($model);
			}

			$file = array();

			$model_file = ($encrypt) ? sprintf(static::$model_pattern, ucwords($name), strtolower($name), 'public static $encrypt = true; ') : sprintf(static::$model_pattern, ucwords($name), strtolower($name), 'public static $encrypt = false; ');


			File::put(static::$models_dir.'/'.strtolower($name).EXT, $model_file);
			self::create_model($name, $model, $encrypt);

		}else{

			return 'To create a new table use array or object as model ONLY!';
		}
	}


	/**
	 * Create model
	 *
	 * @param  string 		$table_name
	 * @param  array|object $model
	 * @param  boolean 		$encrypt
	 * @return void
	 */
	private function create_model($table_name, $model, $encrypt=false){

		if(is_array($model) || is_object($model)){

			if(is_object($model)){

				$model = static::object_to_array($model);
			}

			$file = array();

			File::mkdir(static::$directory.'/'.strtolower($table_name), 0777);

			foreach ($model as $model_key => $default_value) {

				$file[] = static::_row($model_key, $default_value);		
			}

			$file = ($encrypt) ? Crypter::encrypt(static::_rawurlencode(sprintf(static::$file_pattern, implode('', $file)))) : sprintf(static::$file_pattern, implode('', $file));

			File::put(static::$directory.'/'.strtolower($table_name).'/model'.EXT, $file);

		}else{

			return 'To create or update model use array or object as model ONLY!';
		}
	}


	/**
	 * Encrypt table
	 *
	 * @return void
	 */
	private function encrypt_table(){

		$this->all();
		static::$encrypt = true;
		self::create_table(static::$table, static::$model, static::$encrypt);
		$this->update();
	}


	/**
	 * Decrypt table
	 *
	 * @return void
	 */
	private function decrypt_table(){

		$this->all();
		static::$encrypt = false;
		self::create_table(static::$table, static::$model, static::$encrypt);
		$this->update();
	}


	/**
	 * Truncate table
	 *
	 * @return void
	 */
	private function truncate(){

		File::cleandir(static::$directory.'/'.static::$table);
		self::create_model(static::$table, static::$model, static::$encrypt);
	}


	/**
	 * Drop (Deleta) table
	 *
	 * @return void
	 */
	private function drop(){

		File::rmdir(static::$directory.'/'.static::$table);
		File::delete(static::$models_dir.'/'.static::$table.EXT);
	}

	/**
	 * Rename table
	 *
	 * @param  string $new_name
	 * @return void
	 */
	private function rename($new_name){

		File::mvdir(static::$directory.'/'.static::$table, static::$directory.'/'.$new_name);
		File::delete(static::$models_dir.'/'.static::$table.EXT);
		self::create_table($new_name, static::$model, static::$encrypt);
	}


	/**
	 * Delete row (record) from table
	 *
	 * @param  int|string|array $ids
	 * @return boolean
	 */
	private function delete($ids=null){

		if($ids == null){

			if(isset($this->id)){

				return $this->delete($this->id);

			}elseif(isset($this->result)){

				if($this->result){

					foreach ($this->result as &$row) {

						$this->delete($row->id);

						unset($row);
						sleep(0.1);
					}
				}

			}else{

				die("Use TableName::delete($id), TableName::delete(array('$id1', '$id2'..)) or select TableName::where('some request')->delete()");
			}

		}else{

			if(is_array($ids)){

				foreach($ids as &$id){

					$status[] = File::delete(static::path($id));

					unset($id);
					sleep(0.1);
				}

				return end($status);

			}else{

				return File::delete(static::path($ids));
			}
		}
	}


	/**
	 * magic __clone
	 *
	 * @return void
	 */
	final private function  __clone() {

	}


	/**
	 * magic __callStatic to call a callback 
	 * with an array of parameters.
	 * Triggered when invoking inaccessible methods in a static context.
	 *
	 * @param  $method	  	The callable to be called.
	 * @param  $parameters  The parameters to be passed to the callback, as an indexed array.
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters){

		$model = get_called_class();

		if ($model::$_inst === NULL || $model::$_inst !== $model){

			$model::$_inst = new $model;
		}

		return call_user_func_array(array($model::$_inst, $method), $parameters);

	}


	/**
	 * magic __destruct
	 * Unset unused vars
	 *
	 * @return void
	 */
	function __destruct(){

		if(isset($this->{'find_'.Config::get('application.key')})){

			//unset($this->{'full_table_'.static::$table});
			unset($this->{'find_'.Config::get('application.key')});
			unset($this->result);
		}
	}


	/**
	 * magic __sleep
	 * Unset unused vars
	 *
	 * @return void
	 */
	public function __sleep(){

		unset($this->result);
	}



	/**
	 * magic __call
	 * Triggered when invoking inaccessible methods in an object context.
	 *
	 * @return mixed
	 */
	public function __call($method, $parameters){

		self::__destruct();
		$model = get_called_class();
		return call_user_func_array(array($model::$_inst, $method), $parameters);
	}
}