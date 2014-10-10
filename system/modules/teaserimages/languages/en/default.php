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
 * @package    Catalog 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['teaser'] = array('Teasertext', '');
$GLOBALS['TL_LANG']['tl_content']['teaser_addImage'] = array('Add image', 'Add an image to the teaser.');

$GLOBALS['TL_LANG']['tl_article']['teaser_linkedimage'] = array('Link image', 'Link the teaser image to this article.');
$GLOBALS['TL_LANG']['tl_news']['teaser_linkedimage'] = array('Link image', 'Link the teaser image to this post.');
$GLOBALS['TL_LANG']['tl_calender_events']['teaser_linkedimage'] = array('Link image', 'Link the teaser image to this event.');

$GLOBALS['TL_LANG']['tl_content']['addImage']     = array('Add an image', 'Add an image to the content element.');
$GLOBALS['TL_LANG']['tl_content']['singleSRC']    = array('Source file', 'Please select a file or folder from the files directory.');
$GLOBALS['TL_LANG']['tl_content']['alt']          = array('Alternate text', 'An accessible website should always provide an alternate text for images and movies with a short description of their content.');
$GLOBALS['TL_LANG']['tl_content']['size']         = array('Image width and height', 'Here you can set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_content']['imagemargin']  = array('Image margin', 'Here you can enter the top, right, bottom and left margin.');
$GLOBALS['TL_LANG']['tl_content']['imageUrl']     = array('Image link target', 'A custom image link target will override the lightbox link, so the image cannot be viewed fullsize anymore.');
$GLOBALS['TL_LANG']['tl_content']['fullsize']     = array('Full-size view/new window', 'Open the full-size image in a lightbox or the link in a new browser window.');
$GLOBALS['TL_LANG']['tl_content']['floating']     = array('Image alignment', 'Please specify how to align the image.');
$GLOBALS['TL_LANG']['tl_content']['caption']      = array('Image caption', 'Here you can enter a short text that will be displayed below the image.');

?>
