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

class NewsTeaserImage extends Frontend
{
	public function parseArticlesHook($objTemplate, $row)
	{
		// Retrieve default image size even if the regular news image is disabled
		$parentId = $objTemplate->pid;
		$objField = $this->Database->prepare("SELECT title FROM tl_news_archive WHERE id=?")
						->limit(1)
						->execute($objTemplate->pid);
		$archiveName = $objField->title;
				
		$objFields = $this->Database->prepare("SELECT imgSize, news_archives FROM tl_module WHERE type=?")
			->execute('newslist');
		
		// nothing found return		
		if(!$objFields->numRows) return;
		
		$arrFields = array();
		while($objFields->next() )
		{
			$arrFields[] = array(
				'imgSize' => $objFields->imgSize,
				'archives' => deserialize($objFields->news_archives),
			);
			
		}
		
		foreach($arrFields as $i => $value)
		{
			$flipped = array_flip($value['archives']); // flip to prepare to search for existing keys not values
			if(array_key_exists($objTemplate->pid, $flipped))
			{
				$arrSize = $value['imgSize'];
			}
			
		}
		
		
		$teaser_imgSize = false;
		$teaser_imgSize = $arrSize; // default size
		
		// Override the default image size
		if ($objTemplate->teaser_size != '')
		{
			$size = deserialize($objTemplate->teaser_size);
			if ($size[0] > 0 || $size[1] > 0)
			{
				$teaser_imgSize = $objTemplate->teaser_size;
			}
		}
		
		$arrImage = array();
		$arrImage['size'] = $teaser_imgSize;
		$arrImage['singleSRC'] = $objTemplate->teaser_singleSRC;
		$arrImage['alt'] = $objTemplate->teaser_alt;
		$arrImage['imageUrl'] = $objTemplate->teaser_imageUrl; // only need if image is not wrapped in an anchor
		$arrImage['fullsize'] = $objTemplate->teaser_fullsize;
		$arrImage['floating'] = $objTemplate->teaser_floating;
		$arrImage['caption'] = $objTemplate->teaser_caption;
		$arrImage['imagemargin'] = $objTemplate->teaser_imagemargin;
		
		// Add the teaser image
		if ($objTemplate->teaser_addImage && is_file(TL_ROOT . '/' . $objTemplate->teaser_singleSRC))
		{
			if ($teaser_imgSize)
			{
				$objTemplate->teaser_size = $teaser_imgSize;
			}
			$this->addImageToTemplate($objTemplate, $arrImage);
		}
		
		
	}
	
	/**
	 * Add an image to a template
	 * @param object
	 * @param array
	 * @param integer
	 * @param string
	 */
	protected function addImageToTemplate($objTemplate, $arrItem, $intMaxWidth=false, $strLightboxId=false)
	{
		$size = deserialize($arrItem['size']);
		$imgSize = getimagesize(TL_ROOT .'/'. $arrItem['singleSRC']);
		
				
		if (!$intMaxWidth)
		{
			$intMaxWidth = (TL_MODE == 'BE') ? 320 : $GLOBALS['TL_CONFIG']['maxImageWidth'];
		}

		if (!$strLightboxId)
		{
			$strLightboxId = 'lightbox';
		}

		// Store original dimensions
		$objTemplate->width = $imgSize[0];
		$objTemplate->height = $imgSize[1];
	
		// Adjust image size
		if ($intMaxWidth > 0 && ($size[0] > $intMaxWidth || (!$size[0] && !$size[1] && $imgSize[0] > $intMaxWidth)))
		{
			$arrMargin = deserialize($arrItem['imagemargin']);
			
			// Subtract margins
			if (is_array($arrMargin) && $arrMargin['unit'] == 'px')
			{
				$intMaxWidth = $intMaxWidth - $arrMargin['left'] - $arrMargin['right'];
			}

			// See #2268 (thanks to Thyon)
			$ratio = ($size[0] && $size[1]) ? $size[1] / $size[0] : $imgSize[1] / $imgSize[0];

			$size[0] = $intMaxWidth;
			$size[1] = floor($intMaxWidth * $ratio);
		}
		$src = $this->getImage($this->urlEncode($arrItem['singleSRC']), $size[0], $size[1], $size[2]);
		
		// Image dimensions
		if (($imgSize = @getimagesize(TL_ROOT .'/'. $teaser_src)) !== false)
		{
			$objTemplate->teaser_arrSize = $imgSize;
			$objTemplate->teaser_imgSize = ' ' . $teaser_imgSize[3];
			
		}
		// Float image
		if (in_array($arrItem['floating'], array('left', 'right')))
		{
			$objTemplate->teaser_floatClass = ' float_' . $arrItem['floating'];
			$objTemplate->teaser_float = ' float:' . $arrItem['floating'] . ';';
		}
		
		// Image link
		if (strlen($arrItem['imageUrl']) && TL_MODE == 'FE')
		{
			$objTemplate->teaser_href = $arrItem['imageUrl'];
			$objTemplate->teaser_attributes = $arrItem['fullsize'] ? LINK_NEW_WINDOW : '';
		}

		// Fullsize view
		elseif ($arrItem['fullsize'] && TL_MODE == 'FE')
		{
			$objTemplate->teaser_href = $this->urlEncode($arrItem['singleSRC']);
			$objTemplate->teaser_attributes = ' rel="' . $strLightboxId . '"';
		}
				
		// Link to post
		if($objTemplate->teaser_linkedimage && TL_MODE == "FE")
		{
			$objTemplate->teaser_href = $objTemplate->link;
			$objTemplate->teaser_attributes = $arrItem['fullsize'] ? LINK_NEW_WINDOW : '';
		}
		

		$objTemplate->teaser_src = $src;
		$objTemplate->teaser_alt = specialchars($arrItem['alt']);
		$objTemplate->teaser_fullsize = $arrItem['fullsize'] ? true : false;
		$objTemplate->teaser_addBefore = ($arrItem['floating'] != 'below');
		$objTemplate->teaser_margin = $this->generateMargin(deserialize($arrItem['imagemargin']), 'padding');
		$objTemplate->teaser_caption = $arrItem['caption'];
		$objTemplate->teaser_addImage = true;
	}



	//public function parseFrontendTemplateHook($strContent, $strTemplate)
	//{
	//	if(strstr($strTemplate, 'teaserimage') )
	//	{
	//	
	//	}
	//	return $strContent;
	//}
}

?>