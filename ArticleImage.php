<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
    
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * 
 * 
 * Formerly known as TYPOlight Open Source CMS.
 *
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
 * @copyright  Tim Gatzky 2012
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    teaserimages
 * @license    LGPL 
 * @filesource
 */

class ArticleImage extends Frontend
{
	/**
	 * add an image to the article teaser
	 */
	public function __construct($objTemplate, $isCE = false) 
 	{
 		if($objTemplate->addImage)
 		{
 			$arrImage = array
 			(
 				'addImage' => $objTemplate->addImage,
 				'singleSRC' => $objTemplate->singleSRC,
 				'alt' => $objTemplate->alt,
 				'size' => $objTemplate->size,
 				'imagemargin' => $objTemplate->imagemargin,
 				'fullsize' => $objTemplate->fullsize,
 				'caption' => $objTemplate->caption,
 				'linkedimage' => $objTemplate->linkedimage,
 				'imageUrl' => $objTemplate->imageUrl,
 			);
 		}
 		
 		if($objTemplate->linkedimage || $objTemplate->imageUrl)
 		{
 			$objTemplate->imageHref = $objTemplate->href;
 			$arrImage['imageUrl'] = $objTemplate->href;
 		}
 		
 		if($objTemplate->fullsize && !$objTemplate->linkedimage && !$objTemplate->imageUrl)
 		{
 			$objTemplate->imageHref = $arrImage['singleSRC'];
 		}
 		
 		// always link on image if set
 		if($objTemplate->linkedimage)
 		{
 			$objTemplate->imageHref = $objTemplate->href;
 		}
 		
 		$this->addImageToTemplate($objTemplate, $arrImage);
 	}
}


?>