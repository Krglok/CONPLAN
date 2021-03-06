<?php

/*
 Projekt :  ADMIN

Datei   :  admin_edit.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : MFD = Main Formular Data
Das modul realisiert die Bearbeitungsfunktionen f�r die MFD Daten.
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
include_once '_mfd_edit.inc';

/**
 * Callback Funktion fuer mfd liste
 * Startet Edit Funktion
 * @param unknown $ID
 * @param unknown $daten
 * @return string
 */
function mfd_edit_edit_link($ID,$daten)
{
	global $PHP_SELF;
	$link = ""; //$PHP_SELF."?md=".mfd_edit."&id=$daten&ID=$ID";
	return $link;
}

/**
 * Callback Funktion fuer mfd Liste
 * Startet L�sch Funktion
 * @param unknown $ID
 * @param unknown $daten
 * @return string
 */
function mfd_edit_delete_link($ID,$daten)
{
	global $PHP_SELF;
	$link = ""; //$PHP_SELF."?md=".mfd_del."&id=$daten&ID=$ID";
	return $link;
}

/**
 * Callback Funktion fuer MFD Liste
 * startet Info-Funktion, die Anzeige der MFD-Colls
 * @param unknown $ID
 * @param unknown $daten
 * @return string
 */
function mfd_edit_info_link($ID,$daten)
{
	global $PHP_SELF;
	$link = "$PHP_SELF?md=".mfd_editor."&daten=$daten&back=$PHP_SELF&ID=$ID";
	return $link;
}

/**
 * Erstellt die Cloumns fuer die MFD Bearbeitung
 * @param unknown $table
 * @param unknown $mfd_name
 * @return $mfd_cols
 */
function mfd_list_cols($table, $mfd_name)
{
	$mfd_cols = make_mfd_cols_default($table, $mfd_name);
	for ($i=0; $i<6; $i++)
	{
		$list[$i] = $mfd_cols[$i];
	}
	return $list;
}

function mfd_cols_edit_link($ID,$daten)
{
	global $PHP_SELF;
	$link = $PHP_SELF."?md=23&id=$id&daten=$daten&ID=$ID".get_parentlink();;
	return $link;
}

