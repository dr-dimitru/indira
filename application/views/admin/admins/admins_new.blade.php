<h3>{{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
	<small>
		<button 
			id="back"
			onclick="History.back()"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-chevron-left"></i> {{ Lang::line('content.go_back')->get(Session::get('lang')) }}
		</button>
	</small>
</h3>
<hr>
<table class="table table-condensed table-bordered table-hover">
	<thead>
		<tr>
			<th>
				{{ Lang::line('content.name_word')->get(Session::get('lang')) }}: 
			</th>
			<th>
				{{ Lang::line('content.password_word')->get(Session::get('lang')) }}
			</th>
			<th>
				{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}
			</th>
			<th>
				Email
			</th>
			<th>
				{{ Lang::line('content.action_word')->get(Session::get('lang')) }}
			</th>
		</tr>
	</thead>
	<tbody>

		<? 
			$json_save = '{ "name": encodeURI($(\'#name_'.$admin->id.'\').val()), "password": encodeURI($(\'#password_'.$admin->id.'\').val()), "access": $(\'#access_'.$admin->id.'\').val(), "email": encodeURI($(\'#email_'.$admin->id.'\').val()) }';
		?>
		<tr>
			<td>
				<input id="name_{{ $admin->id }}" class="input" type="text" value="{{ $admin->name }}" />
			</td>
			<td>
				<input id="password_{{ $admin->id }}" class="input" type="password" value="" placeholder="Type new password" />
			</td>
			<td>
				<input id="access_{{ $admin->id }}" class="input input-mini" maxlength="3" min="1" max="777" placeholder="400" type="number" value="{{ $admin->access }}" />
			</td>
			<td>
				<input id="email_{{ $admin->id }}" class="input" type="email" value="{{ $admin->email }}" />
			</td>
			<td>
				<div class="btn-group">
					<a 	href="{{ URL::to('admin/admins_action/add') }}" 
						id="go_to_edit_{{ $admin->id }}" 
						data-post="{{ htmlspecialchars($json_save) }}" 
						data-out="work_area"
						data-restore="true" 
						data-load="super_logo" 
						data-prevent-follow="true" 
						class="btn" 
					>
							<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
					</a>
				</div>
			</td>
		</tr>
		@if(isset(${'error'.$admin->id}))
			{{ ${'error'.$admin->id} }}
		@endif

	</tbody>
</table>