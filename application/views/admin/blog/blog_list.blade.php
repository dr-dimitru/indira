@layout('admin.blog.template')

<h3>{{ Lang::line('content.post_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="#" 
			id="new_post"
			onclick="shower('../admin/blog_area/new', 'new_post', 'work_area', false, true)"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
				<i class="icon-plus" style="color: #5bb75b"></i> {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
		</a>
	</small>
</h3>
<hr>
	@if($posts)
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th>
						{{ Lang::line('content.title_word')->get(Session::get('lang')) }}
					</th>
					<th>
						{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}
					</th>
					<th>
						{{ Lang::line('content.tags_word')->get(Session::get('lang')) }}
					</th>
					<th>
						{{ Lang::line('content.action_word')->get(Session::get('lang')) }}
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($posts as $post)
					<? 
						$post_tags = explode(",", $post->tags); 
						$json_delete = '{ "id": "'.$post->id.'", "delete": "delete"}';
					?>
						<tr>
							<td>
								<a id="go_to_blog_{{ $post->id }}" href="#" onclick="showerp('{{ $post->id }}', '../admin/blog_area', 'go_to_blog_{{ $post->id }}', 'work_area', false)">{{ $post->title }}</a>
							</td>
							<td>
								<span class="badge badge-info">{{ $post->access }}</span>
							</td>
							<td>
								@foreach($post_tags as $tag)
									<span class="label">{{ $tag }}</span>
								@endforeach
							</td>
							<td>
								<div class="btn-group">
									<button 
										id="edit_{{ $post->id }}"
										class="btn" 
										onclick="showerp('{{ $post->id }}', '../admin/blog_area', 'edit_{{ $post->id }}', 'work_area', false, true)"
									>
											<i class="icon-edit icon-large"></i>
									</button> 
									<a href="{{ URL::to('/blog/'.$post->id.'?edit=true') }}" class="btn btn-inverse"><i class="icon-lemon" style="color: rgb(255, 194, 0);"></i></a>
									<button 
										id="delete_{{ $post->id }}"
										class="btn btn-danger"  
										onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','../admin/blog_area/delete', 'delete_{{ $post->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), $post->title )) }}', false, true)">
											<i class="icon-trash icon-large"></i>
									</button> 
								</div>
							</td>
						</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Posts in Blog yet</h6>
			<h6>Please create your first post</h6>
		</div>
	@endif