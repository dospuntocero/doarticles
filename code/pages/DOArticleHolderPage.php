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
	
	public function GroupedArticlesByDate() {
        $rtnval = false;
				
        $monthMap = array(
            'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
        );
        $rslts = DB::query("SELECT DISTINCT YEAR(\"Date\") as Year From DOArticle where ArticleHolderID = {$this->ID} Order By YEAR(\"Date\") desc");
        if ($rslts) {
            $rtnval = new ArrayList();
            while($yrow = $rslts->nextRecord()) {
                $tmpRow = new ArrayList();
                $months = DB::query("SELECT DISTINCT MONTH(\"Date\") as theMonth From DOArticle where ArticleHolderID = {$this->ID} and YEAR(\"Date\") = {$yrow['Year']} Order By Month(\"Date\") asc");
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

        //Debug::show($rtnval);
        return $rtnval;
	}


    public function LinkByYear($year) {
        return Controller::join_links($this->Link(),'archive',$year);
    }

    public function LinkByMonth($year,$month) {
        return Controller::join_links($this->Link(),'archive',$year,$month);
    }



}

class DOArticleHolderPage_Controller extends Page_Controller {


	public function archive() {
		// ==========================================
		// = no idea how to do this function... :) =
		// ==========================================
	}

	public function LatestArticles() {

    return DataList::create('DOArticle')->filter(array('ArticleHolderID' => $this->ID))->sort('Created')->Limit(5);
	}


	public function PaginatedArticles() {
		$pages = DataList::create('DOArticle')->filter(array('ArticleHolderID' => $this->ID))->sort('Date');
		$list = new PaginatedList($pages, $this->request);
		$list->setPageLength(5);
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