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


$style = $GLOBALS['style_datalist'];
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

function print_summe($ID)
/*
 Übersicht der vorhandenen Datensätze
*/
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $table = "mag_list";

  $q = "select count(NAME)as Anzahl from $table ";
  $result = mysql_query($q)  or die("Query Fehler :".$q);


  echo "<table  width = \"250\" border=1 BGCOLOR=\"\">\n";
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    // aufruf der Deateildaten
    echo "\t<td>\n";
    echo "\tGesamtzahl der Sprüche\n";
    echo "\t</a></td>\n";
    echo "\t<td>$row[0]&nbsp;</td>\n";
    echo "<tr>";
  }
  echo "</table>";


  $q = "select GRP,count(ID)  from $table group by grp order by grp DESC";
  $result = mysql_query($q)  or die("Query Fehler :".$q);

  mysql_close($db);

  echo "<table width = \"250\" border=1 BGCOLOR=\"\">\n";

  //Kopfzeile
  echo "<tr>\n";
  //Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  echo "</tr>\n";
  //Liste der Datensätze
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    for ($i=0; $i<$field_num; $i++)
    {
      // aufruf der Deateildaten
      if ($i==0)
      {
        echo "\t<td> Anzahl Sprüche in ".$row[$i]."\n";
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td>$row[$i]&nbsp;</td>\n";
      };
    }
    echo "<tr>";
  }
  echo "</table>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

};

/**
 *
 * @param unknown $ID
 * @param unknown $grp
 */
function print_liste($ID, $grp)
{
  //  &grp  beinhaltet die aktuele Gruppe der Datebsaetze (Spruchliste)

  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;


  if ($grp=="")
  {
    print_summe($ID);
    exit;
  }

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $table = "mag_list";

  $q = "select id, grp,nr,stufe,name,spruchdauer,MUK,RAR,GEIST from $table where grp=\"$grp\" order by grp DESC, stufe";
  //  $q = "select id, grp,nr,stufe,name,spruchdauer from $TABLE order by grp DESC, nr";
  $result = mysql_query($q)  or die("Query List...");

  mysql_close($db);

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  echo "<table >\n";

  //Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
  };
  echo "</tr>\n";
  echo "<hr>\n";
  //Liste der Datensätze
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    for ($i=0; $i<$field_num; $i++)
    {
      // aufruf der Deateildaten
      if ($i==0)
      {
        echo "\t<td><a href=\"$PHP_SELF?md=".mfd_edit."&ID=$ID&id=$row[$i]&grp=$grp\"> \n";
        print_menu_icon ("_tcheck","Datensatz bearbeiten");
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td>$row[$i]&nbsp;</td>\n";
      };
    }
    echo "\t<td><a href=\"$PHP_SELF?md=".mfd_info."&ID=$ID&id=$row[0]&grp=$grp\">\n";
    print_menu_icon ("_tinfo","Datensatz Ansehen / Druckversion");
    echo "\t</a></td>\n";
    echo "<tr>";
  }
  echo "</table>";
  
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
  
};


function print_info($daten,$ID)
{
  $ref_mfd = get_mfd_name($daten);
  $mfd_list = get_mfd($ref_mfd);
  $mfd_cols = get_mfd_cols($ref_mfd);
  $row = make_mfd_empty_row($mfd_cols);
  print_mfd_maske($mfd_list, $row, 0, 0, $ID, $mfd_cols,true,$daten);

}

function get_menu_mfd_editor($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
  switch ($md):
  case mfd_add: // erfassen
    $menu = array (0=>array("icon" => "7","caption" => "MAGIE","link" => ""),
        1=>array("icon" => "1","caption" =>$titel, "link" => ""),
        2=>array("icon" => "1","caption" => "NEU","link" => ""),
        9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_edit:  //Bearbeiten
    $menu = array (0=>array("icon" => "7","caption" => "MAGIE","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => " EDIT ","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_del: //
    $menu = array (0=>array("icon" => "7","caption" => "MAGIE","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "DELETE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_info: //
    $menu = array (0=>array("icon" => "7","caption" => "MAGIE","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "MASKE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
    //     default: // main
    //       $menu = array (0=>array("icon" => "7","caption" => "MAGIE","link" => ""),
    //       1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    //       2=>array ("icon" => "_tadd","caption" => "Neu","link" => "$PHP_SELF?md=".mfd_add."&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
    //       5=>array ("icon" => "_stop","caption" => "Zurück","link" => get_home($home)."?md=0&amp;daten=$daten&amp;ID=$ID")
    //       );
  default:  // MAIN-Menu
    $menu = array (0=>array("icon" => "99","caption" => "MAGIE","link" => ""),
    1=>array("icon" => "_tadd","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&sub=$$sub"),
    40=>array("icon" => "_stop","caption" => "Zurück","link" => "con_main.php?md=0&ID=$ID&sub=$sub")
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
// Prüfung ob User  berechtigt ist

// <head>
// ...
// <script src="/ckeditor/ckeditor.js"></script>
// </head>

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
  // Code ausgeführt wird.
}

if (is_admin()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}


print_header_admin("SL Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

if($md == mfd_info)
{
  print_kopf_druck ("penta.gif", $header_typ);
}  else
{
  print_kopf($admin_typ,$header_typ,"MFD Viewer",$anrede,$menu_item);
}


// fuer die Tabellen Operationen
$ref_mfd = "legende";

$home = "con_main.php";


$mfd_list=get_mfd($ref_mfd);
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


  $menu = get_menu_mfd_editor($md, $PHP_SELF, $ID,$ref_mfd,$id,$daten,$sub,$home);


  switch ($md):
case mfd_add:
    print_menu_status($menu);
  echo "Add Maske";
  break;
case mfd_edit:
  print_menu_status($menu);
  print_mfd_edit($id, $ID, $mfd_list, $mfd_cols,$daten);
  break;
case mfd_del:
  //  echo "Delete Maske";
  print_menu_status($menu);
  print_mfd_del($id, $ID, $mfd_list, $mfd_cols,$daten);
  break;
case mfd_info:
  //  echo "Info Maske:";
//  print_menu_status($menu);
  print_mfd_info($id, $ID, $mfd_list, $mfd_cols,$daten);
  break;
case mfd_list:
  print_menu_status($menu);
  echo "mfd List Maske";
  break;
default:
  print_menu_status($menu);
//  print_liste($ID, $sub);
  print_mfd_listeRef( $ID, $mfd_list, $mfd_cols,"mfd_list_edit_link", "mfd_list_delete_link","mfd_list_info_link");
  break;
  endswitch;

  print_md_ende();

  ?>