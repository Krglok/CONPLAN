<?php
/*
 Projekt :  ADMIN

Datei   :  admin_config.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : Main Modul fuer Konfigurationsmodule
Das Modul erzeugt ein Menu, um die Konfiguration zusammenzufassen

- Menu Konfigurator
- MFD Konfigurator
- Tabellen Editor
- Pages Editor

Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";




// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
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

$menu = array (
    0=>array  ("icon" => "7","caption" => "ADMIN CONFIG","link" => ""),
    13=>array ("icon" => "_folder_n","caption" => "Log-File","link" => "admin_log.php?md=0&ID=$ID".get_parentlink().""),
    14=>array ("icon" => "_folder_n","caption" => "DataTable","link" => "admin_table.php?md=0&ID=$ID".get_parentlink().""),
    15=>array ("icon" => "_folder_n","caption" => "MFD Table","link" => "admin_mfd.php?md=0&ID=$ID".get_parentlink().""),
    16=>array ("icon" => "_folder_n","caption" => "MFD Edit","link" => "admin_mfd_edit.php?md=0&ID=$ID".get_parentlink().""),
		20=>array ("icon" => "_folder_n","caption" => "Menu Edit","link" => "admin_menu.php?md=0&ID=$ID".get_parentlink().""),
    30=>array ("icon" => "_folder_n","caption" => "Pages","link" => "admin_pages.php?md=0&ID=$ID".get_parentlink().""),
    99=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID".get_parentlink()."")
);

print_menu($menu);

switch ($md):
case 1:
		print_pages("main.html");
	break;
default:
	print_pages("admin_logo.html");
	break;
endswitch;

print_md_ende();
print_body_ende();

?>