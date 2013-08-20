<?php

return array(

	'useraccess' 				=> 'Пользователи',
	'adminaccess' 				=> 'Администраторы',
	'level_word' 				=> 'Уровень',
	'name_word' 				=> 'Имя',
	'type_word' 				=> 'Тип',
	'access_word' 				=> 'Тип доступа',


	'useraccess_annotation' 	=> 'Для изменения или добавления <strong>Описания</strong> используйте языковой массив: <code>/application/language/../useraccess.php</code>',

	'adminaccess_annotation'	=> 'Для изменения или добавления <strong>Описания</strong> используйте языковой массив: <code>/application/language/../adminaccess.php</code><br />Уровни доступа Администраторов управляются через переменную <code>public $access</code> установленную в каждом контроллере. В случае если переменная <code>public $access</code> не установленна, по умолчанию она равна <code>400</code> и указана в контроллере <strong>Base_Controller</strong> в файле <code>application/controllers/base.php</code>',
);