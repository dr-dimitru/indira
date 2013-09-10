var edited = false;
var changes_confirm_message = true;
var mobile = false;
var change_url = false;

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

	if(mobile){

		$(window).bind('orientationchange', function(){

			orientationHandler();
		});

		if(window.navigator.standalone){

			$.getScript('/cms/scripts/nativescrolling.js');
			$.getScript('/cms/scripts/vendor/fastclick.js')
				.done(function(script, textStatus) {
				  FastClick.attach(document.body);
				});;

			$('body').addClass('iosapp');

			var iospaddingtop = 14;

			var orientationHandler = function(){

				$('#iosappcontainer').addClass('scroll-y');
				$('#iosappcontainer').css({"padding-top":iospaddingtop, "margin-top":-iospaddingtop});
				$('#iosappcontainer').height($(window).height() - 75);
				$('#sidebar_sections').addClass('scroll-y');
				$('#sidebar_sections').css({"max-height": $(window).height() - 85, "height": $(window).height() - 85});
				$('#sidebar_menu').addClass('scroll-y');
				$('#sidebar_menu').css({"max-height": $(window).height() + 2});
			}

			orientationHandler();
		
		}else{

			var orientationHandler = function(){
				
				$('#body').css({"min-height": $(window).height() + 20 });
			}

			orientationHandler();

			$('head').append('<script type="text/javascript">var addToHomeConfig = {'
						+ 'animationIn: "bubble",'
						+ 'animationOut: "drop",'
						+ 'lifespan:10000,'
						+ 'touchIcon:true,};</script>');

			$.getScript('/cms/scripts/vendor/add2home.js')
				.done(function(script, textStatus) {
				  addToHome.show(addToHomeConfig);
				});
			$('head').append('<link href="/cms/styles/vendor/add2home.css" media="all" type="text/css" rel="stylesheet">');
		}
	}
});

$(function(){

	var screenBlock = "<div class='screenBlock'></div>";    
	$("body").append(screenBlock);

	var closeSidebar = function(){

		$("#show_sidebar").removeClass("active");
		$("#wrapper").removeClass("sidebar-open");
		$("#main_sidebar").removeClass("open");
		$("#wrapper").unbind("click.out_of_sidebar");

		$("#wrapper").bind('webkitTransitionEnd', function(){

			$("#sidebar_wrapper").removeClass("open");
			$("#main_sidebar").addClass("closed");
			$("#wrapper").unbind('webkitTransitionEnd');
		});
	}

	var openSidebar = function(){

		$("#show_sidebar").addClass("active");
		$("#wrapper").addClass("sidebar-open");
		$("#main_sidebar").removeClass("closed");
		$("#main_sidebar").addClass("open");

		$("#wrapper").bind("click.out_of_sidebar", function(){

			closeSidebar();
		})
		
		$("#sidebar_wrapper").addClass("open");
	}

	var start = function(){

		$("#show_sidebar").click(function(event){

			event.stopPropagation();
			event.preventDefault();

			if($(this).hasClass("active")){

				closeSidebar()

			}else{

				openSidebar();
			}
		});

	}
	start();

	var main = function(){

		if($('input, textarea, div.input-block-level[id^="text"], select').length !== 0){

			$('input, textarea, .editable, [contenteditable="true"]').unbind('keypress').bind('keypress', function(){

				edited = true;
			});

			$('select').change(function(){

				edited = true;
			});
		}
	}
	main();


	var sidebarInit = function(){

		$('[id^="sidebar_section_"]').click(function(){

			if($(this).hasClass("active")){

				$(this).removeClass('active');
				$(this).parents('section').removeClass('open');

			}else{

				$(this).addClass('active');
				$(this).parents('section').addClass('open');

			}

		});

		$('[id^="ajax_go_to_"].post-body').click(function(){

			$('[id^="ajax_go_to_"].post-body').removeClass('active');
			$(this).addClass('active');

		});

		$('#main_sidebar a[id^="go_to_"], [id^="ajax_go_to_"].post-body').unbind('click.sidebar_link').bind('click.sidebar_link', function(event){

			closeSidebar();
		});
	}
	sidebarInit();

	function closeEditorWarning(){

		if(edited == true){
			
			return 'Changes is not saved, leave this page?';
		}
	}

	window.onbeforeunload = closeEditorWarning

	function animate_ajax(){
		
		if(window.navigator.standalone){

			$("#iosappcontainer").animate({ scrollTop: 0 }, "slow");

		}else{

			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
		
		$('.inner').removeClass('animated bounceInLeft');
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
			$('.inner').addClass('animated bounceInLeft');
		}

		change_url = false;
	});

	var langSwitcher = function(){ 

		$('#language_selector').unbind('change.nav_lang_bar').bind('change.nav_lang_bar', function(event){
		
			var href = $(this).val();
	   			
			var uri = href.split(window.location.protocol + "//" + window.location.host + "/").join('');
			var lang = uri.split('/', 1);
			var button_uri = uri.split(lang).join('');

			shower(window.location.protocol + "//" + window.location.host + '/' + lang + "/tools/navbar", false, 'nav_wrapper', false, false, false, false, false);

			showerp('{"uri": "' + button_uri + '"}', window.location.protocol + "//" + window.location.host + '/' + lang + "/tools/sidebar", false, 'sidebar_wrapper', false, false, false, false, false, function(){

				main();
				sidebarInit();
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

		$('#language_selector').find('option').each(function(){

			var href = $(this).val();
			
			var uri = href.split(window.location.protocol + "//" + window.location.host + "/").join('');
			var lang = uri.split('/', 1);
			var newURL = window.location.protocol + "//" + window.location.host + "/" + lang + current_uri;
			
			$(this).val(newURL);
		});
	});
});