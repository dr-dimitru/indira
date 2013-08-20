@layout('admin.settings.template')

<h3>
	<i class="icon-cog"></i> {{ __('content.main_settings') }} 
</h3>

<hr>

@section('settings')
	
	<table class="table table-condensed table-bordered table-hover">
		<thead>
			<tr>
				<th style="width:95%">
					{{ __('settings.type_word') }}
				</th>
				<th style="width:5%">
					{{ __('forms.action_word') }}
				</th>
			</tr>
		</thead>
		<tbody>

	@foreach($settings as $group => $rows)

		<tr>
			<td>
				{{ ($group !== 'indira') ? 'Laravel' : 'Application' }}: 
				<a 
					id="go_to_edit_{{ $group }}"
					href="{{ action('admin.settings.home@edit', array($group)) }}"
				>
				 {{ ucfirst($group) }}
				</a>
			</td>
			<td>
				<a 
					id="go_to_btn_edit_{{ $group }}"
					class="btn btn-small"
					href="{{ action('admin.settings.home@edit', array($group)) }}"
					title="{{ __('forms.edit_word') }}"
				>
					<i class="icon-edit icon-large"></i>
				</a>
			</td>
		</tr>

	@endforeach

		</tbody>
	</table>


	<div class="well">
		{{ __('settings.annotation') }}
	</div>
@endsection