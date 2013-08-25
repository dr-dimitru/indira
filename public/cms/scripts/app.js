var edited = false;
var changes_confirm_message = true;
var mobile = false;
var change_url = false;

$(function() {
    FastClick.attach(document.body);
});

$(function(){

	if( navigator.userAgent.match(/Android/i)
	 || navigator.userAgent.match(/webOS/i)
	 || navigator.userAgent.match(/iPhone/i)
	 || navigator.userAgent.match(/iPad/i)
	 || navigator.userAgent.match(/iPod/i)
	 || navigator.userAgent.match(/BlackBerry/i)
	 || navigator.userAgent.match(/Windows Phone/i)
	 )
	{
	 	mobile = true;
	}

	if(!mobile){

		var stickyNavTop = $('.navbar').offset().top;  
		  
		var stickyNav = function(){ 
		 
			var scrollTop = $(window).scrollTop();  
			
			if(scrollTop > stickyNavTop)
			{
			    $('.navbar').addClass('sticky');
			} 
			else
			{  
			    $('.navbar').removeClass('sticky');   
			}
		};  
		  
		stickyNav();
		  
		$(window).scroll(function() {  
		    stickyNav();  
		}); 

	}else{

		if(window.navigator.standalone){

			$('body').addClass('iosapp');
		}
	}
});

$(function(){

	var screenBlock = "<div class='screenBlock'></div>";    
	$("body").append(screenBlock);

	if(mobile){

		$(window).bind('orientationchange', function(){

			orientationHandler();
		});

		var iospaddingtop = 65;

		var orientationHandler = function(){

			$('#iosappcontainer').css({"padding-top":iospaddingtop});
			$('#iosappcontainer').height($(window).height() - iospaddingtop);
			$('#body').width($(window).width());
			$('#main_container').css({"min-height": $(window).height() + 40});
		}

		orientationHandler();
	}

	var main = function(){

		if(mobile){

			$('input, textarea, select').focus(function(){$('.navbar').hide();});
			$('input, textarea, select').focusout(function(){$('.navbar').show();});
			$('div.input-block-level[id^="text"]').focus(function(){$('.navbar').hide();});
			$('div.input-block-level[id^="text"]').focusout(function(){$('.navbar').show();});
		}

		$('#admin_nav').find('a[id^="go_to_"]').unbind('click.nav_bar').bind('click.nav_bar', function(event){

			$('#admin_nav').find('.active').removeClass('active');
			$(this).parent('li').addClass('active');
			$(this).parents('[class^="dropdown"]').addClass('active');

		});

		if($('input, textarea, div.input-block-level[id^="text"], select').length !== 0){

			$('input, textarea, div.input-block-level[id^="text"]').on('input', function(){

				edited = true;
			});

			$('select').change(function(){

				edited = true;
			});
		}

		if($('input[id$="_fake_multiselect"]').length !== 0){
			
			$('input[id$="_fake_multiselect"]').unbind('enterKey').bind("enterKey",function(e){

				var id = $(this).attr('data-id');

				if($(this).val().indexOf(',')){

					var add_values = $(this).val().split(',');
				
				}else{

					var add_values = $.trim($(this).val());
				}

				var values = $('#' + id).val().split(',');

				if($(this).val() != '' && jQuery.inArray($(this).val(), values) == -1){

					if($.isArray(add_values)){

						$.each(add_values, function(index, value){

							value = $.trim(value);

							$('#pretty_multiselect_area_' + id).append('<span class="label">' + value + ' <i class="icon-remove" style="cursor: pointer" data-pretty-multiselect="' + value + '" onclick="removePrettyMultiselect($(this), \'' + id + '\')"></i></span> ');

							values.push(value);

						});

					}else{

						$('#pretty_multiselect_area_' + id).append('<span class="label">' + add_values + ' <i class="icon-remove" style="cursor: pointer" data-pretty-multiselect="' + add_values + '" onclick="removePrettyMultiselect($(this), \'' + id + '\')"></i></span> ');

						values.push(add_values);
					}
				}

				values = $(values).map(String.prototype.trim);

				values = jQuery.grep(values, function(value) {

					return value != '';
				});

				var values_string = values.join(',');

				if(values_string.indexOf(',') == 0){
					
					values_string = values_string.substring(1);
				}

				if(values_string.indexOf(',') == (values_string.length - 1)){
					
					values_string = values_string.substring(0, values_string.length - 1);
				}

				$('#' + id).val(values_string);

				$(this).val('');
			});

			$('input[id$="_fake_multiselect"]').keyup(function(e){

				if(e.keyCode == 13)
				{
					$(this).trigger("enterKey");
				}
			});
		}
	}
	main();

	function closeEditorWarning(){

		if(edited == true){
			
			return 'Changes is not saved, leave this page?';
		}
	}

	window.onbeforeunload = closeEditorWarning

	function animate_ajax(){
		
		$('.inner').removeClass('animated bounceInRight');
		$('.inner').addClass('animated bounceOutLeft');
	}

	$(document).ajaxStart(function() {

		$(".screenBlock").fadeIn(100);
	});

	$(document).ajaxComplete(function() {

		edited = false;
		main();
	});

	$(document).ajaxStop(function() {

		$(".screenBlock").fadeOut(100);

		if(change_url){
			$('.inner').removeClass('animated bounceOutLeft');
			$('.inner').addClass('animated bounceInRight');
		}

		change_url = false;
	});

	var langSwitcher = function(){ 

		$('#admin_lang_bar').find('a[id^="go_to_lang_"]').unbind('click.nav_lang_bar').bind('click.nav_lang_bar', function(event){
		
			var href = $(this).attr('href');
	   			
			var uri = href.split(window.location.protocol + "//" + window.location.host + "/").join('');
			var lang = uri.split('/', 1);
			var button_uri = uri.split(lang).join('');

			showerp('{"uri": "' + button_uri + '"}', window.location.protocol + "//" + window.location.host + '/' + lang + "/admin/home/get_navbar", false, 'navbar_container', false, false, false, false, false, function(){

				main();
				langSwitcher();
			});
		});
	}
	langSwitcher();
	

	History.Adapter.bind(window,'statechange',function(){ 

		change_url = true;
		animate_ajax();

   		var State = History.getState();
   			
		var current_uri = State.url.split(window.location.protocol + "//" + window.location.host + "/").join('');
		var current_lang = current_uri.split('/', 1);
		current_uri = current_uri.split(current_lang).join('');

   		$('#admin_lang_bar').find('a[id^="go_to_"]').each(function(){

   			var href = $(this).attr('href');
   			
   			var uri = href.split(window.location.protocol + "//" + window.location.host + "/").join('');
   			var lang = uri.split('/', 1);
   			var newURL = window.location.protocol + "//" + window.location.host + "/" + lang + current_uri;
   			
   			$(this).attr('href', newURL);
   		});
	});
});

function removePrettyMultiselect(obj, id){

	var to_add = obj.attr('data-pretty-multiselect');

	obj.parent().remove();
	var values = $('#' + id).val().split(',');

	values = jQuery.grep(values, function(value) {

		return (value != to_add && value != '');
	});

	var values_string = values.join(',')

	if(values_string.indexOf(',') == 0){
		
		values_string = values_string.substring(1);
	}

	if(values_string.indexOf(',') == (values_string.length - 1)){
					
		values_string = values_string.substring(0, values_string.length - 1);
	}

	$('#' + id).val(values_string);
}