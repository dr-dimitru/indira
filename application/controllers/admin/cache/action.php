<?php

class Admin_Cache_Action_Controller extends Base_Controller {

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
	 * Flush cache
	 * 
	 * @return string
	 */
	public function post_flush(){

		switch (Config::get('cache.driver')) {

			case 'redis':
			case 'memory':
			case 'file':
			case 'database':
				
					Cache::flush();

				break;
			
			default:
				
					return 'Current driver "'.Config::get('cache.driver').'" has no flush() functionality. Only redis, memory, file and database drivers is supported.';
				break;
		}

		return '0';
	}


	/**
	 * Flush bladed (compiled) views
	 * 
	 * @return string
	 */
	public function post_flush_blade(){

		array_map('unlink', glob('storage/views/*'));

		return '0';
	}
}