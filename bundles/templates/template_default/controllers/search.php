<?php

class Templates_Search_Controller extends Templates_Base_Controller {


	/**
	 * Search for posts and blog
	 * posts with same tag
	 * 
	 * @param  strind|int  $tag
	 * @return Laravel\View
	 */
	public function action_tag($tag)
	{	

		Session::put('href.previous', URL::current());

		$tag = rawurldecode($tag);

		$data 			= 	array();
		$data["blogs"] 	= 	Blog::where('tags', 'like', $tag)
							->and_where('lang', '=', Session::get('lang'))
							->and_where('published', '=', 'true')
							->and_where('access', '<=', Session::get('user.access'))
							->get();

		$data["posts"] 	= 	Posts::where('tags', 'like', $tag)
							->and_where('lang', '=', Session::get('lang'))
							->and_where('published', '=', 'true')
							->and_where('access', '<=', Session::get('user.access'))
							->left_join('title', 'posts.section', '=', 'sections.id')
							->get();

		$data["page"]	= 	'templates::search.tags';

		$data["images"] = 	Media::get(array('id', 'formats'));

		$data["search_value"] 	= 	$tag;

		$data["posts_link"] 	= 	Indira::get('modules.posts.link');
		$data["blog_link"] 		= 	Indira::get('modules.blog.link');

		$data["title"]			= 	Utilites::build_title(array(Indira::get('name'), 'templates::content.search.by_tag', $tag));
		$data["canonical_url"]	= 	URL::to('search/tag/'.$tag);
		$data["meta_robots"] 	= 	'noindex, nofollow';

		return (Request::ajax()) ? View::make($data["page"], $data) : View::make('templates::main', $data);
	}
}