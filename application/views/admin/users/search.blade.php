<thead id="search_thead" style="background: rgba(0,0,0,.025);">
	<tr>
		<th colspan="{{ count($listing_columns) + 1 }}" style="text-align:center">
			<h4>{{ __('content.search_results') }}</h4>
		</th>
	</tr>
	<tr>
		@if(in_array('id', $listing_columns))
		<th style="width:2%">
			ID
		</th>
		@endif

		<th style="width:15%">
			{{ __('forms.name_word') }}
		</th>

		@if(in_array('email', $listing_columns))
		<th>
			{{ __('forms.email_word') }}
		</th>
		@endif

		@if(in_array('access', $listing_columns))
		<th>
			{{ __('forms.access_word') }}
		</th>
		@endif

		@if(in_array('first_name', $listing_columns))
		<th>
			{{ __('forms.first_name_word') }}
		</th>
		@endif

		@if(in_array('last_name', $listing_columns))
		<th>
			{{ __('forms.last_name_word') }}
		</th>
		@endif

		@if(in_array('phone', $listing_columns))
		<th>
			{{ __('forms.phone_word') }}
		</th>
		@endif

		@if(in_array('country', $listing_columns))
		<th>
			{{ __('forms.country_word') }}
		</th>
		@endif

		@if(in_array('region', $listing_columns))
		<th>
			{{ __('forms.region_word') }}
		</th>
		@endif

		@if(in_array('city', $listing_columns))
		<th>
			{{ __('forms.city_word') }}
		</th>
		@endif

		@if(in_array('address_line_one', $listing_columns))
		<th>
			{{ __('forms.address_line_one_word') }}
		</th>
		@endif

		@if(in_array('address_line_two', $listing_columns))
		<th>
			{{ __('forms.address_line_two_word') }}
		</th>
		@endif

		@if(in_array('zip_code', $listing_columns))
		<th>
			{{ __('forms.zip_code_word') }}
		</th>
		@endif

		@if(in_array('delivery_type', $listing_columns))
		<th>
			{{ __('forms.delivery_type_word') }}
		</th>
		@endif

		@if(in_array('created_at', $listing_columns))
		<th>
			{{ __('forms.created_at_word') }}
		</th>
		@endif

		@if(in_array('updated_at', $listing_columns))
		<th>
			{{ __('forms.updated_at_word') }}
		</th>
		@endif

		<th style="width:6%">
			{{ __('forms.action_word') }}
		</th>
	</tr>
</thead>
<tbody id="search_tbody" style="background: rgba(0,0,0,.05);">
	@if($users)

		@foreach ($users as $user)

			@include('admin.users.row')

		@endforeach

	@else
		<tr>
			<td colspan="{{ count($listing_columns) + 1 }}">
				{{ $message }}
			</td>
		</tr>
	@endif
	<tr>
		<td colspan="{{ count($listing_columns) + 1 }}">
			<hr style="margin: 20px 0;">
		</td>
	</tr>
</tbody>