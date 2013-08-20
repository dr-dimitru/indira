@foreach($rows as $section)
<tr id="section_row_{{ $section->id }}">

	@if(in_array('order', $listing_columns))
	<td style="text-align:center;padding: 0px;">

		@if($section->order != '1')
		<a 
			id="go_to_up_{{ $section->id }}"
			class="order-caret" 
			href="{{ action('admin.tools.action@order', array('up')) }}?section={{ $lang_key }}&page={{ $page_num + 1 }}&show={{ $take }}" 
			data-post="{{ e('{"table": "Sections", "id": '.$section->id.', "order": "'.$section->order.'", "group": {"column": "lang", "value": "'.$lang_key.'" } }') }}"
			data-prevent-follow="true"
			style="position: relative;top: 5px;"
		>
			<i class="icon-caret-up icon-large"></i>
		</a>
		@endif
		<br>
		@if($section->order != $section->max_order)
		<a 
			id="go_to_up_{{ $section->id }}"
			class="order-caret" 
			href="{{ action('admin.tools.action@order', array('down')) }}?section={{ $lang_key }}&page={{ $page_num + 1 }}&show={{ $take }}" 
			data-post="{{ e('{"table": "Sections", "id": '.$section->id.', "order": "'.$section->order.'", "group": {"column": "lang", "value": "'.$lang_key.'" } }') }}"
			data-prevent-follow="true"
			style="position: relative;top: -5px;left: -2px;"
		>
			<i class="icon-caret-down icon-large"></i>
		</a>
		@endif

	</td>
	<td style="text-align:center;padding: 0px;vertical-align: middle;">
				
		<span class="label">{{ $section->order }}</span>

	</td>
	@endif

	@if(in_array('id', $listing_columns))
	<td style="vertical-align: middle;">
		<span class="label label-inverse">{{ $section->id }}</span>
	</td>
	@endif

	<td style="vertical-align: middle;">

		@if(in_array('lang', $listing_columns))
		<span class="label label-inverse">{{ $section->lang }}</span>
		@endif

		<a 	
			id="go_to_section_{{ $section->id }}" 
			href="{{ action('admin.sections.home@edit', array($section->id)) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word', $section->title)) }} "
		>
			{{ $section->title }}
		</a>
	</td>

	@if(in_array('parent', $listing_columns))
	<td>
		@if($section->parent !== 'false' && !empty($section->parent))
			<a 	
				id="go_to_section_{{ $section->parent }}" 
				href="{{ action('admin.sections.home@edit', array($section->parent)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word', $all_sections[$section->parent]->title)) }}"
			>
				{{ $all_sections[$section->parent]->title }}
			</a>
		@endif
	</td>
	@endif

	@if(in_array('created_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($section->created_at)) ? date('Y-m-d h:i', $section->created_at) : $section->created_at }}</small>
	</td>
	@endif

	@if(in_array('updated_at', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ (is_numeric($section->updated_at)) ? date('Y-m-d h:i', $section->updated_at) : $section->updated_at }}</small>
	</td>
	@endif

	@if(in_array('link', $listing_columns))
	<td style="vertical-align: middle;">
		<small>{{ $section->link }}</small>
	</td>
	@endif

	<td style="vertical-align: middle;">
		<div class="btn-group">

			<a 
				id="go_to_btn_section_{{ $section->id }}"
				class="btn btn-small" 
				href="{{ action('admin.sections.home@edit', array($section->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word', $section->title)) }}"
			>
				<i class="icon-edit icon-large"></i>
			</a> 

			<button 
				id="ajax_delete_{{ $section->id }}"
				class="btn btn-small"
				type="button"
				data-post="{{ e('{ "id": "'.$section->id.'", "delete": "delete"}') }}"
				data-link="{{ action('admin.sections.action@delete') }}"
				data-message="{{ e(__('forms.delete_warning', array('item' => $section->title))) }}"
				data-out="section_row_{{ $section->id }}"
				data-out-popup="true"
				data-remove="section_row_{{ $section->id }}"
				data-prevent-follow="true"
			>
				<i class="icon-trash icon-large red"></i>
			</button>
		</div>
	</td>
</tr>
@endforeach

@if($section->order < $section->max_order)
<tr id="load_more_{{ $lang_key }}_row">
	<td colspan="100" style="padding:0px">
		<button
			id="ajax_load_more_{{ $lang_key }}_table"
			class="btn btn-block btn-inverse"
			type="button"
			data-link="{{ action('admin.sections.home@load_more') }}?section={{ $lang_key }}&page={{ $page_num + 1 }}&show={{ $take }}"
			data-out="{{ $lang_key }}_table"
			data-append="true"
			data-prevent-follow="true"
			data-remove="load_more_{{ $lang_key }}_row"
		>
			{{ __('content.load_more_word') }}
		</button>
	</td>
</tr>
@endif