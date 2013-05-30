<?php

/*
 Projekt :  ADMIN

Datei   :  admin_edit.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : MFD = Main Formular Data
Das modul realisiert die Bearbeitungsfunktionen für die MFD Column Daten.
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
echo "<!--  DATEN Spalte   -->\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_edit.inc';
include_once '_mfd_lib.inc';

/**
 * Callback Funktion fuer mfd liste
 * Startet Edit Funktion
 * @param unknown $ID
 * @param unknown $daten
 * @return string
 */
function mfd_list_edit_link($ID,$id)
{
  global $PHP_SELF;
  global $daten;// Referenz auf mfd, das bearbeitet wird
  $link = $PHP_SELF."?md=".mfd_edit."&id=$id&daten=$daten&ID=$ID";
  return $link;
}

/**
 * Callback Funktion fuer mfd Liste
 * Startet Lösch Funktion
 * @param unknown $ID
 * @param unknown $id, PK des Datensatz
 * @return string
 */
function mfd_list_delete_link($ID,$id)
{
  global $PHP_SELF;
  global $daten;  // Referenz auf mfd, das bearbeitet wird
  
  $link = $PHP_SELF."?md=".mfd_del."&id=$id&daten=$daten&ID=$ID";
  return $link;
}

/**
 * Callback Funktion fuer MFD Liste 
 * startet Info-Funktion, die Anzeige der MFD-Colls
 * @param unknown $ID
 * @param unknown $id, PK des Datensatz
 * @return string
 */
function mfd_list_info_link($ID,$id)
{
  global $PHP_SELF;
  global $daten;// Referenz auf mfd, das bearbeitet wird
  
  $link = $PHP_SELF."?md=".mfd_info."&id=$id&daten=$daten&ID=$ID";
  return $link;
}


function print_info($daten,$ID)
{
	$ref_mfd = get_mfd_name($daten);
	$mfd_list = get_mfd($ref_mfd);
	$mfd_cols = get_mfd_cols($ref_mfd);
	$row = make_mfd_empty_row($mfd_cols);
	print_mfd_maske($mfd_list, $row, 0, 0, $ID, $mfd_cols,true,$daten);
	
}


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


print_header_admin("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"MFD Viewer",$anrede,$menu_item);


// fuer die Tabellen Operationen
$ref_mfd = get_mfd_name($daten,$BEREICH);
$mfd_list=get_mfd($ref_mfd,$BEREICH);
//$mfd_list = make_mfd_table("mfd_cols", "mfd_cols");
//$mfd_list["where"]="ref_mfd=\"$ref_mfd\" ";
//$mfd_list["order"]=" mfd_pos";
// Fuer die Anzeige Listen
$mfd_cols = get_mfd_cols($ref_mfd);

switch($p_md):
case mfd_insert: // Insert -> Erfassen
  mfd_insert($mfd_list, $p_row);
  $md = 0;
  break;
case mfd_update: // Insert -> Erfassen
  mfd_update($mfd_list, $p_row);
  $md = 0;
  break;
case mfd_delete: // Delete => Loeschen
  mfd_delete($mfd_list, $p_row[0]);
  $md=0;
  break;
default: //
  break;
endswitch;



  switch ($md):
case mfd_add: // erfassen
    $menu = array (0=>array("icon" => "7","caption" => "MFD-COLS","link" => ""),
  			1=>array("icon" => "1","caption" =>$ref_mfd, "link" => ""),
    		2=>array("icon" => "1","caption" => "NEU","link" => ""),
        9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
case mfd_edit:  //Bearbeiten
  $menu = array (0=>array("icon" => "7","caption" => "MFD-COLS","link" => ""),
  1=>array("icon" => "1","caption" =>$ref_mfd, "link" => ""),
  2=>array("icon" => "1","caption" => " EDIT ","link" => ""),
  9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
  );
  break;
case mfd_del: // 
    $menu = array (0=>array("icon" => "7","caption" => "MFD-COLS","link" => ""),
	  	1=>array("icon" => "1","caption" =>$ref_mfd, "link" => ""),
	    2=>array("icon" => "1","caption" => "DELETE","link" => ""),
      9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
case mfd_info: // 
    $menu = array (0=>array("icon" => "7","caption" => "MFD-COLS","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
  	1=>array("icon" => "1","caption" =>$ref_mfd, "link" => ""),
    2=>array("icon" => "1","caption" => "MASKE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
    default: // main
  $menu = array (0=>array("icon" => "7","caption" => "MFD-COLS","link" => ""),
  1=>array("icon" => "1","caption" =>$ref_mfd, "link" => ""),
  2=>array ("icon" => "_tadd","caption" => "Neu","link" => "$PHP_SELF?md=".mfd_add."&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
  5=>array ("icon" => "_stop","caption" => "Zurück","link" => "$parent?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
  );
  break;
  endswitch;

  print_menu_status($menu);

  switch ($md):
case mfd_add:
  echo "Add Maske";
  break;
case mfd_edit:
  print_mfd_edit($id, $ID, $mfd_list, $mfd_cols,$daten);
  break;
case mfd_del:
//  echo "Delete Maske";
  print_mfd_del($id, $ID, $mfd_list, $mfd_cols,$daten);
  break;
case mfd_info:
//  echo "Info Maske:";
  print_mfd_info($id, $ID, $mfd_list, $mfd_cols,$daten);
	  break;
case mfd_list:
  echo "mfd List Maske";
  break;
default:
  //  print_table_list($ID);
  //$mfd_cols = mfd_list_cols($mfd_list['table'], $mfd_list['mfd']);
  print_mfd_listeRef( $ID, $mfd_list, $mfd_cols,"mfd_list_edit_link", "mfd_list_delete_link","mfd_list_info_link");
  //print_mfd_liste($ID, $mfd_list, $mfd_cols);
  break;
  endswitch;

  print_md_ende();

  ?>