@layout('admin.modules.template')

<h3>
	<i class="icon-suitcase"></i> {{ __('content.modules_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_module"
			class="btn"
			href="{{ action('admin.modules.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word', 'content.add_new_word')) }}"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>
	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			class="btn"
			href="{{ action('admin.tools.action@module_settings', array('Modules')) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('modules')

	@if($modules)

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>

					@if(in_array('id', $listing_columns))
					<th style="width:5%">
						ID
					</th>
					@endif

					@if(in_array('active', $listing_columns))
					<th style="width:5%">
						{{ __('forms.activated_word') }}
					</th>
					@endif

					<th>
						{{ __('forms.title_word') }}
					</th>

					@if(in_array('access', $listing_columns))
					<th>
						{{ __('forms.access_word') }}
					</th>
					@endif

					@if(in_array('view_access', $listing_columns))
					<th>
						{{ __('forms.view_access_word') }}
					</th>
					@endif

					@if(in_array('link', $listing_columns))
					<th>
						{{ __('forms.link_word') }}
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
					
					<th style="width: 6%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($modules as $id => $module)
	
					@include('admin.modules.row')

				@endforeach

			</tbody>
		</table>
		
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Modules created yet</h6>
		</div>
	@endif

@endsection