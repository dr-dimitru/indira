<? 
	$json_delete = '{ "id": "'.$admin->id.'", "delete": "delete"}';
	$json_save = '{ "id": "'.$admin->id.'", "name": encodeURI($(\'#name_'.$admin->id.'\').val()), "password": encodeURI($(\'#password_'.$admin->id.'\').val()), "access": $(\'#access_'.$admin->id.'\').val(), "email": encodeURI($(\'#email_'.$admin->id.'\').val()) }';
?>
<tr class="
@if(isset(${'saved_'.$admin->id}))
	{{ ${'saved_'.$admin->id} }}
@endif
">
	<td>
		<input id="name_{{ $admin->id }}" class="input span12" type="text" value="{{ $admin->name }}" />
	</td>
	<td>
		<input id="password_{{ $admin->id }}" class="input span12" type="password" value="" placeholder="Type new password" />
	</td>
	<td>
		<input id="access_{{ $admin->id }}" class="input span12" maxlength="3" min="1" max="777" type="number" value="{{ $admin->access }}" />
	</td>
	<td>
		<input id="email_{{ $admin->id }}" class="input span12" type="email" value="<? if(isset($admin->email)){ echo $admin->email; } ?>" />
	</td>
	<td>
		<div class="btn-group">
			<a 	href="{{ URL::to('admin/admins_action/save') }}" 
				id="go_to_edit_{{ $admin->id }}" 
				data-post="{{ htmlspecialchars($json_save) }}" 
				data-out="work_area"
				data-restore="true" 
				data-load="super_logo" 
				data-prevent-follow="true" 
				class="btn" 
			>
					<i class="icon-save" style="color:#5bb75b"></i>
			</a> 
			<a 
				class="btn btn-danger" 
				href="{{ URL::to('admin/admins_action/delete') }}" 
				id="go_to_delete_{{ $admin->id }}" 
				data-post="{{ htmlspecialchars($json_delete) }}" 
				data-out="work_area"
				data-restore="true" 
				data-load="super_logo" 
				data-prevent-follow="true" 
				data-message="{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes($admin->name) )) }}"
			>
					<i class="icon-trash icon-large"></i>
			</a> 
		</div>
	</td>
</tr>
@if(isset(${'error'.$admin->id}))
	{{ ${'error'.$admin->id} }}
@endif