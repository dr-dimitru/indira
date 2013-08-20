@yield('media')

{{ HTML::script('cms/scripts/vendor/jquery.filedrop.js') }}
{{ HTML::script('cms/scripts/uploader.js') }}
{{ HTML::script('cms/scripts/vendor/jquery.lazyload.min.js') }}
<script type="text/javascript">
	$(document).ready(function() {

		var container = window;

		if($(".scroll-y").length !== 0){ 

			container = $(".scroll-y");
		}

		$("img.lazy").lazyload({
			effect: "fadeIn",
			container: container
		});
	});
</script>