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
 * HOOKS
 */
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('NewsTeaserImage', 'addTeaserImage');
$GLOBALS['TL_HOOKS']['getAllEvents'][] = array('CalendarEventsTeaserImage', 'addTeaserImage');
