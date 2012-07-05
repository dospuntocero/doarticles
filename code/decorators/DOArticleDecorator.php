<?php
class DOArticleDecorator extends DataExtension{
    
	function getLatestDOArticles($number=5,$parent = null) {
		return DOArticle::get("Date DESC", "", $number);
	}

	function getFeaturedDOArticles($number=5){
		return DOArticle::get('`Featured` = 1', '`Date` DESC', '', $number);
	}

}