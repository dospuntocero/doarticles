<?php
class DOArticlesURLSegmentDecorator extends Extension {

	static $db = array(
		'URLSegment' => 'Varchar(255)'
	);

	function onBeforeWrite() {
		if ($this->owner->isChanged('Title')) {
	      $this->owner->URLSegment = DOArticlesURLPageDecorator::generateURLSegment($this->owner->Title);
	    }
	}
}