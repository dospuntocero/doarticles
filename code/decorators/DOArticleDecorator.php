<?php
class DOArticleDecorator extends DataExtension{
    /**
     * Latest Articles
     *
     * @param int the number of latest articles to return (default 5) 
     * @return object list of the latest new articles
     */
    function getLatestArticles($number=5) {
		
		return DOArticle::get()->sort('Date DESC')->limit($number);

	}
	/**
	 * @todo - implement a featured functionality.
	 */
	function getFeaturedArticles($number=5){
		return DOArticle::get()->filter("Featured = 1")->sort("Date DESC")->limit($number);
	}

	
	public function Tags(){
		return DOTag::get()->sort('Title','ASC');
	}

}