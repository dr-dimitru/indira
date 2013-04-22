@yield('uploader')

{{ HTML::script('js/jquery.filedrop.js') }}
{{ HTML::script('js/uploader.js') }}
{{ HTML::script('js/jquery.lazyload.min.js') }}
<script type="text/javascript">
	$("img.lazy").lazyload();
</script>