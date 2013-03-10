@layout('admin.admins.template')

<h3>{{ Lang::line('content.admins_word')->get(Session::get('lang')) }} 
	<small>
		<a 
			href="{{ URL::to('admin/admins/new') }}"
			data-title="Indira CMS · {{ Lang::line('content.admins_word')->get(Session::get('lang')) }} · {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}" 
			id="go_to_new_admins"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-plus" style="color: #5bb75b"></i> {{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
		</a>
	</small>
</h3>
<hr>
@section('admins')
	<? 
		$admins = Admin::all(); 
	?>
	@if($admins)
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
		@foreach ($admins as $admin)
		<?
			if(Admin::check() != 777 && isset($admin->email)){

				list($uemail, $domen) = explode("@", $admin->email);
				$admin->email = "******@".$domen;

			}
		?>
				@include('admin.admins.admins_row')
		@endforeach
			</tbody>
		</table>
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Admins</h6><br>
		</div>
	@endif
@endsection