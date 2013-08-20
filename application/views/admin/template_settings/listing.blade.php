@layout('admin.template_settings.template')

<h3>
	<i class="icon-columns"></i> {{ __('template_settings.template_settings') }} 
</h3>

<hr>

@section('template_settings')

	<div class="well" id="templates_control_panel">

		@include('admin.template_settings.control_panel')

	</div>
	
	<table class="table table-condensed table-bordered table-hover">
		<thead>
			<tr>
				<th style="width:94%">
					{{ __('template_settings.setting_type_word') }}
				</th>
				<th style="width:6%">
					{{ __('forms.action_word') }}
				</th>
			</tr>
		</thead>
		<tbody>

	@foreach($settings as $group => $rows)

		<tr>
			<td style="vertical-align: middle">
				<a 
					id="go_to_edit_{{ $group }}"
					href="{{ action('admin.template_settings.home@edit', array($group)) }}"
					data-title="{{ Utilites::build_title(array('content.application_name', 'template_settings.template_settings', $group)) }}"
				>
					{{ ucfirst($group) }}
				</a>
			</td>
			<td style="vertical-align: middle">
				<a 
					id="go_to_edit_{{ $group }}"
					class="btn btn-mini"
					href="{{ action('admin.template_settings.home@edit', array($group)) }}"
					data-title="{{ Utilites::build_title(array('content.application_name', 'template_settings.template_settings', $group)) }}"
					title="{{ __('forms.edit_word') }}"
				>
					<i class="icon-edit icon-large"></i>
				</a>
			</td>
		</tr>

	@endforeach

		</tbody>
	</table>

@endsection