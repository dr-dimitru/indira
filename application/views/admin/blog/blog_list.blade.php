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
					<th style="width: 140px">
						{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}
					</th>
					<th style="width: 200px">
						{{ Lang::line('content.tags_word')->get(Session::get('lang')) }}
					</th>
					<th style="width: 140px">
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


								<a  data-post="{{ htmlspecialchars($json_pub) }}" 
									href="{{ URL::to('admin/blog_area/publish') }}" 
									id="go_to_pub_{{ $post->id }}" 
									data-restore="true" 
									data-out="work_area" 
									data-load="super_logo" 
									data-prevent-follow="true" 
									class="btn btn-mini"  
								>
										@if($post->published == 1)
											<i class="icon-minus-sign"></i>
											{{ Lang::line('content.unpublish')->get(Session::get('lang')) }}
										@else
											<i class="icon-cloud-upload"></i>
											{{ Lang::line('content.publish')->get(Session::get('lang')) }}
										@endif
								</a> 
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

									<a 	href="{{ URL::to('/blog/'.$post->id.'?edit=true') }}" 
										class="btn btn-inverse"
									>
										<i class="icon-lemon" style="color: rgb(255, 194, 0);"></i>
									</a>

									<a  id="go_to_delete_{{ $post->id }}"
										href="{{ URL::to('admin/blog_area/delete') }}" 
										data-post="{{ htmlspecialchars($json_delete) }}" 
										data-restore="true" 
										data-message="{{ sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes($post->title) ) }}" 
										data-out="work_area" 
										data-load="super_logo"
										data-prevent-follow="true" 
										class="btn btn-danger" 
										>
											<i class="icon-trash icon-large"></i>
									</a> 
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