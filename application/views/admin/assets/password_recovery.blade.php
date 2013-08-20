<div class="modal-header">
	<a class="close" data-dismiss="modal">×</a>
	<h3>{{ __('content.pass_recovery_word') }}</h3>
</div>

<div class="modal-body form-vertical">
	<fieldset>
		<div class="control-group">
		<label class="control-label" for="email">
			<h6>Admin's Email:</h6>
		</label>
			<div class="controls input-prepend input-append">
				<span class="add-on">
					<strong>@</strong>
				</span>
				<input 
					REQUIRED 
					class="input" 
					id="email" 
					type="email" 
					style="width:86%"
					value="" 
				/>
				<button 
					id="ajax_password_recovery"
					class="btn"
					data-link="{{ action('admin.iforgot.home@index') }}"
					data-post="{{ e('{"email": encodeURI($(\'#email\').val())}') }}"
					data-out="recovery_action"
					data-prevent-follow="true"
					title="{{ __('content.pass_recovery_action') }}"
				>
					<i class="icon-angle-right icon-large"></i>
				</button>
			</div>
		</div>
	</fieldset>
</div>

<div class="modal-footer" style="text-align:center">
	<div id="recovery_action"></div>
</div>