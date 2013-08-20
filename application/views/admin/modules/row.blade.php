<tr id="module_row_{{ $module->id }}">

	@if(in_array('id', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $module->id }}</span>
	</td>
	@endif

	@if(in_array('active', $listing_columns))
	<td style="vertical-align: middle;">
		<button 
			id="ajax_activate_{{ $module->id }}" 
			class="btn btn-mini" 
			type="button"
			data-post="{{ e('{ "id": "'.$module->id.'" }') }}" 
			data-link="{{ action('admin.modules.action@activate') }}"
			data-prevent-follow="true" 
			data-out="ajax_activate_{{ $module->id }}"
		>
			@if($module->active == 'true')
				<i class="icon-ban-circle red" title="'.__('forms.yes_word').'"></i> <span class="label label-inverse">{{ $module->active }}</span>
			@else
				<i class="icon-off" title="'.__('forms.no_word').'"></i> <span class="label label-inverse">{{ $module->active }}</span>
			@endif
		</button> 
	</td>
	@endif

	<td style="vertical-align: middle;">
		<a 	
			id="go_to_module_{{ $module->id }}" 
			href="{{ action('admin.modules.home@edit', array($module->id)) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word', $module->name)) }} "
		>
			{{ $module->name }}
		</a>
	</td>

	@if(in_array('access', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $module->access }}</span>
	</td>
	@endif

	@if(in_array('view_access', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $module->view_access }}</span>
	</td>
	@endif

	@if(in_array('link', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ ($module->link !== 'false') ? $module->link : null }}</small>
	</td>
	@endif

	@if(in_array('created_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($module->created_at)) ? date('Y-m-d h:i', $module->created_at) : $module->created_at }}</small>
	</td>
	@endif

	@if(in_array('updated_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($module->updated_at)) ? date('Y-m-d h:i', $module->updated_at) : $module->updated_at }}</small>
	</td>
	@endif

	<td style="vertical-align: middle;">
		<div class="btn-group">

			<a 
				id="go_to_btn_module_{{ $module->id }}"
				class="btn btn-small" 
				href="{{ action('admin.modules.home@edit', array($module->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word', $module->name)) }}"
			>
				<i class="icon-edit icon-large"></i>
			</a> 

			<button 
				id="ajax_delete_{{ $module->id }}"
				class="btn btn-small"
				type="button"
				data-post="{{ e('{ "id": "'.$module->id.'", "delete": "delete"}') }}"
				data-link="{{ action('admin.modules.action@delete') }}"
				data-message="{{ e(__('forms.delete_warning', array('item' => $module->name))) }}"
				data-out="section_row_{{ $module->id }}"
				data-out-popup="true"
				data-remove="module_row_{{ $module->id }}"
				data-prevent-follow="true"
			>
				<i class="icon-trash icon-large red"></i>
			</button>

			<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-cog icon-large"></i>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
					<a 
						id="go_to_restore_defaults_{{ $module->id }}" 
						href="{{ action('admin.modules.action@restore_default') }}"
						data-post="{{ e('{ "id": "'.$module->id.'"}') }}"
						data-message="{{ e(__('modules.restore_warning')) }}"
						data-prevent-follow="true"
						data-out="false"
						data-out-popup="true"
					>
						<i class="icon-undo green"></i> {{ __('modules.restore_default') }}
					</a>
				</li>
				<li>
					<a 
						id="go_to_drop_table_{{ $module->id }}" 
						href="{{ action('admin.modules.action@set_default') }}"
						data-post="{{ e('{ "id": "'.$module->id.'"}') }}"
						data-message="{{ e(__('modules.set_default_warning')) }}"
						data-prevent-follow="true"
						data-out="false"
						data-out-popup="true"
					>
						<i class="icon-copy red"></i> {{ __('modules.set_default') }}
					</a>
				</li>
			</ul>
		</div>
	</td>
</tr>