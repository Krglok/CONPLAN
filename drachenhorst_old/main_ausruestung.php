<?php

/*
 Projekt :  MAIN

Datei   :  $RCSfile: main_ausruestung,v $

Datum   :  2002/06/12

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Subseite fuer den Bereich Ausruestung
abgewickelt.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es werden HTML Seiten angezeigt,
die folgenden Subdir  werden werden relativ benutzt

./ausruestung  2)

Die images kommen ebenfalls aus dem Verzeichnis

./images

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

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



*/

include "config.inc";
include "lib.inc";
include "head.inc";




// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------


print_header("PUBLIC_PAGE");

print_body(4);

print_kopf(1,2,"Öffentlich","Sei gegrüsst Freund ");

print_md();

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$daten = $_GET['daten'];

//echo "POST : $p_md / GET : $md / THEMEN :$daten ";
switch ($md):
case 2:
	$menu = array (0=>array("icon" => "99","caption" => "BAUANLEITUNG","link" => ""),
			1=>array ("icon" => "7","caption" => "Bauanleitung","link" => "$PHP_SELF?md=2&daten=ausruestung/bauanleit.html"),
			2=>array ("icon" => "7","caption" => "Schritt 1","link" => "$PHP_SELF?md=2&daten=ausruestung/bau_zuschnei.html"),
			3=>array ("icon" => "7","caption" => "Bild 1","link" => "$PHP_SELF?md=2&daten=ausruestung/bauanleit2.html"),
			4=>array ("icon" => "7","caption" => "Schritt 2","link" => "$PHP_SELF?md=2&daten=ausruestung/bau_rohling.html"),
			5=>array ("icon" => "7","caption" => "Bild 2","link" => "$PHP_SELF?md=2&daten=ausruestung/bauanleit3.html"),
			6=>array ("icon" => "7","caption" => "Schritt 3","link" => "$PHP_SELF?md=2&daten=ausruestung/bau_fertigst.html"),
			19=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=1&daten=ausruestung/ausruestung.html")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "AUSRÜSTUNG","link" => ""),
	1=>array ("icon" => "7","caption" => "Bauanleitung(alt)","link" => "$PHP_SELF?md=2&daten=ausruestung/bauanleit.html"),
	2=>array ("icon" => "7","caption" => "Basisausrüstung","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_basis.html"),
	3=>array ("icon" => "7","caption" => "Waffen","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_waffen.html"),
	4=>array ("icon" => "7","caption" => "Rüstung","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_armor.html"),
	5=>array ("icon" => "7","caption" => "Schusswaffen","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_schussw.html"),
	6=>array ("icon" => "7","caption" => "Berufe","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_beruf.html"),
	7=>array ("icon" => "7","caption" => "Lager","link" => "$PHP_SELF?md=1&daten=ausruestung/aus_lager.html"),
	19=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
	);
	break;
	endswitch;

	print_menu($menu);
	switch ($md):
case 1:
		print_data($daten);
	break;
case 2:
	print_data($daten);
	break;
default: // MAIN MENÜ
	$daten='ausruestung/ausruestung.html';
	print_data($daten);
	break;
	endswitch;
	print_md_ende();
	print_body_ende();



	?>