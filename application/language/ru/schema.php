<?php 

return array(

	'no_migrations' 					=> 	'Файлы миграции (Schema migration) отсутсвуют в папке <code>application/migrations</code>. Узнайте больше об <a href="http://laravel3.veliovgroup.com/docs/database/schema" target="_blank">Shema Builder</a> и <a href="http://laravel3.veliovgroup.com/docs/database/migrations" target="_blank">Migrations</a> в официальной документации.',

	'no_connection'						=> 	'Соединение с Базой Данных не установленно. Вы можете настроить соединение с базой данных в Основных Настройках: <a id="go_to_settings_db" href="/admin/settings/home/edit/database">Database</a>.',

	'name_word' 						=> 	'Имя Таблицы',
	'status_word'						=> 	'Статус Миграции',
	'route_word' 						=> 	'Местоположение файла',
	'up_word' 							=> 	'Up',
	'down_word' 						=> 	'Down',
	'create_migration_word' 			=> 	'Создать файл миграции',
	'create_migration_warning' 			=> 	'Это действие только создает файл миграции, далее Вам будет необходимо проверить и внести корректировки в файл Миграции и запустить миграцию в ручную!',
	'migrate_from_nosql' 				=> 	'Запустить миграцию с FileDB (NoSQL) на SQL',
	'on_nosql' 							=> 	'В данный момент на NoSQL',
	'run_migration_warning' 			=> 	'Это действие переместит таблицу и все ее содержимое на текущее SQL соединение. Пожалуйста перед запуском миграции создайте дамп FileDB. Далее убедитесь в правильности сгенерированного файла Миграции. Вы не можете отменить это действи в будущем!',
	'no_migrations_table' 				=> 	'Перед запуком миграции, Вам необходимо подготовить Вашу базу данных. Laravel использует специальную таблицу для отслеживания изменений. Для создания этой таблицы нажмите на кнопку ниже.',
	'create_migration_table' 			=> 	'Создать таблицу миграции',

	'migration_files_word' 				=> 	'Список Файлов Миграции',
	'sql_tables_word' 					=> 	'Список SQL Таблиц',

	'migrate_to_nosql' 					=> 	'Запустить миграцию с SQL на FileDB (NoSQL)',
	'run_migration_to_nosql_warning' 	=> 	'Это действие переместит таблицу и все ее содержимое в NoSQL (FileDB) базу данных. Пожалуйста перед запуском миграции создайте SQL дамп. Вы не можете отменить это действи в будущем!',
);