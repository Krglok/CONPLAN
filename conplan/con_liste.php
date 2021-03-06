<?php
/*
 Projekt :  CONPLAN

Datei   :  con_liste.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen f�r die Datei <con_tage>
- Efassen neuer Datens�tze
- Bearbeiten vorhandener Datens�tze
- Anzeige der Details ohne Bearbeitung
- L�schen  eines Datensatzes

Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.

Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

$Log: con_liste.php,v $
Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!--  DATEN Spalte   -->\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once "_planung.inc";


//-----------------------------------------------------------------------------
function print_liste($ID,$TAG,$ref_mfd)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;

  // Datenbank zugriff
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  //if ($DEBUG) {echo "Verbunden<br>";}

  mysql_select_db($DB_NAME);
  //if ($DEBUG) {echo "DB ausgew�hlt<br>";}

  $q = "select id,tag,von,bis,bemerkung,leg_id from con_tage order by tag DESC";
  $result = mysql_query($q)
  or die("Query Fehler...");
  //if ($DEBUG) {echo "Query ok<br>";}


  mysql_close($db);


  //Anzeigen von Con_tage
  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "<table  >\n";

  //Header
  echo "<tr>\n";
  echo "\t<td><b>ID</b></td>\n";
  echo "\t<td><b>TAG</b></td>\n";
  echo "\t<td><b>VON</b></td>\n";
  echo "\t<td><b>BIS</b></td>\n";
  echo "\t<td><b>BEMERKUNG</b></td>\n";
  echo "</tr>\n";

  //Daten
  $field_num = mysql_num_fields($result);
  while ($row = mysql_fetch_row($result))
  {
    if ($row[1]==$TAG)
    {
      $bgcolor="silver";
    } else
    {
      $bgcolor="";
    }
    echo "<tr>";
    for ($i=0; $i<$field_num-1; $i++)
    {
      // aufruf der Deateildaten
      if ($i==0)
      {
        echo "\t<td  bgcolor=\"$bgcolor\"><a href=\"$PHP_SELF?md=".mfd_edit."&ID=$ID&id=$row[$i]\">\n";
        print_menu_icon ("_editor","Contag Einladung bearbeiten");
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
      }
    }
    echo "\t<td  bgcolor=\"$bgcolor\"><a href=\"con_plan.php?md=0&ID=$ID&TAG=$row[1]\">\n";
    print_menu_icon ("_branch","Planung bearbeiten");
    echo "<tr>";
    echo "</a></td>\n";
  }
  echo "</table>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

};

function print_info($id,$ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  //Anzeigen von Contage als einfache Maske
  //function view() {

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $result = mysql_query("select id,tag,von,bis,kosten,bemerkung,leg_id,text from con_tage where id=$id")
  or die("Query Fehler...");


  mysql_close($db);

  //Daten bereich
  echo "  <TD\n>";

  $row = mysql_fetch_row($result);

  echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
  echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
      BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
  echo "\t<tr>\n";
  echo "\t<td width=100><b>ID</b></td>\n";
  echo "\t<td>$row[0]</td>\n";
  echo "\t</tr>\n";

  echo "<tr>";
  echo "\t<td><b>TAG</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"tag\" SIZE=5 MAXLENGTH=2 VALUE=\"$row[1]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>von</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"von\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[2]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>bis</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"bis\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[3]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Kosten</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"kosten\" SIZE=10 MAXLENGTH=10 VALUE=\"$row[4]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Bemerkung</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"bemerkung\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[5]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Legende</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"legende\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[6]\">&nbsp;</td>\n";
  echo "<tr>";
  echo "<tr>";
  echo "\t<td><b></b></td>\n";
  echo "\t<td><TEXTAREA NAME=\"text\" COLS=50 ROWS=12>$row[7]</TEXTAREA>&nbsp;</td>\n";
  echo "<tr>";

  echo "</table>";
  echo "  </TD\n>";

};


// function insert($mfd_list,$row)
// {
//   global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  
//   $id = $row[0];
//   $table = $mfd_list["table"];
//   $fields =$mfd_list["fields"];
//   $join = ""; //$mfd_list["join"];
//   $where ="id = $id";
//   $order = "";
  
//   $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
//   or die("Fehler beim verbinden!");
//   $result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
//   $field_num = mysql_num_fields($result);
//   for ($i=0; $i<$field_num; $i++)
//   {
//     $field_name[$i] =  mysql_field_name ($result, $i);
//   }
//   $q ="insert INTO  $TABLE  (";
//   $q = $q."$field_name[1]";
//   for ($i=2; $i<$field_num; $i++)
//   {
//     $q = $q.",$field_name[$i]";
//   };

//   $q = $q.") VALUES (\"$row[1]\" ";
//   for ($i=2; $i<$field_num; $i++)
//   {
//     $q = $q.",\"$row[$i]\" ";
//   };
//   $q = $q.")";
//   //  echo $q;

//   if (mysql_select_db($DB_NAME) != TRUE) {
//     echo "Fehler DB";
//   };
//   //  $q ="insert INTO con_tage (tag,von,bis,bemerkung,kosten,leg_id,text) VALUES ( \"$tag\",\"$von\",\"$bis\",\"$bemerkung\",\"$kosten\",\"$leg_id\",\"$text\"";
//   $result = mysql_query($q) or die("InsertFehler....$q.");

//   mysql_close($db);

// };




function print_maske($id,$ID,$next,$erf)
{
  //
  //  $id   beinhaltet den zu bearbeitenden Datensatz
  //  $ID beinhaltet den User des Programms (authetifizierung)
  //  $next beinhaltet die n�chste zu rufende Funktion
  //
  // durch $next kann die Maske sowohl f�r Erfassen als auch Bearbeiten benutzt werden.
  //
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $TABLE;
  global $PHP_SELF;

  //Anzeigen von Contage als einfache Maske
  //function view() {
  if ($erf == 0 )
  {
    $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
    or die("Fehler beim verbinden!");

    mysql_select_db($DB_NAME);

    $q = "select * from $TABLE where id=$id";
    $result = mysql_query($q) or die("Query BEARB.");

    mysql_close($db);

    $field_num = mysql_num_fields($result);
    //
    $row = mysql_fetch_array ($result);
    $len = mysql_fetch_row($result);
  } else
  {
    $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
    or die("Fehler beim verbinden!");

    mysql_select_db($DB_NAME);

    $q = "select * from $TABLE where id=\"0\"";
    $result = mysql_query($q) or die("Query ERF...");


    mysql_close($db);

    $row = mysql_fetch_array ($result);
    $field_num = mysql_num_fields($result);

  }
  //  echo count($row);
  /**/
  if (count($row)==1)
  {
    for ($i=0; $i<$field_num; $i++)
    {
      $row[$i] = "";
    };
  };
  /**/
  //Daten bereich
