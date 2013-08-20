@layout('admin.sections.template')

<h3>
	<i class="icon-reorder"></i> {{ __('content.sections_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_post"
			class="btn"
			href="{{ action('admin.sections.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.section_word', 'content.add_new_word')) }}"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>

	</div>
	<div class="btn-group pull-right">
		<button class="btn dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li>
				<a 
					id="go_to_module_settings"
					href="{{ action('admin.tools.action@module_settings', array('Sections')) }}" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word', 'content.settings_word')) }}"
				>
					<i class="icon-cog"></i> {{ __('content.settings_word') }}
				</a>
			</li>
			<li>
				<a 
					id="ajax_reset_order"
					href="{{ action('admin.tools.action@order_reset') }}"
					data-post="{{ e('{"table": "Sections", "group": {"column": "lang" } }') }}"
					data-prevent-follow="true"
					data-out-popup="{{ e(Utilites::alert(__('forms.reseted_order'), 'success')) }}"
					data-message="{{ e(__('forms.reset_warning')) }}"
				>
					<i class="icon-list-ol red"></i> {{ __('forms.reset_order') }}
				</a>
			</li>
		</ul>
	</div>
</div>

@section('sections')

	@if($sections)
	
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

		@foreach ($sections as $lang_key => $rows)

			@if(!empty($rows))
			<table class="table table-condensed table-bordered table-hover" id="{{ $lang_key }}_table">
				<thead>
					<tr>
						@if(in_array('order', $listing_columns))
						<th style="width: 2%">
						</th>
						<th style="width: 2%">
						</th>
						@endif

						@if(in_array('id', $listing_columns))
						<th>
							ID
						</th>
						@endif

						<th>
							{{ __('forms.title_word') }}
						</th>

						@if(in_array('parent', $listing_columns))
						<th>
							{{ __('forms.parent_word') }}
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

						@if(in_array('link', $listing_columns))
						<th>
							{{ __('forms.link_word') }}
						</th>
						@endif

						<th style="width: 6%">
							{{ __('forms.action_word') }}
						</th>
					</tr>
				</thead>
				<tbody>
					@include('admin.sections.row')
				</tbody>
			</table>
			@endif

		@endforeach

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
			<h6>No Sections created yet</h6>
			<h6>Please create your first Section</h6>
		</div>
		
	@endif

@endsection