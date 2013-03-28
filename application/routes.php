<?php

Route::get('/(:num)', array('as' => 'item', 'uses' => 'item@index'));

Route::get('lang/(:any)', array('as' => 'lang', 'uses' => 'lang@index'));

Route::get('admin/lang/(:any)', array('as' => 'admin_lang', 'uses' => 'lang@index'));

Route::get('admin/db/(:any)', array('uses' => 'admin.db@index'));

Route::get('admin/blog_area/(:num)', array('uses' => 'admin.blog_area@index'));

Route::get('admin/post_area/(:num)', array('uses' => 'admin.post_area@index'));

Route::get('admin/section_area/(:num)', array('uses' => 'admin.section_area@index'));


Route::controller(Controller::detect());

Route::group(array('before' => 'auth'), function()
{
	// Do stuff before auth
    Route::get('admin', function()
    {
        //
    });

    Route::get('admin/(:any)', function()
    {
        //
    });
});

Route::get('calculate/(:all)', function(){

	return Utilites::calculate_route(URL::full());

});

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
	// Do stuff before every request to your application...

	if(!Session::get('lang', null) && !Cookie::get('lang'))
	{
		Session::put('lang', Config::get('application.language'));
	}
	
	if(Cookie::get('lang'))
	{
		Session::put('lang', Cookie::get('lang'));
	}

	if(Cookie::get('userdata_id')){
		Utilites::revokeUser();
	}

	if(Cookie::get('admin_id')){
		Utilites::revokeAdmin();
	}
	
	if(!Session::get('user.access_level'))
	{
	    Session::put('user.access_level', '1');
	}
	
	if(!Session::get('href.previous'))
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
		return Redirect::to('admin/login');
	}else{
		return Redirect::to('admin/home');
	}
});