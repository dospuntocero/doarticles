<?php
/**
 * Created by JetBrains PhpStorm.
 * User: smathews
 * Date: 7/18/12
 * Time: 3:15 PM
 * -------------------------------------
 */
class ByYearFilter extends SearchFilter {

    public function apply(DataQuery $query) {
        $this->model = $query->applyRelation($this->relation);
        //return $query->where($this->getDbName() . " LIKE '" . Convert::raw2sql($this->getValue()) . "%'");
        $theVal = (int) $this->getValue();
        return $query->where("YEAR(".$this->getDbName().") = " . $theVal);
    }

    public function isEmpty() {
        return $this->getValue() == null || $this->getValue() == '' || (int) $this->getValue() < 1;
    }

}
