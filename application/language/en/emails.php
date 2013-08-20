<?php 

return array(


	'user_registration_subject' 	=> 'Registration at '.Config::get('indira.name'),
	'user_registration_text' 		=> '<strong>:name</strong>, you have been registered at <a href="'.URL::base().'">'.Config::get('indira.name').'</a><br><strong>Yours login:</strong> :login<br><strong>Yours Password:</strong> :password<br>',



	'password_recovery_subject' 	=> 'Password recovery at '.Config::get('indira.name'),
	'password_recovery_text' 		=> 'Password recovery at <a href="'.URL::base().'">'.Config::get('indira.name').'</a><br /> <strong>Login:</strong> :login<br /> <strong>New Password:</strong> :password<br />',
	


	'new_admin_subject' 			=> 'New admin registration',
	'new_admin_text' 				=> 'Hi <strong>:name</strong>,<br /> Your email was registered as administrator at: <a href="'.URL::base().'/admin">'.Config::get('indira.name').'</a><br />To login please use your email as login: <strong>:email</strong><br />Your password: <strong>:password</strong><br /> <i>Have a nice day!</i>',

);