<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}


	/**
	 * Basic Admin access level for all controllers
	 * Usually set to 400 (Guest level - View only)
	 * 
	 * @var int $access
	 */
	public $access = 400;


	/**
	 * Associate controller with module
	 * 
	 * @var string|bool $module_name
	 */
	public $module_name = false;


	/**
	 * Field settings received via Modules::where('name', '=', 'module_name')->only('settings')
	 * 
	 * @var array $fields_settings
	 */
	public static $fields_settings = array();


	/**
	 * Columns shown in table listing
	 * 
	 * @var array $fields_settings
	 */
	public static $listing_fields;


	/**
	 * Fields shown in editor
	 * 
	 * @var array $fields_settings
	 */
	public static $editor_fields; 


	/**
	 * Additions for dropdowns
	 * 
	 * @var array $fields_settings
	 */
	public static $additions = null;


	/**
	 * Set new access level
	 * 
	 * @return void|string
	 */
	public function set_access($access)
	{
		$this->access = (int) $access;

		if(intval(Admin::check()) < (int) $this->access){

			die(Utilites::alert(__('content.permissions_denied'), 'error'));
		}
	}


	/**
	 * Check if user (admin) has rights for action.
	 * If access level is lower than controller's
	 * access level - return "permissions denied"
	 * message.
	 *
	 * This rules applyes for all admin/* pages
	 * Except listed in preg_match regular expression
	 * 
	 * @return void|string
	 */
	public function __construct()
	{	
		
		if(!$this->module_name){

			foreach (Indira::get('modules') as $name => $values) {
				
				if(stripos(strtolower(get_called_class()), $name)){

					$this->module_name = $name;
				}
			}
		}

		if($this->module_name){

			if(Indira::get('modules.'.$this->module_name.'.active')){
					
				$this->access = (int) Indira::get((stripos(get_called_class(), 'Home')) ? 'modules.'.$this->module_name.'.view_access' : 'modules.'.$this->module_name.'.access');

				list(static::$listing_fields, static::$fields_settings, static::$editor_fields) = Utilites::prepare_module_settings($this->module_name, static::$additions);

			}else{

				return die(Response::error('404'));
			}

		}

		if(preg_match('/^admin\/(?!login|logout|home|iforgot)(.*)$/', URI::current())){

			if(intval(Admin::check()) < (int) $this->access){

				die(Utilites::alert(__('content.permissions_denied'), 'error'));
			}
		}
	}
}