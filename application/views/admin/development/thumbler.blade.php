<small class="btn-group" data-toggle="buttons-radio">
	<button 
		type="button" 
		class="btn {{ $on }}"
		@if(!$on)
		id="ajax_dev_on"
		data-link="{{ action('admin.development.action@on') }}"
		data-post="{{  e('{ "dev": "on" }')  }}"
		data-message="{{ e(__('development.warning')) }}"
		@endif
		data-out="dev_thumbler"
		data-prevent-follow="true"
	>
		<i class="icon-minus-sign-alt red"></i> {{ __('forms.on_word') }}
	</button>

	<button 
		type="button" 
		class="btn {{ $off }}"
		@if(!$off)
		id="ajax_dev_off"
		data-link="{{ action('admin.development.action@off') }}"
		data-post="{{ e('{ "dev": "off" }') }}"
		@endif
		data-out="dev_thumbler"
		data-prevent-follow="true"
	>
		<i class="icon-off green"></i> {{ __('forms.off_word') }}
	</button>
</small>