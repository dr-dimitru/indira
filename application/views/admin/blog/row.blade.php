@foreach ($blogs as $blog)
<?php $blog_tags = explode(",", $blog->tags); ?>
	<tr id="blog_row_{{ $blog->id }}">
		@if(in_array('order', $listing_columns))
		<td style="text-align:center;padding: 0px;">

			@if($blog->order != '1')
			<a 
				id="go_to_up_{{ $blog->id }}"
				class="order-caret" 
				href="{{ action('admin.tools.action@order', array('up')) }}" 
				data-post="{{ e('{"table": "Blog", "id": '.$blog->id.', "order": "'.$blog->order.'"}') }}"
				data-prevent-follow="true"
				style="position: relative;top: 5px;"
			>
				<i class="icon-caret-up icon-large"></i>
			</a>
			@endif
			<br>
			@if($blog->order != $max_order)
			<a 
				id="go_to_up_{{ $blog->id }}"
				class="order-caret" 
				href="{{ action('admin.tools.action@order', array('down')) }}" 
				data-post="{{ e('{"table": "Blog", "id": '.$blog->id.', "order": "'.$blog->order.'"}') }}"
				data-prevent-follow="true"
				style="position: relative;top: -5px;left: -2px;"
			>
				<i class="icon-caret-down icon-large"></i>
			</a>
			@endif

		</td>
		<td style="text-align:center;padding: 0px;vertical-align: middle;">
			
			<span class="label">{{ $blog->order }}</span>

		</td>
		@endif

		@if(in_array('id', $listing_columns))
		<td style="vertical-align: middle;">
			<span class="label label-inverse">{{ $blog->id }}</span>
		</td>
		@endif


		<td style="vertical-align: middle;">
			@if(in_array('lang', $listing_columns))
				<span class="label label-inverse">{{ $blog->lang }}</span>
			@endif

			@if(in_array('published', $listing_columns))
				<button 
					id="ajax_pubish_{{ $blog->id }}" 
					class="btn btn-mini" 
					type="button"
					data-post="{{ e('{ "id": "'.$blog->id.'" }') }}" 
					data-link="{{ action('admin.blog.action@publish') }}"
					data-prevent-follow="true" 
					data-out="ajax_pubish_{{ $blog->id }}"
					data-remove="hidden_sign_{{ $blog->id }}"
				>
					@if($blog->published == 'true')
						<i class="icon-minus-sign red" title="{{ __('forms.unpublish_word') }}"></i>
					@else
						<i class="icon-cloud-upload" title="{{ __('forms.publish_word') }}"></i>
					@endif
				</button> 
				@if($blog->published == 'false')
					<sup>
						<small id="hidden_sign_{{ $blog->id }}" class="h6" style="font-size:7px">{{ __('forms.unpublished_word') }}</small>
					</sup>
				@endif
			@endif

			<a 	id="go_to_blog_{{ $blog->id }}" 
				href="{{ action('admin.blog.home@edit', array($blog->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }} · {{ $blog->title }}"
			>
				{{ $blog->title }}
			</a>
		</td>

		@if(in_array('tags', $listing_columns))
		<td style="vertical-align: middle;">
			@foreach($blog_tags as $tag)
				<span class="label">{{ $tag }}</span>
			@endforeach
		</td>
		@endif

		@if(in_array('short', $listing_columns))
		<td style="vertical-align: middle;" class="ellipsis">
			<small>{{ $blog->short }}</small>
		</td>
		@endif

		@if(in_array('created_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($blog->created_at)) ? date('Y-m-d h:i', $blog->created_at) : $blog->created_at }}</small>
		</td>
		@endif

		@if(in_array('updated_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($blog->updated_at)) ? date('Y-m-d h:i', $blog->updated_at) : $blog->updated_at }}</small>
		</td>
		@endif

		@if(in_array('qr_code', $listing_columns))
		<td style="vertical-align: middle;">
			<img height="50" width="50" src="{{ $blog->qr_code }}" />
		</td>
		@endif

		@if(in_array('access', $listing_columns))
		<td style="vertical-align: middle;">
			<span class="label label-inverse">{{ $blog->access }}</span>
		</td>
		@endif

		@if(in_array('link', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ $blog->link }}</small>
		</td>
		@endif

		<td style="vertical-align: middle;">
			<div class="btn-group">
				<a 	id="go_to_btn_blog_{{ $blog->id }}" 
					href="{{ action('admin.blog.home@edit', array($blog->id)) }}" 
					class="btn btn-small" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }} · {{ $blog->title }}" 
				>
						<i class="icon-edit icon-large"></i>
				</a> 

				<a 	href="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)).'?edit=true' }}" 
					class="btn btn-inverse btn-small"
				>
					<i class="icon-lemon"></i>
				</a>

				<button 
					id="ajax_delete_{{ $blog->id }}"
					class="btn btn-small"
					type="button"
					data-link="{{ action('admin.blog.action@delete') }}" 
					data-post="{{ e('{ "id": "'.$blog->id.'", "delete": "delete"}') }}" 
					data-message="{{ e(__('forms.delete_warning', array('item' => $blog->title))) }}" 
					data-prevent-follow="true" 
					data-out="blog_row_{{ $blog->id }}"
					data-remove="blog_row_{{ $blog->id }}"
					data-out-popup="true"
				>
					<i class="icon-trash icon-large red"></i>
				</button> 
			</div>
		</td>
	</tr>
@endforeach