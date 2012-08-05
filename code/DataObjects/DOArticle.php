<?php
class DOArticle extends DataObject{
	static $singular_name = "Article";
	static $plural_name = "Articles";

	static $db = array (
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Excerpt' => 'HTMLText',
		'Date' => 'Date',
		'Featured' => 'Boolean'
	);

	static $belongs_many_many = array(
		'DOArticleHolderPages' => 'DOArticleHolderPage',
	);
	
	static $has_one = array (
		'ImageSet' => 'Image'
	);

	static $searchable_fields = array(
		'Title',
		'Content'
	);

	static $summary_fields = array(
		'SmallTitle' => 'Title'
	);

	function getSmallTitle(){
		return $this->dbObject('Title')->LimitCharacters(90);
	}

	function Link(){
//		return "view/".$this->URLSegment;
		return Controller::join_links($this->DOArticleHolderPages()->Link(),'view',$this->URLSegment);
	}

	function LinkByMonth($year,$month) {
		return Controller::join_links($this->Link(),'archive',$year,$month);
	}

	function getMonth() {
		return date('M', strtotime($this->Date));
	}

	public function getYear() {
		return date('Y',strtotime($this->Date));
	}

	public function getCMSFields() {

		$UploadField = new UploadField('ImageSet', _t('DOArticles.MainImage',"Main image", null, null, null, "MainImages"));
		$UploadField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));

		$fields = parent::getCMSFields();


		$fields->addFieldToTab('Root.Main',new TextField('Title',_t('DOArticles.TITLE',"Title")));
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