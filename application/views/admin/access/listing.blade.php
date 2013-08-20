@layout('admin.access.template')

<h3>
	<i class="icon-key"></i> {{ __('content.access_levels') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			href="{{ action('admin.access.home@new') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.access_levels', 'content.add_new_word')) }}"
			id="go_to_new_acess"
			class="btn"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>
</div>

@section('access')
	
	<h2>{{ __('access.useraccess') }}</h2>

	@if($useraccess)

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th style="width:10%">
						{{ __('forms.access_word') }}
					</th>
					<th style="width:85%">
						{{ __('forms.description_word') }}
					</th>
					<th style="width:5%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($useraccess as $id => $access)

				<tr id="useraccess_row_{{ $access->id }}">
					<td style="vertical-align: middle;">
						<span class="label label-inverse">{{ $access->level }}</span>
					</td>
					<td style="vertical-align: middle;">
						<small>{{ (Lang::has('useraccess.'.$access->name)) ? __('useraccess.'.$access->name) : $access->name }}</small>
					</td>
					<td style="vertical-align: middle;">
						<div class="btn-group">
							<a 
								id="go_to_edit_{{ $access->name }}"
								class="btn btn-small"
								href="{{ action('admin.access.home@edit', array('useraccess', $access->id)) }}"
							>
								<i class="icon-edit icon-large"></i>
							</a>
							<button 
								id="ajax_delete_useraccess_{{ $access->id }}" 
								class="btn btn-small"
								type="button"
								data-link="{{ action('admin.access.action@delete') }}"
								data-post="{{ e('{ "id": "'.$access->id.'", "access": "useraccess", "delete": "delete"}') }}"
								data-message="{{ e(__('forms.delete_warning', array('item' => $access->name))) }}"
								data-prevent-follow="true"
								data-out="useraccess_row_{{ $access->id }}"
								data-out-popup="true"
								data-remove="useraccess_row_{{ $access->id }}"
							>
								<i class="icon-trash icon-large red"></i>
							</button>
						</div>
					</td>
				</tr>

				@endforeach
			</tbody>
		</table>

	@else

		<div class="well">
			No User's access levels created yet
		</div>

	@endif

	<div class="well well-small">
		{{ __('access.useraccess_annotation') }}
	</div>

	<hr>

	<h2>{{ __('access.adminaccess') }}</h2>

	@if($adminaccess)
	
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th style="width:10%">
						{{ __('forms.access_word') }}
					</th>
					<th style="width:85%">
						{{ __('forms.description_word') }}
					</th>
					<th style="width:5%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($adminaccess as $id => $access)

				<tr id="adminaccess_row_{{ $access->id }}">
					<td style="vertical-align: middle;">
						<span class="label label-inverse">{{ $access->level }}</span>
					</td>
					<td style="vertical-align: middle;">
						<small>{{ __('adminaccess.'.$access->name) }}</small>
					</td>
					<td style="vertical-align: middle;">
						<div class="btn-group">
							<a 
								id="go_to_edit_{{ $access->name }}"
								class="btn btn-small"
								href="{{ action('admin.access.home@edit', array('adminaccess', $access->id)) }}"
							>
								<i class="icon-edit icon-large"></i>
							</a>
							<button 
								id="ajax_delete_adminaccess_{{ $access->id }}" 
								class="btn btn-small"
								type="button"
								data-link="{{ action('admin.access.action@delete') }}"
								data-post="{{ e('{ "id": "'.$access->id.'", "access": "adminaccess", "delete": "delete"}') }}"
								data-message="{{ e(__('forms.delete_warning', array('item' => $access->name))) }}"
								data-prevent-follow="true"
								data-out="adminaccess_row_{{ $access->id }}"
								data-out-popup="true"
								data-remove="adminaccess_row_{{ $access->id }}"
							>
								<i class="icon-trash icon-large red"></i>
							</button>
						</div>
					</td>
				</tr>

				@endforeach
			</tbody>
		</table>

	@else
		<div class="well">
			No Admin's access levels created yet
		</div>
	@endif
	
	<div class="well well-small">
		{{ __('access.adminaccess_annotation') }}
	</div>

@endsection