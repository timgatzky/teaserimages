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
 		$articleHref = $objTemplate->href;
 	
 		// handle include articles
 		if($isCE)
 		{
 			$this->import('Database');
 			$objArticle = $this->Database->prepare("SELECT addImage,singleSRC,alt,size,imagemargin,fullsize,caption,floating,linkedimage,imageUrl FROM tl_article WHERE id=?")
 							->limit(1)
 							->execute($objTemplate->article);
 			
 			if(!$objArticle->addImage)
 			{
 				return '';
 			}
 			$arrImage = $objArticle->row();
 		}
 		
 		// regular article
 		if(!$isCE && $objTemplate->addImage) 		
 		{
 			$arrImage = array
 			(
 				'addImage' => $objTemplate->addImage,
 				'singleSRC' => $objTemplate->singleSRC,
 				'alt' => $objTemplate->alt,
 				'size' => $objTemplate->size,
 				'imagemargin' => $objTemplate->imagemargin,
 				'floating' => $objTemplate->floating,
 				'fullsize' => $objTemplate->fullsize,
 				'caption' => $objTemplate->caption,
 				'linkedimage' => $objTemplate->linkedimage,
 				'imageUrl' => $objTemplate->imageUrl,
 			);
	 	}
	 	
	 	// add image to template
 		$this->addImageToTemplate($objTemplate, $arrImage);
 		
 		$objTemplate->imageHref = $arrImage['imageUrl'];
 		 		
 		// prepare for lightbox
 		if($arrImage['fullsize'] && !$arrImage['linkedimage'] && !$arrImage['imageUrl'])
 		{
 			$objTemplate->imageHref = $arrImage['singleSRC'];
 		}
 		
 		// link on article
 		if($arrImage['linkedimage'])
 		{
 			$objTemplate->imageHref = $articleHref;
 			
 			// open in new window
 			if($arrImage['fullsize'])
 			{
 				$objTemplate->attributes = 'target="_blank"';
 			}
 		}
		
 	}
}


?>