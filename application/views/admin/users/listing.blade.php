@layout('admin.users.template')

<h3>
	<i class="icon-user"></i> {{ __('content.users_word') }} 
	<small>
		<a 
			href="{{ action('admin.users.home@settings') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word', 'content.settings_word')) }}" 
			id="go_to_new_users"
			class="btn btn-small btn-inverse"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-wrench"></i> {{ __('content.settings_word') }}
		</a>
	</small>
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			href="{{ action('admin.users.home@new') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word', 'content.add_new_word')) }}" 
			id="go_to_new_users"
			class="btn"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>

	<div class="pull-left input-append input-prepend" style="position: relative;">
		<input type="hidden" style="display:none" value="email" id="searchField">
		<div class="btn-group">
			<button class="btn dropdown-toggle" data-toggle="dropdown" id="field">
				<span id="searchFieldName">Email</span> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="top: 30px;" aria-labelledby="field">
				@foreach($listing_columns as $column)
				<li>
					<button 
						class="btn"
						id="search_by_{{ $column }}"
						onclick="$('#searchFieldName').html($('#search_by_{{ $column }}').html()); $('#searchField').val($('#search_by_{{ $column }}').attr('data-value'));"
						data-value="{{ $column }}"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('forms.'.$column.'_word') }}
					</buton>
				</li>
				@endforeach
			</ul>
		</div>
		<input type="hidden" style="display:none" value="like" id="compareType">
		<div class="btn-group">
			<button class="btn dropdown-toggle" data-toggle="dropdown" id="type">
				<span id="compareName">{{ __('content.like_word') }}</span> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="top: 30px;" aria-labelledby="type">
				<li>
					<button 
						class="btn"
						onclick="$('#compareName').html($(this).html()); $('#compareType').val($(this).attr('data-value'));"
						data-value="like"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('content.like_word') }}
					</buton>
				</li>
				<li>
					<button 
						class="btn"
						onclick="$('#compareName').html($(this).html()); $('#compareType').val($(this).attr('data-value'));"
						data-value="equal"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('content.equal_word') }}
					</buton>
				</li>
				<li>
					<button 
						class="btn"
						onclick="$('#compareName').html($(this).html()); $('#compareType').val($(this).attr('data-value'));"
						data-value="soundex"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('content.sounds_like_word') }}
					</buton>
				</li>
				<li>
					<button 
						class="btn"
						onclick="$('#compareName').html($(this).html()); $('#compareType').val($(this).attr('data-value'));"
						data-value="similar"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('content.similar_word') }}
					</buton>
				</li>
				<li>
					<button 
						class="btn"
						onclick="$('#compareName').html($(this).html()); $('#compareType').val($(this).attr('data-value'));"
						data-value="all"
						style="width:100%; text-align:left; margin: 0px;"
					>
						{{ __('content.search.all_search_types') }}
					</buton>
				</li>
			</ul>
		</div>
		{{ Form::search('search_user', null, array('id' => 'search_user', 'class' => 'search-query span3', 'style' => 'border: none;', 'placeholder' => __('users.search_placeholder'))) }}
		<button 
			type="button"
			class="btn"
			data-ajaxify="true"
			data-link="{{ action('admin.users.action@search') }}"
			data-post="{{ e('{"field": $(\'#searchField\').val(), "value": $(\'#search_user\').val(), "type": $(\'#compareType\').val()}') }}"
			data-prevent-follow="true"
			data-append="prepend"
			data-out="users_listing_table"
			onclick="if($('#search_thead')){ $('#search_thead').remove(); } if($('#search_tbody')){ $('#search_tbody').remove(); }"
		>
			{{ __('content.search_word') }}
		</button>
		<button 
			type="button"
			class="btn"
			onclick="if($('#search_thead')){ $('#search_thead').remove(); } if($('#search_tbody')){ $('#search_tbody').remove(); }"
		>
			<i class="icon-remove"></i>
		</button>
	</div>

	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			class="btn"
			href="{{ action('admin.tools.action@module_settings', array('Users')) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('users')
	@if($users)

		@if($pagination)
			<div class="row-fluid">
				<div class="span7">
					{{ $pagination }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>
		@endif

	<div class="row-fluid">
		<div class="span12">
			<div class="scroll" style="overflow-y: scroll; -webkit-overflow-scrolling: touch;">	
				<table class="table table-condensed table-bordered table-hover" id="users_listing_table">
					<thead>
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
					<tbody>
						@foreach ($users as $user)

							@include('admin.users.row')

						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

		@if($pagination)
			<div class="row-fluid">
				<div class="span7">
					{{ $pagination }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>
		@endif

	@else
		<div class="well well-large" style="text-align: center">
			<h6>{{ __('users.no_users_exists') }}</h6><br>
		</div>
	@endif
@endsection