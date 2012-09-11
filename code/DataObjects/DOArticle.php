<?php

/**
 * Created by JetBrains PhpStorm.
 * User: smathews
 * Date: 8/6/12
 * Time: 12:59 PM
 * @package    DOArticles
 * @subpackage DataObjects
 * -------------------------------
 * @property String Title
 * @property String Content
 * @property String Excerpt
 * @property String Date
 * @property bool Featured
 * @method ManyManyList DOArticleHolderPages($filter = "", $sort = "", $join = "", $limit = "")
 *
 */
class DOArticle extends DataObject{
    
    /**
     * @var array
     */
    public static $db = array (
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Excerpt' => 'HTMLText',
		'Date' => 'Date'
	);

	/**
     * @var array
     */
	public static $has_one = array (
		'Image' => 'Image'
	);
	
	/**
     * @var array
     */
    public static $many_many = array(
        'Tags' => 'DOTag'
    );
    
    /**
     * @var array
     */
    public static $belongs_many_many = array(
		'DOArticlesCategoryPages' => 'DOArticlesCategoryPage',
	);

    /**
     * @var array
     */
    public static $searchable_fields = array(
		'Title',
		'Content'
	);

    /**
     * @var array
     */
    public static $summary_fields = array(
			'SmallTitle' => 'Title',
			"CatsAsString" => "Categories",
			"TagsAsString" => "Tags",
		);

    /**
     * @var string
     */
    static $singular_name = "Article";
    /**
     * @var string
     */
    static $plural_name = "Articles";
    
    //CRUD settings
    public function canCreate($member = null) {return true;}
	public function canView($member = null) {return true;}
	public function canEdit($member = null) {return true;}
	public function canDelete($member = null) {return true;}




/**
 * Object Methods
 */


     /**
     * @return FieldList
     */
    public function getCMSFields() {

		$fields = parent::getCMSFields();
		

		// remove the Tags and   DOArticleHolderPages tabs
		$fields->fieldByName('Root')->removeByName('Tags');
		$fields->fieldByName('Root')->removeByName('DOArticlesCategoryPages');

		/** @var TabSet $root  */
		// $root = $fields->fieldByName('Root');
		// $pgtab = $fields->findOrMakeTab('Root.Holders',_t('DOArticles.HoldersTabTitle','Display in Holders'));
		// $pgtab->push(new CheckboxSetField('DOArticleHolderPages','Holder Pages',DOArticleHolderPage::get()->map('ID','Title')));
		$fields->removeFieldFromTab("Root.Main","Image");
		if ($this->ID) {
			$UploadField = new UploadField('Image', _t('DOArticles.MainImage',"Main image", null, null, null, _t('DOArticle.IMAGE',"Image")));
			$UploadField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
			
			//nicer categories selector
			$categories = new DOCategoriesField('DOArticlesCategoryPages', 'Categories');
			$categories->setCategoryHolderNode();
			$fields->addFieldToTab('Root.Main',$categories);
			
			//nicer tags
			// @todo replace with a ListboxField or nicer tagging ui
			$fields->addFieldToTab('Root.Main',$tgfield = new DOTagField($this,'Tags','Tags',$this->Tags()));
			$fields->addFieldToTab('Root.Main',new LiteralField('TagList','<div class="field text"><label class="left">'._t('DOArticle.AVAILABLETAGS',"Available Tags").'</label><div class="middleColumn">'.$this->ShowTagsList()."</div></div>"));
			
				
			
						
			$fields->addFieldToTab("Root.Main", $UploadField);
			$tgfield->addExtraClass('text');
		}

		$fields->addFieldToTab('Root.Main', new TextField('Title',_t('DOArticles.TITLE',"Title")));


		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content',_t('DOArticles.CONTENT',"Content")));

		$fields->addFieldToTab('Root.Main', $dateField = new DateField('Date',_t('DOArticles.Date',"Date")));
		$dateField->setConfig('showcalendar', true);
		$dateField->setConfig('dateformat', 'dd/MM/YYYY');

		$fields->addFieldToTab('Root.Main',new TextareaField('Excerpt',_t('DOArticles.EXCERPT',"Excerpt")));
		$fields->removeFieldFromTab("Root.Main","URLSegment");

		return $fields;
	}

	/**
	 * @return string
	 */
	public function getCatsAsString() {
		$val = $this->DOArticlesCategoryPages()->column('Title');
		if (is_array($val)) {
			return join(", ",$val);
		} else {
			return '';
		}
	}

	/**
	 * @return string
	 */
	
	public function ShowTagsList() {
		$val = DOTag::get()->column('Title');
		$taglist = "<div class=''>";
		if (is_array($val)) {
			return join(", ",$val);
			
			// foreach ($val as $value) {
			// 	$taglist.= '<span title="'.$value.'" class="badge modified">'.$value.'</span>, ';
			// }
			// $taglist.="</div>";
			// return $taglist;
		} else {
			return '';
		}
	}
	
	/**
	 * @return string
	 */
	public function getTagsAsString() {
		$val = $this->Tags()->column('Title');
		if (is_array($val)) {
			return join(", ",$val);
		} else {
			return '';
		}
	}

    /**
     * @return mixed
     */
	public function getSmallTitle(){
			return $this->dbObject('Title')->LimitCharacters(90);
		}

    /**
     * @return string
     */
    public function getMonth() {
			return date('M', strtotime($this->Date));
    }

    /**
     * @return string
     */
    public function getYear() {
			return date('Y',strtotime($this->Date));
    }


	
/**
 * Template Methods
 */
	
	
	/**
     * @return String
     */
	public function Link() {
			// $c = Controller::curr();
			// $link = Controller::join_links("articles/".$c->Link('view'),$this->URLSegment);
			return "/article/read/".$this->URLSegment;
		}
    /**
     * @param $year
     * @param $month
     *
     * @return String
     */
    public function LinkByMonth($year,$month) {
			return Controller::join_links($this->Link(),'archive',$year,$month);
    }



}