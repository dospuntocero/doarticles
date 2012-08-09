<?php
class DOArticleViewer extends Controller {
	

	public static $allowed_actions = array (
		'read'
	);

	function read(){

		$pid = $this->URLParams['ID'];

		$article = DOArticle::get()->filter('URLSegment' , $pid)->First();
		if($article){
			return $this->customise(array('Article' => $article))->renderWith(array('DOArticleHolderPage_view','Page'));
		}
		return $this->httpError(404);
	}
}