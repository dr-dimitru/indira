<?php 

return array(

	'section_error_message' => 'Все поля обязательны к заполнению',
	'post_title_err' => 'Поле "'.Lang::line('content.title_word')->get(Session::get('lang')).'" - обязательно к заполнению',
	'post_text_err' => 'Текст статьи обязателен к заполнению',
	'post_section_err' => 'Поле "'.Lang::line('content.section_word')->get(Session::get('lang')).'" - выбранно не корректно, статья должна принадлежать разделу',
	'post_access_err' => 'Поле "'.Lang::line('content.access_level_word')->get(Session::get('lang')).'" - выбранно не корректно',
	'undefined_err_word' => 'Произошла неизвестная ошибка, попробуйте поторить Ваше действие.',
	'edit_on_page' => 'Редактировать "на живую"',
	'same_title_err' => '"Название" поста уже занято. Вы не можете создать два поста с одинаковым названием. Пожалуйста измените поле "Название"',
	'registration_email_text' => 'Поздравляем с регистрацией на Adminizer.VeliovGroup.com<br> 	<strong>Ваш логин:</strong> %1$s<br> 	<strong>Пароль:</strong> %2$s<br>',
	'registration_email_subject' => 'Регистрация на проекте Veliov Group: Adminizer',
	
);