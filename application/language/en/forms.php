<?php 

return array(

	'section_error_message' => 'All field is requred.',
	'post_title_err' => 'Field "'.Lang::line('content.title_word')->get(Session::get('lang')).'" is required',
	'post_text_err' => 'Text is required',
	'post_section_err' => 'Field "'.Lang::line('content.section_word')->get(Session::get('lang')).'" - Is not selected, post must be assigned to some '.Lang::line('content.section_word')->get(Session::get('lang')),
	'post_access_err' => 'Field "'.Lang::line('content.access_level_word')->get(Session::get('lang')).'" - Is not selected',
	'undefined_err_word' => 'Sorry, undefined error occured, please try again.',
	'edit_on_page' => 'Edit as user view',
	'same_title_err' => 'This post title already used. You can not use same title for two different posts. Please select another "Title"',
	'registration_email_text' => 'You have been registered at Adminizer.VeliovGroup.com<br> 	<strong>Yours login:</strong> %1$s<br> 	<strong>Yours Password:</strong> %2$s<br>',
	'registration_email_subject' => 'Registration at Veliov Group: Adminizer',

);