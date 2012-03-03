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

$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback'][]=array('tl_calendar_events_teaserimage', 'modifyPalette');


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'][] = 'teaser_addImage';

$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace(
	'teaser;',
	'teaser,teaser_addImage;',	
	$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

/**
 * Subpalettes
 */
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes'], 1, array
(
	'teaser_addImage'		=> 'teaser_singleSRC,teaser_alt,teaser_size,teaser_imagemargin,teaser_imageUrl,teaser_fullsize,teaser_caption,teaser_floating,teaser_linkedimage', 
));

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['fields'], 1, array
(
		'teaser_addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser_addImage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'teaser_singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true)
		),
		'teaser_alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long')
		),
		#'teaser_size' => array
		#(
		#	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
		#	'exclude'                 => true,
		#	'inputType'               => 'imageSize',
		#	'options'                 => array('crop', 'proportional', 'box'),
		#	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
		#	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
		#),
		'teaser_size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => $GLOBALS['TL_CROP'],
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50')
		),
		'teaser_imagemargin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'teaser_imageUrl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageUrl'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_calendar_events', 'pagePicker')
			)
		),
		'teaser_fullsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'teaser_linkedimage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calender_events']['teaser_linkedimage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50 m12')
		),
		'teaser_caption' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'teaser_floating' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
			'exclude'                 => true,
			'inputType'               => 'radioTable',
			'options'                 => array('above', 'left', 'right', 'below'),
			'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC']
		),
));


class tl_calendar_events_teaserimage extends Backend
{
	public function modifyPalette()
	{
		if($GLOBALS['TL_CONFIG']['teaser_events_tinymce'])
		{
			$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['teaser'] = array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser'],
				'exclude'                 => false,
				'search'                  => true,
				'inputType'               => 'textarea',
				'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
				'explanation'             => 'insertTags'
			);
		}
		
		// Version-Fallback: Check contao version to use old fashion scalemode for images
		if (version_compare(VERSION . '.' . BUILD, '2.11.0', '<'))
      	{
      		$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['teaser_size'] = array
			(
			   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
			   'exclude'                 => false,
			   'inputType'               => 'imageSize',
			   'options'                 => array('crop', 'proportional', 'box'),
			   'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			   'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
			);
      	}
	}
	
	
}





?>