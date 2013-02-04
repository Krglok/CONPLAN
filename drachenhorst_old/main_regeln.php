<?php

/*
 Projekt : MAIN

Datei   :  main_regeln.php

Datum   :  2002/06/12

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Subseite fuer den Bereich Regeln
abgewickelt.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Im wesentlichen werden HTML Sieten angezeigt,
die folgenden Subdir  werden werden relativ benutzt

./regeln  2)
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

1.1  2004/01/27   Länge des Kalenders geaendert, kw1, kw2 nicht LIMIT des SELECT

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

print_header("Regeln");

print_body(2);

print_kopf(1,2,"Öffentlich","Sei gegrüsst Freund ");

print_md();

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$daten = $_GET['daten'];

//echo "POST : $p_md / GET : $md / THEMEN :$daten ";

$menu = array (0=>array("icon" => "99","caption" => "Usere Regeln","link" => "$PHP_SELF?md=1&daten=regeln.html"),
		1=>array ("icon" => "7","caption" => "Interne Regeln","link" => "$PHP_SELF?md=1&daten=regeln/regeln_erw.html"),
		2=>array ("icon" => "7","caption" => "Silbermond","link" => "$PHP_SELF?md=1&daten=regeln/regeln_kurz.html"),
		3=>array ("icon" => "7","caption" => "Con-Planung","link" => "$PHP_SELF?md=1&daten=regeln/regeln_con.html"),
		4=>array ("icon" => "7","caption" => "NSC-Klassen","link" => "$PHP_SELF?md=1&daten=regeln/regeln_nsc1.html"),
		5=>array ("icon" => "7","caption" => "Capture the Flag","link" => "$PHP_SELF?md=1&daten=regeln/regeln_cf1.html"),
		//               98=>array("icon" => "0","caption" => "","link" => "","target"=>""),
		19=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=1")
);

print_menu($menu);
switch ($md):
case 0: // MAIN MENÜ
	$daten='regeln/regeln.html';
print_data($daten);
break;

default: // MAIN MENÜ
	print_data($daten);
	break;
	endswitch;
	print_md_ende();
	print_body_ende();



	?>