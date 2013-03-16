@layout('admin.db.template')

<h3>
	{{ $table_name }} 
	<small>
		<button 
			id="back"
			onclick="History.back()"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-chevron-left"></i> {{ Lang::line('content.go_back')->get(Session::get('lang')) }}
		</button>

		<button 
			id="update_db_{{ $table_name }}"
			onclick="shower('{{ URL::to('admin/db/update/'.$table_name) }}', 'update_db_{{ $table_name }}', 'work_area', false, false);"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-refresh"></i>  {{ Lang::line('content.update_db')->get(Session::get('lang')) }}
		</button>
	</small>
</h3>
<hr>
<div class="row-fluid">
	<div class="span12">
		@if($table)
		<table class="table table-bordered">
			<thead>
				<tr>
					@foreach($table as $value1)@endforeach
							<th colspan="2">
								{{ Lang::line('content.action_word')->get(Session::get('lang')) }}
							</th>
						@foreach($value1 as $key => $row_value)
							<th>{{ $key }}</th>
						@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($table as $value)
				<tr>
					<td>
						<a
							href="{{ URL::to('admin/db/edit/'.$table_name.'/'.$value->id) }}" 
							id="go_to_edit_row_{{ $value->id }}" 
							class="btn btn-mini"
							data-title="Indira CMS · File DB · {{ Lang::line('content.edit_word')->get(Session::get('lang')) }} · {{ $table }}"
						>
							<i class="icon-edit icon-large"></i> {{ Lang::line('content.edit_word')->get(Session::get('lang')) }}
						</a>
					</td>
					<td>
						<?php
							$json_delete = '{ "id": "'.$value->id.'", "table": "'.$table_name.'", "delete": "delete"}';
						?>
						<button 
							id="delete_row_{{ $value->id }}" 
							class="btn btn-danger btn-mini"
							onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}', '{{ URL::to('admin/db/delete') }}', 'delete_row_{{ $value->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), $value->id )) }}', false, true)"
						>
							 <i class="icon-trash icon-large"></i> {{ Lang::line('content.delete_word')->get(Session::get('lang')) }}
						</button>
					</td>
					@foreach($value as $key => $row_value)
					<td class="ellipsis">{{ substr(strip_tags($value->$key), 0, 100) }}</td>
					@endforeach
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<center>
			<h6>No records in "{{ $table_name }}" table</h6>
		</center>
		@endif
	</div>
</div>