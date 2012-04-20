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
 * @ Thanks to Torben Stoffer <stoffer@wangaz.com> for the extension xArticlesImage
 */

$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][]=array('tl_article_teaserimage', 'modifyPalette');

		

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'addImage';

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(
	'teaser;',
	'teaser,addImage;',	
	$GLOBALS['TL_DCA']['tl_article']['palettes']['default']
);

/**
 * Subpalettes
 */
array_insert($GLOBALS['TL_DCA']['tl_article']['subpalettes'], 1, array
(
	'addImage'		=> 'singleSRC,alt,size,imagemargin,imageUrl,fullsize,caption,floating,linkedimage', 
));

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_article']['fields'], 1, array
(
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser_addImage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true)
		),
		'alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long')
		),
		#'size' => array
		#(
		#	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
		#	'exclude'                 => true,
		#	'inputType'               => 'imageSize',
		#	'options'                 => array('crop', 'proportional', 'box'),
		#	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
		#	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
		#),
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => $GLOBALS['TL_CROP'],
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50')
	
		),
		'imagemargin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'imageUrl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageUrl'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_article_teaserimage', 'pagePicker')
			)
		),
		'fullsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'linkedimage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_article']['teaser_linkedimage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50 m12')
		),
		'caption' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'floating' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
			'exclude'                 => true,
			'inputType'               => 'radioTable',
			'options'                 => array('above', 'left', 'right', 'below'),
			'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC']
		),
));
			

class tl_article_teaserimage extends Backend
{
	
	public function modifyPalette()
	{
		if($GLOBALS['TL_CONFIG']['teaser_articles_tinymce'])
		{
			$GLOBALS['TL_DCA']['tl_article']['fields']['teaser'] = array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser'],
				'exclude'                 => false,
				'search'                  => true,
				'inputType'               => 'textarea',
				'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
				'explanation'             => 'insertTags'
			);
		}
		else
		{
			$GLOBALS['TL_DCA']['tl_article']['fields']['teaser'] = array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser'],
				'exclude'                 => false,
				'search'                  => true,
				'inputType'               => 'textarea',
				'eval'                    => array(),
				'explanation'             => 'insertTags'
			);
		
		}
		
		// Version-Fallback: Check contao version to use old fashion scalemode for images
		if (version_compare(VERSION . '.' . BUILD, '2.11.0', '<'))
      	{
      		$GLOBALS['TL_DCA']['tl_article']['fields']['size'] = array
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
	
		
		
			/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
		public function pagePicker(DataContainer $dc)
		{
			$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
			return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
		}
		
	
}





?>