<?php 

class DOArticlesAdmin extends ModelAdmin {
	public static $managed_models = array('DOArticle'); // Can manage multiple models
	static $url_segment = 'articles'; // Linked as /admin/products/
	static $menu_title = 'Articles';
	
	}