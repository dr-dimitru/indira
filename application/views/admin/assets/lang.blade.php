<ul id="admin_lang_bar" class="nav pull-right">

    @if(count(Config::get('application.languages')) > 1)
    	<li class="divider-vertical"></li>
    	<li class="dropdown">
			<a href="#" class="dropdown-toggle icon" data-toggle="dropdown">
				<i class="icon-fixed-width icon-2x icon-globe"></i>
			</a>
			<ul class="dropdown-menu">
				<li class="nav-header striked">
					<hr>
					<span>{{ __('content.language_word') }}</span>
				</li>

		@foreach(Indira::get('language') as $key => $value)

		    @if(Session::get('lang') == $key)

				<li class="active">
					<a 
						id="go_to_lang_{{ $key }}"
						href="{{ (isset($url_for_langbar)) ? URL::to($url_for_langbar, null, false, $key) : URL::to_language($key) }}"
					>
						{{ $value["params"]["text"] }}
					</a>
				</li>

		    @else

				<li>
					<a 
						id="go_to_lang_{{ $key }}"
						href="{{ (isset($url_for_langbar)) ? URL::to($url_for_langbar, null, false, $key) : URL::to_language($key) }}"
					>
						{{ $value["params"]["text"] }}
					</a>
				</li>

		    @endif

			<?php unset($key, $value); ?>
		@endforeach
			
			</ul>
		</li>
	@endif
</ul>