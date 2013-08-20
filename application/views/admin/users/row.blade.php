<tr id="user_row_{{ $user->id }}">

	@if(in_array('id', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $user->id }}</span>
	</td>
	@endif


	<td style="vertical-align: middle;">
		<a 	id="go_to_admin_{{ $user->id }}" 
			href="{{ action('admin.users.home@edit', array($user->id)) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word', $user->name)) }}"
		>
			{{ $user->name }}
		</a>
	</td>

	@if(in_array('email', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->email }}</small>
	</td>
	@endif

	@if(in_array('access', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $user->access }}</span>
	</td>
	@endif

	@if(in_array('first_name', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->first_name }}</small>
	</td>
	@endif

	@if(in_array('last_name', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->last_name }}</small>
	</td>
	@endif

	@if(in_array('phone', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $user->phone }}</span>
	</td>
	@endif

	@if(in_array('country', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->country }}</small>
	</td>
	@endif

	@if(in_array('region', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->region }}</small>
	</td>
	@endif

	@if(in_array('city', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->city }}</small>
	</td>
	@endif

	@if(in_array('address_line_one', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->address_line_one }}</small>
	</td>
	@endif

	@if(in_array('address_line_two', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $user->address_line_two }}</small>
	</td>
	@endif

	@if(in_array('zip_code', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $user->zip_code }}</span>
	</td>
	@endif

	@if(in_array('delivery_type', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $user->delivery_type }}</span>
	</td>
	@endif

	@if(in_array('created_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($user->created_at)) ? date('Y-m-d h:i', $user->created_at) : $user->created_at }}</small>
	</td>
	@endif

	@if(in_array('updated_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($user->updated_at)) ? date('Y-m-d h:i', $user->updated_at) : $user->updated_at }}</small>
	</td>
	@endif

	<td style="vertical-align: middle;">
		<div class="btn-group">


			<a 	id="go_to_user_{{ $user->id }}" 
				class="btn btn-small"
				href="{{ action('admin.users.home@edit', array($user->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word', $user->name)) }}"
			>
				<i class="icon-edit icon-large"></i>
			</a>

			<button 
				id="ajax_delete_{{ $user->id }}"
				class="btn btn-small" 
				type="button"
				data-link="{{ action('admin.users.action@delete') }}"  
				data-post="{{ e('{ "id": "'.$user->id.'", "delete": "delete"}') }}"
				data-out="user_row_{{ $user->id }}"
				data-remove="user_row_{{ $user->id }}"
				data-prevent-follow="true" 
				data-out-popup="true"
				data-message="{{ e(__('forms.delete_warning', array('item' => e($user->name)))) }}"
			>
				<i class="icon-trash red icon-large"></i>
			</button> 
		</div>
	</td>
</tr>