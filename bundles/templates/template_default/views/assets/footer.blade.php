<footer class="page-footer">

	<div class="container">

		<span class="h6">
			{{ (Indira::get('contact_email')) ? HTML::mailto(Indira::get('contact_email'), __('templates::content.email_us_word')) : null }}<br />
			{{ date('Y') }} Powered by <a href="http://indira-cms.com">Indira<sup><i class="icon-lemon gold"></i></sup> CMS</a> v.{{ Config::get('indira.indira_version') }}<br />
			© <a href="http://veliovgroup.com">Veliov Group</a> All Rights Reserved and belongs to site owner.
		</span>

		<br>
		
		<div class="footer-logo">
			<i class="icon-lemon icon-3x"></i>
		</div>
	</div>

</footer>

@if($ga_trackcode = Template::where('type', '=', 'google_analytics')->and_where('name', '=', 'tracking_code')->only('value'))

<script>
	var _gaq=[['_setAccount','{{ $ga_trackcode }}'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

@endif