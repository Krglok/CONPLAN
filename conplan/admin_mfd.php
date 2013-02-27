<?php

/*
 Projekt :  ADMIN

Datei   :  admin_edit.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : MFD = Main Formular Data
Das modul realisiert die Bearbeitungsfunktionen für die MFD Daten.
Es werden automatisch Daten fuer MFD Schema und MFD-COLS Schema erstellt.
Das MFD Schema wird als Library abgelegt und bietet die Funktionen
- Anzeige einer Datenliste mit Bearbeitungsaufruf  und Deleteaufruf
- Anzeige einer Detailmaske nach Standardscheme mit Speichern
zum Editieren (Update) eines Datensatzes
zum erfassen (Insert) eines Datensatzes


Es wird eine Session Verwaltung benutzt, die den User prueft.

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
include_once '_edit.inc';
include_once '_mfd_lib.inc';


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

// <head>
// ...
// <script src="/ckeditor/ckeditor.js"></script>
// </head>

$BEREICH = 'ADMIN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$md     = GET_md(0);
$id     = GET_id(0);
$daten  = GET_daten("");

$ID     = GET_SESSIONID("");
$p_md   = POST_md(0);
$p_id 	= POST_id(0);
$p_row 	= POST_row("");
$p_editor1 = POST_editor1("");

session_start($ID);
$user       = $_SESSION["user"];
$user_lvl   = $_SESSION["user_lvl"];
$spieler_id = $_SESSION["spieler_id"];
$user_id 	= $_SESSION["user_id"];

if ($ID == "")
{
  $session_id = 'FFFF';
  echo "session";
  //  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

if (is_admin()==FALSE)
{
  $session_id = 'FFFF';
  echo "Admin";
  //  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}


print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"Menu Konfigurator",$anrede,$menu_item);

$bereich = "PUBLIC";
$sub     = "main";
$item		 = "regeln";

// fuer die Tabellen Operationen
$mfd_list = make_mfd_table("mfd_list", "mfd_list");
// Fuer die Anzeige Listen
$mfd_cols = make_mfd_cols_default($mfd_list['table'], $mfd_list['mfd']);

switch($p_md):
case 5: // Insert -> Erfassen
  mfd_insert($mfd_list, $p_row);
  $md = 0;
  break;
case 6: // Insert -> Erfassen
  mfd_update($mfd_list, $p_row);
  $md = 0;
  break;
endswitch;



  switch ($md):
case 2: // erfassen
    $menu = array (0=>array("icon" => "7","caption" => "MFD","link" => "$PHP_SELF?md=1&ID=$ID"),
        1=>array("icon" => "1","caption" => "NEU","link" => ""),
        2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
case 4:  //Bearbeiten
  $menu = array (0=>array("icon" => "7","caption" => "MFD","link" => "$PHP_SELF?md=1&ID=$ID"),
  1=>array("icon" => "1","caption" => "ÄNDERN","link" => ""),
  2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
  );
  break;
case 10: // main
  $menu = array (0=>array("icon" => "7","caption" => "MFD","link" => "$PHP_SELF?md=1&ID=$ID"),
  1=>array ("icon" => "_tadd","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
  5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
  );
  break;
default: // main
  $menu = array (0=>array("icon" => "7","caption" => "MFD","link" => "$PHP_SELF?md=1&ID=$ID"),
  5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
  );
  break;
  endswitch;

  print_menu_status($menu);

  switch ($md):
case 2:

    break;
case 3:

  break;
case 4:
  break;
case 10:
  break;
default:
  //  print_table_list($ID);
  print_mfd_liste($ID, $mfd_list, $mfd_cols);
  break;
  endswitch;

  print_md_ende();

  ?>