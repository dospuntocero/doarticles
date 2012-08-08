<?php

Object::add_extension('DOArticle', 'DOArticleURLSegmentDecorator');
Object::add_extension('Page', 'DOArticleDecorator');

//Director::addRules(10, array(ArticleViewer::$url_segment => 'ArticleViewer'));