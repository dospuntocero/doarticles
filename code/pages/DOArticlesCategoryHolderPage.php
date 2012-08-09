<?php

class DOArticlesCategoryHolderPage extends Page {

	static $singular_name = "Article Categories Holder";
	static $plural_name = "Articles Category Holder";
	static $icon = "DOArticles/images/files.png";
	static $description = 'List of categories';

	static $allowed_children = array("DOArticlesCategoryPage"); // set to string "none" or array of classname(s)
	static $default_child = "DOArticlesCategoryPage"; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = true; //
	static $hide_ancestor = null; //dont show ancestry class

	static $many_many = array(
		'DOArticles' => 'DOArticle',
	);

	public function canCreate($member = null) {
		return DataList::create("DOArticlesCategoryHolderPage")->count() < 1;
	}

}

class DOArticlesCategoryHolderPage_Controller extends Page_Controller {

	public function LatestArticles() {
		//return DataList::create('DOArticle')->filter(array('ArticleHolderID' => $this->ID))->sort('Created')->Limit(5);
		return $this->data()->DOArticles()->sort('Created')->Limit(5);
	}

	public function PaginatedArticles() {
		//$pages = DataList::create('DOArticle')->filter(array('ArticleHolderID' => $this->ID))->sort('Date DESC');
        $pages = $this->data()->DOArticles()->sort('Date DESC');
		$list = new PaginatedList($pages, $this->request);
		$list->setPageLength(5);
		return $list;
	}

}