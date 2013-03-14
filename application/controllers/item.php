<?php

class Item_Controller extends Base_Controller {
	
	public function action_index($item=null)
	{
		
		if($item){
		    
		    $post = Posts::find($item);
		    
		    if($post){

			    if(Session::get('user.access_level') < $post->access)
			    {
			        return View::make('item.no_access')
			        			->with('id', null)
			        			->with('title', Lang::line('content.permissions_denied')->get(Session::get('lang')))
			        			->with('post', $post)
			        			->with('posts_preview', Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get());

			        Session::put('href.previous', URL::current());
			    }
			    elseif ($post) 
				{
			       
			       Session::put('href.previous', URL::current());
			       
			       if(!$post->qr_code)
			       {
						$filename = Filedb::add_qrcode($item);

						Posts::where('id', '=', $item)->update(array('qr_code' => '.'.$filename));

						$qr_code_filename = '<img src="'.Config::get('application.url').substr($filename, 1).'" alt="'.Lang::line('content.site_title')->get(Session::get('lang')).' · '.$post->title.'" title="'.Lang::line('content.site_title')->get(Session::get('lang')).' · '.$post->title.'" />';
			       }
			       else
			       {
				       	$qr_code_filename = '<img src="'.Config::get('application.url').substr($post->qr_code, 1).'" alt="'.Lang::line('content.site_title')->get(Session::get('lang')).' · '.$post->title.'" title="'.Lang::line('content.site_title')->get(Session::get('lang')).' · '.$post->title.'" />';
			       }
			       
			       $post->qr_code_filename = $qr_code_filename;
			       
			       return View::make('item.index')
			       			->with('post', $post)
			        		->with('posts_preview', Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get());
			    }
			    else {

			    	$post = new stdClass;
					$post->id = null;

			        return View::make('item.no_item')
			        			->with('post', $post)
			        			->with('title', Lang::line('content.no_page')->get(Session::get('lang')))
			        			->with('posts_preview', Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get());
			    }

			}else{
				$post = new stdClass;
				$post->id = null;

				return View::make('item.no_item')
							->with('post', $post)
							->with('title', Lang::line('content.no_page')->get(Session::get('lang')))
			        		->with('posts_preview', Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get());
			}
			
			
		}else{
			$post = new stdClass;
			$post->id = null;

			return View::make('item.no_item')
						->with('post', $post)
						->with('title', Lang::line('content.no_page')->get(Session::get('lang')))
			        	->with('posts_preview', Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get());
		}
	}

}