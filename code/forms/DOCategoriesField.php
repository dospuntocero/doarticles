<?php

/**
 * DOCategoriesField
 * 
 * Extends the TreeMultiselectField to allow a dropdown lost of nested categories
 *
 * PHP version 5
 *
 * @package    DoArticles
 * @author     Cam Findlay <cam@camfindlay.com>
 * @copyright  2012 Cam Findlay Consulting
 * @version    SVN: $Id$      
 * @uses	   TreeMultiselectField
 */

class DOCategoriesField extends TreeMultiselectField {
  

  function __construct($name, $title, $sourceObject = "SiteTree", $keyField = "ID", $labelField = "Title") {
	  parent::__construct($name, $title, $sourceObject, $keyField, $labelField);
	  
}

  
/**
 * Finds the ID of the DOArticlesCategoryHolderPage as sets the top level treenode
 */  
public function setCategoryHolderNode(){
	
	$node = DOArticlesCategoryHolderPage::get()->First()->ID;
	
	$this->setTreeBaseID($node);
	
	
}  
  
  
}