<?php

class Templates_Base_Controller extends Controller {

	/**
	 * Main layout
	 *
	 * @var $layout
	 */
	public $layout = 'templates::template';


	/**
	 * Basic user access level
	 *
	 * @var int $access
	 */
	public static $access = 1;


	/**
	 * Rediret to previous viewed page
	 *
	 * @var bool $redirect
	 */
	public static $redirect = false;


	/**
	 * Prepare data for views.
	 *
	 * @return void
	 */
	public function __construct(){

		if(URL::current() == URL::base().'/' && Cookie::get('last_url') !== URL::base().'/'){

			setcookie("redirect_to", Cookie::get('last_url'), time()+3600);
			static::$redirect = true;
		}

		Cookie::forever('last_url', URL::full());
		Session::put('last_url', URL::full());

		parent::__construct();

		static::set_assets();
	}

	/**
	 * Prepare assets for views.
	 *
	 * @return void
	 */
	static function set_assets(){

		Asset::container('header')->bundle('templates');
		Asset::container('header')->add('bootstrap', Config::get('indira.template').'/styles/bootstrap.min.css');
		Asset::container('header')->add('font-awesome', Config::get('indira.template').'/styles/vendor/font-awesome.min.css');
		Asset::container('header')->add('app-styles', Config::get('indira.template').'/styles/styles.css');
		Asset::container('header')->add('animate', Config::get('indira.template').'/styles/vendor/animate.min.css');

		Asset::container('header')->add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
		Asset::container('header')->add('history-js', Config::get('indira.template').'/scripts/vendor/jquery.history.js');
		Asset::container('header')->add('bootstrap-js', Config::get('indira.template').'/scripts/bootstrap.min.js');
		Asset::container('header')->add('indira-js', Config::get('indira.template').'/scripts/indira.min.js');
		Asset::container('header')->add('app-js', Config::get('indira.template').'/scripts/app.js');

		if(static::$redirect){
			Asset::container('header')->add('redirect', Config::get('indira.template').'/scripts/redirect.js');
		}
	}


	/**
	 * Make view with 404 status response
	 * Page does not exists
	 *
	 * @return Laravel\View
	 */
	public static function _404(){

		$data = array();
		$data["page"] = 'templates::assets.page_not_exists';
		return (Request::ajax()) ? Response::view($data["page"], $data) : Response::view('templates::main', $data)->status(404);
	}


	/**
	 * Make view with 401 status response
	 * Permission denied
	 *
	 * @return Laravel\View
	 */
	public static function _401(){

		$data = array();
		$data["page"] = 'templates::assets.permission_denied';
		return (Request::ajax()) ? Response::view($data["page"], $data) : Response::view('templates::main', $data)->status(401);
	}


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
}