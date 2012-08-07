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

    public static $has_one = array(

    );

    public static $has_many = array(

    );

    public static $belongs_many_many = array(
        'Articles' => 'DOArticle'
    );

    public static function findOrCreateTag($tagname) {
        $tag = false;
        $tagname = trim($tagname);
        if (!empty($tagname)) {
            $tag = DoTag::get()->filter(array("Title"=>$tagname))->first();
            if (!$tag) {
                $tag = new DoTag();
                $tag->Title = $tagname;
                $tag->write();
            }
        }
        return $tag;
    }
}

