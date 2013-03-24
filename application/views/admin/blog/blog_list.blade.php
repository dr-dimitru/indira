@layout('admin.blog.template')

<h3>{{ Lang::line('content.post_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="{{ URL::to('admin/blog_area/new') }}" 
			id="go_to_new_post"
			data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}"
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
					<?php 
						$post_tags = explode(",", $post->tags); 
						$json_delete = '{ "id": "'.$post->id.'", "delete": "delete"}';
						$json_pub = '{ "id": "'.$post->id.'" }';
					?>
						<tr>
							<td>
								@if($post->published == 0)
								<sup>
									<font class="h6">{{ Lang::line('content.unpublished')->get(Session::get('lang')) }}</font>
								</sup>
								@endif
								<a 	id="go_to_post_{{ $post->id }}" 
									href="{{ URL::to('/admin/blog_area/'.$post->id) }}" 
									data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ $post->title }}"
								>{{ $post->title }}</a>


								<button 
									id="pub_{{ $post->id }}"
									class="btn btn-mini"  
									onclick="showerp('{{ htmlspecialchars($json_pub) }}','{{ URL::to('admin/blog_area/publish') }}', 'pub_{{ $post->id }}', 'work_area', false, true)">
										@if($post->published == 1)
											<i class="icon-minus-sign"></i>
											{{ Lang::line('content.unpublish')->get(Session::get('lang')) }}
										@else
											<i class="icon-cloud-upload"></i>
											{{ Lang::line('content.publish')->get(Session::get('lang')) }}
										@endif
								</button> 
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
									<a 	id="go_to_btn_post_{{ $post->id }}" 
										href="{{ URL::to('/admin/blog_area/'.$post->id) }}" 
										class="btn" 
										data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }} · {{ $post->title }}" 
									>
											<i class="icon-edit icon-large"></i>
									</a> 
									<a href="{{ URL::to('/blog/'.$post->id.'?edit=true') }}" class="btn btn-inverse"><i class="icon-lemon" style="color: rgb(255, 194, 0);"></i></a>
									<button 
										id="delete_{{ $post->id }}"
										class="btn btn-danger"  
										onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','{{ URL::to('admin/blog_area/delete') }}', 'delete_{{ $post->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes($post->title) )) }}', false, true)">
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