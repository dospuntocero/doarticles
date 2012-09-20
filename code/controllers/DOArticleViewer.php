<?php
class DOArticleViewer extends Page_Controller {

	public function GroupedArticlesByDate() {
		$rtnval = false;

		if (i18n::get_locale() == "es_ES") {
			$monthMap = array(
				'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'
			);
		}else{
			$monthMap = array(
				'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
			);
		}
		
		$rslts = DB::query("SELECT DISTINCT YEAR(\"Date\") as Year From DOArticle where ArticleHolderID = {$this->ID} Order By YEAR(\"Date\") desc");
		if ($rslts) {
			$rtnval = new ArrayList();
			while($yrow = $rslts->nextRecord()) {
				$tmpRow = new ArrayList();
				$months = DB::query("SELECT DISTINCT MONTH(\"Date\") as theMonth From DOArticle where ArticleHolderID = {$this->ID} and YEAR(\"Date\") = {$yrow['Year']} Order By Month(\"Date\") desc");
				while($mrow = $months->nextRecord()) {
						//Debug::show($mrow);
						$tmpRow->push(new ArrayData(
							array(
								'Year' => $yrow['Year'],
								'Month' => $monthMap[(((int) $mrow['theMonth'])-1)],
								'Children' => DataObject::get('DOArticle',"ArticleHolderID = {$this->ID} and (YEAR(\"Date\") = {$yrow['Year']} and MONTH(\"Date\") = {$mrow['theMonth']})")
							)
					));
				}
				$rtnval->push(new ArrayData(
						array(
								'Year' => $yrow['Year'],
								'Children' => $tmpRow
						)
				));
			}
		}
		return $rtnval;
	}


	public function LinkByYear($year) {
		return Controller::join_links($this->Link(),'archive',$year);
	}

	public function LinkByMonth($year,$month) {
		return Controller::join_links($this->Link(),'archive',$year,$month);
	}
	
	public function archive() {	
			$theRecs = false;
			$theYear = (int) $this->request->param('ID');
			$theMonth = (int) $this->request->param('OtherID');

			if (i18n::get_locale() == "es_ES") {
				$months = array(
						'ene' => 1,
						'feb' => 2,
						'mar' => 3,
						'abr' => 4,
						'may' => 5,
						'jun' => 6,
						'jul' => 7,
						'ago' => 8,
						'sep' => 9,
						'oct' => 10,
						'nov' => 11,
						'dic' => 12
				);
			}else{
				$months = array(
						'jan' => 1,
						'feb' => 2,
						'mar' => 3,
						'apr' => 4,
						'may' => 5,
						'jun' => 6,
						'jul' => 7,
						'aug' => 8,
						'sep' => 9,
						'oct' => 10,
						'nov' => 11,
						'dec' => 12
				);
			}
			// correct for month as text
			if ($theMonth < 1) {
					$theMonth = strtolower($this->request->param('OtherID'));
					$theMonth = (int) @$months[$theMonth];
			}
			if (($theYear > 0) && ($theMonth > 0)) {
					$theRecs = DOArticle::get()->filter(array(
						 // 'ArticleHolderID' => $this->ID,
							'Date:ByYear' => $theYear,
							'Date:ByMonth' => $theMonth
					))->sort('Date desc');
			} else if ($theYear > 0) {
					$theRecs =	DOArticle::get()->filter(array(
							//'ArticleHolderID' => $this->ID,
							'Date:ByYear' => $theYear
					))->sort('Date desc');
			}

			if ($theRecs) {
					$theRecs = new PaginatedList($theRecs,$this->request);
					$theRecs->setPageLength(5);
			} else {
				$theRecs = false;
		}

		return $this->customise(array('PaginatedArticles'=>$theRecs))->renderWith(array("DOArticlesCategoryPage","Page"));
	}

	

	//shows the article for reading
	function read(){
	
		$pid = $this->URLParams['ID'];
	
		$article = DOArticle::get()->filter('URLSegment' , $pid)->First();
		if($article){
			return $this->customise( array('Article'=>$article,'Title'=>$article->Title))->renderWith(array("DOArticleHolderPage_view","Page") );
		}
		return $this->httpError(404);
	}
	
	public function PaginatedArticles() {
		$pages = $this->data()->DOArticles()->sort('Date DESC');
		$list = new PaginatedList($pages, $this->request);
		$list->setPageLength(5);
		return $list;
	}

	public function getTagName(){
		$theTag = $this->request->param('ID');
		return DOTag::get()->filter(array('URLSegment'=>$theTag))->first()->Title;
	}

	public function bytag() {
			$tags = false;
			$theTag = $this->request->param('ID');
			// Debug::show($theTag);
			if (is_numeric($theTag)) {
					$theTag = (int) $theTag;
					$tags = DOTag::get()->filter(array('ID'=>$theTag))->first()->Articles();
			} else {
					$tags = DOTag::get()->filter(array('URLSegment'=>$theTag))->first()->Articles();
			}
			// Debug::dump($tags);
			if ($tags) {
					$list = new PaginatedList($tags, $this->request);
					$list->setPageLength(5);
			} else {
					$list = false;
			}

			return $this->customise(array('PaginatedArticles'=>$list))->renderWith(array("DOArticlesCategoryPage","Page"));

	}
}