$style = $GLOBALS['style_datatab'];
echo "<div $style >";
echo "<!--  DATEN Spalte   -->\n";
  
  echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
  echo "<TABLE WIDTH=\"500\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
      BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
  echo "\t<tr>\n";
  echo "\t<td width=100></td>\n";
  echo "\t<td><center><b>CON TAGE</b></td>\n";
  echo "\t</tr>\n";

  echo "\t<tr>\n";
  echo "\t<td width=100><b>ID</b></td>\n";
  echo "\t<td>$row[0]</td>\n";
  echo "\t</tr>\n";

  echo "<tr>";
  echo "\t<td><b>TAG</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[1]\" SIZE=5 MAXLENGTH=3 VALUE=\"$row[1]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>von</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[2]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>bis</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[3]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Kosten</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[4]\" SIZE=10 MAXLENGTH=10 VALUE=\"$row[4]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Bemerkung</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[7]\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[7]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>Legende</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[9]\" SIZE=3 MAXLENGTH=3 VALUE=\"$row[9]\">&nbsp;</td>\n";
  echo "<tr>";
  echo "<tr>";
  echo "\t<td><b></b></td>\n";
  echo "\t<td><TEXTAREA NAME=\"row[8]\" COLS=50 ROWS=12>$row[8]</TEXTAREA>&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>von</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[5]\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[5]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "<tr>";
  echo "\t<td><b>bis</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[6]\" SIZE=12 MAXLENGTH=10 VALUE=\"$row[6]\">&nbsp;</td>\n";
  echo "<tr>";

  echo "\t<tr>\n";
  echo "\t<td></td>\n";
  echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
      </td>\n";
  echo "\t</tr>\n";

  echo "</table>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
  

};


function get_menu_con_tage($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
  switch ($md):
  case mfd_add: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
        1=>array("icon" => "1","caption" => "ERFASSEN","link" => ""),
        2=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case mfd_edit: // Ansehen des Datesatzes als Form
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
    1=>array("icon" => "1","caption" => "BEARBEITEN","link" => ""),
    8=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID&dd=0")
    );
    break;
  case mfd_del: // Anzeigen L�schen Form
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
    1=>array("icon" => "1","caption" => "L�SCHEN","link" => ""),
    9=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID&dd=0")
    );
    break;
  case mfd_info: // Anzigen Bearbeiten Form
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
    1=>array("icon" => "1","caption" => "INFO","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case 10:
    $menu = array (0=>array("icon" => "0","caption" => "CON-TAG","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  default:  // MAIN-Menu
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
    1=>array("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=".mfd_add."&ID=$ID"),
    9=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$home?md=0&ID=$ID")
    );
  endswitch;
  return $menu;
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Pr�fung ob User  berechtigt ist

$BEREICH = 'SUBSL';

$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$ID     = GET_SESSIONID("");
$id     = GET_id("0");

$p_md   = POST_md(0);
$p_row  = POST_row("");

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

if (is_subsl()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgef�hrt wird.
}

print_header("Con Planung");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegr�sst Meister ";

print_kopf_planung("<b>CON Planung</b>",$anrede,$menu_item);

$TAG   = get_akttag();

$ref_mfd = "con_tage";

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

  $home = "larp.php";
  $titel = "CON TAGE";
  
  $menu = get_menu_con_tage($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);

  switch ($md):
  case mfd_add:
    print_menu_status($menu);
    print_mfd_erf($id, $ID, $mfd_list, $mfd_cols, $daten);
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
    print_menu_status($menu);
    print_mfd_info($id, $ID, $mfd_list, $mfd_cols,$daten);
    break;
  case mfd_list:
    print_menu_status($menu);
    echo "mfd List Maske";
    break;
  default:
    print_menu_status($menu);
    print_liste($ID,$TAG,$ref_mfd);
    //print_mfd_listeRef( $ID, $mfd_list, $mfd_cols,"mfd_list_edit_link", "mfd_list_delete_link","mfd_list_info_link");
    break;
    endswitch;
  
  print_body_ende();

  ?>