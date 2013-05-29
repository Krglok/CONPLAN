<?php
/*
 Projekt :  MAIN

Datei   :  main.php

Datum   :  2002/06/12

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird der Oeffentliche Teil der HP abgewickelt.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es werden Datenbanklisten generiert.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis
./pages
Die images kommen aus dem Verzeichnis
./images
Die HTML Seiten werden mit der Funktion
function print_data($html_file)
dargestellt.

Die zugehoerigen HTML Seiten sollten in einem Subdir sein siehe 2)
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe sind in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Seiten liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem parallelen Pfad 
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.

1.1  2004/01/27   Länge des Kalenders geaendert, kw1, kw2 nicht LIMIT des SELECT
#1   20.11.2007		Länge des Kalenders geändert, "AND  < kw2 "  entfernt, damit alle
folgenden Wochen angezeigt werden.
Folgejahr mit abgefragt durch "OR jahr =$j1
Order Klausel geaendert auf "jahr,kw"

REVISION
#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

Ver 3.0 / 04.02.2013
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
include_once '_log_lib.inc';




function get_menu_main($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
	// manuelles main menu
	$menu = array (0=>array("icon" => "0","caption" => "Hauptseite","link" => "ss","itemtyp"=>"0"),
			1=>array ("icon" => "_page","caption" => "Übersicht","link" => "main.html","itemtyp"=>"2"),
			2=>array ("icon" => "_list","caption" => "News","link" => "$PHP_SELF?md=12","itemtyp"=>"0"),
//			3=>array ("icon" => "_list","caption" => "Termine","link" => "$PHP_SELF?md=11","itemtyp"=>"0"),
			5=>array ("icon" => "_key","caption" => "Innerer Zirkel","link" => "slogin.html","itemtyp"=>"2"),
			6=>array ("icon" => "0","caption" => "","link" => "","itemtyp"=>"0"),
			10=>array ("icon" => "_page","caption" => "Kurzdarstellung","link" => "kurzdars.html","itemtyp"=>"2"),
//			11=>array ("icon" => "_page","caption" => "LPD","link" => "lpd.html","itemtyp"=>"2"),
			12=>array ("icon" => "_page","caption" => "Unsere Regeln","link" => "main_sub.php?md=0&sub=regeln"),
//			13=>array ("icon" => "_page","caption" => "Unser Spielgebiet","link" => "weg_viet.html","itemtyp"=>"2"),
//			14=>array ("icon" => "_list","caption" => "Unsere Spieler","link" => "main_sub.php?md=0&sub=spieler"),
//			15=>array ("icon" => "_list","caption" => "Unsere Spieler","link" => "$PHP_SELF?md=10&sub=spieler"),
			20=>array ("icon" => "0","caption" => "","link" => "","itemtyp"=>"0"),
			21=>array ("icon" => "_page","caption" => "Die Welt","link" => "main_sub.php?md=0&sub=land"),
//			22=>array ("icon" => "_page","caption" => "Neue Chronik","link" => "main_chronik.php"),
			//		23=>array ("icon" => "_page","caption" => "Ausrüstung","link" => "main_ausruestung.php","itemtyp"=>"0"),
			24=>array ("icon" => "_page","caption" => "Bilder","link" => "main_bilder.php?md=0","itemtyp"=>"0"),
			30=>array ("icon" => "0","caption" => "","link" => "","itemtyp"=>"0"),
//			31=>array ("icon" => "_link","caption" => "Liberi Effera","link" => "http://www.liberi-effera.de/","itemtyp"=>"0"),
			32=>array ("icon" => "_link","caption" => "Draskoria","link" => "http://draskoria.game-host.org:8090/ ","itemtyp"=>"0"),
			//		33=>array ("icon" => "_zip","caption" => "Download","link" => "main_download.php","daten"=>"","itemtyp"=>"0"),
			34=>array ("icon" => "_list","caption" => "Links","link" => "links.html","itemtyp"=>"2"),
			50=>array ("icon" => "_help","caption" => "Ich","link" => "ich.html","itemtyp"=>"2"),
			51=>array ("icon" => "_help","caption" => "Impressum","link" => "impressum.html","itemtyp"=>"2")
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
$BEREICH = 'PUBLIC';

print_header("Hauptseite");
print_body(2);

// Steuerparameter und steuerdaten
$md     =GET_md(0);
$daten  =GET_daten("");
$item   =GET_item("");
$sub    =GET_sub("main");
$id     =GET_id(0);

$ID     =GET_SESSIONID("0");

$link = "help_view.php?md=$md&item=$item&sub=$sub&daten=$daten";
$menu_item = array ("icon" => $menu_help, "caption" => "Hilfe","link" => "javascript:openHelp('$link')","itemtyp"=>"0");


print_kopf($logo_typ,$header_typ,"Öffentlich",$anrede,$menu_item);

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";

$home = "main.php";
//prueft ob ein dynamisches menu vorhanden ist
  $menu = get_menu_main($md,$PHP_SELF, $ID,"Hauptseite",$id,$daten,$sub,$home);
	print_menu($menu);

// Auswahl der Aktion durch $md
if (do_standard_md($md, $daten, $sub, $ID) == false)
{
// und erstellen das Datenbereiches
	switch ($md):
	case 0: // MAIN MENU
	  	$daten='main.html';
	    print_pages($daten);
	    break;
	default: // MAIN MENU    
		print_news();
		break;
	endswitch;
}
	// Erstellt Body Ende
	print_body_ende();



	?>