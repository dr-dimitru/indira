<?php 

return array(


	'user_registration_subject' 	=> 'Регистрация на '.Config::get('indira.name'),
	'user_registration_text' 		=> '<strong>:name</strong>, поздравляем с регистрацией на <a href="'.Config::get('application.url').'">'.Config::get('indira.name').'</a><br><strong>Ваш логин:</strong> :login<br><strong>Пароль:</strong> :password<br>',
	


	'password_recovery_subject' 	=> 'Восстановление пароля на '.Config::get('indira.name'),
	'password_recovery_text' 		=> 'Восстановление пароля на <a href="'.Config::get('application.url').'">'.Config::get('indira.name').'</a><br /><strong>Ваш логин:</strong> :login<br /><strong>Новый Пароль:</strong> :password<br />',
	


	'new_admin_subject' 			=> 'Регистрация в качестве администратора',
	'new_admin_text' 				=> 'Добрый день <strong>:name</strong>,<br /> Ваш email был добавлен в ряды администраторов на: <a href="'.Config::get('application.url').'">'.Config::get('indira.name').'</a><br />Для входа в качестве логина используйте Ваш email: <strong>:email</strong><br />Пароль для входа: <strong>:password</strong>',
);