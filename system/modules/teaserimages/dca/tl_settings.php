<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2011
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		teaserimages
 * @link		http://contao.org
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{teaser_settings_legend:hide},teaser_articles_tinymce,teaser_events_tinymce,teaser_news_tinymce;';

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_settings']['fields'], 1, array
(
	'teaser_articles_tinymce' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_articles_tinymce'],
		'exclude'               => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('tl_class'=>'w50')
	),
	'teaser_events_tinymce' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_events_tinymce'],
		'exclude'               => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('tl_class'=>'w50')
	),
	'teaser_news_tinymce' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_news_tinymce'],
		'exclude'               => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('tl_class'=>'w50')
	),
));
