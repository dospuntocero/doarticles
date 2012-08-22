<?php
LeftAndMain::require_css('DOArticles/css/doarticleadmin.css');
Object::add_extension('DOArticle', 'DOArticleURLSegmentDecorator');
Object::add_extension('DOTag', 'DOArticleURLSegmentDecorator');
Object::add_extension('Page', 'DOArticleDecorator');