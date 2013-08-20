<?php

class Templates_Tools_Controller extends Templates_Base_Controller {


	/**
	 * Laravel restful controller
	 * 
	 * @var bool $restful
	 */
	public $restful = true;


	/**
	 * Return view of templates::assets.navbar
	 * We use it to update navbar element on locale switch
	 * 
	 * @return Laravel\View
	 */
	public function get_navbar(){

		return View::make('templates::assets.navbar');
	}

	/**
	 * Return view of templates::assets.sidebar
	 * We use it to update sidebar element on locale switch
	 * 
	 * @return Laravel\View
	 */
	public function post_sidebar(){

		return Controller::call('templates::content@sidebar');
	}
}