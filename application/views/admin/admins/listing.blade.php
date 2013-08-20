@layout('admin.admins.template')

<h3>
	<i class="icon-group"></i> {{ __('content.admins_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			href="{{ action('admin.admins.home@new') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.admins_word', 'content.add_new_word')) }}" 
			id="go_to_new_admins"
			class="btn"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>

	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			class="btn"
			href="{{ action('admin.tools.action@module_settings', array('Admins')) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.admins_word', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('admins')
	@if($admins)
		<div id="save_errors"></div>
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					@if(in_array('id', $listing_columns))
					<th style="width:2%">
						ID
					</th>
					@endif

					<th style="width:25%">
						{{ __('forms.name_word') }}
					</th>

					@if(in_array('access', $listing_columns))
					<th>
						{{ __('forms.access_word') }}
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
				@foreach ($admins as $admin)

					@include('admin.admins.row')

				@endforeach
			</tbody>
		</table>
	@else
		<div class="well well-large" style="text-align: center">
			<h6>{{ __('admins.no_admins_exists') }}</h6><br>
		</div>
	@endif
@endsection