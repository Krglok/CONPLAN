-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db451197603.db.1and1.com
-- Erstellungszeit: 31. Mai 2013 um 11:41
-- Server Version: 5.1.67
-- PHP-Version: 5.3.3-7+squeeze15
-- 
-- Datenbank: `db451197603`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `artefakte`
-- 

CREATE TABLE IF NOT EXISTS `artefakte` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `ismagisch` enum('true','false') COLLATE latin1_german2_ci DEFAULT NULL,
  `Stufe` int(11) unsigned DEFAULT '0',
  `bezeichnung` text COLLATE latin1_german2_ci,
  `herstellung` text COLLATE latin1_german2_ci,
  `wert` int(10) unsigned DEFAULT NULL,
  `mp_find` int(10) unsigned DEFAULT NULL,
  `mp_ident` int(10) unsigned DEFAULT NULL,
  `mp_zer` int(10) unsigned DEFAULT NULL,
  `r_sc` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_nsc` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_ort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_sort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=235 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=235 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bib_bereich`
-- 

CREATE TABLE IF NOT EXISTS `bib_bereich` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `bereich` char(5) COLLATE latin1_german2_ci DEFAULT NULL,
  `bereich_name` char(100) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bib_item`
-- 

CREATE TABLE IF NOT EXISTS `bib_item` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `item` char(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `item_name` char(100) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `FieldName` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bib_thema`
-- 

