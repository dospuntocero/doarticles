<?php
/**
 * Created by JetBrains PhpStorm.
 * User: smathews
 * Date: 7/18/12
 * Time: 7:25 PM
 * -------------------------------------
 */
class ByMonthFilter extends SearchFilter {
    public function apply(DataQuery $query) {
        $this->model = $query->applyRelation($this->relation);
        //return $query->where($this->getDbName() . " LIKE '" . Convert::raw2sql($this->getValue()) . "%'");
        $theVal = (int) $this->getValue();
        return $query->where("MONTH(".$this->getDbName().") = " . $theVal);
    }

    public function isEmpty() {
        return $this->getValue() == null || $this->getValue() == '' || (int) $this->getValue() < 1;
    }
}
