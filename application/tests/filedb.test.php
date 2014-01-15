<?php

class TestFiledb extends PHPUnit_Framework_TestCase {

	static $model = array('id' => '', 'created_at' => '', 'updated_at' => '', 'text' => '', 'int' => '', 'array' => '', 'object' => '');

	public function testCreate_table()
	{
		Filedb::create_table('unittest', static::$model);
		$this->assertEquals(Unittest::model(), static::$model);

	}

	public function testConstruct()
	{
		$this->assertInstanceOf('Unittest', new Unittest);
	}

	public function testInit()
	{
		$this->assertInstanceOf('Unittest', Unittest::init());
	}

	public function testSave()
	{
		$time = time();

		$obj = new stdClass();
		$obj->abc = 'a';
		$obj->bcd = 'b';
		$obj->cde = 'c';

		$tmp = new Unittest;
		$tmp->text = 'Created via Table instanse';
		$tmp->int = $time;
		$tmp->array = array('a' => 'abc', 'b' => 'bcd', 'c' => 'cde');
		$tmp->object = $obj;

		$tmp->save();

		$this->assertObjectHasAttribute('id', $tmp);

		$id = $tmp->id;

		$this->assertEquals($time, Unittest::find($id)->int, $tmp->int);
	}

	public function testFindAndUpdate(){

		$tmp = Unittest::find(1);
		$this->assertObjectHasAttribute('id', $tmp);

		$check_int = $tmp->int;
		$check_text = "updated after Find() method";

		$tmp->text = $check_text;
		$tmp->save();

		$this->assertEquals($check_int, Unittest::find(1)->int, $tmp->int);
		$this->assertEquals($check_text, Unittest::find(1)->text, $tmp->text);
	}

	public function testCreate150Rows(){

		$initial_count = Unittest::count();

		$obj = new stdClass();
		$obj->text = 'Created via Table instanse';
		$obj->int = time();
		$obj->array = array('a' => 'abc', 'b' => 'bcd', 'c' => 'cde');
		$obj->object = '';

		$array = array('text' => 'abc', 'int' => 123, 'array' => $obj->array, 'object' => '');

		for ($i=1; $i <= 50; $i++){ 
			
			$obj->int = $i;
			Unittest::create($obj);
		}

		unset($i);

		for ($i=1; $i <= 50; $i++){ 
			
			$array['int'] = $i;
			Unittest::create($array);
		}

		unset($i);

		for ($i=1; $i <= 50; $i++){ 
			
			$tmp = Unittest::init();
			$tmp->text = 'Created via Table instanse';
			$tmp->int = $i;
			$tmp->array = array('a' => 'abc', 'b' => 'bcd', 'c' => 'cde');
			$tmp->object = '';

			$tmp->save();
		}

		unset($i);

		$total_count = $initial_count + 150;

		$this->assertEquals($total_count, Unittest::count());
	}

	public function testLimit(){

		$tmp = Unittest::limit(10, 20);
		$res = $tmp->get();
		$count = $tmp->count();

		$control_count = count(current($tmp));

		$this->assertEquals(20, $count, $control_count);
	}

	public function testSkip(){

		$init_count = Unittest::count();

		$tmp = Unittest::skip(20);
		$res = $tmp->get();
		$count = $tmp->count();

		$control_count = $init_count - 20;

		$this->assertEquals($count, $control_count);
	}

	public function testTake(){

		$tmp = Unittest::take(50);
		$res = $tmp->get();
		$count = $tmp->count();

		$control_count = count(current($tmp));

		$this->assertEquals(50, $count, $control_count);
	}

	public function testAVG(){

		$tmp = Unittest::take(10);
		$res = $tmp->get();
		$avg = $tmp->avg('id');

		$sum = array();

		foreach ($res as $key => $value) {
			
			$sum[] = $value->id;
		}

		$control_sum = array_sum($sum);
		$control_avg = $control_sum / 10;

		$this->assertEquals($control_avg, $avg);
	}

	public function testSUM(){

		$tmp = Unittest::take(10);
		$res = $tmp->get();
		$sum = $tmp->sum('id');

		$s = array();

		foreach ($res as $key => $value) {
			
			$s[] = $value->id;
		}

		$control_sum = array_sum($s);

		$this->assertEquals($control_sum, $sum);
	}

