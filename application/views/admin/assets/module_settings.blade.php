<h3>
	<i class="icon-cog"></i> {{ $module }} · {{ __('content.settings_word') }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ URL::to('admin/'.strtolower($module)) }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.'.$module.'_word')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@if(isset($settings->id->table))
<div class="row-fluid">
	<div class="offset3 span6">
		<h6>{{ __('tools.table_listing_settings') }}</h6>
		@if($settings)
			@foreach($settings as $key => $value)

				@if(isset($value->table))
					@if($value->editable == 'true')
						<?php $json_save = '{"module": "'.$module.'", "setting": "'.$key.'", "option": "table", "value": $(\'#'.$key.'_listing\').val() }' ?>
						<label class="checkbox inline">
						<i 	style="cursor: pointer" 
							onclick="if($('#{{ $key.'_listing' }}').val() !== 'true'){ $('#{{ $key.'_listing' }}').val('true'); $(this).removeClass().addClass('icon-check'); }else{ $('#{{ $key.'_listing' }}').val('false'); $(this).removeClass().addClass('icon-check-empty'); }" 
							id="ajax_checkbox_{{ $key.'_listing' }}" 
							class="icon-check{{ ($value->table == 'true') ? null : '-empty' }}"
							data-link="{{ action('admin.tools.action@module_settings_save') }}"
							data-post="{{ e($json_save) }}"
							data-out="null"
							data-restore="true"
							data-prevent-follow="true"
							data-out-popup="true"
						> {{ __('forms.'.$key.'_word') }}</i>
						{{ Form::hidden($key.'_listing', $value->table, array('id' => $key.'_listing', 'style' => 'display:none')); }}
							
						</label>

					@endif
				@endif

			@endforeach
		@endif
	</div>
</div>

<hr>
@endif


@if(isset($settings->id->editor))
<div class="row-fluid">
	<div class="offset3 span6">
		<h6>{{ __('tools.edit_fields_settings') }}</h6>
		@if($settings)
			@foreach($settings as $key => $value)

				@if(isset($value->editor))
					@if($value->editable == 'true')
						<?php $json_save = '{"module": "'.$module.'", "setting": "'.$key.'", "option": "editor", "value": $(\'#'.$key.'_editor\').val() }' ?>
						<label class="checkbox inline">
						<i 	style="cursor: pointer" 
							onclick="if($('#{{ $key.'_editor' }}').val() !== 'true'){ $('#{{ $key.'_editor' }}').val('true'); $(this).removeClass().addClass('icon-check'); }else{ $('#{{ $key.'_editor' }}').val('false'); $(this).removeClass().addClass('icon-check-empty'); }" 
							id="ajax_checkbox_{{ $key.'_editor' }}" 
							class="icon-check{{ ($value->editor == 'true') ? null : '-empty' }}"
							data-link="{{ action('admin.tools.action@module_settings_save') }}"
							data-post="{{ e($json_save) }}"
							data-out="null"
							data-restore="true"
							data-prevent-follow="true"
							data-out-popup="true"
						> {{ __('forms.'.$key.'_word') }}</i>
						{{ Form::hidden($key.'_editor', $value->editor, array('id' => $key.'_editor', 'style' => 'display:none')); }}
							
						</label>

					@endif
				@endif

			@endforeach
		@endif
	</div>
</div>
@endif


@if(isset($settings->id->frontend))
<hr>

<div class="row-fluid">
	<div class="offset3 span6">
		<h6>{{ __('tools.frontend_settings') }}</h6>
		@if($settings)
			@foreach($settings as $key => $value)

				@if(isset($value->frontend))
					@if($value->editable == 'true')
						<?php $json_save = '{"module": "'.$module.'", "setting": "'.$key.'", "option": "frontend", "value": $(\'#'.$key.'_frontend\').val() }' ?>
						<label class="checkbox inline">
						<i 	style="cursor: pointer" 
							onclick="if($('#{{ $key.'_frontend' }}').val() !== 'true'){ $('#{{ $key.'_frontend' }}').val('true'); $(this).removeClass().addClass('icon-check'); }else{ $('#{{ $key.'_frontend' }}').val('false'); $(this).removeClass().addClass('icon-check-empty'); }" 
							id="ajax_checkbox_{{ $key.'_frontend' }}" 
							class="icon-check{{ ($value->frontend == 'true') ? null : '-empty' }}"
							data-link="{{ action('admin.tools.action@module_settings_save') }}"
							data-post="{{ e($json_save) }}"
							data-out="null"
							data-restore="true"
							data-prevent-follow="true"
							data-out-popup="true"
						> {{ __('forms.'.$key.'_word') }}</i>
						{{ Form::hidden($key.'_frontend', $value->frontend, array('id' => $key.'_frontend', 'style' => 'display:none')); }}
							
						</label>

					@endif
				@endif

			@endforeach
		@endif
	</div>
</div>
@endif