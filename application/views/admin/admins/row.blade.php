<tr id="admin_row_{{ $admin->id }}">

	@if(in_array('id', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $admin->id }}</span>
	</td>
	@endif


	<td style="vertical-align: middle;">
		<a 	id="go_to_admin_{{ $admin->id }}" 
			href="{{ action('admin.admins.home@edit', array($admin->id)) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.admins_word', $admin->name)) }}"
		>
			{{ $admin->name }}
		</a>

		@if(in_array('email', $listing_columns))
			({{ $admin->email }})
		@endif
	</td>

	@if(in_array('access', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $admin->access }}</span>
	</td>
	@endif

	@if(in_array('created_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($admin->created_at)) ? date('Y-m-d h:i', $admin->created_at) : $admin->created_at }}</small>
	</td>
	@endif

	@if(in_array('updated_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($admin->updated_at)) ? date('Y-m-d h:i', $admin->updated_at) : $admin->updated_at }}</small>
	</td>
	@endif

	<td style="vertical-align: middle;">
		<div class="btn-group">


			<a 	id="go_to_admin_{{ $admin->id }}" 
				class="btn btn-small"
				href="{{ action('admin.admins.home@edit', array($admin->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.admins_word', $admin->name)) }}"
			>
				<i class="icon-edit icon-large"></i>
			</a>

			@if($admin->id == $min_id)

				<button 
					class="btn disabled btn-small" 
					disabled 
				>
					<i class="icon-minus-sign red icon-large"></i>
				</button>

			@else

				<button 
					id="ajax_delete_{{ $admin->id }}"
					class="btn btn-small" 
					type="button"
					data-link="{{ action('admin.admins.action@delete') }}"  
					data-post="{{ e('{ "id": "'.$admin->id.'", "delete": "delete"}') }}"
					data-out="admin_row_{{ $admin->id }}"
					data-remove="admin_row_{{ $admin->id }}"
					data-prevent-follow="true" 
					data-out-popup="true"
					data-message="{{ e(__('forms.delete_warning', array('item' => e($admin->name)))) }}"
				>
					<i class="icon-trash red icon-large"></i>
				</button> 

			@endif
		</div>
	</td>
</tr>