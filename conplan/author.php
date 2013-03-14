<?php
/*
 Projekt :  AUTHOR

Datei   :  author.php

Datum   :  2013/03/14 

Rev.    :  3.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Author Teil der HP abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis pages

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
//include_once ''; "_login.inc";



function get_menu_author_main($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
	$menu = array (
	"0"=>array("icon" => "0","caption" => $titel,"link" => "","itemtyp"=>"0"),
	"1"=>array ("icon" => "_page","caption" => "Public Bereiche","link" => "author_html.php?md=1&ID=$ID","itemtyp"=>"0"),
 	"2"=>array ("icon" => "_editor","caption" => "Intern Bereiche","link" => "author_data.php?md=1&ID=$ID","itemtyp"=>"0"),
	"3"=>array ("icon" => "_buble","caption" => "Bereich Menü","link" => "author_menu.php?md=1&ID=$ID","itemtyp"=>"0"),
// 	"4"=>array ("icon" => "_anmeld","caption" => "Anmeldung","link" => "larp_anmeldung.php?md=0&ID=$ID","itemtyp"=>"0"),
// 	"5"=>array ("icon" => "_folder","caption" => "Bilder 1-99","link" => "larp_bilder.php?md=0&ID=$ID","itemtyp"=>"0"),
	"99"=>array ("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=99&ID=$ID&sub=main&item=regeln","itemtyp"=>"0"),
	);
	
	return $menu;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

	$BEREICH = 'AUTHOR';
	
	$md     = GET_md(0);
	$daten  = GET_daten("");
	$sub    = GET_sub("");
	$id     = GET_id(0);
	
	
	$ID     = GET_SESSIONID("");
	session_id ($ID);
	session_start();
	$user       = $_SESSION["user"];
	$user_lvl   = $_SESSION["user_lvl"];
	$spieler_id = $_SESSION["spieler_id"];
	$user_id 	= $_SESSION["user_id"];
	$SID        = $_SESSION["ID"];
	
	if ($ID != $SID)
	{
		header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
		exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
		// Code ausgeführt wird.
	}
	
	if (is_user()==FALSE)
	{
	//  echo "no lvl";	
	  header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
	    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	  // Code ausgeführt wird.
	}
	
	print_header("Interner Bereich");
	print_body(2);
	
	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";
	
	$menu_item = $menu_item_help;
	$anrede["name"] = $spieler_name;
	
	print_kopf($logo_typ,$header_typ,"AUTHOR",$anrede,$menu_item);
	
	$titel = "INTERN";
	$home = "larp.php";
	
	$menu = get_menu_author_main($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);
	
	print_menu($menu);
	
	switch ($md):
	case 1:
		print_kalender();
		break;
	default:
		print_news();
		break;
	endswitch;

	print_md_ende();

	?>