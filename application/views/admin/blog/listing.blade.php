@layout('admin.blog.template')

<h3>
	<i class="icon-coffee"></i> {{ __('content.blog_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_blog"
			class="btn"
			href="{{ action('admin.blog.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.blog_word', 'content.add_new_word')) }}"
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
					href="{{ action('admin.tools.action@module_settings', array('Blog')) }}" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.blog_word', 'content.settings_word')) }}"
				>
					<i class="icon-cog"></i> {{ __('content.settings_word') }}
				</a>
			</li>
			<li>
				<a 
					id="ajax_reset_order"
					data-post="{{ e('{"table": "Blog"}') }}"
					href="{{ action('admin.tools.action@order_reset') }}"
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

@section('blog')

	@if($blogs)
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

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					@if(in_array('order', $listing_columns))
					<th style="width:2%">
					</th>
					<th style="width:2%">
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

					@if(in_array('tags', $listing_columns))
					<th>
						{{ __('forms.tags_word') }}
					</th>
					@endif

					@if(in_array('short', $listing_columns))
					<th>
						{{ __('forms.short_word') }}
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

					@if(in_array('qr_code', $listing_columns))
					<th>
						{{ __('content.qrcode') }}
					</th>
					@endif

					@if(in_array('access', $listing_columns))
					<th>
						{{ __('forms.access_word') }}
					</th>
					@endif

					@if(in_array('link', $listing_columns))
					<th>
						{{ __('forms.link_word') }}
					</th>
					@endif

					<th style="width:10%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@include('admin.blog.row')
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
			<h6>No Posts in Blog yet</h6>
			<h6>Please create your first post</h6>
		</div>
	@endif

@endsection