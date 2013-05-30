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
Das modul realisiert die Bearbeitungsfunktionen für die MFD <download>.

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
// Prüfung ob User  berechtigt ist

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
  $ref_mfd = "download";
  
    $home = "admin_main.php";
    // hier wird der Editor eingebuden
    print_mfd_editor($ref_mfd,$md, $p_md, $p_row,$id,$daten,$sub,$home);
  
  print_md_ende();

?>