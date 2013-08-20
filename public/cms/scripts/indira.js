// Specify your own
var loading_element = '<i class="icon-cog icon-2x icon-spin"></i>';

// Bind onclick event to all matched DOM-objects
$(function(){
	ajaxify();
});

// Binds 'click' on anchor elements with ids started with go_to_, on buttons with ids or class started with ajax_
function ajaxify(){

	$('a[id^="go_to_"], [id^="ajax_"], button[class^="ajax_"], [data-ajaxify="true"]').unbind('click.link').bind('click.link', function(event){

		event.stopPropagation();
		event.preventDefault();

		var load_el, out_el, q, link, title, append, restore, remove, popup_out, field_name;

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

		if($(this).attr('data-remove')){
			remove = $(this).attr('data-remove');
		}else{
			remove = false;
		}

		if($(this).attr('data-restore')){
			restore = $(this).attr('data-restore');
		}else{
			restore = true;
		}

		if($(this).attr('data-encode')){
			encode = $(this).attr('data-encode');
		}else{
			encode = true;
		}

		if($(this).attr('data-out')){
			out_el = $(this).attr('data-out');
		}else{
			out_el = 'work_area';
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

		if($(this).attr('data-out-popup')){
			
			if($(this).attr('data-out-popup') == 'true'){

				popup_out = true;

			}else{

				popup_out = $(this).attr('data-out-popup');
			}

		}else{
			popup_out = false;
		}

		if($(this).attr('data-title')){
			title = $(this).attr('data-title');
		}else{
			title = '';
		}

		if($(this).attr('data-file-field')){
			field_name = $(this).attr('data-file-field');
		}else{
			field_name = '';
		}

		if($(this).attr('data-form-name')){
			form_name = $(this).attr('data-form-name');
		}else{
			form_name = '';
		}

		if($(this).attr('data-prevent-follow') !== 'true'){

				if(edited == true){

					var changes_confirm_message = confirm('Changes is not saved, leave this page?');
						
					if(changes_confirm_message == false){

						return false;
					}
				}

			History.pushState({query:q, load_element:load_el, out_element:out_el, msg:message, appnd:append, rstr:restore, enc:encode, popup:popup_out},title, link);

		}else{

			if(field_name){

				file_upload(link, load_el, out_el, append, restore, remove, popup_out, field_name, form_name, false);

			}else if(message){

				showerp_alert(q, link, load_el, out_el, message, append, restore, encode, remove, popup_out, false);

			}else if(q){
				
				showerp(q, link, load_el, out_el, append, restore, encode, remove, popup_out, false);
			
			}else{

				shower(link, load_el, out_el, append, restore, remove, popup_out, false);

			}
		}
		
		return false;
	});

}

/**
* Used for back and forward browser navigation in case of AJAX powered links and site navigation.
* Using State.data array defines previously used function and invokes in again.
*
* @param 	string 		State.data.query
* @param 	string 		State.url
* @param 	string 		State.data.load_element
* @param 	string 		State.data.out_element
* @param 	string 		State.data.msg
* @param 	boolean 	State.data.appnd
* @param 	boolean 	State.data.rstr
* @param 	boolean 	tate.data.enc
* @param 	string 		State.data.popup
*
*/
History.Adapter.bind(window,'statechange',function(){ 

    var State = History.getState();   
    if(State.data.msg){
    	
    	showerp_alert(State.data.query, State.url, State.data.load_element, State.data.out_element, State.data.msg, State.data.appnd, State.data.rstr, State.data.enc, false, State.data.popup, false);  

    }else if(State.data.query){

    	showerp(State.data.query, State.url, State.data.load_element, State.data.out_element, State.data.appnd, State.data.rstr, State.data.enc, false, State.data.popup, false);

    }else{

    	shower(State.url, State.data.load_element, State.data.out_element, State.data.appnd, State.data.rstr, false, State.data.popup, false);
    }
});

/**
* Shower loads page (var p) via GET method.
*
* @param 	string 		p
* @param 	string 		load_el
* @param 	string 		out_el
* @param 	boolean 	append
* @param 	boolean 	restore
* @param 	string 		remove
* @param 	string 		popup_out
* @param 	function 	callback
*
*/
function shower(p, load_el, out_el, append, restore, remove, popup_out, callback){
	restore = eval(restore);

	var prev_load_el = $('#'+load_el).html();

	$.ajax({
	  type: "GET",
	  url: p,
	}).done(function( html ) {

		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}

		if(append == 'prepend')
		{
			$('#'+out_el).prepend(html);
		}
		else if(append == 'true'){

			$('#'+out_el).append(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}

		if(remove)
		{
			$('#'+remove).remove();
		}


		if(popup_out)
		{
			if(popup_out == 'true'){
				$.gritter.add({text: html});
			}
			else
			{
				$.gritter.add({text: popup_out});
			}
		}

		ajaxify();

		if(callback){

			return callback()
		}
	}).fail(function(jqXHR, textStatus){

		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}
	});
	
	$('#'+load_el).html(loading_element);
}


