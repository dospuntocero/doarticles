<?php
class DOArticleURLSegmentDecorator extends DataExtension {

	static $db = array(
		'URLSegment' => 'Varchar(255)'
		);

	function onBeforeWrite() {
		$this->owner->URLSegment = singleton('SiteTree')->generateURLSegment($this->owner->Title);
	}
}