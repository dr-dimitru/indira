<div class="admin-editable pages">
	<div class="pull-left" id="status_{{ $page_data->id }}"></div>
	<div class="btn-group pull-right">
		<a
			href="{{ action('admin.pages.home@edit', array($page_data->id)) }}"
			class="btn"
		>
			<i class="icon-lemon"></i>
		</a>
		<button 
			id="ajax_save_button_{{ $page_data->id }}"
			class="btn"
			type="button" 
			onclick="$('.editable').redactor('destroy');"
			data-link="{{ action('admin.pages.action@save') }}" 
			data-post="{{ e('{"id": "'.$page_data->id.'","title":  encodeURI(\''.$page_data->title.'\'),"main":  encodeURI(\''.$page_data->main.'\'),"link":  encodeURI(\''.$page_data->link.'\'),"pattern":  encodeURI(\''.$page_data->pattern.'\'),"access": "'.$page_data->access.'","lang": "'.$page_data->lang.'","content": encodeURI($(\'#page_editor_'.$page_data->id.'\').html())}') }}"
			data-out="status_{{ $page_data->id }}"
			data-load="status_{{ $page_data->id }}"
			data-prevent-follow="true"
		>
			<i class="icon-save"></i>
		</button>
		<button
			type="button"
			class="btn"
			onclick="$('.editable').redactor({air: true});"
		>
			<i class="icon-pencil"></i>
		</button>
		<button
			type="button"
			class="btn"
			onclick="$('.editable').redactor('destroy');"
		>
			<i class="icon-remove-sign"></i>
		</button>
	</div>
</div>