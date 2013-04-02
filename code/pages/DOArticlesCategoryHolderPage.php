<?php

class doarticlesCategoryHolderPage extends Page {

	static $singular_name = "Article Categories Holder";
	static $icon = "doarticles/images/files.png";
	static $description = 'List of categories for adding articles';

	static $allowed_children = array("doarticlesCategoryPage"); // set to string "none" or array of classname(s)
	static $default_child = "doarticlesCategoryPage"; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = true; //
	static $hide_ancestor = null; //dont show ancestry class

	public function canCreate($member = null) {
		return DataList::create("doarticlesCategoryHolderPage")->count() < 1;
	}

}

class doarticlesCategoryHolderPage_Controller extends DOArticleViewer {

	//always redirect to the first category
	function init(){
		parent::init();
		if($this->Children()->Count()){
			$this->redirect($this->Children()->First()->AbsoluteLink());
		}
	}
}
