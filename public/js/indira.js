function shower(p, load_el, out_el, append, restore){
	
	if(append || restore)
	{
		var prev_load_el = $('#'+load_el).html();
	}
	
	$.ajax({
	  type: "GET",
	  url: p
	}).done(function( html ) {
		if(append)
		{
			$('#'+load_el).html(prev_load_el);
			$('#'+out_el).append(html);
		}
		else if(restore)
		{
			$('#'+load_el).html(prev_load_el);
			$('#'+out_el).html(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}
	});
	
	
	$('#'+load_el).html(decodeURIComponent($('#loader').val()));
}

function showerp(q, p, load_el, out_el, append, restore){
	
	q = q.replace(/\n/g, '<br>');
	
	if(append || restore)
	{
		var prev_load_el = $('#'+load_el).html();
	}
	
	$.ajax({
	  type: "POST",
	  url: p,
	  data: 'data='+encodeURIComponent(q),
	}).done(function( html ) {
		if(append)
		{
			$('#'+load_el).html(prev_load_el);
			$('#'+out_el).append(html);
		}
		else if(restore)
		{
			$('#'+load_el).html(prev_load_el);
			$('#'+out_el).html(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}
	});

	$('#'+load_el).html(decodeURIComponent($('#loader').val()));
}

function showerp_alert(q, p, load_el, out_el, message, append){
	var message = confirm(message);
	if (message==true)
	{
		q = q.replace(/\n/g, '<br>');
		
		if(append)
		{
			var prev_load_el = $('#'+load_el).html();
		}
		
		$.ajax({
		  type: "POST",
		  url: p,
		  data: 'data='+encodeURIComponent(q),
		}).done(function( html ) {
			if(append)
			{
				$('#'+load_el).html(prev_load_el);
				$('#'+out_el).append(html);
			}
			else
			{
				$('#'+out_el).html(html);
			}
		});
	
		$('#'+load_el).html(decodeURIComponent($('#loader').val()));
	}
}