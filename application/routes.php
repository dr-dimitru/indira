<?php
//FILTER WHEN DEVELOPMENT_MODE IS ON
Route::filter('pattern: *', array('name' => 'development_mode', function(){

	if(Indira::is('under_development'))
	{	
		$headers['Cache-Control'] = 'no-cache, must-revalidate';
		$headers['Pragma'] = 'no-cache';
		$headers['Expires'] = 'Sat, 26 Jul 1997 05:00:00 GMT';
		$page = View::make('admin.assets.503')->get();
		return Response::make($page, 503, $headers);
	}

}));


//TEMPLATE ROUTES
Route::get('/'.Indira::get('modules.pages.link').'/(:any)', array('as' => 'pages', 'uses' => 'templates::pages@page'));
Route::get('/'.Indira::get('modules.sections.link').'/(:any)', array('as' => 'sections', 'uses' => 'templates::content@sections'));
Route::get('/'.Indira::get('modules.blog.link').'/(:any)', array('as' => 'blog', 'uses' => 'templates::content@blog'));
Route::get('/'.Indira::get('modules.posts.link').'/(:any)', array('as' => 'posts', 'uses' => 'templates::content@posts'));
Route::get('/'.Indira::get('modules.posts.link'), array('as' => 'posts_listing', 'uses' => 'templates::content@posts_listing'));
Route::get('/'.Indira::get('modules.blog.link'), array('as' => 'blog_listing', 'uses' => 'templates::content@blog_listing'));
Route::get('/search/tag/(:any)', array('as' => 'search_tag', 'uses' => 'templates::search@tag'));
Route::get('/', array('as' => 'main_page', 'uses' => 'templates::pages@index'));

//USER'S LOGIN, SIGN UP, iFORGOT
Route::post('/user/login', array('as' => 'user_login', 'uses' => 'templates::user@login'));
Route::get('/user/logout', array('as' => 'user_logout', 'uses' => 'templates::user@logout'));
Route::post('/user/iforgot', array('as' => 'user_iforgot', 'uses' => 'templates::iforgot@recover'));
Route::post('/user/signup', array('as' => 'user_signup', 'uses' => 'templates::user@signup'));

//TEMPLATE HELPERS ROUTES
Route::get('/tools/navbar', array('uses' => 'templates::tools@navbar'));
Route::post('/tools/sidebar', array('uses' => 'templates::tools@sidebar'));



//AUTH FILTER FOR CMS
Route::filter('pattern: ^admin/(?!home|iforgot)(.*)$', 'auth');


//REGISTER ALL NOT DEFINED ABOVE ROUTES
Route::controller(Controller::detect());
Route::controller(Controller::detect('templates'));


Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});


Route::filter('before', function()
{
	//RUN INDIRA
	Indira::before();

	if(!Session::has('href.previous'))
	{
	    Session::put('href.previous', URL::home());
	}

});


Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (!Admin::check()){

		return Redirect::to('admin');
	}
});