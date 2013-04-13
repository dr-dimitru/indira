$(function(){
	ajaxify();
});

function ajaxify(){

	$('a[id^="go_to_"], button[id^="ajax_"], button[class^="ajax_"]').unbind('click.link').bind('click.link', function(event){

		event.stopPropagation();
		event.preventDefault();

		var load_el, out_el, q, link, title, append, restore;

		if($(this).attr('data-load')){
			load_el = $(this).attr('data-load');
		}else{
			load_el = 'super_logo';
		}

		if($(this).attr('data-append')){
			append = $(this).attr('data-append');
		}else{
			append = false;
		}

		if($(this).attr('data-restore')){
			restore = $(this).attr('data-restore');
		}else{
			restore = true;
		}

		if($(this).attr('data-out')){
			out_el = $(this).attr('data-out');
		}else{
			out_el = 'work_area';
		}

		if($(this).attr('data-title')){
			title = $(this).attr('data-title');
		}else{
			title = '';
		}

		if($(this).attr('data-post')){
			q = $(this).attr('data-post');
		}else{
			q = '';
		}

		if($(this).attr('data-message')){
			message = $(this).attr('data-message');
		}

		if($(this).attr('href')){
			link = $(this).attr('href');
		}else{
			link = $(this).attr('data-link');
		}

		if($(this).attr('data-message')){

			showerp_alert(q, link, load_el, out_el, message, append, restore);

		}else if($(this).attr('data-post')){
			
			showerp(q, link, load_el, out_el, append, restore);
		
		}else{

			shower(link, load_el, out_el, append, restore);

		}

		if($(this).attr('data-title')){
			title = $(this).attr('data-title');
		}else{
			title = '';
		}

		if($(this).attr('data-prevent-follow') !== 'true'){

			History.pushState({query:q, load_element:load_el, out_element:out_el, appnd:append, rstr:restore},title,link);

		}
		return false;
	});

}

History.Adapter.bind(window,'statechange',function(){ 
    var State = History.getState();     
    if(State.data.query){
    	showerp(State.data.query, State.url, State.data.load_element, State.data.out_element, State.data.appnd, State.data.rstr);
    }else{
    	shower(State.url, State.data.load_element, State.data.out_element, false, true);
    }
});

function shower(p, load_el, out_el, append, restore){
	append = eval(append);
	restore = eval(restore);

	if(append || restore)
	{
		var prev_load_el = $('#'+load_el).html();
	}
	
	$.ajax({
	  type: "GET",
	  url: p,
	}).done(function( html ) {
		if(append)
		{
			$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
			$('#'+out_el).append(html);
		}
		else if(restore)
		{
			$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
			$('#'+out_el).html(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}
		ajaxify();
	});
	
	
	$('#'+load_el).html('<i class="icon-cog icon-2x icon-spin"></i>');
}

function showerp(q, p, load_el, out_el, append, restore){
	append = eval(append);
	restore = eval(restore);

	q = eval('(' + q + ')');
	q = JSON.stringify(q);
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
			$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
			$('#'+out_el).append(html);
		}
		else if(restore)
		{
			$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
			$('#'+out_el).html(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}
		ajaxify();
	});

	$('#'+load_el).html('<i class="icon-cog icon-2x icon-spin"></i>');
}

function showerp_alert(q, p, load_el, out_el, message, append, restore){
	append = eval(append);
	restore = eval(restore);
	
	var message = confirm(message);
	if (message==true)
	{
		q = eval('(' + q + ')');
		q = JSON.stringify(q);
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
				$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
				$('#'+out_el).append(html);
			}
			else if(restore)
			{
				$('#'+load_el).html('<i class="icon-lemon icon-2x"></i>');
				$('#'+out_el).html(html);
			}
			else
			{
				$('#'+out_el).html(html);
			}
			ajaxify();
		});
	
		$('#'+load_el).html('<i class="icon-cog icon-2x icon-spin"></i>');
	}
}