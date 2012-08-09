<?php
class DOArticlesCategoryPage extends Page {

	static $singular_name = "DOArticlesCategoryPage";
	static $plural_name = "DOArticlesCategoryPages";
	static $icon = "";
	static $allowed_children = "none"; // set to string "none" or array of classname(s)
	static $default_child = none; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = false; //
	static $hide_ancestor = null; //dont show ancestry class
	
	static $db = array(
		
	);
}

class DOArticlesCategoryPage_Controller extends Page_Controller {

}