CREATE TABLE IF NOT EXISTS `bib_thema` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `thema` char(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `thema_name` char(100) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bib_titel`
-- 

CREATE TABLE IF NOT EXISTS `bib_titel` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `bereich` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `thema` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `item` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `titel` varchar(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `Kurz` varchar(100) COLLATE latin1_german2_ci DEFAULT NULL,
  `Text` text COLLATE latin1_german2_ci,
  `Author` varchar(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `kalender` varchar(5) COLLATE latin1_german2_ci DEFAULT NULL,
  `jahr` varchar(5) COLLATE latin1_german2_ci DEFAULT NULL,
  `stichwort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `sort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `owner` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `zugriff` enum('public','protect','privat') COLLATE latin1_german2_ci DEFAULT 'privat',
  `pdf_link` varchar(100) COLLATE latin1_german2_ci DEFAULT NULL,
  `logo_link` varchar(100) COLLATE latin1_german2_ci DEFAULT NULL,
  `siegel_link` varchar(100) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `TYP` (`bereich`,`thema`),
  KEY `name` (`bereich`,`titel`)
) ENGINE=MyISAM AUTO_INCREMENT=295 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=295 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bib_zugriff`
-- 

CREATE TABLE IF NOT EXISTS `bib_zugriff` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bereich_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `bib_zugriff` enum('public','protect','privat') COLLATE latin1_german2_ci NOT NULL DEFAULT 'public',
  `bib_recht` enum('read','write') COLLATE latin1_german2_ci NOT NULL DEFAULT 'read',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bilder`
-- 

CREATE TABLE IF NOT EXISTS `bilder` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `sort` tinyint(3) unsigned DEFAULT NULL,
  `lfd` tinyint(3) unsigned DEFAULT NULL,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `beschreibung` text COLLATE latin1_german2_ci,
  `imgtype` varchar(65) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `sort` (`tag`,`sort`,`lfd`)
) ENGINE=MyISAM AUTO_INCREMENT=2564 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=2564 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bilder_topic`
-- 

CREATE TABLE IF NOT EXISTS `bilder_topic` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `sort` tinyint(3) unsigned DEFAULT NULL,
  `path` varchar(65) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_basis`
-- 

CREATE TABLE IF NOT EXISTS `char_basis` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `spieler_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `beruf` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `rasse` enum('Mensch','Elf','Halbelf','Kender','Zwerg','Gnom','Drow','Andere') COLLATE latin1_german2_ci NOT NULL DEFAULT 'Mensch',
  `gilde` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `hintergrund` text COLLATE latin1_german2_ci,
  `nsc` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  `wappen_path` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `bild_path` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `lebenslauf` text COLLATE latin1_german2_ci,
  `tendenz` enum('H','N','D') COLLATE latin1_german2_ci DEFAULT 'N',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  `aktiv` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_fert`
-- 

CREATE TABLE IF NOT EXISTS `char_fert` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` int(10) unsigned NOT NULL DEFAULT '1',
  `EP` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=799 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=799 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_kopf`
-- 

CREATE TABLE IF NOT EXISTS `char_kopf` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `notority` float DEFAULT '1',
  `klasse` enum('MUK','MK') COLLATE latin1_german2_ci DEFAULT 'MUK',
  `lp` tinyint(3) NOT NULL DEFAULT '3',
  `mp` int(3) DEFAULT NULL,
  `mpn` int(3) DEFAULT NULL,
  `ap` tinyint(3) DEFAULT NULL,
  `ks` tinyint(3) DEFAULT NULL,
  `ep_start` int(3) DEFAULT NULL,
  `ep_tage` int(11) DEFAULT NULL,
  `ep_vorteil` int(3) DEFAULT NULL,
  `ep_nachteil` int(4) DEFAULT NULL,
  `ep_fert` int(4) DEFAULT NULL,
  `ep_waf` int(4) DEFAULT NULL,
  `ep_mag` int(4) DEFAULT NULL,
  `ep_alch` int(4) DEFAULT NULL,
  `ep_rest` int(4) DEFAULT NULL,
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=228 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_mag`
-- 

CREATE TABLE IF NOT EXISTS `char_mag` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `Name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` int(10) unsigned NOT NULL DEFAULT '1',
  `EP` tinyint(3) DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1386 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1386 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_nach`
-- 

CREATE TABLE IF NOT EXISTS `char_nach` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` int(10) unsigned NOT NULL DEFAULT '1',
  `EP` tinyint(3) DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=151 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_rasse`
-- 

CREATE TABLE IF NOT EXISTS `char_rasse` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `MK` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'N',
  `text` text COLLATE latin1_german2_ci,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Charakter Rassen als Referenz' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_tage`
-- 

CREATE TABLE IF NOT EXISTS `char_tage` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `Name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `conname` char(15) COLLATE latin1_german2_ci DEFAULT NULL,
  `con` tinyint(4) DEFAULT NULL,
  `tage` tinyint(10) DEFAULT '0',
  `con_ep` tinyint(3) DEFAULT '0',
  `sonder_ep` tinyint(3) DEFAULT '0',
  `notority` float DEFAULT '0',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=998 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=998 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_trank`
-- 

CREATE TABLE IF NOT EXISTS `char_trank` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `Name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` int(10) unsigned NOT NULL DEFAULT '1',
  `EP` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=203 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=203 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_vor`
-- 

CREATE TABLE IF NOT EXISTS `char_vor` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` int(10) unsigned NOT NULL DEFAULT '1',
  `EP` tinyint(3) DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `char_waf`
-- 

CREATE TABLE IF NOT EXISTS `char_waf` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `char_id` int(10) unsigned DEFAULT NULL,
  `Name` char(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `KS` int(10) unsigned NOT NULL DEFAULT '0',
  `EP` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `SL` enum('J','N') COLLATE latin1_german2_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=528 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=528 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_ablauf`
-- 

CREATE TABLE IF NOT EXISTS `con_ablauf` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S3` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `NAME` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `KURZ` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_GRP` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_NSC` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_SC` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_ORT` varchar(40) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_GERUECHT` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `R_LEGEND` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `BESCHREIBUNG` text COLLATE latin1_german2_ci,
  `TAG` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `TAG` (`TAG`)
) ENGINE=MyISAM AUTO_INCREMENT=1625 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1625 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_andienst`
-- 

CREATE TABLE IF NOT EXISTS `con_andienst` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `contag` tinyint(3) unsigned DEFAULT NULL,
  `typ` char(15) COLLATE latin1_german2_ci DEFAULT NULL,
  `spieler` char(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `ref_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=518 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Dienste fuer die Con Anmeldung' AUTO_INCREMENT=518 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_anmeldung`
-- 

CREATE TABLE IF NOT EXISTS `con_anmeldung` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `tag` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `email` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `abwasch` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `taverne` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `wc` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `nsc` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `aufbau` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `orga` enum('1','0') COLLATE latin1_german2_ci DEFAULT '0',
  `kommentar` text COLLATE latin1_german2_ci,
  `spieler_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ID` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1635 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1635 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_buch`
-- 

CREATE TABLE IF NOT EXISTS `con_buch` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `Kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `Text` text COLLATE latin1_german2_ci,
  `Wert` int(11) DEFAULT NULL,
  `r_sc` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_nsc` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_ort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_sort` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2_1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=475 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=475 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_geruecht`
-- 

CREATE TABLE IF NOT EXISTS `con_geruecht` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_nsc` varchar(30) COLLATE latin1_german2_ci DEFAULT '0',
  `r_sort` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Typ` tinyint(3) unsigned DEFAULT NULL,
  `frage` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `antwort_1` text COLLATE latin1_german2_ci,
  `antwort_2` text COLLATE latin1_german2_ci,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=449 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=449 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_gilde`
-- 

CREATE TABLE IF NOT EXISTS `con_gilde` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `notority` enum('Hell','Neutral','Dunkel') COLLATE latin1_german2_ci DEFAULT NULL,
  `hintergrund` text COLLATE latin1_german2_ci,
  `lebenslauf` text COLLATE latin1_german2_ci,
  `gm_id` int(10) unsigned DEFAULT NULL,
  `gm_name` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `NSC` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'J',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_grp_user`
-- 

CREATE TABLE IF NOT EXISTS `con_grp_user` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `grp_id` int(10) unsigned DEFAULT NULL,
  `lvl` tinyint(3) unsigned DEFAULT '10',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Zugriffliste für Con Gruppen' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_konst`
-- 

CREATE TABLE IF NOT EXISTS `con_konst` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` tinyint(3) unsigned DEFAULT NULL,
  `user_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=307 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_nsc`
-- 

CREATE TABLE IF NOT EXISTS `con_nsc` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_grp` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_spieler` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_ort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_sort` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Notority` float(10,2) DEFAULT NULL,
  `Hintergrund` text COLLATE latin1_german2_ci,
  `auf_1` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_2` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_3` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_4` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_5` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2_1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=977 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=977 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_orte`
-- 

CREATE TABLE IF NOT EXISTS `con_orte` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `Bezeichnung` text COLLATE latin1_german2_ci,
  `Magie` text COLLATE latin1_german2_ci,
  `r_nsc` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_art` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_buch` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_sort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=790 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=790 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_sc`
-- 

CREATE TABLE IF NOT EXISTS `con_sc` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `spieler_id` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_grp` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_char` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_ort` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `r_sort` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Notority` float(10,2) DEFAULT NULL,
  `Hintergrund` text COLLATE latin1_german2_ci,
  `auf_1` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_2` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_3` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_4` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `auf_5` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=498 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=498 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `con_tage`
-- 

CREATE TABLE IF NOT EXISTS `con_tage` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` tinyint(3) unsigned DEFAULT NULL,
  `von` date DEFAULT NULL,
  `bis` date DEFAULT NULL,
  `kosten` float DEFAULT NULL,
  `an_von` date DEFAULT NULL,
  `an_bis` date DEFAULT NULL,
  `bemerkung` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `text` text COLLATE latin1_german2_ci,
  `leg_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `download`
-- 

CREATE TABLE IF NOT EXISTS `download` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` text COLLATE latin1_german2_ci,
  `groesse` float DEFAULT NULL,
  `path` varchar(65) COLLATE latin1_german2_ci DEFAULT NULL,
  `bereich` enum('public','user','sl','admin') COLLATE latin1_german2_ci DEFAULT 'public',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `forum_post`
-- 

CREATE TABLE IF NOT EXISTS `forum_post` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `foren_id` int(10) unsigned NOT NULL DEFAULT '0',
  `top_id` int(10) unsigned NOT NULL DEFAULT '0',
  `post_id` int(10) unsigned DEFAULT NULL,
  `author` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `betreff` varchar(50) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `text` text COLLATE latin1_german2_ci,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=105150 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=105150 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `forum_topic`
-- 

CREATE TABLE IF NOT EXISTS `forum_topic` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(40) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `forums`
-- 

CREATE TABLE IF NOT EXISTS `forums` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `admin` varchar(40) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `email` varchar(40) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `zugriff` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pw` varchar(15) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `bezeichnung` text COLLATE latin1_german2_ci,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `hilfe`
-- 

CREATE TABLE IF NOT EXISTS `hilfe` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `help_modul` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `help_sub` varchar(45) COLLATE latin1_german2_ci NOT NULL,
  `help_page` varchar(45) COLLATE latin1_german2_ci NOT NULL,
  `help_md` int(11) NOT NULL,
  `lfd` int(5) DEFAULT '1',
  `help_titel` varchar(100) COLLATE latin1_german2_ci DEFAULT NULL,
  `text` text COLLATE latin1_german2_ci,
  PRIMARY KEY (`ID`),
  KEY `help_titel` (`help_titel`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `idea_post`
-- 

CREATE TABLE IF NOT EXISTS `idea_post` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `betreff` varchar(40) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `text` text COLLATE latin1_german2_ci,
  `kategorie` enum('INTIME','ORGA','SPIELER','SL','WEB') COLLATE latin1_german2_ci NOT NULL DEFAULT 'ORGA',
  `user_id` int(10) unsigned DEFAULT NULL,
  `erl` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kalender`
-- 

CREATE TABLE IF NOT EXISTS `kalender` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `jahr` int(10) unsigned NOT NULL DEFAULT '0',
  `kw` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `monat` tinyint(3) unsigned DEFAULT NULL,
  `mo` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `di` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mi` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `do` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fr` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sa` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `so` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mo_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `di_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `mi_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `do_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `fr_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `sa_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `so_typ` enum('nocon','aufbau','contag','basteln','vv') COLLATE latin1_german2_ci DEFAULT 'nocon',
  `bemerkung` char(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `contag` int(11) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `KAL_ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=537 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=537 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `legende`
-- 

CREATE TABLE IF NOT EXISTS `legende` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `S0` varchar(10) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `S1` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `S2` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `Kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `Datum` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `Beschreibung` text COLLATE latin1_german2_ci,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mag_grp`
-- 

CREATE TABLE IF NOT EXISTS `mag_grp` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `grp` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `grp_name` char(30) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mag_list`
-- 

CREATE TABLE IF NOT EXISTS `mag_list` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `grp` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `nr` smallint(5) unsigned DEFAULT NULL,
  `Stufe` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `Spruchdauer` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `Wirkdauer` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `Wirkbereich` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `Reichweite` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `Wirkung` text COLLATE latin1_german2_ci,
  `Kosten` varchar(75) COLLATE latin1_german2_ci DEFAULT NULL,
  `Patzer` text COLLATE latin1_german2_ci,
  `Ausfuehrung` text COLLATE latin1_german2_ci,
  `MUK` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'N',
  `RAR` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'N',
  `GEIST` enum('J','N') COLLATE latin1_german2_ci DEFAULT 'N',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `grp` (`grp`),
  KEY `Stufe` (`Stufe`),
  KEY `grp_2` (`grp`),
  KEY `grp_3` (`grp`)
) ENGINE=MyISAM AUTO_INCREMENT=364 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=364 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu_bereich`
-- 

CREATE TABLE IF NOT EXISTS `menu_bereich` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `bereich` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `bereich_titel` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `bereich_lvl` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='bereiche der homepage' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu_item`
-- 

CREATE TABLE IF NOT EXISTS `menu_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` int(11) NOT NULL,
  `item` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `item_titel` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `item_typ` int(11) DEFAULT NULL,
  `item_icon_typ` int(11) DEFAULT NULL,
  `item_icon` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `item_link` varchar(200) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `item_sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_item` (`item`),
  KEY `idx_sort` (`item_sort`),
  KEY `idx_link` (`item_link`),
  KEY `idx_ref` (`ref_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Menu eintraege der sub_bereiche, konkrete menus' AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu_page`
-- 

CREATE TABLE IF NOT EXISTS `menu_page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` varchar(45) NOT NULL,
  `page` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `page_titel` varchar(100) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `page_typ` int(11) DEFAULT '1',
  `page_icon_typ` int(11) DEFAULT NULL,
  `page_icon` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `page_layout` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT 'default',
  `page_text` text CHARACTER SET latin1 COLLATE latin1_german2_ci,
  PRIMARY KEY (`ID`),
  KEY `idx_page` (`page`),
  KEY `idx_ref_page` (`ref_sub`,`page`),
  KEY `idx_titel` (`page_titel`),
  KEY `idx_ref` (`ref_sub`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='die pages zu den Subbereiche, enthaelt hmtl bzw. text conten' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu_sub`
-- 

CREATE TABLE IF NOT EXISTS `menu_sub` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_bereich` int(11) NOT NULL,
  `sub` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `sub_bereich` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `sub_titel` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `sub_html` varchar(200) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT 'pages/',
  `sub_images` varchar(200) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT 'images/',
  `sub_typ` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `idx_sub` (`sub`),
  KEY `idx_ref` (`ref_bereich`),
  KEY `idx_ref_sub` (`ref_bereich`,`sub`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='subbereich oder pagebereich' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mfd_cols`
-- 

CREATE TABLE IF NOT EXISTS `mfd_cols` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_mfd` varchar(45) DEFAULT NULL,
  `mfd_pos` int(11) DEFAULT NULL,
  `mfd_field` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `mfd_field_titel` varchar(45) CHARACTER SET latin1 COLLATE latin1_german2_ci DEFAULT NULL,
  `mfd_width` int(11) DEFAULT '35',
  `mfd_field_typ` varchar(100) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_refmfm` (`ref_mfd`,`mfd_pos`)
) ENGINE=MyISAM AUTO_INCREMENT=179 DEFAULT CHARSET=latin1 COMMENT='Spaltendefinition MFD' AUTO_INCREMENT=179 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mfd_list`
-- 

CREATE TABLE IF NOT EXISTS `mfd_list` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_bereich` varchar(25) DEFAULT 'ADMIN',
  `ref_sub` varchar(25) DEFAULT 'main',
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
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COMMENT='Liste der Main Formular Definition' AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `news`
-- 

CREATE TABLE IF NOT EXISTS `news` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `text_1` char(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `Text_2` char(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `text_3` char(50) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=377 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=377 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `regelwerk`
-- 

CREATE TABLE IF NOT EXISTS `regelwerk` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `kapitel` tinyint(4) DEFAULT '0',
  `absatz` tinyint(3) unsigned DEFAULT '0',
  `item` tinyint(3) unsigned DEFAULT '0',
  `typ` enum('TE','FE','WA','RU','MA','TR') COLLATE latin1_german2_ci DEFAULT 'TE',
  `kurz` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `text` text COLLATE latin1_german2_ci,
  `index_1` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `index_2` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` tinyint(3) DEFAULT '0',
  `muk` tinyint(3) DEFAULT NULL,
  `mk` tinyint(3) DEFAULT NULL,
  `last_usr` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `last_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `last_usr` (`last_usr`)
) ENGINE=MyISAM AUTO_INCREMENT=886 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Online Datensammlung ' AUTO_INCREMENT=886 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `spieler`
-- 

CREATE TABLE IF NOT EXISTS `spieler` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `vorname` varchar(20) COLLATE latin1_german2_ci DEFAULT NULL,
  `Geb` date DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `orga` varchar(20) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `grprec` tinyint(3) unsigned DEFAULT NULL,
  `Bemerkung` text COLLATE latin1_german2_ci,
  `telefon` varchar(20) COLLATE latin1_german2_ci DEFAULT NULL,
  `charakter` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `orga` (`orga`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=167 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `syslog`
-- 

CREATE TABLE IF NOT EXISTS `syslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(1024) DEFAULT NULL,
  `typ` enum('INFO','ERROR','DEBUG') DEFAULT 'INFO',
  `user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2235 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2235 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `trank_grp`
-- 

CREATE TABLE IF NOT EXISTS `trank_grp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grp` char(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `name` char(30) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `trank_list`
-- 

CREATE TABLE IF NOT EXISTS `trank_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grp` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `nr` varchar(5) COLLATE latin1_german2_ci DEFAULT NULL,
  `name` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `stufe` tinyint(4) DEFAULT '1',
  `K1` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `K2` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `K3` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `K4` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `K5` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `K6` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `herstellung` text COLLATE latin1_german2_ci,
  `wirkung` text COLLATE latin1_german2_ci,
  `patzer` text COLLATE latin1_german2_ci,
  `R1` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R2` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R3` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R4` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R5` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R6` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Liste der Traenke' AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `trank_pflanz_list`
-- 

CREATE TABLE IF NOT EXISTS `trank_pflanz_list` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `grp` varchar(10) COLLATE latin1_german2_ci DEFAULT NULL,
  `nr` smallint(5) unsigned DEFAULT NULL,
  `realname` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` text COLLATE latin1_german2_ci,
  `R1` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R2` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R3` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R4` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R5` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  `R6` char(3) COLLATE latin1_german2_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci COMMENT='Liste der Alchimie Pflanzen und Stoffe' AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `user_liste`
-- 

CREATE TABLE IF NOT EXISTS `user_liste` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `spieler_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `pword` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  `lvl` int(11) NOT NULL DEFAULT '0',
  `old_pw` varchar(30) COLLATE latin1_german2_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `user_id_2` (`ID`),
  KEY `user_id` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=144 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `images`
-- 

-- 
-- Tabellenstruktur für Tabelle `download`
-- 

CREATE TABLE IF NOT EXISTS `images` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE latin1_german2_ci DEFAULT NULL,
  `kurz` text COLLATE latin1_german2_ci,
  `groesse` float DEFAULT NULL,
  `path` varchar(128) COLLATE latin1_german2_ci DEFAULT NULL,
  `bereich` enum('public','user','sl','admin') COLLATE latin1_german2_ci DEFAULT 'public',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=76 ;
