<?php 

class DOArticlesAdmin extends ModelAdmin {
	public static $managed_models = array('DOArticle','DOTag'); // Can manage multiple models
	static $url_segment = 'articles'; // Linked as /admin/products/
	static $menu_title = 'Articles';
	public $showImportForm = false;
}