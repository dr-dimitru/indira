@foreach($pages as $key => $page)
<tr id="page_row_{{ $page->id }}">

	@if(in_array('id', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $page->id }}</span>
	</td>
	@endif

	<td style="vertical-align: middle;">

		@if(in_array('lang', $listing_columns))
		<span class="label label-inverse">{{ $page->lang }}</span>
		@endif

		@if(in_array('published', $listing_columns))
			<button 
				id="ajax_pubish_{{ $page->id }}" 
				class="btn btn-mini" 
				type="button"
				data-post="{{ e('{ "id": "'.$page->id.'" }') }}" 
				data-link="{{ action('admin.pages.action@publish') }}"
				data-prevent-follow="true" 
				data-out="ajax_pubish_{{ $page->id }}"
				data-remove="hidden_sign_{{ $page->id }}"
			>
				@if($page->published == 'true')
					<i class="icon-minus-sign red" title="{{ __('forms.unpublish_word') }}"></i>
				@else
					<i class="icon-cloud-upload" title="{{ __('forms.publish_word') }}"></i>
				@endif
			</button> 
			@if($page->published == 'false')
				<sup>
					<small id="hidden_sign_{{ $page->id }}" class="h6" style="font-size:7px">{{ __('forms.unpublished_word') }}</small>
				</sup>
			@endif
		@endif

		<a 	
			id="go_to_page_{{ $page->id }}" 
			href="{{ action('admin.pages.home@edit', array($page->id)) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word', $page->title)) }} "
		>
			{{ $page->title }}
		</a>
	</td>

	@if(in_array('link', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $page->link }}</small>
	</td>
	@endif

	@if(in_array('tags', $listing_columns))
	<td style="vertical-align: middle;">
		<?php 
			$page_tags = explode(",", $page->tags); 
		?>

		@foreach($page_tags as $tag)
			<span class="label">{{ $tag }}</span>
		@endforeach

	</td>
	@endif

	@if(in_array('created_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($page->created_at)) ? date('Y-m-d h:i', $page->created_at) : $page->created_at }}</small>
	</td>
	@endif

	@if(in_array('updated_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($page->updated_at)) ? date('Y-m-d h:i', $page->updated_at) : $page->updated_at }}</small>
	</td>
	@endif

	@if(in_array('access', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $page->access }}</span>
	</td>
	@endif

	<td style="vertical-align: middle;">
		<div class="btn-group">

			<a 
				id="go_to_btn_page_{{ $page->id }}"
				class="btn btn-small" 
				href="{{ action('admin.pages.home@edit', array($page->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word', $page->title)) }}"
			>
				<i class="icon-edit icon-large"></i>
			</a> 
			<a href="{{ URL::to_route('pages', array(($page->link) ? $page->link : $page->id)).'?edit=true' }}" class="btn btn-small btn-inverse" title="{{ __('forms.edit_on_page') }}">
				<i class="icon-lemon"></i>
			</a>
			<button 
				id="ajax_delete_{{ $page->id }}"
				class="btn btn-small"
				type="button"
				data-post="{{ e('{ "id": "'.$page->id.'", "delete": "delete"}') }}"
				data-link="{{ action('admin.pages.action@delete') }}"
				data-message="{{ e(__('forms.delete_warning', array('item' => $page->title))) }}"
				data-out="page_row_{{ $page->id }}"
				data-out-popup="true"
				data-remove="page_row_{{ $page->id }}"
				data-prevent-follow="true"
			>
				<i class="icon-trash icon-large red"></i>
			</button>
		</div>
	</td>
</tr>
@endforeach

@if($pagination)
<tr id="load_more_pages_rows">
	<td colspan="100" style="padding:0px">
		<button
			id="ajax_load_more_pages_rows"
			class="btn btn-block btn-inverse"
			type="button"
			data-link="{{ action('admin.pages.home@load_more') }}?page={{ $page_num + 1 }}&show={{ $take }}"
			data-out="pages_listing_table"
			data-append="true"
			data-prevent-follow="true"
			data-remove="load_more_pages_rows"
		>
			{{ __('content.load_more_word') }}
		</button>
	</td>
</tr>
@endif