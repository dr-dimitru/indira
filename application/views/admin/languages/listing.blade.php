@layout('admin.languages.template')

<h3>
	<i class="icon-globe"></i> {{ __('content.locales') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			href="{{ action('admin.languages.home@new') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.locales', 'content.add_new_word')) }}"
			id="go_to_new_acess"
			class="btn"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>
</div>

@section('languages')
	
	<table class="table table-condensed table-bordered table-hover">
		<thead>
			<tr>
				<th style="width:25%">
					{{ __('content.language_word') }}
				</th>
				<th style="width:15%">
					<a href="http://www.iana.org/assignments/language-subtag-registry" target="_blank">Language Code</a>
				</th>
				<th style="width:25%">
					Language + Region Code
				</th>
				<th style="width:25%">
					{{ __('content.folder_word') }}
				</th>
				<th style="width:10%">
					{{ __('forms.action_word') }}
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($languages as $id => $language)

			<tr id="language_row_{{ $language->id }}">
				<td>
					<a 
						id="go_to_edit_{{ $language->id }}"
						href="{{ action('admin.languages.home@edit', array($language->id)) }}"
					>
						{{ $language->text_lang }}
					</a>
				</td>
				<td>
					<span class="label label-inverse">{{ $language->lang }}</span>
				</td>
				<td>
					<small>{{ $language->ietf }}</small>
				</td>
				<td>
					<code>application/language/{{ $language->lang }}</code>
				</td>
				<td>
					<div class="btn-group">
						<a 
							id="go_to_edit_btn_{{ $language->id }}"
							class="btn btn-small"
							href="{{ action('admin.languages.home@edit', array($language->id)) }}"
						>
							<i class="icon-edit icon-large"></i>
						</a>
						<button 
							id="ajax_delete_language_{{ $language->id }}" 
							class="btn btn-small"
							type="button"
							data-link="{{ action('admin.languages.action@delete') }}"
							data-post="{{ e('{ "id": "'.$language->id.'", "delete": "delete"}') }}"
							data-message="{{ e(__('forms.delete_warning', array('item' => $language->text_lang))) }}"
							data-prevent-follow="true"
							data-out="language_row_{{ $language->id }}"
							data-out-popup="true"
							data-remove="language_row_{{ $language->id }}"
						>
							<i class="icon-trash icon-large red"></i>
						</button>
					</div>
				</td>
			</tr>

			@endforeach
		</tbody>
	</table>
@endsection