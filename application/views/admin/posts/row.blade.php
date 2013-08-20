@foreach ($post_group as $post)
	<tr id="post_row_{{ $post->id }}">
		@if(in_array('order', $listing_columns))
		<td style="text-align:center;padding: 0px;">

			@if($post->order != '1')
			<a 
				id="go_to_up_{{ $post->id }}"
				class="order-caret" 
				href="{{ action('admin.tools.action@order', array('up')) }}?section={{ $post->section }}&page={{ $page_num + 1 }}&show={{ $take }}" 
				data-post="{{ e('{"table": "Posts", "id": '.$post->id.', "order": "'.$post->order.'", "group": {"column": "section", "value": "'.$post->section.'" } }') }}"
				data-prevent-follow="true"
				style="position: relative;top: 5px;"
			>
				<i class="icon-caret-up icon-large"></i>
			</a>
			@endif
			<br>
			@if($post->order != $post->max_order)
			<a 
				id="go_to_up_{{ $post->id }}"
				class="order-caret" 
				href="{{ action('admin.tools.action@order', array('down')) }}?section={{ $post->section }}&page={{ $page_num + 1 }}&show={{ $take }}" 
				data-post="{{ e('{"table": "Posts", "id": '.$post->id.', "order": "'.$post->order.'", "group": {"column": "section", "value": "'.$post->section.'" } }') }}"
				data-prevent-follow="true"
				style="position: relative;top: -5px;left: -2px;"
			>
				<i class="icon-caret-down icon-large"></i>
			</a>
			@endif

		</td>
		<td style="text-align:center;padding: 0px;vertical-align: middle;">
					
			<span class="label">{{ $post->order }}</span>

		</td>
		@endif

		@if(in_array('id', $listing_columns))
		<td style="vertical-align: middle;">
			<span class="label label-inverse">{{ $post->id }}</span>
		</td>
		@endif


		<td style="vertical-align: middle;">

			@if(in_array('lang', $listing_columns))
			<span class="label label-inverse">{{ $post->lang }}</span>
			@endif

			@if(in_array('published', $listing_columns))
				<button 
					id="ajax_pubish_{{ $post->id }}" 
					class="btn btn-mini" 
					type="button"
					data-post="{{ e('{ "id": "'.$post->id.'" }') }}" 
					data-link="{{ action('admin.posts.action@publish') }}"
					data-prevent-follow="true" 
					data-out="ajax_pubish_{{ $post->id }}"
					data-remove="hidden_sign_{{ $post->id }}"
				>
					@if($post->published == 'true')
						<i class="icon-minus-sign red" title="{{ __('forms.unpublish_word') }}"></i>
					@else
						<i class="icon-cloud-upload" title="{{ __('forms.publish_word') }}"></i>
					@endif
				</button> 
				@if($post->published == 'false')
					<sup>
						<small id="hidden_sign_{{ $post->id }}" class="h6" style="font-size:7px">{{ __('forms.unpublished_word') }}</small>
					</sup>
				@endif
			@endif

			<a 	id="go_to_post_{{ $post->id }}" 
				href="{{ action('admin.posts.home@edit', array($post->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }} · {{ $post->title }}"
			>
				{{ $post->title }}
			</a>

			@if(is_object($post->related))
				@foreach($post->related as $lang => $post_id)
					@if($post_id !== 'false')
					<a
						id="go_to_chained_{{ $lang }}_{{ $post_id }}"
						class="order-caret"
						href="{{ action('admin.posts.home@edit', array($post_id)) }}"
					>
						<i 
							rel="tooltip" 
							class="icon-link"
							title="{{ substr($lang,8) }}"
						></i>
					</a>
					@endif
				@endforeach
			@endif

		</td>

		@if(in_array('tags', $listing_columns))
		<td style="vertical-align: middle;">
			<?php 
				$post_tags = explode(",", $post->tags); 
			?>

			@foreach($post_tags as $tag)
				<span class="label">{{ $tag }}</span>
			@endforeach

		</td>
		@endif

		@if(in_array('short', $listing_columns))
		<td style="vertical-align: middle;" class="ellipsis">
			<small>{{ $post->short }}</small>
		</td>
		@endif

		@if(in_array('created_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($post->created_at)) ? date('Y-m-d h:i', $post->created_at) : $post->created_at }}</small>
		</td>
		@endif

		@if(in_array('updated_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($post->updated_at)) ? date('Y-m-d h:i', $post->updated_at) : $post->updated_at }}</small>
		</td>
		@endif

		@if(in_array('qr_code', $listing_columns))
		<td style="vertical-align: middle;">
			<img height="50" width="50" src="{{ $post->qr_code }}" />
		</td>
		@endif

		@if(in_array('access', $listing_columns))
		<td style="vertical-align: middle;">
			<span class="label label-inverse">{{ $post->access }}</span>
		</td>
		@endif

		@if(in_array('link', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ $post->link }}</small>
		</td>
		@endif

		<td style="vertical-align: middle;">
			<div class="btn-group">

				<a 	id="go_to_btn_post_{{ $post->id }}" 
					class="btn btn-small" 
					href="{{ action('admin.posts.home@edit', array($post->id)) }}" 
					title="{{ e(__('forms.edit_word')) }}"
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }} · {{ $post->title }}"
				>
					<i class="icon-edit icon-large"></i>
				</a> 

				<a 	href="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)).'?edit=true' }}" 
					class="btn btn-inverse btn-small" 
					title="{{ e(__('forms.edit_on_page')) }}">
					<i class="icon-lemon"></i>
				</a>

				<button 
					id="ajax_delete_{{ $post->id }}"
					class="btn btn-small"
					type="button"
					title="{{ e(__('forms.delete_word')) }}"
					data-post="{{ e('{ "id": "'.$post->id.'", "delete": "delete"}') }}"
					data-link="{{ action('admin.posts.action@delete') }}"
					data-message="{{ e(__('forms.delete_warning', array('item' => $post->title))) }}"
					data-out="post_row_{{ $post->id }}"
					data-out-popup="true"
					data-remove="post_row_{{ $post->id }}"
					data-prevent-follow="true"
				>
					<i class="icon-trash icon-large red"></i>
				</button> 

			</div>
		</td>
	</tr>
@endforeach

@if($post->order < $post->max_order)
	<tr id="load_more_{{ $post->section }}_row">
		<td colspan="100%" style="padding:0px">
			<button
				id="ajax_load_more_{{ $post->section }}_table"
				class="btn btn-block"
				type="button"
				data-link="{{ action('admin.posts.home@load_more') }}?section={{ $post->section }}&page={{ $page_num + 1 }}&show={{ $take }}"
				data-out="{{ $post->section }}_table"
				data-append="true"
				data-prevent-follow="true"
				data-remove="load_more_{{ $post->section }}_row"
			>
				<i class="icon-expand-alt icon-large"></i> {{ __('content.load_more_word') }}
			</button>
		</td>
	</tr>
@endif