-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_calendar_events`
-- 

CREATE TABLE `tl_calendar_events` (
  `teaser_addImage` char(1) NOT NULL default '',
  `teaser_singleSRC` varchar(255) NOT NULL default '',
  `teaser_alt` varchar(255) NOT NULL default '',
  `teaser_size` varchar(64) NOT NULL default '',
  `teaser_imagemargin` varchar(128) NOT NULL default '',
  `teaser_imageUrl` varchar(255) NOT NULL default '',
  `teaser_fullsize` char(1) NOT NULL default '',
  `teaser_caption` varchar(255) NOT NULL default '',
  `teaser_floating` varchar(32) NOT NULL default '',
  `teaser_linkedimage` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 
-- Table `tl_news`
-- 

CREATE TABLE `tl_news` (
  `teaser_addImage` char(1) NOT NULL default '',
  `teaser_singleSRC` varchar(255) NOT NULL default '',
  `teaser_alt` varchar(255) NOT NULL default '',
  `teaser_size` varchar(64) NOT NULL default '',
  `teaser_imagemargin` varchar(128) NOT NULL default '',
  `teaser_imageUrl` varchar(255) NOT NULL default '',
  `teaser_fullsize` char(1) NOT NULL default '',
  `teaser_caption` varchar(255) NOT NULL default '',
  `teaser_floating` varchar(32) NOT NULL default '',
  `teaser_linkedimage` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_articles`
-- 

CREATE TABLE `tl_article` (
  `addImage` char(1) NOT NULL default '',
  `singleSRC` varchar(255) NOT NULL default '',
  `alt` varchar(255) NOT NULL default '',
  `size` varchar(64) NOT NULL default '',
  `imagemargin` varchar(128) NOT NULL default '',
  `imageUrl` varchar(255) NOT NULL default '',
  `fullsize` char(1) NOT NULL default '',
  `caption` varchar(255) NOT NULL default '',
  `floating` varchar(32) NOT NULL default '',
  `linkedimage` char(1) NOT NULL default '1',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


