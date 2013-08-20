<?php

return array(

	'useraccess' 				=> 'Users',
	'adminaccess' 				=> 'Admins',
	'level_word' 				=> 'Level',
	'name_word' 				=> 'Name',
	'type_word' 				=> 'Type',
	'access_word' 				=> 'Access Type',

	'useraccess_annotation' 	=> 'To edit or add <strong>Description</strong> please find language array in: <code>/application/language/../useraccess.php</code>',

	'adminaccess_annotation' 	=> 'To edit or add <strong>Description</strong> please find language array in: <code>/application/language/../adminaccess.php</code><br />Admin\'s access levels ruled by <code>public $access</code> variable in each controller. If <code>public $access</code> is not defined, by default it set to <code>400</code> in <strong>Base_Controller</strong> in <code>application/controllers/base.php</code>',
);