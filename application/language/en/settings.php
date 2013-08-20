<?php

return array(


	'type_word' 						=> 'Type',
	'annotation' 						=> 'This settings values overrides values specified in config arrays, please find default values in: <code>applicalion/config/</code>.<br />To manage settings types please find <code>Indira::set(array(...));</code> in <code>application/start.php</code>.<br />You may use <code>Indira::set()</code> method at any place of your project right after <code>Indira::start()</code><hr>This setting available at any plase of your code via <code>Config::get()</code>, for example: 
	<pre>echo Config::get(\'session.driver\');<br />//Will output: <br />//file</pre>',

	'warning' 							=> '<strong style="color:#bd362f">Warning! Change this settings with mind!</strong><br /> This settings values overrides values specified in config arrays, please find default values in: <code>applicalion/config/</code>.<br />To manage settings types please find <code>Indira::set(array(...));</code> in <code>application/start.php</code>.<br />You may use <code>Indira::set()</code> method at any place of your project right after <code>Indira::start()</code>',


	'application_language_annotation' 	=> '<strong>Default Application Language</strong>: The default language of your application. This language will be used by Lang library as the default language when doing string localization.',

	'application_timezone_annotation'	=> '<strong>Application Timezone</strong>: The default timezone of your application. The timezone will be used when Laravel needs a date, such as when writing to a log file or travelling to a distant star at warp speed. Find list of supported timezones on <a href="http://www.php.net/manual/en/timezones.php" target="_blank">PHP.net List of Supported Timezones</a>',

	'application_asset_url_annotation' 	=> '<strong>Asset URL</strong>: The base URL used for your application\'s asset files. This is useful if you are serving your assets through a different server or a CDN. If it is not set, we\'ll default to the application URL above.',

	'application_index_annotation' 		=> '<strong>Application Index</strong>: If you are including the "index.php" in your URLs, you can ignore this. However, if you are using mod_rewrite to get cleaner URLs, just set this option to an empty string and we\'ll take care of the rest.',

	'application_url_annotation' 		=> '<strong>Application URL</strong>: The URL used to access your application without a trailing slash. The URL does not have to be set. If it isn\'t, we\'ll try our best to guess the URL of your application.',

	'application_profiler_annotation'	=> '<strong>Profiler Toolbar</strong>: Laravel includes a beautiful profiler toolbar that gives you a heads up display of the queries and logs performed by your application. This is wonderful for development, but, of course, you should disable the toolbar for production applications.',

	'application_ssl_annotation' 		=> '<strong>SSL Link Generation</strong>: Many sites use SSL to protect their users\' data. However, you may not be able to use SSL on your development machine, meaning all HTTPS will be broken during development.<br /><br /> For this reason, you may wish to disable the generation of HTTPS links throughout your application. This option does just that. All attempts to generate HTTPS links will generate regular HTTP links instead.',

	'application_encoding_annotation' 	=> '<strong>Application Character Encoding</strong>: The default character encoding used by your application. This encoding will be used by the Str, Text, Form, and any other classes that need to know what type of encoding to use for your awesome application.',


	'auth_driver_annotation' 			=> '<strong style="color:#bd362f">Drivers</strong>: fluent, eloquent - <strong style="color:#bd362f">ONLY</strong>!<br /><strong>Default Authentication Driver</strong>: Laravel uses a flexible driver-based system to handle authentication. You are free to register your own drivers using the Auth::extend method. Of course, a few great drivers are provided out of box to handle basic authentication simply and easily.',

	'auth_username_annotation' 			=> '<strong>Authentication Username</strong>: Here you may specify the database column that should be considered the "username" for your users. Typically, this will either be "username" or "email". Of course, you\'re free to change the value to anything.',

	'auth_password_annotation'			=> '<strong>Authentication Password</strong>: Here you may specify the database column that should be considered the "password" for your users. Typically, this will be "password" but, again, you\'re free to change the value to anything you see fit.',

	'auth_model_annotation' 			=> '<strong>Authentication Model</strong>: When using the "<strong>eloquent</strong>" authentication driver, you may specify the model that should be considered the "User" model. This model will be used to authenticate and load the users of your application.',

	'auth_table_annotation' 			=> '<strong>Authentication Table</strong>: When using the "<strong>fluent</strong>" authentication driver, the database table used to load users may be specified here. This table will be used in by the fluent query builder to authenticate and load your users.',


	'cache_key_annotation' 				=> '<strong>Cache Key</strong>: This key will be prepended to item keys stored using Memcached and APC to prevent collisions with other applications on the server. Since the memory based stores could be shared by other applications, we need to be polite and use a prefix to uniquely identify our items.',

	'cache_driver_annotation' 			=> '<strong style="color:#bd362f">Drivers</strong>: file, memcached, apc, redis, database, memory, wincache  - <strong style="color:#bd362f">ONLY</strong>!.<br /><strong>Cache Driver</strong>: The name of the default cache driver for your application. Caching can be used to increase the performance of your application by storing any commonly accessed data in memory, a file, or some other storage.<br /><br /> A variety of great drivers are available for you to use with Laravel. Some, like APC, are extremely fast. However, if that isn\'t an option in your environment, try file or database caching. Find out more about cache drivers in <a href="http://laravel3.veliovgroup.com/docs/cache/config" target="_blank">official docs</a>',

	'cache_database_annotation' 		=> '<strong>Cache Database</strong>:  When using the database cache driver, this database table will be used to store the cached item. You may also add a "connection" option to the array to specify which database connection should be used.',

	'cache_memcached_annotation' 		=> '<strong>Memcached Servers</strong>: The Memcached servers used by your application. Memcached is a free and open source, high-performance, distributed memory caching system. It is generic in nature but intended for use in speeding up web applications by alleviating database load.<br /><br /> For more information, check out: <a href="http://memcached.org" target="_blank">memcached.org</a>.',


	'database_default_annotation' 		=> '<strong>Default Database Connection</strong>: The name of your default database connection. This connection will be used as the default for all database operations unless a different name is given when performing said operation. This connection name should be listed in the array of connections below.',

	'database_connections_annotation'	=> '<strong>Database Connections</strong>: All of the database connections used by your application. Many of your  applications will no doubt only use one connection; however, you have the freedom to specify as many connections as you can handle.<br /><br />All database work in Laravel is done through the PHP\'s PDO facilities, so make sure you have the PDO drivers for your particular database of choice installed on your machine.',

	'database_redis_annotation' 		=> '<strong>Redis Databases</strong>: Redis is an open source, fast, and advanced key-value store. However, it provides a richer set of commands than a typical key-value store such as APC or memcached. All the cool kids are using it.<br /><br />To get the scoop on Redis, check out: <a href="http://redis.io" target="_blank">redis.io</a>.',


	'indira_indira_version_annotation' 	=> 'Current version of Inira CMS you have.',

	'indira_under_development_annotation'=>'<strong>Development Mode</strong>: If you turn on developer\'s mode, users will see page 503 error - "Website is down for maintanse".<br/>Find out more at <a href="/admin/development">Dev Mode</a>.',

	'indira_default_template_annotation'=> 'Default Template used for all pages and content types. <strong style="color:#bd362f">You no need to change it</strong>',

	'indira_default_mobile_template_annotation' => 'Default Template for mobile devices. <strong style="color:#bd362f">You no need to change it</strong>',

	'indira_posts_template_annotation' 	=> 'Template used for "Posts". <strong style="color:#bd362f">You no need to change it</strong>',
	'indira_blog_template_annotation' 	=> 'Template used for "Blog". <strong style="color:#bd362f">You no need to change it</strong>',
	'indira_name_annotation' 			=> 'Name of your project.',
	'indira_admin_email_annotation' 	=> 'Admin\'s email',
	'indira_no-reply_email_annotation'	=> 'No-reply email. Used as "From" to send emails',
	'indira_contact_email_annotation' 	=> 'Email, which will be used as official website\'s and feedback email.',


	'session_driver_annotation' 		=> '<strong style="color:#bd362f">Drivers</strong>: cookie, file, memcached, apc, redis, database - <strong style="color:#bd362f">ONLY</strong>!<br /><strong>Session Driver</strong>: The name of the session driver used by your application. Since HTTP is stateless, sessions are used to simulate "state" across requests made by the same user of your application. In other words, it\'s how an application knows who the heck you are.',

	'session_table_annotation' 			=> '<strong>Session Database</strong>: The database table on which the session should be stored. It probably goes without saying that this option only matters if you are using the super slick database session driver.',

	'session_lifetime_annotation' 		=> '<strong>Session Lifetime</strong>: The number of minutes a session can be idle before expiring.',

	'session_expire_on_close_annotation'=> '<strong>Session Expiration On Close</strong>: Determines if the session should expire when the user\'s web browser closes.',

	'session_cookie_annotation' 		=> '<strong>Session Cookie Name</strong>: The name that should be given to the session cookie.',
	'session_path_annotation' 			=> '<strong>Session Cookie Path</strong>: The path for which the session cookie is available.',
	'session_domain_annotation' 		=> '<strong>Session Cookie Domain</strong>: The domain for which the session cookie is available.<br><strong style="color:#bd362f">Please, DO NOT set "null"!</strong>',

	'session_secure_annotation' 		=> '<strong>HTTPS Only Session Cookie</strong>: Determines if the cookie should only be sent over HTTPS.',
);