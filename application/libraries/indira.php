<?php

class Indira{


	/**
	 * Run it in start.php
	 * $configs string|array|null
	 *
	 * @return void
	 */
	public static function start($configs = null){

		if($configs){
			self::set($configs);
		}

		static::set_languages();
		static::set_template();
		static::load_modules();
	}

	/**
	 * Run it in 'before' route filter
	 *
	 * @return void
	 */
	public static function before(){

		static::set_language();
		static::set_admin();
		static::set_user();
	}


	/**
	 * Set config from FileDB Settings table 
	 *
	 * @param string|array $prefix application, auth, session, etc.
	 * @return void
	 */
	public static function set($paths){

		if(!is_array($paths)){

			if(stripos($paths, '.')){

				list($path, $param) = explode('.', $paths);

				$data = Settings::where('type', '=', $path)->and_where('param', '=', $param)->get();

			}else{

				$paths = array($paths);
			}

		}else{

			$data = Settings::where('type', '=', $paths)->get();
		}
			
		if($data){
			
			foreach($data as $id => $row){

				$row->value = ($row->value == 'false' || $row->value == 'true') ? ($row->value === 'true') : $row->value;

				$row->value = (is_object($row->value)) ? Filedb::object_to_array($row->value) : $row->value;

				Config::set($row->type.'.'.$row->param, $row->value);
			}
		}
	}


	/**
	 * Get value from 'indira.*' Config array
	 * Returns boolean value if string value is 'true' or 'false'
	 *
	 * @param string $param
	 * @return string|boolean
	 */
	public static function get($param){

		$data = (Config::has('indira.'.$param)) ? Config::get('indira.'.$param) : false;

		if($data == 'true'){

			return true;
		
		}elseif($data == 'false'){

			return false;
		
		}else{

			return $data;
		}
	}


	/**
	 * Set Modules link into config array
	 *
	 * @return void
	 */
	public static function load_modules(){

		foreach(Modules::get(array('link', 'name', 'active', 'access', 'view_access')) as $module){
			
			Config::set('indira.modules.'.$module->name.'.link', (isset($module->link)) ? $module->link : 'false' );
			Config::set('indira.modules.'.$module->name.'.access', (int) (isset($module->access)) ? $module->access : 777 );
			Config::set('indira.modules.'.$module->name.'.view_access', (int) (isset($module->view_access)) ? $module->view_access : 777 );
			Config::set('indira.modules.'.$module->name.'.active', (bool) (isset($module->active)) ? ($module->active == 'true') : false );
		}
	}


	/**
	 * Set languages array to config
	 *
	 * @return void
	 */
	public static function set_languages(){

		$languages = Langtable::init();

		if($languages->count() > 1){

			foreach($languages->get(array('lang', 'text_lang', 'ietf')) as $lang){

				$langs[] = $lang->lang;

				Config::set('indira.language.'.$lang->lang.'.params.ietf', $lang->ietf);
				Config::set('indira.language.'.$lang->lang.'.params.text', $lang->text_lang);
				Config::set('indira.language.'.$lang->lang.'.params.lang', $lang->lang);
			}

			Config::set('application.languages', $langs);
		}
	}


	/**
	 * Template name to config - 'indira.template'
	 * And register Bundle's name
	 *
	 * @var    $id 	template id
	 * @return void
	 */
	public static function set_template($id = null){

		$template = Templates::init();
		
		if($id){

			$desktop = $mobile = Templates::where_id($id)->only('name');
		
		}else{

			$mobile = $template->where_in('active', 'true')->and_where('is_mobile', '=', 'true')->only('name');
			$desktop = $template->where_in('active', 'true')->and_where('is_mobile', '=', 'false')->only('name');

		}

		if(!$desktop){

			$desktop = $template->where_id(Config::get('indira.default_template'))->only('name');
		}

		$tablet = (Indira::get('default_tablet_template') == 'desktop') ? $desktop : $mobile;

		$md = new MobileDetect;

		if(!defined('TMPLT')){
			
			if($md->isMobile())
			{	
				if($md->isTablet()){

					define('TMPLT', $tablet);
				
				}else{

					define('TMPLT', (!empty($mobile)) ? $mobile : $desktop);
				
				}

				define('TMPLT_TYPE', 'mobile');
				define('DEVICE_TYPE', ($md->isTablet()) ? 'tablet' : 'phone');
			}
			else
			{	
				define('TMPLT', $desktop);
				define('TMPLT_TYPE', 'desktop');
				define('DEVICE_TYPE', 'desktop');
			}
		}


		if($md->isTablet()){

			Config::set('indira.template', $tablet);
		
		}else{

			Config::set('indira.template', (!empty($mobile) && $md->isMobile()) ? $mobile : $desktop);
		}

		Config::set('indira.template_type', TMPLT_TYPE);

		$template_settings = array(	'location'	=> 'path: bundles/templates/template_'.Config::get('indira.template'),
									'handles' 	=> '/',
									'auto'		=> true);

		Bundle::register('templates', $template_settings);
	}


