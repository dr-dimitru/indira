<hr>
<div class="container">
<footer style="text-align:center">
	<h6>{{ Lang::line('content.footer_sign')->get(Session::get('lang')) }}</h6>
	{{ Lang::line('content.footer_text')->get(Session::get('lang')) }}
	
	<div class="footer" style="text-align:left; font-weight: 100; font-size: 10px;">
	<hr>
		<p>Code licensed under the 
		{{ HTML::link('http://www.apache.org/licenses/LICENSE-2.0', 'Apache License v2.0', array('target' => '_blank')) }}. 
		Documentation licensed under 
		{{ HTML::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0', array('target' => '_blank')) }}.</p>
		<p>Код распространяется под лицензией {{ HTML::link('http://www.apache.org/licenses/LICENSE-2.0', 'Apache License v2.0', array('target' => '_blank')) }}.
		 Документация распространяется под лицензией {{ HTML::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0', array('target' => '_blank')) }}.</p>
	</div>
	
	{{ HTML::script('js/bootstrap.min.js') }}
	<script>
		$('a').tooltip();
	</script>
</footer>
</div>


@if(Config::get('application.google_analytics'))

<script>
  var _gaq=[['_setAccount','{{ Config::get('application.google_analytics') }}'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

@endif
<!--
Copyright 2012 Veliov Group: Dmitriy A. Golev

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
-->