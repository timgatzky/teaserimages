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


class CalendarEventsTeaserImage extends \Frontend
{
	/**
	 * Add teaser image to template
	 * @param array
	 * @param array
	 * @param integer
	 * @param integer
	 * @return array
	 * called from getAllEvents HOOK
	 */
	public function addTeaserImage($arrEvents, $arrCalendars, $intStart, $intEnd, $objModule)
	{
		$arrReturn = array();
		foreach($arrEvents as $date => $startDate)
		{
			foreach($startDate as $time => $events)
			{
				foreach($events as $i => $event)
				{
					if($event['teaser_addImage'])
					{
						// overwrite image size if set in module
						$size = deserialize($event['teaser_size']);
						if($objModule->size != '')
						{
							$size = deserialize($objModule->imgSize);
						}
						
						// fetch teaser image
						$objFile = \FilesModel::findByPk($event['teaser_singleSRC']);
						if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
						{
							return;
						}
						$event['teaser_singleSRC'] = $objFile->path;
						
						// create psydo template object to call addImageToTemplate Function
						$objTemplate = new \FrontendTemplate($objModule->cal_template);
						
						$arrTeaserImage = array
						(
							'singleSRC'		=> $event['teaser_singleSRC'],
							'size'			=> $event['teaser_size'],
							'alt'			=> $event['teaser_alt'],
							'imageUrl'		=> $event['teaser_imageUrl'],
							'fullsize'		=> $event['teaser_fullsize'],
							'floating'		=> $event['teaser_floating'],
							'imagemargin'	=> $event['teaser_imagemargin'],
							'linkedimage'	=> $event['teaser_linkedimage']
						);					 
						parent::addImageToTemplate($objTemplate,$arrTeaserImage);
						
						// set vars
						$event['teaser_singleSRC'] 		= $objTemplate->singleSRC;
						$event['teaser_src'] 			= $objTemplate->src;
						$event['teaser_href']			= $objTemplate->href;
						$event['teaser_alt']			= $objTemplate->alt;
						$event['teaser_title']			= $objTemplate->title;
						$event['teaser_imageUrl']		= $objTemplate->imageUrl;
						$event['teaser_fullsize']		= $objTemplate->fullsize;
						$event['teaser_float']			= $objTemplate->float;
						$event['teaser_floatClass']		= $objTemplate->floatClass;
						$event['teaser_margin']			= $objTemplate->margin;
						$event['teaser_imgSize'] 		= $objTemplate->imgSize;
						$event['teaser_attributes']		= $objTemplate->attributes;
						$event['teaser_addBefore']		= $objTemplate->addBefore;
						
 						// Link to post, overwrite all other link settings
 						if($event['teaser_linkedimage'] && TL_MODE == "FE")
						{
							$event['teaser_href'] = $event['href'];
							$event['teaser_attributes'] = $objTemplate->fullsize ? LINK_NEW_WINDOW : '';
						}
						
						// remove temp. template
						unset($objTemplate);
					}
					
					// set
					$arrReturn[$date][$time][$i] = $event;
				}
			}
		}
	
		$arrEvents = $arrReturn;
		return $arrEvents;
	}
}
