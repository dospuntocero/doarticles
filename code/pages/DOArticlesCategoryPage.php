<?php
class DOArticlesCategoryPage extends Page {

	static $singular_name = "Articles Category Page";
	static $icon = "doarticles/images/article-category.png";
	static $allowed_children = array('DOArticlesCategoryPage'); // set to string "none" or array of classname(s)
	static $default_child = "none"; //one classname
	static $default_parent = null; // NOTE: has to be a URL segment NOT a class name
	static $can_be_root = false; //
	static $hide_ancestor = null; //dont show ancestry class
	
	static $many_many = array(
		'DOArticles' => 'DOArticle',
	);
	
	public function canCreate($member = null) {
		return DataList::create("DOArticlesCategoryHolderPage")->count() >= 1;
	}

	
	
	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$config = GridFieldConfig::create();
		$config->addComponent(new GridFieldToolbarHeader());
		$config->addComponent(new GridFieldAddNewButton('toolbar-header-right'));
		$config->addComponent(new GridFieldDataColumns());
		$config->addComponent(new GridFieldEditButton());
		$config->addComponent(new GridFieldDeleteAction());
		$config->addComponent(new GridFieldDetailForm());
		$config->addComponent(new GridFieldSortableHeader());

		$gridField = new GridField('DOArticles', _t('DOArticlesCategoryPage.ARTICLES',"Articles"), $this->DOArticles(), $config);

		$fields->addFieldToTab("Root.Articles", $gridField);
		return $fields;
	}
	
	
}

class DOArticlesCategoryPage_Controller extends DOArticleViewer {

}