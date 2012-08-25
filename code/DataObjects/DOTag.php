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
 * @method ManyManyList Articles($filter = "", $sort = "", $join = "", $limit = "")
 */


class DOTag extends DataObject {



    public static $db = array(
        'Title' => 'Varchar(255)'
    );



    public static $summary_fields = array(
			'Title' => 'Tag',
			"URLSegment" => "URLSegment"
		);

		public function Link(){
			return "/article/bytag/".$this->URLSegment;
		}

    public static $has_one = array(

    );

    public static $has_many = array(

    );

    public static $belongs_many_many = array(
        'Articles' => 'DOArticle'
    );
    
    /**
     * @var string
     */
    public static $singular_name = "Tag";
    /**
     * @var string
     */
    public static $plural_name = "Tags";
    
    //CRUD Settings
    public function canCreate($member = null) {return true;}
	public function canView($member = null) {return true;}
	public function canEdit($member = null) {return true;}
	public function canDelete($member = null) {return true;}

/**
 * Object Methods
 */
 	
 	/**
 	 * @param string tagname 
 	 * @return sting tag - either a new tag or existing use tag Title.
 	 */
    public static function findOrCreateTag($tagname) {
        $tag = false;
        $tagname = trim($tagname);
        if (!empty($tagname)) {
            $tag = DOTag::get()->filter(array("Title"=>$tagname))->first();
            if (!$tag) {
                $tag = new DOTag();
                $tag->Title = $tagname;
                $tag->write();
            }
        }
        return $tag;
    }
}

