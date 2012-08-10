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
     * @var string
     */
    static $singular_name = "Article";
    /**
     * @var string
     */
    static $plural_name = "Articles";

    /**
     * @var array
     */
    static $db = array (
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Excerpt' => 'HTMLText',
		'Date' => 'Date'
	);

    /**
     * @var array
     */
    static $many_many = array(
        'Tags' => 'DOTag'
    );

    /**
     * @var array
     */
    static $belongs_many_many = array(
		'DOArticlesCategoryPages' => 'DOArticlesCategoryPage',
	);


	public function getCatsAsString() {
		$val = $this->DOArticlesCategoryPages()->column('Title');
		if (is_array($val)) {
			return join(", ",$val);
		} else {
			return '';
		}
	}

	public function getTagsAsString() {
		$val = $this->Tags()->column('Title');
		if (is_array($val)) {
			return join(", ",$val);
		} else {
			return '';
		}
	}




    /**
     * @var array
     */
		static $has_one = array (
		'Image' => 'Image'
	);

    /**
     * @var array
     */
    static $searchable_fields = array(
		'Title',
		'Content'
	);

    /**
     * @var array
     */
    static $summary_fields = array(
			'SmallTitle' => 'Title',
			"CatsAsString" => "Categories",
			"TagsAsString" => "Tags",
		);

    /**
     * @return mixed
     */
		function getSmallTitle(){
			return $this->dbObject('Title')->LimitCharacters(90);
		}

    /**
     * @return String
     */
		function Link() {
			// $c = Controller::curr();
			// $link = Controller::join_links("articles/".$c->Link('view'),$this->URLSegment);
			return $this->URLSegment;
		}
    /**
     * @param $year
     * @param $month
     *
     * @return String
     */
    function LinkByMonth($year,$month) {
			return Controller::join_links($this->Link(),'archive',$year,$month);
    }

    /**
     * @return string
     */
    function getMonth() {
			return date('M', strtotime($this->Date));
    }

    /**
     * @return string
     */
    public function getYear() {
			return date('Y',strtotime($this->Date));
    }

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
			$fields->addFieldToTab('Root.Main',new CheckboxSetField('DOArticlesCategoryPages','Holder Pages',DOArticlesCategoryPage::get()->map('ID','Title')));
			$fields->addFieldToTab('Root.Main',$tgfield = new DOTagField($this,'Tags','Tags',$this->Tags()));			
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


}