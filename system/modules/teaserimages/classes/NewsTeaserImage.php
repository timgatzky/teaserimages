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

class NewsTeaserImage extends \Frontend
{
	/**
	 * Insert a teaser image to the template
	 * @param object
	 * @param array
	 * @return void
	 * called from parseArticles HOOK
	 */
	public function addTeaserImage($objTemplate, $row)
	{
		if(!$objTemplate->teaser_addImage)
		{
			return;
		}
		
		// original image setting
		$addNewsImage = $objTemplate->addImage;
		$addTeaserImage = $objTemplate->teaser_addImage;
		
		// overwrite image sizes if set in module
		if($row['size'] != '')
		{
			$objTemplate->size = $row['size'];
			$objTemplate->teaser_size = $row['size'];
		}	
		
		// teaser image
		if($addTeaserImage)
		{
			// fetch teaser image
			$objFile = \FilesModel::findByPk($objTemplate->teaser_singleSRC);
			if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
			{
				return;
			}
			$objTemplate->teaser_singleSRC = $objFile->path;
					
			$arrTeaserImage = array
			(
				'singleSRC'		=> $objTemplate->teaser_singleSRC,
				'size'			=> $objTemplate->teaser_size,
				'alt'			=> $objTemplate->teaser_alt,
				'imageUrl'		=> $objTemplate->teaser_imageUrl,
				'fullsize'		=> $objTemplate->teaser_fullsize,
				'floating'		=> $objTemplate->teaser_floating,
				'imagemargin'	=> $objTemplate->teaser_imagemargin,
				'linkedimage'	=> $objTemplate->teaser_linkedimage,
			);
			
		}
		
		// news image		
		if($addNewsImage)
		{
			// store news image data
			$arrNewsImage = array
			(
				'singleSRC'		=> $objTemplate->singleSRC,
				'size'			=> $objTemplate->size,
				'alt'			=> $objTemplate->alt,
				'imageUrl'		=> $objTemplate->imageUrl,
				'fullsize'		=> $objTemplate->fullsize,
				'floating'		=> $objTemplate->floating,
				'imagemargin'	=> $objTemplate->imagemaring
			);
		}
		
		// Add teaser image.
		if($addTeaserImage)
		{
			//Use contao internal function. (overwrites news image values)
			parent::addImageToTemplate($objTemplate, $arrTeaserImage);
			
			// set template vars
			$objTemplate->teaser_imgSize = $objTemplate->imgSize;
			$objTemplate->teaser_src = $objTemplate->src;
			$objTemplate->teaser_attributes = $objTemplate->attributes;
			$objTemplate->teaser_addBefore = $objTemplate->addBefore;
			$objTemplate->teaser_margin = $objTemplate->margin;
			$objTemplate->teaser_title = $objTemplate->title;
			$objTemplate->teaser_alt = $objTemplate->alt;
			$objTemplate->teaser_href = $objTemplate->href;
			$objTemplate->teaser_float = $objTemplate->float;
			$objTemplate->teaser_floatClass = $objTemplate->floatClass;
			
			// link to post
			if($objTemplate->teaser_linkedimage && TL_MODE == 'FE')
			{
				$objTemplate->teaser_href = $objTemplate->link;
				$objTemplate->teaser_attributes = $objTemplate->teaser_fullsize ? LINK_NEW_WINDOW : '';
			}
		}
		
		// Add news image.
		if($addNewsImage)
		{
			// restore news image in template
			parent::addImageToTemplate($objTemplate, $arrNewsImage);
		}
		
		$objTemplate->addImage = $addNewsImage;
		$objTemplate->teaser_addImage = $addTeaserImage;
	}
	
}

?>