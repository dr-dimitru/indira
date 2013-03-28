@layout('admin.sections.template')

<h3>{{ Lang::line('content.sections_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="{{ URL::to('admin/section_area/new') }}" 
			id="go_to_new_section"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
				<i class="icon-plus" style="color: #5bb75b"></i> {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
		</a>
	</small>
</h3>
<hr>
@section('sections')
	<table class="table table-condensed table-bordered table-hover">
		<thead>
			<tr>
				<th>
					{{ Lang::line('content.title_word')->get(Session::get('lang')) }}
				</th>
				<th style="width: 140px">
					{{ Lang::line('content.language_word')->get(Session::get('lang')) }}
				</th>
				<th style="width: 100px">
					{{ Lang::line('content.action_word')->get(Session::get('lang')) }}
				</th>
			</tr>
		</thead>
		<tbody>
	@if($sections)
		@foreach ($sections as $section)
			<? 
				$json_delete = '{ "id": "'.$section->id.'", "delete": "delete"}';
			?>
				<tr>
					<td>
						<a 	
							id="go_to_section_{{ $section->id }}" 
							href="{{ URL::to('admin/section_area/'.$section->id) }}" 
							data-out="work_area"
							data-title="Indira CMS · {{ Lang::line('content.sections_word')->get(Session::get('lang')) }} · {{ $section->title }}"
						>
							{{ $section->title }}
						</a>
					</td>
					<td>
						<span class="badge badge-info">{{ $section->lang }}</span>
					</td>
					<td>
						<div class="btn-group">
							<a 
								id="go_to_btn_section_{{ $section->id }}"
								href="{{ URL::to('admin/section_area/'.$section->id) }}" 
								data-out="work_area"
								data-title="Indira CMS · {{ Lang::line('content.sections_word')->get(Session::get('lang')) }} · {{ $section->title }}"
								class="btn" 
							>
									<i class="icon-edit icon-large"></i>
							</a> 
							<button 
								id="delete_{{ $section->id }}"
								class="btn btn-danger"  
								onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','{{ URL::to('admin/section_area/delete') }}', 'delete_{{ $section->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes($section->title) )) }}')">
									<i class="icon-trash icon-large"></i>
							</button> 
						</div>
					</td>
				</tr>
		@endforeach
	@else
		<tr>
			<td colspan="3">
				<h6>No Sections | Please create a section</h6>
			</td>
		</tr>
	@endif
		</tbody>
	</table>
@endsection