function get_menu_mfd_edit($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
  switch ($md):
  case mfd_add: // erfassen
    $menu = array (0=>array("icon" => "7","caption" => "MFD EDIT","link" => "$PHP_SELF?md=0&ID=$ID"),
    				1=>array("icon" => "1","caption" => "NEU","link" => ""),
    				2=>array ("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case mfd_edit:  //Bearbeiten
    $menu = array (0=>array("icon" => "7","caption" => "MFD EDIT","link" => "$PHP_SELF?md=0&ID=$ID"),
    1=>array("icon" => "1","caption" => " EDIT ","link" => ""),
    2=>array ("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case mfd_del: //
    $menu = array (0=>array("icon" => "7","caption" => "MFD EDIT","link" => "$PHP_SELF?md=0&ID=$ID"),
    1=>array("icon" => "1","caption" => "DELETE","link" => ""),
    2=>array ("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case mfd_info: //
    $link = $PHP_SELF."?md=21&id=$id&ID=$ID";
    $menu = array (0=>array("icon" => "7","caption" => "MFD EDIT","link" => "$PHP_SELF?md=0&ID=$ID"),
        1=>array("icon" => "1","caption" => "MFD INFO","link" => ""),
        2=>array("icon" => "_tadd","caption" => "Make Cols","link" => "$link"),
        9=>array ("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  default: // main
    $menu = array (0=>array("icon" => "7","caption" => "MFD EDIT","link" => "$PHP_SELF?md=1&ID=$ID"),
    5=>array ("icon" => "_stop","caption" => "Zur�ck","link" => get_home($home)."?md=0&ID=$ID")
    );
    break;
    endswitch;
  
  return $menu;
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Pr�fung ob User  berechtigt ist

// <head>
// ...
// <script src="/ckeditor/ckeditor.js"></script>
// </head>

  $BEREICH = 'ADMIN';
  
  
  $md     = GET_md(0);
  $id     = GET_id(0);
  $daten  = GET_daten("");
  $sub    = GET_sub("");
  
  $ID     = GET_SESSIONID("");
  $p_md   = POST_md(0);
  $p_id 	= POST_id(0);
  $p_row 	= POST_row("");
  //$p_editor1 = POST_editor1("");
  
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
  	// Code ausgef�hrt wird.
  }
  
  if (is_admin()==FALSE)
  {
  	$session_id = 'FFFF';
  	echo "Admin";
  	//  header ("Location: main.php");  // Umleitung des Browsers
  	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  	// Code ausgef�hrt wird.
  }
  
  $parent = "";
  
  print_header_admin("Admin Bereich");
  
  print_body(2);
  
  $spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";
  
  
  $spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";
  
  $menu_item = $menu_item_help;
//   $link = "help_view.php?md=$md&item=admin_mfd_edit.php&sub=$sub&daten=$daten";
//   $menu_item = array ("icon" => $menu_help, "caption" => "Hilfe","link" => "javascript:openHelp('$link')","itemtyp"=>"0");
  
  $anrede["name"] = $spieler_name;
  $anrede["formel"] = "Sei gegr�sst Meister ";
  
  print_kopf($admin_typ,$header_typ,"MFD Editor",$anrede,$menu_item);
  
  
  // fuer die Tabellen Operationen
  $mfd_list = make_mfd_table("mfd_list", "mfd_list");
  $mfd_list["order"] = "mfd_name, id";
  // Fuer die Anzeige Listen
  $mfd_cols = make_mfd_cols_default($mfd_list['table'], $mfd_list['mfd']);
  
  
  switch($p_md):
  case mfd_edit_insert: // Insert -> Erfassen
  	mfd_insert($mfd_list, $p_row);
  $md = 0;
  break;
  case mfd_edit_update: // Insert -> Erfassen
  	mfd_update($mfd_list, $p_row);
  	$md = 0;
  	break;
  case mfd_edit_delete: // Delete => Loeschen
  	mfd_delete($mfd_list, $p_row[0]);
  	$md=0;
  	break;
	endswitch;

	$home = "admin_config.php";
	
  $menu = get_menu_mfd_edit($md, $PHP_SELF, $ID, "", $id, $daten, $sub, $home);


	switch ($md):
//   case mfd_add:
//       print_menu_status($menu);
//       print_mfd_erf($id, $ID, $mfd_list, $mfd_cols,$daten);
// 	echo "Add Maske";
//   	break;
//   case mfd_edit:
// 	  print_menu_status($menu);
//     print_mfd_edit($id, $ID, $mfd_list, $mfd_cols,$daten);
// 	echo "Edit Maske:".$daten;
//     break;
//   case mfd_del:
//   	//  echo "Delete Maske";
// 	  print_menu_status($menu);
//     print_mfd_del($id, $ID, $mfd_list, $mfd_cols,$daten);
//   	break;
//   case mfd_info:
//   	//  echo "Info Maske:";
// 	  print_menu_status($menu);
//     print_mfd_info($mfd_list,$id,$ID);
//   	break;
  case mfd_edit_add:
  case mfd_edit_edit:
  case mfd_edit_del:
  case mfd_edit_info:
  case mfd_editor:
    $ref_mfd = get_mfd_name($daten);
    $home = "PHP_SELF";
    $fields = "";
    echo $ref_mfd;
    print_mfd_editor($ref_mfd,$md, $p_md, $p_row,$id,$daten,$sub,$home,$fields);
    break;
  default:
  	//  print_table_list($ID);
	  print_menu_status($menu);
    $mfd_cols = mfd_list_cols($mfd_list['table'], $mfd_list['mfd']);
  	print_mfd_listeRef( $ID, $mfd_list, $mfd_cols,"mfd_edit_edit_link", "mfd_edit_delete_link","mfd_edit_info_link");
  	//print_mfd_liste($ID, $mfd_list, $mfd_cols);
  	break;
	endswitch;

	print_md_ende();

	?>