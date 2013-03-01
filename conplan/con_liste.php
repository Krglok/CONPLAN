<?php
/*
 Projekt :  CONPLAN

Datei   :  con_liste.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <con_tage>
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

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
echo "<!---  DATEN Spalte   --->\n";

echo '</div>';
echo "<!---  ENDE DATEN Spalte   --->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once "_planung.inc";


//-----------------------------------------------------------------------------
function print_liste($ID,$TAG)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;

  // Datenbank zugriff
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  //if ($DEBUG) {echo "Verbunden<br>";}

  mysql_select_db($DB_NAME);
  //if ($DEBUG) {echo "DB ausgewählt<br>";}

  $q = "select id,tag,von,bis,bemerkung,leg_id from con_tage order by tag DESC";
  $result = mysql_query($q)
  or die("Query Fehler...");
  //if ($DEBUG) {echo "Query ok<br>";}


  mysql_close($db);


  //Anzeigen von Con_tage
  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!---  DATEN Spalte   --->\n";

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
        echo "\t<td  bgcolor=\"$bgcolor\"><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]\">\n";
        print_menu_icon ("_db","Contag Einladung bearbeiten");
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
  echo "<!---  ENDE DATEN Spalte   --->\n";

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


function insert($row)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $TABLE;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  $result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    $field_name[$i] =  mysql_field_name ($result, $i);
  }
  $q ="insert INTO  $TABLE  (";
  $q = $q."$field_name[1]";
  for ($i=2; $i<$field_num; $i++)
  {
    $q = $q.",$field_name[$i]";
  };

  $q = $q.") VALUES (\"$row[1]\" ";
  for ($i=2; $i<$field_num; $i++)
  {
    $q = $q.",\"$row[$i]\" ";
  };
  $q = $q.")";
  //  echo $q;

  if (mysql_select_db($DB_NAME) != TRUE) {
    echo "Fehler DB";
  };
  //  $q ="insert INTO con_tage (tag,von,bis,bemerkung,kosten,leg_id,text) VALUES ( \"$tag\",\"$von\",\"$bis\",\"$bemerkung\",\"$kosten\",\"$leg_id\",\"$text\"";
  $result = mysql_query($q) or die("InsertFehler....$q.");

  mysql_close($db);

};


function update($row)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $TABLE;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  $result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    $field_name[$i] =  mysql_field_name ($result, $i);
  }
  $q ="update $TABLE  SET ";
  $q = $q."$field_name[1]=\"$row[1]\" ";
  for ($i=2; $i<$field_num; $i++)
  {
    $q = $q.",$field_name[$i]=\"$row[$i]\" ";
  };
  $q = $q."where id=\"$row[0]\" ";

  //  echo $q;
  if (mysql_select_db($DB_NAME) != TRUE) {
    echo "Fehler DB";
  };
  /**/
  $result = mysql_query($q) or die("update Fehler....$q.");
  /**/
  mysql_close($db);

};


function print_maske($id,$ID,$next,$erf)
{
  //
  //  $id   beinhaltet den zu bearbeitenden Datensatz
  //  $ID beinhaltet den User des Programms (authetifizierung)
  //  $next beinhaltet die nächste zu rufende Funktion
  //
  // durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
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
echo "<!---  DATEN Spalte   --->\n";
  
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
  echo "<!---  ENDE DATEN Spalte   --->\n";
  

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

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
  // Code ausgeführt wird.
}

if (is_subsl()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}


print_header("Con Planung");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf_planung("<b>CON Planung</b>",$anrede,$menu_item);

$TAG   = get_akttag();

$TABLE = "con_tage";

switch ($p_md):
case 5:  // MAIN-Menu
  insert($p_row);
  $md=0;
  break;
case 6: // Update eines bestehnden Datensatzes
  // Update SQL
  update($p_row);
  $md=0;
  break;
case 7: // Delete eines bestehenden Datensatzes
  // SQL delete
  loeschen($id);
  $md=0;
  break;
default :
  break;
  endswitch;


  switch ($md):
case 1: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
        1=>array("icon" => "1","caption" => "ERFASSEN","link" => ""),
        2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
case 2: // Ansehen des Datesatzes als Form
  $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
  1=>array("icon" => "1","caption" => "ANSEHEN","link" => ""),
  8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&dd=0")
  );
  break;
case 3: // Anzeigen Löschen Form
  $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
  1=>array("icon" => "1","caption" => "LÖSCHEN","link" => ""),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&dd=0")
  );
  break;
case 4: // Anzigen Bearbeiten Form
  $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
  1=>array("icon" => "1","caption" => "BEARBEITEN","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
case 10:
  $menu = array (0=>array("icon" => "0","caption" => "CON-TAG","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
default:  // MAIN-Menu
  $menu = array (0=>array("icon" => "1","caption" => "CON-TAG","link" => ""),
  1=>array("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID"),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
  );
  endswitch;

  print_menu_status($menu);


  switch ($md):
case 1:
    //
    print_maske($id,$ID,5,1);
  break;
case 2:
  print_maske($id,$ID,0,0);
  break;
case 3:
  //
  break;
case 4:
  //
  print_maske($id,$ID,6,0);
  break;
case 10:
  print_hilfe($ID,$item,$id);
  break;
default:
  print_liste($ID,$TAG);
  break;
  endswitch;

  print_body_ende();

  ?>