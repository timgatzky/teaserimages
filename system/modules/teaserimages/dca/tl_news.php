<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package teaserimages
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');

/**
 * Modify dca
 */
$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][] = array('tl_news_teaserimages', 'modifyDca');

/**
 * Selectors
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['__selector__'][] = 'teaser_addImage';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_news']['subpalettes']['teaser_addImage'] = 'teaser_singleSRC,teaser_alt,teaser_size,teaser_imagemargin,teaser_imageUrl,teaser_fullsize,teaser_caption,teaser_floating,teaser_linkedimage';

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace
(
	'teaser;',
	'teaser,teaser_addImage;',	
	$GLOBALS['TL_DCA']['tl_news']['palettes']['default']
);

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_news']['fields'], 1, array
(
	'teaser_addImage' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['teaser_addImage'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('submitOnChange'=>true),
	   'sql'                     => "char(1) NOT NULL default ''"
	),
	'teaser_singleSRC' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
	   'exclude'                 => true,
	   'inputType'               => 'fileTree',
	   'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true),
	   'sql'					 => "binary(16) NULL",
	),
	'teaser_alt' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
	   'exclude'                 => true,
	   'search'                  => true,
	   'inputType'               => 'text',
	   'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'teaser_size' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
	   'exclude'                 => true,
	   'inputType'               => 'imageSize',
	   'options'                 => $GLOBALS['TL_CROP'],
	   'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	   'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	   'sql'                     => "varchar(64) NOT NULL default ''"
	),
	'teaser_imagemargin' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
	   'exclude'                 => true,
	   'inputType'               => 'trbl',
		'options'                 => array('px', '%', 'em', 'ex', 'pt', 'pc', 'in', 'cm', 'mm'),
		'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
		'sql'                     => "varchar(128) NOT NULL default ''"
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
	   	array('tl_news', 'pagePicker')
	   ),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'teaser_fullsize' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('tl_class'=>'w50 m12'),
	   'sql'                     => "char(1) NOT NULL default ''"
	),
	'teaser_caption' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
	   'exclude'                 => true,
	   'search'                  => true,
	   'inputType'               => 'text',
	   'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'teaser_floating' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
	   'exclude'                 => true,
	   'inputType'               => 'radioTable',
	   'options'                 => array('above', 'left', 'right', 'below'),
	   'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
	   'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	   'sql'                     => "varchar(12) NOT NULL default ''"
	),
	'teaser_linkedimage' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_news']['teaser_linkedimage'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50 m12'),
	   'sql'                     => "char(1) NOT NULL default '1'"
	),
));

// Backwards compatibility
if (version_compare(VERSION, '3.2', '<'))
{
	$GLOBALS['TL_DCA']['tl_news']['fields']['singleSRC']['sql'] = "varchar(255) NOT NULL default ''";
}

class tl_news_teaserimages extends Backend
{
	/**
	 * Modify dca
	 * @param object
	 * @return void
	 */
	public function modifyDca(DataContainer $dc)
	{
		if(!$GLOBALS['TL_CONFIG']['teaser_news_tinymce'])
		{
			unset($GLOBALS['TL_DCA']['tl_news']['fields']['teaser']['eval']['rte']);
		}
	}
}

