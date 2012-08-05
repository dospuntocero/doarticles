<?php

class ArticleViewer extends Page_Controller {

   public static $url_segment = 'articles';

   public static $allowed_actions = array (
		'view'
	);


	function view(){
	    $pid = $this->URLParams['ID'];
	    $article = DOArticle::get()->filter('URLSegment' , $pid)->First();
	    if($article){
            return $this->customise(array('Article' => $article))->renderWith(array('DOArticleHolderPage_view','Page'));
	    }
	
	    return $this->httpError(404);
	}
}