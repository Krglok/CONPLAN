<?php
/*
 Projekt :  LARP

Datei   :  larp.php

Datum   :  2002/06/12 17:39:02

Rev.    :  3.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Interne Teil der HP abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis

./

Die images kommen aus dem Verzeichnis

./images

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

Die zugehoerigen HTML Seiten sollten in einem Subdir sein 2)
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.


#1   20.11.2007		Länge des Kalenders geändert, "AND  < kw2 "  entfernt, damit alle
folgenden Wochen angezeigt werden.
Folgejahr mit abgefragt durch "OR jahr =$j1
Order Klausel geaendert auf "jahr,kw"

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
//include_once ''; "_login.inc";




// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$BEREICH = 'INTERN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
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
  echo "no lvl";	
  header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

print_header("Interner Bereich");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;

print_kopf($logo_typ,$header_typ,"Intern",$anrede,$menu_item);

if ($item == '')
{
	$menu = array (
	"0"=>array("icon" => "0","caption" => "INTERN","link" => "","itemtyp"=>"0"),
	"1"=>array ("icon" => "$menu_list","caption" => "Spieler","link" => "larp_sc.php?md=1&ID=$ID","itemtyp"=>"0"),
	"2"=>array ("icon" => "$menu_folder","caption" => "Forum Intern","link" => "larp_forum_1.php?md=1&ID=$ID","itemtyp"=>"0"),
	"3"=>array ("icon" => "$menu_folder","caption" => "Forum MC","link" => "larp_forum_2.php?md=1&ID=$ID","itemtyp"=>"0"),
	"4"=>array ("icon" => "$menu_folder","caption" => "Anmeldung","link" => "larp_anmeldung.php?md=0&ID=$ID","itemtyp"=>"0"),
	"5"=>array ("icon" => "$menu_folder","caption" => "Bilder","link" => "larp_bilder.php?md=0&ID=$ID","itemtyp"=>"0"),
	"6"=>array ("icon" => "$menu_folder","caption" => "Neue Bilder","link" => "larp_bilder1.php?md=0&ID=$ID","itemtyp"=>"0"),
	"7"=>array ("icon" => "$menu_folder","caption" => "Termine","link" => "$PHP_SELF?md=1&ID=$ID","itemtyp"=>"0"),
//	"8"=>array ("icon" => "$menu_zip","caption" => "Download","link" => "larp_download.php?md=0&ID=$ID","itemtyp"=>"0"),
	"9"=>array ("icon" => "$menu_list","caption" => "Regelwerk","link" => "larp_regeln.php?md=0&ID=$ID","itemtyp"=>"0"),
	"20"=>array ("icon" => "0","caption" => "","link" => "","itemtyp"=>"0"),
//	"21"=>array ("icon" => "$menu_folder","caption" => "Charakter","link" => "char_liste.php?md=0&ID=$ID","itemtyp"=>"0"),
	"23"=>array ("icon" => "$menu_list","caption" => "Legenden","link" => "larp_legende.php?md=0&ID=$ID","itemtyp"=>"0"),
	"24"=>array ("icon" => "$menu_folder","caption" => "Sprueche","link" => "larp_magie.php?md=0&ID=$ID","itemtyp"=>"0"),
//	"25"=>array ("icon" => "$menu_folder","caption" => "Traenke","link" => "larp_trank_liste.php?md=0&ID=$ID","itemtyp"=>"0"),
//	"26"=>array ("icon" => "$menu_folder","caption" => "Bibliothek","link" => "larp_gdw_liste.php?md=0&ID=$ID","itemtyp"=>"0"),
//	"27"=>array ("icon" => "$menu_folder","caption" => "Bibliothekar","link" => "larp_gdw.php?md=0&ID=$ID","itemtyp"=>"0"),
	"29"=>array ("icon" => "$menu_stop","caption" => "ENDE","link" => "main.php?md=99&ID=$ID&sub=main&item=regeln","itemtyp"=>"0"),
	"30"=>array ("icon" => "_link","caption" => "Draskoria","link" => "http://draskoria.game-host.org:8090/ \"target=_blank\"","itemtyp"=>"0"),
	"31"=>array ("icon" => "_link","caption" => "GdW","link" => "/gdw_bib/  \"target=_blank\"","itemtyp"=>"0"),
	"32"=>array ("icon" => "_link","caption" => "Liberi Effera","link" => "http://www.liberi-effera.de/ \"target=_blank\"","itemtyp"=>"0"),
	);
	print_menu($menu);
} else
{
	// Erstellt ein dynamisches Menu
	print_menu(get_menu_items($BEREICH, $sub, $item));

}

// switch ($md):
// case 1: //  SPIELERLISTE
// 	$menu = array (0=>array("icon" => "99","caption" => "Termine","link" => ""),
// 			1=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
// 	);
// 	break;
// case 2:
// 	break;
// default: // MAIN MENÜ
// 	endswitch;
switch ($md):
case 1:
		print_kalender();
	break;
case 2:
	break;
case 4:
	break;
case 5:
	break;
default:
	print_news();
	break;
	endswitch;

	print_md_ende();

	?>