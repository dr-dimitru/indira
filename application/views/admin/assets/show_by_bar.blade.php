@if($table_records > 10)
	<div class="pagination">
		<ul>
			<li class="disabled"><a>{{ __('content.show_by_word') }}: </a></li>
			@for ($i=10; $i<=$show_by_limit; $i += $show_by_hop) 
					
				<li class="<?php if(isset(${$table_name.'_by_'.$i.'_disabled'})){ echo ${$table_name.'_by_'.$i.'_disabled'}; } ?>"><a id="go_to_{{ $table_name }}_by_{{ $i }}" href="{{ URL::current() }}?show={{ $i }}">{{ $i }}</a></li>

			@endfor
			@if($table_records > 100)
				@for ($i=100; $i<=500; $i += 100) 
					
					<li class="<?php if(isset(${$table_name.'_by_'.$i.'_disabled'})){ echo ${$table_name.'_by_'.$i.'_disabled'}; } ?>"><a id="go_to_{{ $table_name }}_by_{{ $i }}" href="{{ URL::current() }}?show={{ $i }}">{{ $i }}</a></li>

				@endfor
			@endif
		</ul>
	</div>
@endif