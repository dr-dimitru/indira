<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body scroll scroll-y">

	<div class="control-group">

		<label class="control-label" for="code_pattern"><h6>{{ __('promocode.generator.pattern') }}</h6></label>

		<div class="controls">

			<input type="text" class="span6" id="code_pattern" value="AAAA-11AA-1111-AA11" />
			<small class="help-block">{{ __('promocode.generator.pattern_help') }}</small>

		</div>

	</div>

	<hr style="margin: 10px -10px">

	<div class="control-group">

		<label class="control-label" for="code_qty"><h6>{{ __('promocode.generator.qty') }}</h6></label>

		<div class="controls">

			<input type="number" class="span6" id="code_qty" value="5" max="50" min="1" />
			<small class="help-block">{{ __('promocode.generator.qty_help') }}</small>

		</div>

	</div>

	<hr style="margin: 10px -10px">

	{{ Utilites::html_form_build('select', array('code_access_level', null, Utilites::prepare_additions('useraccess')), View::make('admin.assets.form_pattern'), __('promocode.generator.access_level'), array('id' => 'code_access_level', 'class' => 'span6')) }}

</div>

<div class="modal-footer">
	<div class="actions">
		<button 
			type="button"
			class="btn btn-block btn-inverse"
			data-ajaxify="true"
			data-link="{{ action('admin.promocodes.action@generator') }}"
			data-post="{{ e('{ "code_pattern": encodeURI($(\'#code_pattern\').val()), "code_qty": encodeURI($(\'#code_qty\').val()), "code_access_level": encodeURI($(\'#code_access_level\').val()) }') }}"
			data-prevent-follow="true"
		>
			{{ __('promocode.generator.generate') }}
		</button>
	</div>
</div>