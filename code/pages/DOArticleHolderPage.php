<?php
class DOArticleHolderPage extends Page {

	static $singular_name = "Article Holder";
	static $plural_name = "Articles Holder";
	static $icon = "DOArticles/images/files.png";
	static $description = 'Displays a list of Articles';

	static $allowed_children = "none"; // set to string "none" or array of classname(s)
	static $default_child = ""; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = true; //
	static $hide_ancestor = null; //dont show ancestry class

	static $has_many = array(
		'DOArticles' => 'DOArticle',
	);
}

class DOArticleHolderPage_Controller extends Page_Controller {


	public function PaginatedArticles() {
	    $pages = DataList::create('DOArticle')->filter(array('ArticleHolderID' => $this->ID))->sort('Date');
		$list = new PaginatedList($pages, $this->request);
		$list->setPageLength(10);
	    return $list;
	}

	function view(){
	    $pid = $this->URLParams['ID'];

	    $article = DOArticle::get()->filter('URLSegment' , $pid)->First();

	    if($article){
            return $this->customise(array('Article' => $article));
	    }
	    return $this->httpError(404);
	}
}