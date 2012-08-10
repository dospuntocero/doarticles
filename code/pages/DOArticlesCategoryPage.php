<?php
class DOArticlesCategoryPage extends Page {

	static $singular_name = "Articles Category Page";
	static $icon = "DOArticles/images/article-category.png";
	static $allowed_children = "none"; // set to string "none" or array of classname(s)
	static $default_child = "none"; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = false; //
	static $hide_ancestor = null; //dont show ancestry class
	
	static $many_many = array(
		'DOArticles' => 'DOArticle',
	);
}

class DOArticlesCategoryPage_Controller extends DOArticleViewer {


}