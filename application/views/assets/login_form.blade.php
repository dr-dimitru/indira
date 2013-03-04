<?
    $promo_active = Promosettings::get_settings('active');
    $promo_on_login = Promosettings::get_settings('on_login');
?>
<div id="login_form" class="modal fade">
	 <div class="modal-header">
	 	<a class="close" data-dismiss="modal" >×</a>
	    <h3>{{ Lang::line('content.login_word')->get(Session::get('lang')) }}</h3>
    </div>
    
    <div class="modal-body form-horizontal">
    	<fieldset>
    		<div class="control-group">
    		    {{ Form::label('login', Lang::line('content.login_email_word')->get(Session::get('lang')), array('class' => 'control-label')); }}
                <div class="controls">
                    
                    <input 
                        REQUIRED 
                        type="email" 
                        name="login" 
                        id="login" 
                        value="<? 
                        if(Cookie::get('userdata_login'))
                        {
                            echo trim(Crypter::decrypt(Cookie::get('userdata_login')));
                        } 
                        ?>" 
                        class="input" 
                        placeholder="{{ Lang::line('placeholders.email')->get(Session::get('lang')) }}" 
                    />
                    
                </div>
            </div>
        </fieldset>
        
        <fieldset>
        	<div class="control-group">
                {{ Form::label('password', Lang::line('content.password_word')->get(Session::get('lang')), array('class' => 'control-label')); }}
                <div class="controls">
                    
                    <input 
                        REQUIRED 
                        id="password" 
                        type="password" 
                        class="input" 
                        value="<? 
                        if(Cookie::get('userdata_pass'))
                        {
                           echo trim(Crypter::decrypt(Cookie::get('userdata_pass')));
                        }
                        ?>" 
                        placeholder="{{ Lang::line('content.password_word')->get(Session::get('lang')) }}" 
                    />

                </div>
            </div>
       </fieldset>
        
        @if($promo_active == 1 && $promo_on_login == 1)
            <? 
                $json_data = '{"login": "\'+encodeURI($(\'#login\').val())+\'", "password": "\'+encodeURI($(\'#password\').val())+\'", "promo": "\'+encodeURI($(\'#promo_code\').val())+\'", "remember": "\'+$(\'#remember-me\').val()+\'"}';
             ?>
            <fieldset>
            	<div class="control-group">
                    {{ Form::label('promo_code', Lang::line('content.promo_code_word')->get(Session::get('lang')), array('class' => 'control-label')); }}
                    <div class="controls">
                        {{ Form::text('promo_code', '', array('class'=>'input')); }}
                        <p class="help-block">{{ Lang::line('content.promo_code_annotation')->get(Session::get('lang')) }}</p>
                    </div>
                </div>
            </fieldset>
                
        @else
            <? $json_data = '{"login": "\'+encodeURI($(\'#login\').val())+\'", "password": "\'+encodeURI($(\'#password\').val())+\'", "remember": "\'+$(\'#remember-me\').val()+\'"}'; ?>
        @endif
        
        <div id="login_action"></div>
    </div>
        
    <div class="modal-footer form-inline">
        <a 
            href="#pass_recovery_form" 
            class="pull-left" 
            onclick="$('#login_form').modal('hide')" 
            data-toggle="modal">
                <i class="icon-warning-sign"></i> {{ Lang::line('content.pass_recovery_word')->get(Session::get('lang')) }}
        </a>
        <i 
            style="cursor: pointer"
            onclick="if($('#remember-me').val() !== '1'){$('#remember-me').val('1'); $(this).removeClass().addClass('icon-check'); }else{$('#remember-me').val('0'); $(this).removeClass().addClass('icon-check-empty'); }" 
            id="remember-me_icon" 
            class="icon-check"> 
                {{ Lang::line('content.remember_me_word')->get(Session::get('lang')) }}
        </i>
        <label class="checkbox" style="margin: 0px 5px">
            <input 
                CHECKED 
                id="remember-me" 
                name="remember-me" 
                type="hidden"
                style="display:none" 
                value="1" 
                onchange="if(this.value !== '1'){this.value = '1'; }else{this.value = '0'}"
            />
        </label>

        <a 
            href="#" 
            onclick="showerp('<?= htmlspecialchars($json_data); ?>', '<?= Config::get('application.url') ?>/login', 'login_action', 'login_action')" 
            class="btn btn-primary">
                {{ Lang::line('content.login_action_word')->get(Session::get('lang')) }}
        </a>
    </div>
            
</div>