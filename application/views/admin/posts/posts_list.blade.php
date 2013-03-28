@layout('admin.posts.template')

<h3>{{ Lang::line('content.post_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="{{ URL::to('admin/post_area/new') }}" 
			data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}"
			id="go_to_new_post"
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
							href="{{ URL::to('admin/section_area/'.$section->id) }}" 
							data-title="Indira CMS · {{ Lang::line('content.sections_word')->get(Session::get('lang')) }} · {{ $section->title }}" 
						>
							{{ $section->title }}
						</a>
					</th>
					<th style="width: 160px">
						{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}
					</th>
					<th style="width: 140px">
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
								<a 	id="go_to_post_{{ $post->id }}" 
									href="{{ URL::to('admin/post_area/'.$post->id) }}" 
									data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ $post->title }}"
								>
									{{ $post->title }}
								</a>
							</td>
							<td>
								<span class="badge badge-info">{{ $post->access }}</span>
							</td>
							<td>
								<div class="btn-group">
									<a 	id="go_to_btn_post_{{ $post->id }}" 
										href="{{ URL::to('admin/post_area/'.$post->id) }}" 
										class="btn" 
										data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ $post->title }}"
									>
											<i class="icon-edit icon-large"></i>
									</a> 
									<a href="{{ URL::to('/'.$post->id.'?edit=true') }}" class="btn btn-inverse"><i class="icon-lemon" style="color: rgb(255, 194, 0);"></i></a>
									<button 
										id="delete_{{ $post->id }}"
										class="btn btn-danger"  
										onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','{{ URL::to('admin/post_area/delete') }}', 'delete_{{ $post->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes($post->title) )) }}', false, true)">
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