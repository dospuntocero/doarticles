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
		'Date' => 'Date',
		'Featured' => 'Boolean'
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
		'DOArticleHolderPages' => 'DOArticleHolderPage',
	);

    /**
     * @var array
     */
    static $has_one = array (
		'ImageSet' => 'Image'
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
		'SmallTitle' => 'Title'
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
    function Link(){
//		return "view/".$this->URLSegment;
		return Controller::join_links($this->DOArticleHolderPages()->Link(),'view',$this->URLSegment);
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

		$UploadField = new UploadField('ImageSet', _t('DOArticles.MainImage',"Main image", null, null, null, "MainImages"));
		$UploadField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));

		$fields = parent::getCMSFields();

        // remove the Tags and   DOArticleHolderPages tabs
        $fields->fieldByName('Root')->removeByName('Tags');
        $fields->fieldByName('Root')->removeByName('DOArticleHolderPages');

        /** @var TabSet $root  */
        $root = $fields->fieldByName('Root');
        $pgtab = $fields->findOrMakeTab('Root.Holders',_t('DOArticles.HoldersTabTitle','Display in Holders'));
        $pgtab->push(new CheckboxSetField('DOArticleHolderPages','Holder Pages',DOArticleHolderPage::get()->map('ID','Title')));


		$fields->addFieldToTab('Root.Main',new TextField('Title',_t('DOArticles.TITLE',"Title")));
        $fields->addFieldToTab('Root.Main',new DOTagField($this,'Tags','Tags',$this->Tags()));
		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content',_t('DOArticles.CONTENT',"Content")));

		$fields->addFieldToTab('Root.Main', $dateField = new DateField('Date',_t('DOArticles.Date',"Date")));
		$dateField->setConfig('showcalendar', true);
		$dateField->setConfig('dateformat', 'dd/MM/YYYY');

		$fields->addFieldToTab('Root.Main',new TextareaField('Excerpt',_t('DOArticles.EXCERPT',"Excerpt")));
		$fields->addFieldToTab('Root.Main',new CheckboxField('Featured',_t('DOArticles.FEATURED',"Is this article featured?")));

		$fields->removeFieldFromTab("Root.Main","URLSegment");
		$fields->addFieldToTab("Root.Main", $UploadField);

		return $fields;
	}


}