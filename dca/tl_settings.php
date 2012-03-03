<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Tim Gatzky 2011 
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    News 
 * @license    LGPL 
 * @filesource
 */

/**
 * Palettes
 */
#$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'teaser_settings';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{teaser_settings_legend:hide},teaser_articles_tinymce,teaser_events_tinymce,teaser_news_tinymce;';

/**
 * Subpalettes
 */
//array_insert($GLOBALS['TL_DCA']['tl_settings']['subpalettes'], 1, array
//(
//	'teaser_news_settings'		=> 'teaser_news_tinymce', 
//
//));


/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_settings']['fields'], 1, array
(
		'teaser_articles_tinymce' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_articles_tinymce'],
			'default'				=> false,
			'exclude'               => true,
			'inputType'             => 'checkbox',
			'eval'                  => array('submitOnChange'=>false, 'tl_class'=>'w50')
		),
		'teaser_events_tinymce' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_events_tinymce'],
			'default'				=> false,
			'exclude'               => true,
			'inputType'             => 'checkbox',
			'eval'                  => array('submitOnChange'=>false, 'tl_class'=>'w50')
		),
		'teaser_news_tinymce' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['teaser_news_tinymce'],
			'default'				=> false,
			'exclude'               => true,
			'inputType'             => 'checkbox',
			'eval'                  => array('submitOnChange'=>false, 'tl_class'=>'w50')
		),

));

?>