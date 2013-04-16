<?php

class Item_Controller extends Base_Controller {
	
	public function action_index($item=null)
	{
		
		if($item){
		    
		    $post = Posts::find($item);
		    
		    if($post){

		    	$data = array();
		    	$data["post"] = $post;
		    	$data["posts_preview"] = Posts::where('lang', '=', Session::get('lang'))->where('id', '!=', $post->id)->get();

			    if(Session::get('user.access_level') < $post->access){	

			    	$data["id"] = null;
			    	$data["title"] = Lang::line('content.permissions_denied')->get(Session::get('lang'));

			        return Response::view_with_status('item.no_access', 401, $data);

			    }else{
			       
			       Session::put('href.previous', URL::current());
			       
			       return View::make('item.index', $data);

			    }

			}else{

				$post = new stdClass;
				$post->id = null;

				$data = array();
				$data["post"] = $post;
				$data["title"] = Lang::line('content.no_page')->get(Session::get('lang'));
				$data["posts_preview"] = Posts::where('lang', '=', Session::get('lang'))->where('id', '!=', $post->id)->get();

				return Response::view_with_status('item.no_item', 404, $data);
			}
			
			
		}else{

			return Response::error(404);
		}
	}

}