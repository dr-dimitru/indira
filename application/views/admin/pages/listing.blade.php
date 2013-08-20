@layout('admin.pages.template')

<h3>
	<i class="icon-file-alt"></i> {{ __('content.pages_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_page"
			class="btn"
			href="{{ action('admin.pages.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word', 'content.add_new_word')) }}"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>
	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			href="{{ action('admin.tools.action@module_settings', array('Pages')) }}"
			class="btn" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('pages')

	@if($pages)

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

			<table class="table table-condensed table-bordered table-hover" id="pages_listing_table">
				<thead>
					<tr>
						@if(in_array('id', $listing_columns))
						<th>
							ID
						</th>
						@endif

						<th style="width: 20%">
							{{ __('forms.title_word') }}
						</th>

						@if(in_array('link', $listing_columns))
						<th>
							{{ __('forms.link_word') }}
						</th>
						@endif

						@if(in_array('tags', $listing_columns))
						<th>
							{{ __('forms.tags_word') }}
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

						@if(in_array('access', $listing_columns))
						<th>
							{{ __('forms.access_word') }}
						</th>
						@endif

						<th style="width: 6%">
							{{ __('forms.action_word') }}
						</th>
					</tr>
				</thead>
				<tbody>

					@include('admin.pages.row')

				</tbody>
			</table>

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
			<h6>No Pages Created Yet :(</h6>
		</div>
	@endif

@endsection