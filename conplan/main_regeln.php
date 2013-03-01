<?php

/*
 Projekt : MAIN

Datei   :  main_regeln.php

Datum   :  2002/06/12

Rev.    :  3.0

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

Ver 3.0 / 04.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include "_config.inc";
include "_lib.inc";
include "_head.inc";


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------

print_header("Regeln");

print_body(2);


// Steuerparameter und steuerdaten
$md=GET_md(0);
$daten=GET_daten("");
$item=GET_item("main");
$sub=GET_sub("");

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Öffentlich",$anrede,$menu_item);

//echo "POST : $p_md / GET : $md / THEMEN :$daten ";

$menu = array (0=>array("icon" => "99","caption" => "Usere Regeln","link" => "$PHP_SELF?md=1&daten=regeln/regeln.html"),
		1=>array ("icon" => "_page","caption" => "Interne Regeln","link" => "$PHP_SELF?md=1&daten=regeln/regeln_erw.html"),
		2=>array ("icon" => "_page","caption" => "Silbermond","link" => "$PHP_SELF?md=1&daten=regeln/regeln_kurz.html"),
		3=>array ("icon" => "_page","caption" => "Con-Planung","link" => "$PHP_SELF?md=1&daten=regeln/regeln_con.html"),
		4=>array ("icon" => "_page","caption" => "NSC-Klassen","link" => "$PHP_SELF?md=1&daten=regeln/regeln_nsc1.html"),
		5=>array ("icon" => "_page","caption" => "Capture the Flag","link" => "$PHP_SELF?md=1&daten=regeln/regeln_cf1.html"),
		//               98=>array("icon" => "0","caption" => "","link" => "","target"=>""),
		19=>array("icon" => "_stop","caption" => "Zurück","link" => "main.php?md=0")
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