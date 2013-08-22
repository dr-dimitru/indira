<div id="user_info" class="form">
	<div class="fields well">
		{{ __('templates::content.user.info', array('name' => Session::get('user.name'), 'access' => Session::get('user.access'))) }}

		<div id="status_user_info"></div>
	</div>

	<div class="actions">
		<button 
			class="btn btn-block"
			onclick="$('#user_info').slideToggle(); $('#edit_user_form').slideToggle();"
		>
			{{ __('templates::content.user.edit_word') }}
		</button> 
		<hr>
		<button 
			id="ajax_user_logout"
			class="btn btn-block"
			data-link="{{ URL::to_route('user_logout') }}"
			data-out="status_user_info"
			data-prevent-follow="true"
		>
			{{__('templates::content.logout_word')}}
		</button>
	</div>
</div>