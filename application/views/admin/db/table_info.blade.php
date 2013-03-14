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
						edit
					</td>
					<td>
						<button 
							id="delete_row_{{ $value->id }}" 
							class="btn btn-danger btn-mini"
							onclick="showerp_alert('', '{{ URL::to('') }}')"
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
	</div>
</div>