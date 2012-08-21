<?php

class GroupedAndSubGroupedList extends GroupedList {
    /**
     * @param  string $index
     * @return ArrayList
     */
    public function groupBy($index) {
        $result = array();

        foreach ($this->list as $item) {
            $key = is_object($item) ? $item->$index : $item[$index];

            if (array_key_exists($key, $result)) {
                $result[$key]->push($item);
            } else {
                //$result[$key] = new ArrayList(array($item));
                $result[$key] = GroupedAndSubGroupedList::create(new ArrayList());
                $result[$key]->push($item);
            }
        }

        return $result;
    }



}
