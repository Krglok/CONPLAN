<?php
/*
 * Projekt :  ADMIN
 * 
 * Datei   :  _mfd_edit.inc
 * 
 * Datum   :  2013/03/07
 * 
 * Rev.    :  3.0
 * 
 * Author  :  Olaf Duda
 * 
 * Dieser Include beinhaltet eine komplette MFD Edit abwicklung.
 * Im rufenden Modul muss der Header und der Kopf und das Ende erstellt werden.
 * Ebenso  muss die Var $ref_mfd mit eiunem sinnvollen Wert fuer eine MFD
 * belegt werden. Dieser File enthält Daten fuer ein Hauptmodul.
 * 
 * Der INCLUDE realsiert einen Standard Editor fuer MFD Daten 
 * 
 */

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



$mfd_list=get_mfd($ref_mfd);
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
  5=>array ("icon" => "_stop","caption" => "Zurück","link" => get_home($BEREICH)."?md=0&amp;daten=$daten&amp;ID=$ID")
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

?>