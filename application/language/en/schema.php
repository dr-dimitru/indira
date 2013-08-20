<?php 

return array(

	'no_migrations' 					=> 	'No Schema migration files created at <code>application/migrations</code>. Find out more at <a href="http://laravel3.veliovgroup.com/docs/database/schema" target="_blank">Shema Builder</a> and <a href="http://laravel3.veliovgroup.com/docs/database/migrations" target="_blank">Migrations</a> offical docs.',

	'no_connection'						=> 	'Connection to database is not established. Please go to Main Settings: <a id="go_to_settings_db" href="/admin/settings/home/edit/database">Database</a> to set your default DB connection and server credentials.',

	'name_word' 						=> 	'Table Name',
	'status_word'						=> 	'Migration Status',
	'route_word' 						=> 	'File Route',
	'up_word' 							=> 	'Up',
	'down_word' 						=> 	'Down',
	'create_migration_word' 			=> 	'Create Schema Migration File',
	'create_migration_warning' 			=> 	'This action only creates Migration file, next you need to review and migrate table manually!',
	'migrate_from_nosql' 				=> 	'Run migration from FileDB (NoSQL) to SQL',
	'on_nosql' 							=> 	'Currently on NoSQL',
	'run_migration_warning' 			=> 	'This action moves table and all it\'s content into current SQL connection. Please before runnig migration create FileDB Dump. Next make sure you check and review Migration file. You can not undone this action in future!',
	'no_migrations_table' 				=> 	'Before you can run migrations, we need to do some work on your database. Laravel uses a special table to keep track of which migrations have already run. To create this table, just click on button below.',
	'create_migration_table' 			=> 	'Create Migration Table',

	'migration_files_word' 				=> 	'List of Migration\'s files',
	'sql_tables_word' 					=> 	'List of SQL tables',

	'migrate_to_nosql' 					=> 	'Run migration from SQL to FileDB (NoSQL)',
	'run_migration_to_nosql_warning' 	=> 	'This action moves table and all it\'s content into NoSQL (FileDB) DataBase. Please before runnig migration create SQL Dump. You can not undone this action in future!',

);