	/**
	 * Set locale and language switching
	 *
	 * @return void
	 */
	public static function set_language(){

		$default_language = Config::get('application.language');

	    if(Config::has('application.languages')){

	    	$lang_uri = URI::segment(1);
	    	$languages = Config::get('application.languages');

		    if(!in_array($lang_uri, $languages))
		    {
		    	foreach ($languages as $value)
		    	{
		    		if(stripos(Request::server("HTTP_ACCEPT_LANGUAGE"), $value))
		    		{
		    			$language = $value;
		    		}
		    	}

		    	if(!isset($language)){

		    		if(Session::has('lang'))
					{
						$language = Session::get('lang');
					}
					elseif(Cookie::has('lang'))
					{
						$language = Cookie::get('lang');
					}
					else
					{
						$language = Config::get('application.language');
					}
		    	}

		    	Cookie::forever('lang', $language);
		        Session::put('lang', $language);
		        Config::set('application.language', $language);

		        if(stripos(URI::current(), $lang_uri))
		        {
		        	 return Redirect::to(str_ireplace($lang_uri, $language, URI::current()));
		        }
		       
		    }
		    else
		    {
		    	$language = $lang_uri;
		    }

		    if(	!Session::has('lang') 				|| 
		    	!Cookie::has('lang') 				|| 
		    	Session::get('lang') !== $language 	|| 
		    	Cookie::get('lang') !==  $language)
		    {
		        Session::put('lang', $language);
		        Cookie::forever('lang', $language);
		    }

			Config::set('application.language', $language);

		}else{

			if(!Session::has('lang') && !Cookie::has('lang'))
			{
				Session::put('lang', Config::get('application.language'));
				Cookie::forever('lang', Config::get('application.language'));
			}	
			elseif(Cookie::has('lang'))
			{
				Session::put('lang', Cookie::get('lang'));
				Config::set('application.language', Cookie::get('lang'));
			}
			elseif(Session::has('lang'))
			{
				Cookie::forever('lang', Session::get('lang'));
				Config::set('application.language', Session::get('lang'));
			}
		}
	}


	/**
	 * Set admin data, and keep alive admin
	 *
	 * @return void
	 */
	public static function set_admin(){

		if(Cookie::has('admin_id')){

			Utilites::revokeAdmin();
		}
	}


	/**
	 * Set admin data, and keep alive user
	 *
	 * @return void
	 */
	public static function set_user(){

		if(Cookie::has('user_id')){

			Utilites::revokeUser();
		}
		
		if(!Session::has('user.access')){
			
		    Session::put('user.access', '1');
		}
	}


	/**
	 * Find out has set or not keys from indira.* Config array
	 *
	 * @param string $param 
	 * @return void
	 */
	public static function is($param){

		switch ($param) {
			case 'under_development':

				// RETURN "UNDER DEVELOPMENT" MESSAGE 
				// IF 'INDIRA.UNDER_DEVELOPMENT' IS SET TO "TRUE"
				// HIS MESSAGE SHOWN TO EVERYONE EXCERPT ADMIN (777)
				if(Config::get('indira.under_development') == 'true')
				{
					if(preg_match('/^admin(.*)$/', URI::current()))
					{
						return false;
					}
					else
					{
						return (Admin::check() !== 777) ? true : false;
					}
				}
				return false;
				break;
			
			default:

				return Config::has('indira.'.$param);
				break;
		}
	}
}