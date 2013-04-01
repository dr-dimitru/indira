@layout('admin.db.template')

<h3>File DB</h3>
<hr>

<div class="row-fluid">
	<div class="span6">
		<h4>{{ Lang::line('content.db_info_title')->get(Session::get('lang')) }}</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Database size</th>
					<th>Total records</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ round(Filedb::get_db_size()/1024,3) }}KB</td>
					<td>{{ Filedb::get_db_records() }}</td>
				</tr>
			</tbody>
		</table>

		<hr>

		<h4>Tables</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Table</th>
					<th>Action</th>
					<th>Records</th>
					<th>Size</th>
				</tr>
			</thead>
			<tbody>
				@foreach(Filedb::get_tables() as $table)
				<tr>
					<td>
						<a 
							href="{{ URL::to('admin/db/'.$table) }}" 
							id="go_to_table_{{ $table }}"
							data-out="work_area"
							data-title="Indira CMS · File DB · {{ $table }}" 
						>
							{{ $table }}
						</a>
					</td>
					<td>
						<a 
							href="{{ URL::to('admin/db/'.$table) }}" 
							id="go_to_table_btn_{{ $table }}" 
							data-out="work_area"
							data-title="Indira CMS · File DB · {{ $table }}" 
							class="btn"
						>
							<i class="icon-search"></i>
						</a>
					</td>
					<td>{{ Filedb::get_table_records($table) }}</td>
					<td>{{ round(Filedb::get_table_size($table)/1024, 3) }}KB</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="span6">
		<div class="well well-small">
			<h6>Thank you using Filedb</h6>
			<p>
				Filedb is noSQL file-oriented database.<br>
				Filedb is based on php files and arrays.<br>
				Filedb is lighter and faster on small projects than other noSQL or SQL DBs<br>
			</p>
			<p>
				We hope you'll enjoy using Filedb as driver for your content, cause:
					<ul>
						<li>When installing Indira CMS you don't need to take care about dumping, exporting, importing, installing, connecting your DB - <strong>Filedb is working out of box</strong> as soon as you upload your project on server.</li>
						<li>Easy dumping or reserve copying content</li>
						<li>JSON ready - All data saved in arrays and already URI (RAW) encoded</li>
						<li>Laravel friendly - Filedb supports all Laravel's fluent queries and Eloquent ready</li>
					<ul>
			</p>
		</div>
	</div>
</div>