/**
* Showerp loads page (var p) and passing data specified in (var q) via POST method.
*
* @param 	string 		q
* @param 	string 		p
* @param 	string 		load_el
* @param 	string 		out_el
* @param 	boolean 	append
* @param 	boolean 	restore
* @param 	boolean 	encode
* @param 	string 		remove
* @param 	string 		popup_out
* @param 	function 	callback
*
*/
function showerp(q, p, load_el, out_el, append, restore, encode, remove, popup_out, callback){
	restore = eval(restore);

	if(!encode){
		encode = true;
	}else{
		encode = eval(encode);
	}
	
	var prev_load_el = $('#'+load_el).html();

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
		
		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}

		if(append == 'prepend')
		{
			$('#'+out_el).prepend(html);
		}
		else if(append == 'true'){

			$('#'+out_el).append(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}

		if(remove)
		{
			$('#'+remove).remove();
		}

		if(popup_out)
		{
			if(popup_out === true){
				$.gritter.add({text: html});
			}
			else
			{
				$.gritter.add({text: popup_out});
			}
		}

		ajaxify();

		if(callback){

			return callback()
		}
	}).fail(function(jqXHR, textStatus){

		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}
	});

	$('#'+load_el).html(loading_element);
}

/**
* Showerp_alert loads page (var p), passing data specified in (var q) 
* and before send ajax request invokes alert() function with (var message) via POST method.
*
* @param 	string 		q
* @param 	string 		p
* @param 	string 		load_el
* @param 	string 		out_el
* @param 	string 		message
* @param 	boolean 	append
* @param 	boolean 	restore
* @param 	boolean 	encode
* @param 	string 		remove
* @param 	string 		popup_out
* @param 	function 	callback
*
*/
function showerp_alert(q, p, load_el, out_el, message, append, restore, encode, remove, popup_out, callback){
	restore = eval(restore);

	if(!encode){
		encode = true;
	}else{
		encode = eval(encode);
	}
	
	
	var message = confirm(message);
	if (message == true)
	{
		if(encode)
		{
			q = eval('(' + q + ')');
			q = JSON.stringify(q);
			q = q.replace(/\n/g, '<br>');
			q = 'data='+encodeURIComponent(q);
		}
		
		var prev_load_el = $('#'+load_el).html();

		$.ajax({
		  type: "POST",
		  url: p,
		  data: q,
		}).done(function( html ) {

			if(restore)
			{
				$('#'+load_el).html(prev_load_el);
			}
			
			if(append == 'prepend')
			{
				$('#'+out_el).prepend(html);
			}
			else if(append == 'true'){

				$('#'+out_el).append(html);
			}
			else
			{
				$('#'+out_el).html(html);
			}

			if(remove)
			{
				$('#'+remove).remove();
			}

			if(popup_out)
			{
				if(popup_out === true){
					$.gritter.add({text: html});
				}
				else
				{
					$.gritter.add({text: popup_out});
				}
			}

			ajaxify();

			if(callback){

				return callback()
			}

		}).fail(function(jqXHR, textStatus){

			if(restore)
			{
				$('#'+load_el).html(prev_load_el);
			}
		});
	
		$('#'+load_el).html(loading_element);
	}
}

/**
* file_upload uploads file (var p), passing data specified in FormData($('#field_name')[0])
*
* @param 	string 		p
* @param 	string 		load_el
* @param 	string 		out_el
* @param 	boolean 	append
* @param 	boolean 	restore
* @param 	boolean 	encode
* @param 	string 		remove
* @param 	string 		popup_out
* @param 	string 		field_name
* @param 	function 	callback
*
*/
function file_upload(p, load_el, out_el, append, restore, remove, popup_out, field_name, form_name, callback){
	
	restore = eval(restore);
	
	var prev_load_el = $('#'+load_el).html();

	var fd = new FormData();    
	fd.append( form_name, $("#" + field_name)[0].files[0] );

	$.ajax({
	  type: "POST",
	  url: p,
	  data: fd,
	  processData: false,
	  contentType: false,
	}).done(function( html ) {

		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}
		
		if(append == 'prepend')
		{
			$('#'+out_el).prepend(html);
		}
		else if(append == 'true'){

			$('#'+out_el).append(html);
		}
		else
		{
			$('#'+out_el).html(html);
		}

		if(remove)
		{
			$('#'+remove).remove();
		}

		if(popup_out)
		{
			if(popup_out === true){
				$.gritter.add({text: html});
			}
			else
			{
				$.gritter.add({text: popup_out});
			}
		}

		ajaxify();

		if(callback){

			return callback()
		}

	}).fail(function(jqXHR, textStatus){

		if(restore)
		{
			$('#'+load_el).html(prev_load_el);
		}
	});

	$('#'+load_el).html(loading_element);
}