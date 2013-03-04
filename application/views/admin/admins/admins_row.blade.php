<? 
	$json_delete = '{ "id": "'.$admin->id.'", "delete": "delete"}';
	$json_save = '{ "id": "'.$admin->id.'", "name": "\'+encodeURI($(\'#name_'.$admin->id.'\').val())+\'", "password": "\'+encodeURI($(\'#password_'.$admin->id.'\').val())+\'", "access": "\'+$(\'#access_'.$admin->id.'\').val()+\'", "email": "\'+encodeURI($(\'#email_'.$admin->id.'\').val())+\'" }';
?>
<tr>
	<td>
		<input id="name_{{ $admin->id }}" class="input" type="text" value="{{ $admin->name }}" />
	</td>
	<td>
		<input id="password_{{ $admin->id }}" class="input" type="password" value="" placeholder="Type new password" />
	</td>
	<td>
		<input id="access_{{ $admin->id }}" class="input input-mini" maxlength="3" min="1" max="777" type="number" value="{{ $admin->access }}" />
	</td>
	<td>
		<input id="email_{{ $admin->id }}" class="input" type="email" value="<? if(isset($admin->email)){ echo $admin->email; } ?>" />
	</td>
	<td>
		<div class="btn-group">
			<button 
				id="edit_{{ $admin->id }}"
				class="btn" 
				onclick="showerp('{{ htmlspecialchars($json_save) }}', '../admin/admins_action/save', 'edit_{{ $admin->id }}', 'work_area', false, true)"
			>
					<i class="icon-save" style="color:#5bb75b"></i>
			</button> 
			<button 
				id="delete_{{ $admin->id }}"
				class="btn btn-danger"  
				onclick="showerp_alert('{{ htmlspecialchars($json_delete) }}','../admin/admins_action/delete', 'delete_{{ $admin->id }}', 'work_area', '{{ htmlspecialchars(sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), $admin->name )) }}', false, true)">
					<i class="icon-trash icon-large"></i>
			</button> 
		</div>
	</td>
</tr>
@if(isset(${'error'.$admin->id}))
	{{ ${'error'.$admin->id} }}
@endif