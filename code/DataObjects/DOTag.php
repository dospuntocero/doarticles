<?php
/**
 * Created by JetBrains PhpStorm.
 * User: smathews
 * Date: 8/3/12
 * Time: 4:55 PM
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

    public static function findOrMakeTag($title) {
        $tag = DOTag::get()->filter(array("Title"=>$title))->First();
        if (!$tag) {
            $tag = new DOTag();
            $tag->Title = $title;
            $tag->write();
        }
        return $tag;
    }

}

