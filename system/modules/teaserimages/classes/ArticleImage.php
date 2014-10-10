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


class ArticleImage extends \Frontend
{
	/**
	 * Add image to template
	 * @param object
	 * @param boolean
	 */
	public function __construct($objTemplate, $isCE = false) 
 	{
 		$articleHref = $objTemplate->href;
 		$arrImage = array();
 		
 		// handle include articles
 		if($isCE)
 		{
 			$objDatabase = \Database::getInstance();
 			$objArticle = $objDatabase->prepare("SELECT * FROM tl_article WHERE id=?")
 							->limit(1)
 							->execute($objTemplate->article);
 			
 			if(!$objArticle->addImage)
 			{
 				return;
 			}
 			$arrImage = $objArticle->row();
 			
 			// fetch teaser image
			$objFile = \FilesModel::findByPk($arrImage['singleSRC']);
			if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
			{
				return;
			}
			$arrImage['singleSRC'] = $objFile->path;
 		}
 		
 		// regular article
 		if(!$isCE && $objTemplate->addImage) 		
 		{
 			// fetch teaser image
			$objFile = \FilesModel::findByPk($objTemplate->singleSRC);
			if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
			{
				return;
			}
			$objTemplate->singleSRC = $objFile->path;
 			
 			$arrImage = array
 			(
 				'addImage' 		=> $objTemplate->addImage,
 				'singleSRC' 	=> $objTemplate->singleSRC,
 				'alt' 			=> $objTemplate->alt,
 				'size' 			=> $objTemplate->size,
 				'imagemargin' 	=> $objTemplate->imagemargin,
 				'floating' 		=> $objTemplate->floating,
 				'fullsize' 		=> $objTemplate->fullsize,
 				'caption' 		=> $objTemplate->caption,
 				'linkedimage' 	=> $objTemplate->linkedimage,
 				'imageUrl' 		=> $objTemplate->imageUrl,
 			);
	 	}
	 	
	 	if(count($arrImage) < 1)
	 	{
		 	return;
	 	}
	 	
	 	// add image to template
 		parent::addImageToTemplate($objTemplate, $arrImage);
 		
 		$objTemplate->imageHref = $arrImage['imageUrl'];
 		$objTemplate->href = $articleHref;
	 			
 		// prepare for lightbox
 		if($arrImage['fullsize'] && !$arrImage['linkedimage'] && !$arrImage['imageUrl'])
 		{
 			$objTemplate->imageHref = $arrImage['singleSRC'];
 		}
 		
 		// link to article
 		if($arrImage['linkedimage'] && TL_MODE == 'FE')
 		{
 			$objTemplate->imageHref = $articleHref;
			$objTemplate->attributes = $objTemplate->fullsize ? LINK_NEW_WINDOW : '';
 		}
 	}
}


?>