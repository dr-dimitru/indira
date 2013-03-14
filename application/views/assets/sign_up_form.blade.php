<div id="registration_form" class="modal fade">
	 <div class="modal-header">
	 	<a class="close" data-dismiss="modal" >×</a>
	    <h3>{{ Lang::line('content.registration_word')->get(Session::get('lang')) }}</h3>
	 </div>
	 <div class="modal-body form-horizontal">
	 	<fieldset>
	 		<div class="control-group">
	 	 		<label class="control-label" for="reg_login">
	 				{{ Lang::line('content.login_email_word')->get(Session::get('lang')) }}: 
	 			</label>
	 			<div class="controls">
	 				<input class="input" id="reg_login" type="email" value="" />
	 			</div>
	 		</div>
	 	</fieldset>
	 	<fieldset>
	 		<div class="control-group">
	 	 		<label class="control-label" for="name">
	 				{{ Lang::line('content.name_word')->get(Session::get('lang')) }}: 
	 			</label>
	 			<div class="controls">
	 				<input class="input" id="name" type="text" value="" />
	 			</div>
	 		</div>
	 	</fieldset>
	 	<fieldset>
	 		<div class="control-group">
	 	 		<label class="control-label" for="reg_password">
	 				{{ Lang::line('content.password_word')->get(Session::get('lang')) }}: 
	 			</label>
	 			<div class="controls">
	 				<input class="input" id="reg_password" type="password" value="" />
	 			</div>
	 		</div>
	 	</fieldset>
	 	<fieldset>
	 		<div class="control-group">
	 	 		<label class="control-label" for="re_password">
	 				{{ Lang::line('content.re_password_word')->get(Session::get('lang')) }}: 
	 			</label>
	 			<div class="controls">
	 				<input class="input" id="re_password" type="password" value="" />
	 			</div>
	 		</div>
	 	</fieldset>
	 	
	 	@if(Promosettings::get_settings('active') == 1 && Promosettings::get_settings('on_registration') == 1)
		 	<?php $json_data = '{"login": "\'+encodeURI($(\'#reg_login\').val())+\'", "name": "\'+encodeURI($(\'#name\').val())+\'", "password": "\'+encodeURI($(\'#reg_password\').val())+\'", "re_password": "\'+encodeURI($(\'#re_password\').val())+\'", "promo": "\'+encodeURI($(\'#reg_promo_code\').val())+\'"}'; ?>
		 	<fieldset>
		 		<div class="control-group">
		 	 		<label class="control-label" for="reg_promo_code">
		 				{{ Lang::line('content.promo_code_word')->get(Session::get('lang')) }}: 
		 			</label>
		 			<div class="controls">
		 				<input class="input" id="reg_promo_code" type="text" />
		 				<p class="help-block">{{ Lang::line('content.promo_code_annotation')->get(Session::get('lang')) }}</p>
		 			</div>
		 		</div>
		 	</fieldset>
	 	@else
	 		<?php $json_data = '{"login": "\'+encodeURI($(\'#reg_login\').val())+\'", "name": "\'+encodeURI($(\'#name\').val())+\'", "password": "\'+encodeURI($(\'#reg_password\').val())+\'", "re_password": "\'+encodeURI($(\'#re_password\').val())+\'"}'; ?>
	 	@endif

	 	<div id="registration_action"></div>
	 </div>
	 <div class="modal-footer">
	 	<a 
	 		href="#pass_recovery_form" 
	 		class="pull-left" 
	 		onclick="$('#registration_form').modal('hide')" 
	 		data-toggle="modal">
	 			{{ Lang::line('content.pass_recovery_word')->get(Session::get('lang')) }}
	 	</a>

	    <a 
	    	href="#" 
	    	onclick="showerp('<?= htmlspecialchars($json_data); ?>', '<? Config::get('application.url') ?>/sign_up/', 'registration_action', 'registration_action')" 
	    	class="btn btn-primary">
	    		{{ Lang::line('content.registration_action_word')->get(Session::get('lang')) }}
	    </a>
	 </div>
</div>