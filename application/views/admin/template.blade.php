@include('admin.assets.head')
	<body id="body" class="admin {{ TMPLT_TYPE }} {{ DEVICE_TYPE }}" style="zoom: 1;">
		@if(Config::get('indira.under_development') == 'true')
			<button
				id="ajax_go_to_dev_settings"
				class="btn btn-mini pull-right"
				data-link="{{ action('admin.development.home@index') }}"
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.development')) }}"
			>
				<span class="label label-important">{{ __('development.is_on') }}</span>
			</button>
		@endif

        <div id="wrap">
            <!--[if lt IE 7]>
                <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
            <![endif]-->
            @if(TMPLT_TYPE !== 'mobile')
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span4">
                            <h1 class="logo">Indira<sup><i class="icon-lemon"></i></sup><sub>CMS</sub></h1>
                        </div>
                    </div>
                </div>
            @endif

            @if(TMPLT_TYPE == 'mobile')
                @include('admin.assets.toolbar')

                <div id="iosappcontainer" class="scroll-y" style="min-width:100%">
                    <div id="main_container" class="container-fluid">
                        <div class="inner">
                    
                            @include('admin.body')

                        </div>
                    </div>
                </div>

            @else

                <div id="main_container" class="container-fluid">
                    @include('admin.assets.toolbar')
                    <div class="inner">
                
                        @include('admin.body')

                    </div>
                </div>

            @endif
        </div>
        @if(TMPLT_TYPE !== 'mobile')
            <div id="push"></div>
            @include('admin.assets.footer')

        @endif

        <div class="modal" id="main_modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true" style="display:none"></div>
	</body>
</html>