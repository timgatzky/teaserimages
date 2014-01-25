<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Teaserimages
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'ArticleImage'              => 'system/modules/teaserimages/classes/ArticleImage.php',
	'CalendarEventsTeaserImage' => 'system/modules/teaserimages/classes/CalendarEventsTeaserImage.php',
	'NewsTeaserImage'           => 'system/modules/teaserimages/classes/NewsTeaserImage.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_teaser'                  => 'system/modules/teaserimages/templates',
	'event_short_teaserimage'    => 'system/modules/teaserimages/templates',
	'mod_article_teaser'         => 'system/modules/teaserimages/templates',
	'news_full_tags_teaserimage' => 'system/modules/teaserimages/templates',
	'news_full_teaserimage'      => 'system/modules/teaserimages/templates',
	'news_latest_teaserimage'    => 'system/modules/teaserimages/templates',
	'news_short_teaserimage'     => 'system/modules/teaserimages/templates',
));
