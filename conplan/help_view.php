<?php
/*
Projekt :  MAIN

Datei   :  help.php

Datum   :  2002/06/12

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Hilfe aufgerufen.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es wird Datenbankeintraegen gesucht, ansonsten wird die Hilfe 
HTML Page aufgerufen.
Die Hilfe Seiten werden in einem separaten Fenster aufgerufen.

Ver 3.0 / 04.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.
 
*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_log_lib.inc';

function print_help_header()
{
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<meta content=\"text/html; charset=iso-8859-1\" http-equiv=\"Content-Type\">
<meta content=\"Olaf Duda\" name=\"Author\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"../Layout/konzept1.css\">
</head>
<body id=\"help_1\">
";
}

function print_help_body_ende()
{
echo "</body>
</html>
";
}

function get_menu_hilfe($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
	// manuelles main menu
	$menu = array (0=>array("icon" => "0","caption" => "Hilfeseite","link" => "ss","itemtyp"=>"0"),
			1=>array ("icon" => "_page","caption" => "Übersicht","link" => "main.html","itemtyp"=>"2"),
	);
	return $menu;
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keine user pruefung, da es eine public seite ist
	$BEREICH = 'HILFE';
	// Steuerparameter und steuerdaten
	$md     =GET_md(0);
	$item   =GET_item("");
	$sub    =GET_sub("main");
	$daten  =GET_daten("");
	
	if (get_help_page($item, $md, $datem, $sub) !==false)
	{
	print_help_header("Hilfeseite");
	print_body();
	//prueft ob ein dynamisches menu vorhanden ist
	print_menu($menu);
		
	// Erstellt Body Ende
	print_help_body_ende();
	} else
	{
//$menu_item_help = array ("icon" => $menu_help, "caption" => "Hilfe","link" => "javascript:openHelp()","itemtyp"=>"0");
			
		$html_file = "./help/help.html";
		
	}


	?>