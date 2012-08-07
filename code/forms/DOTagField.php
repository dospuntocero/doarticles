<?php
/**
 * Created by JetBrains PhpStorm.
 * User: smathews
 * Date: 8/6/12
 * Time: 2:29 PM
 * -------------------------------------
 */
class DOTagField extends TextField {
    protected $controller = null;
    protected $tagSaveType = 'field';

    function __construct(DataObject $controller,  $name, $title = null,  $value = '', $maxLength = null, $form = null) {
        parent::__construct($name, $title, $value, $maxLength, $form);
        $this->controller = $controller;
        if ($this->controller && $this->controller->hasField($name)) {
            $this->tagSaveType = 'field';
        } else if ($this->controller && ($this->controller->getRelationClass($name) !== null)) {
            $this->tagSaveType = 'relation';
        }

       /*
        if ($values) {
            $this->setValue($values);
        }
        */
       // Debug::show($this->tagSaveType);
    }

    function Field($properties = array()) {
        if ($this->controller->ID) {
            return parent::Field($properties);
        } else {
            return '<h4>Please Save Before You Can Add Tags</h4>';
        }
    }


    /**
     * @param String|Array|RelationList $value
     *
     * @return DOTagField|FormField
     */
    public function setValue($value) {
        #Debug::show($value);
        if (is_a($value,'DataList')) {
            $vals = $value->column('Title');
            $vals = implode(", ",$vals);
            parent::setValue($vals);
        } else if (is_string($value)) {
            parent::setValue($value);
        } else if (is_array($value)) {
            $vals = implode(", ",$value);
            parent::setValue($vals);
        }


        return $this;
    }

	function saveInto(DataObjectInterface $record) {
        if($this->name) {
            if ($this->tagSaveType == 'field') {
                parent::saveInto($record);
            } else if ($record->hasMethod($this->name)) {
                //Debug::show($this->Value());
                $tags = explode(",",$this->Value());
                //Debug::show($tags);
                /** @var RelationList $tagrel  */
                $tagrel = $record->{$this->name}();
                //Debug::show($tagrel);
                $keep = array();
                foreach($tags as $tagname) {
                    /** @var bool|DOTag $tag  */
                    $tag = DOTag::findOrCreateTag($tagname);
                    if ($tag) {
                        #Debug::show($tag);
                        $keep[] = $tag->ID;
                        if (!$tagrel->find('ID',$tag->ID)) {
                            $tagrel->add($tag);

                        }
                    }
                }
                // delete tags which are no longer on this relation
                $all = $tagrel->column("ID");
                //Debug::show($all);

                // do this the hard way since i don't trust the array functions
                for($i=0;$i<sizeof($all);$i++) {
                    if (!in_array($all[$i],$keep)) {
                        $tagrel->removeByID($all[$i]);
                    }
                }

            }

        }
    }

}
