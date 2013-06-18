<?php

/*
 Projekt : ADMIN

Datei   :  admin_con.php,v $

Datum   :  2002/06/01

Rev.    : 3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Log datei angezeigt
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

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite


$Log: conadmin.php,v $
Revision 1.4  2002/06/01 10:40:00  windu
Erweiterung um bilder_admin

Revision 1.3  2002/05/30 07:22:21  windu
ADmin-Funktion für
Einbringen des Aktuellen Con-Tages
mit neuer Tabelle con_konst

Revision 1.2  2002/05/24 13:11:52  windu
neue icons im menü

Revision 1.1  2002/05/03 20:23:41  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.4  2002/03/09 18:28:52  windu
Korrekturen und Aufteilung in LIB.INC

Revision 1.3  2002/02/26 18:42:40  windu
keyword aktiviert

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
include_once '_log_lib.inc';


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist
$BEREICH = 'ADMIN';


$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
$ID     = GET_SESSIONID("");

session_start($ID);
$user       = $_SESSION["user"];
$user_lvl   = $_SESSION["user_lvl"];
$spieler_id = $_SESSION["spieler_id"];
$user_id 	= $_SESSION["user_id"];

if ($ID == "")
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

if (is_admin()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}
  
  
print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"<b>Admin Bereich</b>",$anrede,$menu_item);

switch ($md):
default:
	$menu = array (0=>array("icon" => "7","caption" => "LOG-FILE","link" => ""),
	1=>array ("icon" => "_list","caption" => "SUCHEN","link" => "$PHP_SELF?md=".mfd_list."&ID=$ID"),
	20=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
	);

endswitch;

print_menu_status($menu);
$table = 'syslog';
$mfd_list = make_mfd_table($table, $table);

switch ($md):
case mfd_list:
	echo "MFD FILTER MASKE";
    $result = log_data_result100($mfd_list);
    print_log_data($result,$ID);
	break;
default:
	echo "DEFAULT";
	$result = log_data_result100($mfd_list);
    print_log_data($result,$ID);
  	break;
	endswitch;

	print_md_ende();
	print_body_ende();

	?>