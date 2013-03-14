<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

// Route::any('admin/uploads/(:any)', function($file)
// {
//     Redirect::to(URL::home().'/uploads/'.$file);
// 	//return URL::home().'/uploads/'.$file;
// });

Route::get('/(:num)', array('as' => 'item', 'uses' => 'item@index', function($item)
{

}));


Route::get('lang/(:any)', array('as' => 'lang', 'uses' => 'lang@index', function($lang)
{

}));

Route::get('admin/lang/(:any)', array('as' => 'admin_lang', 'uses' => 'lang@index', function($lang)
{

}));

Route::get('admin/db/(:any)', array('uses' => 'admin.db@index', function($table)
{

}));

Route::get('admin/db/update/(:any)', array('uses' => 'admin.db@update', function($table)
{

}));

Route::get('admin/db/delete/(:any)', array('uses' => 'admin.db@delete', function($id)
{

}));


Route::controller(Controller::detect());

Route::group(array('before' => 'auth'), function()
{
    Route::get('admin', function()
    {
        //
    });

    Route::get('admin/(:any)', function()
    {
        //
    });
});


//Route::any('admin/(:any)', array('before' => 'auth', 'as' => 'action'));

Route::get('calculate/(:all)', function(){

	return Utilites::calculate_route(URL::full());

});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

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