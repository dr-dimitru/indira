@__yield('filedb')
<script type="text/javascript">
	$("input[id^='table_name_']").keypress(function(event){

	    var key = event.which;

	    if(97 <= key && key <= 122)
	        return true;

	    return false;
	});

	$("input[id$='_name']").keypress(function(event){

	    var key = event.which;

	    if(key == 95)
	    	return true;
	    if(97 <= key && key <= 122)
	        return true;

	    return false;
	});
</script>