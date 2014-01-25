<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2012
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		teaserimages
 * @link		http://contao.org
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');

/**
 * Modify dca
 */
$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][] = array('tl_article_teaserimages', 'modifyDca');

/**
 * Selectors
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'addImage';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['addImage'] = 'singleSRC,alt,size,imagemargin,imageUrl,fullsize,caption,floating,linkedimage';

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace
(
	'teaser;',
	'teaser,addImage;',	
	$GLOBALS['TL_DCA']['tl_article']['palettes']['default']
);

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_article']['fields'], 1, array
(
	'addImage' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['addImage'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('submitOnChange'=>true),
	   'sql'                     => "char(1) NOT NULL default ''"
	),
	'singleSRC' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
	   'exclude'                 => true,
	   'inputType'               => 'fileTree',
	   'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true),
	   'sql'					 => "binary(16) NULL",
	),
	'alt' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
	   'exclude'                 => true,
	   'search'                  => true,
	   'inputType'               => 'text',
	   'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'size' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
	   'exclude'                 => true,
	   'inputType'               => 'imageSize',
	   'options'                 => $GLOBALS['TL_CROP'],
	   'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	   'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	   'sql'                     => "varchar(64) NOT NULL default ''"
	),
	'imagemargin' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
	   'exclude'                 => true,
	   'inputType'               => 'trbl',
		'options'                 => array('px', '%', 'em', 'ex', 'pt', 'pc', 'in', 'cm', 'mm'),
		'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
		'sql'                     => "varchar(128) NOT NULL default ''"
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
	   		array('tl_article_teaserimages', 'pagePicker')
	   ),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'fullsize' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('tl_class'=>'w50 m12'),
	   'sql'                     => "char(1) NOT NULL default ''"
	),
	'caption' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
	   'exclude'                 => true,
	   'search'                  => true,
	   'inputType'               => 'text',
	   'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
	   'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'floating' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
	   'exclude'                 => true,
	   'inputType'               => 'radioTable',
	   'options'                 => array('above', 'left', 'right', 'below'),
	   'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
	   'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	   'sql'                     => "varchar(12) NOT NULL default ''"
	),
	'linkedimage' => array
	(
	   'label'                   => &$GLOBALS['TL_LANG']['tl_article']['teaser_linkedimage'],
	   'exclude'                 => true,
	   'inputType'               => 'checkbox',
	   'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50 m12'),
	   'sql'                     => "char(1) NOT NULL default '1'"
	),
));

// Backwards compatibility
if (version_compare(VERSION, '3.2', '<'))
{
	$GLOBALS['TL_DCA']['tl_article']['fields']['singleSRC']['sql'] = "varchar(255) NOT NULL default ''";
}

			

class tl_article_teaserimages extends \Backend
{
	/**
	 * Modify dca
	 * @param object
	 * @return void
	 */
	public function modifyDca(DataContainer $dc)
	{
		if(!$GLOBALS['TL_CONFIG']['teaser_articles_tinymce'])
		{
			unset($GLOBALS['TL_DCA']['tl_article']['fields']['teaser']['eval']['rte']);
		}
	}	
		
	/**
	 * Return the link picker wizard
	 * @param \DataContainer
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="contao/page.php?do='.Input::get('do').'&amp;table='.$dc->table.'&amp;field='.$dc->field.'&amp;value='.str_replace(array('{{link_url::', '}}'), '', $dc->value).'" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']).'" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\''.specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])).'\',\'url\':this.href,\'id\':\''.$dc->field.'\',\'tag\':\'ctrl_'.$dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '').'\',\'self\':this});return false">' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}

		
	
}





?>