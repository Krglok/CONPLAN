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
 
*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";


/**
 * Erstellt eine Liste von News , max 10, als Tabelle
 * Kann direkt in die Datatab geschrieben werden.
 */
function print_news()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	echo "<TABLE >";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news order by id DESC LIMIT 10")
	or die("Query Fehler...");

	while ($row = mysql_fetch_row($result))
	{
		echo "<TR>";
		echo "<td>$row[0]&nbsp;<BR><BR><BR>";
		echo "</td>\n";
		echo "<td>$row[1]<BR>$row[2]<BR>$row[3]<BR>";
		echo "</td>\n";
		echo '</TR>';
	}

	mysql_close($db);
	echo '</TABLE>';
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	};



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist
// keine user pruefung, da es eine public seite ist
$BEREICH = 'PUBLIC';
print_header("Hauptseite");
print_body(2);

$PHP_SELF = $_SERVER['PHP_SELF'];
// Steuerparameter und steuerdaten
$md=GET_md(0);
$daten=GET_daten("");
$menu=GET_menu("");
$sub=GET_sub("main");

$menu_item = array("icon" => $menu_help, "caption" => "Help","link" => "javascript:openHelp()");
print_kopf($logo_typ,$header_typ,"Öffentlich","Sei gegrüsst Freund ",$menu_item);

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";


// $menu = array (0=>array("icon" => "99","caption" => "Hauptseite","link" => "ss"),
// 		1=>array ("icon" => "7","caption" => "Übersicht","link" => "$PHP_SELF?md=0&daten=main.html"),
// 		2=>array ("icon" => "5","caption" => "News","link" => "$PHP_SELF?md=5"),
// 		3=>array ("icon" => "5","caption" => "Termine","link" => "$PHP_SELF?md=4"),
// 		4=>array ("icon" => "5","caption" => "Liberi Effera","link" => "http://www.liberi-effera.de/"),
// 		5=>array ("icon" => "13","caption" => "Innerer Zirkel","link" => "$PHP_SELF?md=2&daten=slogin.html"),
// 		6=>array ("icon" => "0","caption" => "","link" => ""),
// 		10=>array ("icon" => "7","caption" => "Kurzdarstellung","link" => "$PHP_SELF?md=&2&daten=kurzdars.html"),
// 		11=>array ("icon" => "7","caption" => "LPD","link" => "$PHP_SELF?md=2&daten=lpd.html"),
// 		12=>array ("icon" => "1","caption" => "Unsere Regeln","link" => "main_regeln.php?md=0"),
// 		13=>array ("icon" => "7","caption" => "Unser Spielgebiet","link" => "$PHP_SELF?md=2&daten=weg_viet.html"),
// 		14=>array ("icon" => "1","caption" => "Unsere Spieler","link" => "main_spieler.php?md=0"),
// 		20=>array ("icon" => "0","caption" => "","link" => ""),
// 		21=>array ("icon" => "1","caption" => "Das Land","link" => "main_pages.php?md=0"),
// 		22=>array ("icon" => "1","caption" => "Neue Chronik","link" => "main_chronik.php"),
// 		23=>array ("icon" => "1","caption" => "Ausrüstung","link" => "main_ausruestung.php"),
// 		24=>array ("icon" => "1","caption" => "Bilder","link" => "main_bilder.php?md=0"),
// 		30=>array ("icon" => "0","caption" => "","link" => ""),
// 		31=>array ("icon" => "1","caption" => "Draskoria","link" => "http://draskoria.game-host.org:8090/\"target=_blank\""),
// 		32=>array ("icon" => "1","caption" => "Download","link" => "main_download.php","daten"=>""),
// 		33=>array ("icon" => "5","caption" => "Links","link" => "$PHP_SELF?md=2&daten=links.html"),
// 		34=>array ("icon" => "7","caption" => "Ich","link" => "$PHP_SELF?md=2&daten=ich.html"),
// 		35=>array ("icon" => "10","caption" => "Impressum","link" => "$PHP_SELF?md=2&daten=Impressum.html")
// );

if ($menu == '')
{
	print_menu($menu_default);
} else
{
	// Erstellt ein dynamisches Menu
	print_menu(get_menu_items($BEREICH, $sub));
	
}

// Auswahl der Aktion durch $md
// und erstellen das Datenbereiches
switch ($md):
case 0: // MAIN MENU
  	$daten='main.html';
    print_pages($daten);
    break;
case 1: // html die in pages liegen
    print_data($daten);
    break;
case 2: // html der nicht in pages liegt
	print_pages($daten);
	break;
case 3: // MAIN MENU
	print_sc_liste();
	break;
case 4: // MAIN MENU
	print_kalender();
	break;
case 5:
	print_news();
	break;
default: // MAIN MENU    
	print_news();
	break;
endswitch;

	// Abschluss der Tabelle fuer Bereich Menue / Daten
	print_md_ende();
	// Erstellt Body Ende
	print_body_ende();



	?>