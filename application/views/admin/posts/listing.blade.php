@layout('admin.posts.template')

<h3>
	<i class="icon-desktop"></i> {{ __('content.post_word') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_post"
			class="btn"
			href="{{ action('admin.posts.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word', 'content.add_new_word')) }}"
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
					href="{{ action('admin.tools.action@module_settings', array('Posts')) }}" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word', 'content.settings_word')) }}"
				>
					<i class="icon-cog"></i> {{ __('content.settings_word') }}
				</a>
			</li>
			<li>
				<a 
					id="ajax_reset_order"
					data-post="{{ e('{"table": "Posts", "group": {"column": "section" } }') }}"
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

@section('posts')

	@if($posts)

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

		@foreach ($posts as $key => $post_group)

			<?php $new_group = true; ?>

			@if($post_group)
				
				@foreach ($post_group as $post)

					@if($new_group)
						<table class="table table-condensed table-bordered table-hover" id="{{ $key }}_table">
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

									<th style="width: 30%">
										{{ __('forms.section_word') }}: 
										<a 	id="go_to_section_{{ $post->{"sections.id"} }}"
											href="{{ action('admin.sections.home@edit', array($post->{"sections.id"})) }}" 
											data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word')) }} · {{ $post->{"sections.title"} }}"
										>
											{{ $post->{"sections.title"} }}
										</a>
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
									
									<th style="width: 6%">
										{{ __('forms.action_word') }}
									</th>
								</tr>
							</thead>
							<tbody>
					@endif

					<?php $new_group = false;?>
				@endforeach
					
								@include('admin.posts.row')

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

		<script type="text/javascript">
			$('[rel=tooltip]').tooltip();
		</script>
		
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Posts</h6>
			<h6>No Sections</h6>
			<h6>Please create Section at first and than Post</h6>
		</div>
	@endif

@endsection