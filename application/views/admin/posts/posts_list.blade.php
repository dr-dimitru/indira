@layout('admin.posts.template')

<h3>{{ Lang::line('content.post_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="#" 
			id="new_post"
			onclick="shower('../admin/post_area/new', 'new_post', 'work_area', false, true)"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
				<i class="icon-plus" style="color: #5bb75b"></i> {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
		</a>
	</small>
</h3>
<hr>
@section('posts')
	<? 
		$sections = Sections::all(); 
	?>
	@if($sections)
		@foreach ($sections as $section)
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th>
						{{ Lang::line('content.section_word')->get(Session::get('lang')) }}: 
						<a 
							id="go_to_section_{{ $section->id }}"
							href="#" 
							onclick="showerp('{{ $section->id }}', '../admin/section_area', 'go_to_section_{{ $section->id }}', 'work_area', false)"
						>
							{{ $section->title }}
						</a>
					</th>
					<th>
						{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}
					</th>
					<th>
						{{ Lang::line('content.action_word')->get(Session::get('lang')) }}
					</th>
				</tr>
			</thead>
			<? 
				$posts = Posts::where('section', '=', $section->id)->get(); 
			?>
			<tbody>
			@if($posts)
				@foreach ($posts as $post)
					<? 
						$post_tags = explode(",", $post->tags); 
						$json_delete = '{ "id": "'.$post->id.'", "delete": "delete"}';
					?>
						<tr>
							<td>
								<a id="go_to_post_{{ $post->id }}" href="#" onclick="showerp('{{ $post->id }}', '../admin/post_area', 'go_to_post_{{ $post->id }}', 'work_area', false)">{{ $post->title }}</a>
							</td>
							<td>
								<span class="badge badge-info">{{ $post->access }}</span>
							</td>
							<td>
								<div class="btn-group">
									<button 
										id="edit_{{ $post->id }}"
										class="btn" 
										onclick="showerp('{{ $post->id }}', '../admin/post_area', 'edit_{{ $post->id }}', 'work_area', false, true)"
									>
											<i class="icon-edit icon-large"></i>
									</button> 
									<a href="{{ URL::to('/'.$post->id.'?edit=true') }}" class="btn btn-inverse"><i class="icon-lemon" style="color: rgb(255, 194, 0);"></i></a>
									<button 
										id="delete_{{ $post->id }}"
										class="btn btn-danger"  
										onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','../admin/post_area/delete', 'delete_{{ $post->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), $post->title )) }}', false, true)">
											<i class="icon-trash icon-large"></i>
									</button> 
								</div>
							</td>
						</tr>
				@endforeach
			@else
				<tr>
					<td colspan="3">
						<h6>No Posts</h6>
					</td>
				</tr>
			@endif
			</tbody>
		</table>
		@endforeach
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Sections</h6><br>
			<h6>Please create Section at first</h6>
		</div>
	@endif
@endsection