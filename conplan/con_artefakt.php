<?php

/*
 * Projekt :  ADMIN
 * 
 * Datei   :  admin_bilder.php
 * 
 * Datum   :  2013/02/14
 * 
 * Rev.    :  3.0
 * 
 * Author  :  Olaf Duda
 * 
beschreibung : MFD = Main Formular Data Editor
Das modul realisiert die Bearbeitungsfunktionen f�r die MFD <download>.

Die Realisation des Editors liegt im include "_mfd_edit.inc"

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_edit.inc';
include_once '_mfd_lib.inc';
include_once '_mfd_edit.inc';



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Pr�fung ob User  berechtigt ist

  $BEREICH = 'SL';
  
  $md     = GET_md(0);
  $id     = GET_id(0);
  $daten  = GET_daten("");
  $sub    = GET_sub("");
  
  $ID     = GET_SESSIONID("");
  $p_md   = POST_md(0);
  $p_id 	= POST_id(0);
  $p_row 	= POST_row("");
  
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
    // Code ausgef�hrt wird.
  }
  
  if (is_admin()==FALSE)
  {
    $session_id = 'FFFF';
    header ("Location: main.php");  // Umleitung des Browsers
    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
    // Code ausgef�hrt wird.
  }
  
  
  print_header_admin("SL Bereich");
  
  print_body(2);
  
  $spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";
  
  
  $spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";
  
  $menu_item = $menu_item_help;
  $anrede["name"] = $spieler_name;
  $anrede["formel"] = "Sei gegr�sst Meister ";
  
  print_kopf($admin_typ,$header_typ,"MFD Viewer",$anrede,$menu_item);
  
  
  // fuer die Tabellen Operationen
  $ref_mfd = "artefakte";
  
  $home = "con_main.php";
  $fields = "id,S0,name,kurz,wert,r_sc,r_nsc,r_ort";
  
  // hier wird der Editor eingebuden
  print_mfd_editor($ref_mfd,$md, $p_md, $p_row,$id,$daten,$sub,$home,$fields);
  
  print_body_ende();
  
?>