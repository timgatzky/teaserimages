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
 * @package    Calendar 
 * @license    LGPL 
 * @filesource
 */

class CalendarEventsTeaserImage extends Frontend
{
	public function getAllEventsHook($arrEvents, $arrCalendars, $intStart, $intEnd)
	{
		// bring calendars array in correct order for comparing with cal_calendar BLOB in tl_module
		// sorting by name/title
		
		$objFields = $this->Database->prepare("SELECT id,title FROM tl_calendar WHERE id IN(" . implode(',', $arrCalendars) . ") ORDER BY title" )
						->execute();
		if(!$objFields->numRows) return ;
		
		while($objFields->next())
		{
			$cal_calendar[] = $objFields->id;
		}
		
		
		// get module settings
		$objModule = $this->Database->prepare("SELECT id,name,type,cal_calendar,cal_noSpan,cal_format,imgSize FROM tl_module WHERE type=? AND cal_calendar=?")
						->execute( 'eventlist', serialize($cal_calendar) );
		if(!$objModule->numRows) return $arrEvents;
		
		$short = $objModule->cal_noSpan;
		$defaultSize = deserialize($objModule->imgSize);
		
		$arrReturn = array();
		foreach($arrEvents as $date => $startDate)
		{
			foreach($startDate as $time => $events)
			{
				foreach($events as $i => $event)
				{
					if($event['teaser_addImage'] && is_file(TL_ROOT . '/' . $event['teaser_singleSRC']) )
					{
						// overwrite default image settings
						$size = deserialize($event['teaser_size']);
						if(!strlen($size[0]) && !strlen($size[1])) 
						{
							$size = $defaultSize;
						}
						// generate image
						$src = $event['teaser_singleSRC'];
						$src = $this->getImage($src, $size[0], $size[1], $size[2]);
						
						$event['teaser_margin'] = $this->generateMargin(deserialize($event['teaser_imagemargin']), 'padding');
 						$event['teaser_src'] = $src;
 						
 						
 						// Image dimensions
						if (($imgSize = @getimagesize(TL_ROOT .'/'. $src)) !== false)
						{
							$event['teaser_imgSize'] = ' ' . $imgSize[3];
						}
														
						// Float image
						if (in_array($event['teaser_floating'], array('left', 'right')))
						{
						   	$event['teaser_floatClass'] = ' float_' . $event['teaser_floating'];
						  	$event['teaser_float'] = ' float:' . $event['teaser_floating'] . ';';	
						}
						
						// Image link
						if (strlen($event['teaser_imageUrl']) && !$event['teaser_linkedimage'] && TL_MODE == 'FE')
						{
						    $event['teaser_href'] = $event['teaser_imageUrl'];
						   	$event['teaser_attributes'] = $event['teaser_fullsize'] ? LINK_NEW_WINDOW : '';
						}
						// Fullsize view
						elseif ($event['teaser_fullsize'] && !$event['teaser_linkedimage'] && TL_MODE == 'FE')
						{
							if (!$strLightboxId) $strLightboxId = 'lightbox';
							$event['teaser_attributes'] = ' rel="' . $strLightboxId . '"';
							$event['teaser_href'] = $this->urlEncode($event['teaser_singleSRC']);
						}
 						
 						// Link to post, overwrite all other link settings
 						if($event['teaser_linkedimage'] && TL_MODE == "FE")
						{
							$event['teaser_href'] = $event['href'];
							$event['teaser_attributes'] = $event['teaser_fullsize'] ? LINK_NEW_WINDOW : '';
						}
						
						$event['teaser_addBefore'] = ($event['teaser_floating'] != 'below');
						
					}
					
					$arrReturn[$date][$time][$i] = $event;
					
				}
			}
		}
		
	
		$arrEvents = $arrReturn;
		return $arrEvents;
		
	}
}

?>