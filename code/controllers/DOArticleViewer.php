<?php
class DOArticleViewer extends Page_Controller {
	
	public function Tags(){
		return DOTag::get();
	}


	function read(){

		$pid = $this->URLParams['ID'];

		$article = DOArticle::get()->filter('URLSegment' , $pid)->First();
		if($article){
			return $this->customise(array('Article'=>$article))->renderWith(array("DOArticleHolderPage_view","Page"));
		}
		return $this->httpError(404);
	}
	
	public function PaginatedArticles() {
		$pages = $this->data()->DOArticles()->sort('Date DESC');
		$list = new PaginatedList($pages, $this->request);
		$list->setPageLength(5);
		return $list;
	}
	
  public function bytag() {
      $tags = false;
      $theTag = $this->request->param('ID');
      // Debug::show($theTag);
      if (is_numeric($theTag)) {
          $theTag = (int) $theTag;
          $tags = DOTag::get()->filter(array('ID'=>$theTag))->first()->Articles("DOArticle.ID IN (Select zz.DOArticleID FROM DOArticleHolderPage_DOArticles zz where zz.DOArticleHolderPageID = ".$this->data()->ID.")");
      } else {
          $tags = DOTag::get()->filter(array('Title'=>$theTag))->first()->Articles("DOArticle.ID IN (Select zz.DOArticleID FROM DOArticleHolderPage_DOArticles zz where zz.DOArticleHolderPageID = ".$this->data()->ID.")");
      }
			// Debug::dump($tags);
      if ($tags) {
          $list = new PaginatedList($tags, $this->request);
          $list->setPageLength(5);
      } else {
          $list = false;
      }

      return $this->customise(array('PaginatedArticles'=>$list))->renderWith(array("DOArticleHolderPage","Page"));

  }

	
	
}