<?php
/**
 * @property String Title
 * @property String Content
 * @property String Excerpt
 * @property String Date
 * @property bool Featured
 * @property int ArticleHolderID
 * @property int ImageSetID
 * @method ManyManyList Tags($filter = "", $sort = "", $join = "", $limit = "")
 * @method DOArticleHolderPage ArticleHolder()
 * @method Image ImageSet()
 */
class DOArticle extends DataObject{
	static $singular_name = "Article";
	static $plural_name = "Articles";

    protected $tagsAsString = "";

	static $db = array (
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Excerpt' => 'HTMLText',
		'Date' => 'Date',
		'Featured' => 'Boolean'
	);

	static $has_one = array (
		'ArticleHolder' => 'DOArticleHolderPage',
		'ImageSet' => 'Image'
	);

	static $searchable_fields = array(
		'Title',
		'Content',
		'ArticleHolder.Title'
	);

	static $summary_fields = array(
		'SmallTitle' => 'Title',
		'ArticleHolder.Title' => 'Category'
	);

    static $many_many = array(
        'Tags' => 'DOTag'
    );

    static $casting = array(
        'TagsAsString' => 'Text'
    );

    public function __construct($record = null, $isSingleton = false, $model = null) {
        $this->tagsAsString = "";
        parent::__construct($record, $isSingleton, $model);


        if ($this->Tags()->count() > 0) {
            $tgList = $this->Tags()->map('ID','Title')->values();
            if(sizeof($tgList) > 0) {
                $this->tagsAsString = join(", ",$tgList);
            }
        }

    }

	function getSmallTitle(){
		return $this->dbObject('Title')->LimitCharacters(90);
	}

	function Link(){
//		return "view/".$this->URLSegment;
		return Controller::join_links($this->ArticleHolder()->Link(),'view',$this->URLSegment);
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

    /**
     *  @todo figure out how data is initialized in SS3 and make this a true getter/setter
     */
    public function getTagsAsString() {
        return $this->tagsAsString;
    }

    public function setTagsAsString($t) {
        $this->tagsAsString = $t;
    }

    public function onAfterWrite() {
        parent::onAfterWrite();
        // assume tags as string is a comma seperated list and build tags based on that
        if (!empty($this->tagsAsString) && $this->isChanged("TagsAsString")) {
            $tgIds = array();
            $tgList = explode(",",$this->tagsAsString);
            if ($tgList && sizeof($tgList) > 0) {
                // build the list of tags
                for($i=0;$i<sizeof($tgList);$i++) {
                    $tgText = trim($tgList[$i]);
                    $theTag = DOTag::findOrMakeTag($tgText);
                    if ($theTag) {
                        $tgID = $theTag->ID;
                        if($tgID > 0) {
                            $tgIds[] = $tgID;
                        }
                    }
                }
            }
            // clean up current tags by removing any which are not in the $tgIDs
            $cTagIDS = $this->Tags()->map("ID","Title")->keys();
            $delMe = array_diff($cTagIDS,$tgIds);
            $addMe = array_diff($tgIds,$cTagIDS);
            foreach($delMe as $id) {
                $this->Tags()->removeByID($id);
            }
            foreach($addMe as $id) {
                $this->Tags()->add($id);
            }
            $this->flushCache();

        }
    }


}