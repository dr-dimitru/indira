//Specify your own
var loading_element = '<i class="icon-cog icon-2x icon-spin"></i>';

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

		if($(this).attr('data-encode')){
			encode = $(this).attr('data-encode');
		}else{
			encode = 'true';
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
		}else{
			message = null;
		}

		if($(this).attr('href')){
			link = $(this).attr('href');
		}else{
			link = $(this).attr('data-link');
		}

		if($(this).attr('data-title')){
			title = $(this).attr('data-title');
		}else{
			title = '';
		}

		if($(this).attr('data-prevent-follow') !== 'true'){

			History.pushState({query:q, load_element:load_el, out_element:out_el, msg:message, appnd:append, rstr:restore, enc:encode},title, link);

		}else{

			if(message){

				showerp_alert(q, link, load_el, out_el, message, append, restore, encode);

			}else if(q){
				
				showerp(q, link, load_el, out_el, append, restore, encode);
			
			}else{

				shower(link, load_el, out_el, append, restore, encode);

			}
		}
		
		return false;
	});

}

History.Adapter.bind(window,'statechange',function(){ 
    var State = History.getState();   
    if(State.data.msg){
    	
    	showerp_alert(State.data.query, State.url, State.data.load_element, State.data.out_element, State.data.msg, State.data.appnd, State.data.rstr, State.data.enc);  

    }else if(State.data.query){

    	showerp(State.data.query, State.url, State.data.load_element, State.data.out_element, State.data.appnd, State.data.rstr, State.data.enc);

    }else{

    	shower(State.url, State.data.load_element, State.data.out_element, State.data.appnd, State.data.rstr);
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
		ajaxify();
	});
	
	
	$('#'+load_el).html(loading_element);
}

function showerp(q, p, load_el, out_el, append, restore, encode){
	append = eval(append);
	restore = eval(restore);

	if(!encode){
		encode = true;
	}else{
		encode = eval(encode);
	}
	
	if(append || restore)
	{
		var prev_load_el = $('#'+load_el).html();
	}

	if(encode)
	{
		q = eval('(' + q + ')');
		q = JSON.stringify(q);
		q = q.replace(/\n/g, '<br>');
		q = 'data='+encodeURIComponent(q);
	}
	
	$.ajax({
	  type: "POST",
	  url: p,
	  data: q,
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
		ajaxify();
	});

	$('#'+load_el).html(loading_element);
}

function showerp_alert(q, p, load_el, out_el, message, append, restore, encode){
	append = eval(append);
	restore = eval(restore);

	if(!encode){
		encode = true;
	}else{
		encode = eval(encode);
	}
	
	
	var message = confirm(message);
	if (message==true)
	{
		if(encode)
		{
			q = eval('(' + q + ')');
			q = JSON.stringify(q);
			q = q.replace(/\n/g, '<br>');
			q = 'data='+encodeURIComponent(q);
		}
		
		if(append || restore)
		{
			var prev_load_el = $('#'+load_el).html();
		}
		
		$.ajax({
		  type: "POST",
		  url: p,
		  data: q,
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
			ajaxify();
		});
	
		$('#'+load_el).html(loading_element);
	}
}