	public function testCount(){

		$tmp = Unittest::take(37);
		$count = $tmp->count();

		$this->assertEquals($count, 37);
	}

	public function testMAX(){

		$vals = array();

		for ($i=1; $i < 10; $i++){
			$m = rand();
			$vals[] = $m;
			Unittest::create(array('text' => 'testMAX', 'int' => $m));
		}

		$control_max = max($vals);
		$max = Unittest::where('text', '=', 'testMAX')->max('int');

		$this->assertEquals($control_max, $max);

		Unittest::where('text', '=', 'testMAX')->delete();

		$this->assertEmpty(Unittest::where('text', '=', 'testMAX')->get());
	}

	public function testMIN(){

		$vals = array();

		for ($i=1; $i < 10; $i++){
			$m = rand();
			$vals[] = $m;
			Unittest::create(array('text' => 'testMIN', 'int' => $m));
		}

		$control_min = min($vals);
		$min = Unittest::where('text', '=', 'testMIN')->min('int');

		$this->assertEquals($control_min, $min);

		Unittest::where('text', '=', 'testMIN')->delete();

		$this->assertEmpty(Unittest::where('text', '=', 'testMIN')->get());
	}

	public function testIncrement(){

		$tmp = Unittest::find(25);
		$control_int = $tmp->int;

		$tmp->increment('int');
		++$control_int;
		$this->assertEquals((int)$tmp->int, $control_int);

		$tmp->increment('int', 77);
		$control_int += 77;

		$this->assertEquals((int)$tmp->int, $control_int);


		$tmp = Unittest::where('id', '=', 25);
		$control_int = $tmp->only('int');
		$tmp->increment('int');
		++$control_int;
		$this->assertEquals((int)Unittest::where('id', '=', 25)->only('int'), $control_int);

		$tmp->increment('int', 77);
		$control_int += 77;

		$this->assertEquals((int)Unittest::where('id', '=', 25)->only('int'), $control_int);
	}

	public function testDecrement(){

		$tmp = Unittest::find(25);
		$control_int = $tmp->int;

		$tmp->decrement('int');
		--$control_int;
		$this->assertEquals((int)$tmp->int, $control_int);

		$tmp->decrement('int', 77);
		$control_int -= 77;

		$this->assertEquals((int)$tmp->int, $control_int);


		$tmp = Unittest::where('id', '=', 25);
		$control_int = $tmp->only('int');
		$tmp->decrement('int');
		--$control_int;
		$this->assertEquals((int)Unittest::where('id', '=', 25)->only('int'), $control_int);

		$tmp->decrement('int', 77);
		$control_int -= 77;

		$this->assertEquals((int)Unittest::where('id', '=', 25)->only('int'), $control_int);
	}

	// public function testNULLforNonCorrectIdInFind(){

	// 	$this->assertNull(Unittest::find(99999));
	// }

	public function testEncryptTable(){

		$this->assertFalse(Unittest::is_encrypted());
		Unittest::init()->encrypt_table();
		$this->assertTrue(Unittest::is_encrypted());
	}

	public function testDecryptTable(){

		$this->assertTrue(Unittest::is_encrypted());
		Unittest::init()->decrypt_table();
		$this->assertFalse(Unittest::is_encrypted());
	}

	public function testDuplicate(){

		$id = Unittest::create(array('text' => 'DuplicateTest'), true);
		$this->assertEquals(1, Unittest::where('text', '=', 'DuplicateTest')->count());

		Unittest::duplicate($id);
		$this->assertEquals(2, Unittest::where('text', '=', 'DuplicateTest')->count());
	}

	public function testRenameTable(){

		$this->assertInstanceOf('Unittest', Unittest::init());
		Unittest::init()->rename('newunittesting');

		$this->assertInstanceOf('newunittesting', newunittesting::init());
		$this->assertEmpty(Unittest::where_id(1)->get());
	}

	public function testTruncateTable(){

		newunittesting::init()->truncate();
		$this->assertEquals(0, newunittesting::count());
	}


	public function testAllEmptyTable(){

		$this->assertEmpty(newunittesting::all());
	}

	public function testDropTable(){

		newunittesting::init()->drop();
		$this->assertEquals('No such table (storage/db/newunittesting/)!', newunittesting::init());
	}
}