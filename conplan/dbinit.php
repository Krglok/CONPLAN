<?php
/*
delimiter $$

CREATE TABLE `menu_bereich` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `bereich` varchar(45) DEFAULT NULL,
  `bereich_titel` varchar(45) DEFAULT NULL,
  `bereich_lvl` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='bereiche der homepage'$$


delimiter $$

CREATE TABLE `menu_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` varchar(25) NOT NULL,
  `item` varchar(45) DEFAULT NULL,
  `item_titel` varchar(45) DEFAULT NULL,
  `item_typ` int(11) DEFAULT NULL,
  `item_icon_typ` int(11) DEFAULT NULL,
  `item_icon` varchar(45) DEFAULT NULL,
  `item_link` varchar(200) DEFAULT NULL,
  `item_sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_item` (`item`),
  KEY `idx_sort` (`item_sort`),
  KEY `idx_link` (`item_link`),
  KEY `idx_ref` (`ref_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Menu eintraege der sub_bereiche, konkrete menus'$$

delimiter $$

CREATE TABLE `menu_page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` varchar(25) NOT NULL,
  `page` varchar(45) DEFAULT NULL,
  `page_titel` varchar(100) DEFAULT NULL,
  `page_typ` int(11) DEFAULT '1',
  `page_icon_typ` int(11) DEFAULT NULL,
  `page_icon` varchar(45) DEFAULT NULL,
  `page_layout` varchar(45) DEFAULT 'default',
  `page_text` text,
  PRIMARY KEY (`ID`),
  KEY `idx_page` (`page`),
  KEY `idx_ref_page` (`ref_sub`,`page`),
  KEY `idx_titel` (`page_titel`),
  KEY `idx_ref` (`ref_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='die pages zu den Subbereiche, enthaelt hmtl bzw. text conten'$$

delimiter $$

CREATE TABLE `menu_sub` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_bereich` varchar(25) NOT NULL,
  `sub` varchar(25) DEFAULT NULL,
  `sub_titel` varchar(45) DEFAULT NULL,
  `sub_html` varchar(200) DEFAULT 'pages/',
  `sub_images` varchar(200) DEFAULT 'images/',
  PRIMARY KEY (`ID`),
  KEY `idx_sub` (`sub`),
  KEY `idx_ref` (`ref_bereich`),
  KEY `idx_ref_sub` (`ref_bereich`,`sub`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='subbereich oder pagebereich'$$

delimiter $$

CREATE TABLE `mfd_cols` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_mfd` varchar(25) DEFAULT NULL,
  `mfd_pos` int(11) DEFAULT NULL,
  `mfd_field` varchar(45) DEFAULT NULL,
  `mfd_field_titel` varchar(45) DEFAULT NULL,
  `mfd_width` int(11) DEFAULT '35',
  PRIMARY KEY (`ID`),
  KEY `idx_refmfm` (`ref_mfd`,`mfd_pos`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Spaltendefinition MFD'$$

delimiter $$

CREATE TABLE `mfd_list` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` varchar(25) DEFAULT NULL,
  `mfd_name` varchar(25) DEFAULT NULL,
  `mfd_table` varchar(45) DEFAULT NULL,
  `mfd_titel` varchar(45) DEFAULT NULL,
  `mfd_fields` varchar(250) DEFAULT NULL,
  `mfd_join` varchar(250) DEFAULT NULL,
  `mfd_where` varchar(250) DEFAULT NULL,
  `mfd_order` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_name` (`mfd_name`),
  KEY `idx_table` (`mfd_table`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Liste der Main Formular Definition'$$


  
  
 */