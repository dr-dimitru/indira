<?php

return array(

	'footer_sign' 				=> 'Под капотом © <a href="http://indira-cms.com">Indira</a>',


	/**
	 * Words
	 */
	'documentation_word' 		=> 'Документация',
	'blog_word' 				=> 'Блог',
	'post_word' 				=> 'Публикация',
	'posts_word' 				=> 'Публикации',
	'section_word' 				=> 'Раздел',
	'menu_word' 				=> 'Меню',
	'registration_word' 		=> 'Регистрация',
	'login_word'				=> 'Войти',
	'email_word'				=> 'Email',
	'password_word'				=> 'Пароль',
	'no_posts_word' 			=> 'Пусто',
	'email_us_word' 			=> 'Обратная связь',
	'contents_word' 			=> 'Содержание',
	'remember_me_word' 			=> 'Запомнить меня',
	'logout_word' 				=> 'Выйти',
	'next_word' 				=> 'Следующий',
	'previous_word' 			=> 'Предыдущий',
	'save_word' 				=> 'Сохранить',
	'cancel_word' 				=> 'Отменить',
	'close_word' 				=> 'Закрыть',

	#########################
	'more_word' 				=> 'Еще...',
	'no_page' 					=> 'Такая страница не существует',
	'promo_code_word' 			=> 'Промо-код',
	're_password_word' 			=> 'Повторите пароль',
	'registration_action_word'	=> 'Зарегистрироваться',
	'pass_recovery_word' 		=> 'Восстановить пароль',
	'pass_recovery_action' 		=> 'Получить новый пароль',


	/**
	* User data
	**/
	'user' 						=> array(	'info' => 'Вы вошли как <strong>:name</strong><br />Ваш уровень доступа: <span class="label">:access</span>',
											'edit_word' => 'Редактировать профиль',),


	/**
	 * Page not exists
	 */
	'page_not_exists' 			=> array(	'title' => '<i class="icon-exclamation red"></i> Страница не существует :(.',
											'notification' => 'Мы не смогли найти запрошенную Вами страницу.',
											'text' => 'Мы извиняемся, но здесь что-то не так — старая или неправильно введенная ссылка. Пожалуйста не уходите и не переключайтесь, попробуйте воспользоваться поиском или перейти на главную страницу.'),


	/**
	 * No content
	 * For modules without content
	 */
	'no_content' 				=> array(	'title' => '<i class="icon-exclamation red"></i> Этот раздел пуст на Вашем языке.',
											'notification' => 'Мы не можем найти контент в данном разделе.',
											'text' => 'Приносим свои извинения за предоставленные неудобства, но этот раздел пуст на выбранном языке. Если Вы модератор или администратор сайта вы можете отключить этот модуль или добавить контент на текущем языке.'),


	/**
	 * Permission denied
	 */
	'permission_denied' 		=> array(	'title' => '<i class="icon-shield"></i> Доступ запрещен<i class="icon-exclamation"></i>',
											'notification' => 'Ваш уровень доступа ниже, чем требуется для просмотра этой страницы.',
											'text' => 'Вам необходимо связаться с владельцем сайтя для повышения Вашего уровня доступа.'),


	/**
	 * Search
	 */
	'search' 					=> array(	'search' => 'Поиск',
											'by_tag' => 'Поиск по тегу',
											'no_results' => 'Поиск не дал результатов'),


	/**
	 * Text Helpers
	 */
	'promo_code_annotation' 	=> 'Если Вы не знаете что такое Промо-код - оставьте это поле пустым',
	'last_blog_posts' 			=> 'Последние :num постов',


	/**
	 * Text Warnings
	 */
	'permissions_denied' 		=> 'У Вас не достаточно прав',
	'success_login' 			=> 'Вы успешно вошли',
	'success_logout' 			=> 'Вы успешно вышли',
	'incorrect_pass_message'	=> 'Не верный пароль!',
	'others_promo_message' 		=> 'Вы ввели не верный или чужой промо-код',
	'non_exsist_promo_message'	=> 'Вы ввели не верный или не существующий пароль',
	'user_success_login' 		=> 'Вы успешно вошли! <a href="index.php">Продолжить</a>',
	'incorrect_pass_repass' 	=> 'Пароль и подтверждение пароля разные!',
	'incorrect_email_message'	=> 'Логин (email) введен не верно, Прим.: name@domen.ru',
	'name_error_message' 		=> '"Имя" обязательно к заполнению и должно содержать минимум 3 символа.',
	'password_error' 			=> 'Введите пароль для решистрации.',
	'user_success_signup' 		=> 'Вы успегно зарегистрировались! <a href="index.php">Продолжить</a>',
	'registered_message' 		=> 'Этот "Логин" уже зарегистрирован, если Вы забыли пароль - воспользуйтесь восстановлением пароля.',
	'success_recovery' 			=> 'Вы успешно восстановили пароль, проверьте свою почту!',

);