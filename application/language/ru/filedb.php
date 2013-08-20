<?php

return array(

	'filedb' 					=> 	'File DB',
	'summary' 					=> 	'Состояние базы данных',
	'db_size' 					=> 	'Размер базы данных',
	'db_records' 				=> 	'Всего записей',
	'tables_word' 				=> 	'Таблицы',
	'table_word' 				=> 	'Таблица',
	'records_word' 				=> 	'Записей',
	'size_word' 				=> 	'Размер',
	'update_table' 				=> 	'Обновить таблицу в соответсвии с моделью',
	'default_value' 			=> 	'Значение по умолчанию',
	'column' 					=> 	'Имя колонки',
	'table_name' 				=> 	'Имя таблицы',
	'table_name_desc' 			=> 	'Пожалуйста, введите имя без пробелов, нижних подчеркиваний и заглавных символов',
	'add_column' 				=> 	'Добавить колонку',
	'model_word' 				=> 	'Модель',
	'rename_word' 				=> 	'Переименовать',
	'new_name_word' 			=> 	'Новое имя',
	'dump_word' 				=> 	'Скачать дамп FileDB',

	'encrypt_word' 				=> 	'Зашифровать',
	'encrypted_word'			=> 	'Зашифровано',
	'encrypted_action'			=> 	'Таблица <strong>:t<strong> зашифрована',
	'encryption_annotation' 	=>	'Процесс может занять более <span style="color:#bd362f">одной минуты!</span> Пожалуйста, <span style="color:#bd362f">не перезагружайте</span> и <span style="color:#bd362f">не уходите</span> с этой страницы<span style="color:#bd362f">!</span> Время ожидания зависит от <span style="color:#bd362f">производительности</span> Вашего сервера.',

	'decrypt_word' 				=> 	'Расшифровать',
	'decrypted_action'			=> 	'Таблица <strong>:t<strong> расшифрована',

	'truncate_table'			=> 	'Удалить все записи в таблице',
	'truncate_notification'		=> 	'все записи в таблице',
	'truncated_table'			=> 	'Все записи в таблице <strong>:t</strong> удалены',

	'drop_table'				=> 	'Удалить таблицу',
	'drop_notification'			=> 	'полностью таблицу',
	'dropped_table'				=> 	'Таблица <strong>:t</strong> удалена',

	'table_updated_notification'=> 	'Таблица <strong>:t</strong> успешно обновлена!',
	'uneditable_model' 			=> 	'Модель таблицы :t не редактируемая. Пожалуйста используйте файл: <code>application/models/:t.php</code> для внесения изменений',


	'promo' 					=> 	'
<h6>Спасибо за использование Filedb</h6>
<p>
	Filedb это noSQL файло-ориентированая база данных.<br>
	Filedb основана на PHP-файлах и массивах.<br>
	Filedb легче и работает быстрее на <strong>малых проектах</strong> чем другие noSQL или SQL БД<br>
</p>
<p>
	Мы надеемся Вам понравится использование Filedb как драйвер для Вашего контента, так как:
		<ul>
			<li>При установке Indira CMS Вам не нужно заботится об дампах, экспортах, импортах, установке, соединении с БД - <strong>Filedb работает сразу "Out of Box"</strong> как только Вы зальете свой проект на сервер</li>
			<li>Простота резервного копирования и создания дампов</li>
			<li>Почти как JSON - Вся информация хранится в массивах и закодирована методом URI (RAW). Просто поместите строку из БД в <code>json_encode()</code></li>
			<li>Совместимо с Laravel - Filedb поддерживает большинство Fluent и Eloquent запросов</li>
		<ul>
</p>',
);