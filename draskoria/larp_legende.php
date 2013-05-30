<?php
/*
 Projekt : LARP

Datei   :  larp_leg_liste.php

Datum   :  2002/05/24

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <Legende>
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
include_once '_mfd_lib.inc';

//-----------------------------------------------------------------------------
function print_leg_liste($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;

  //Anzeigen von Legendenliste
  //function view() {

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  //if ($DEBUG) {echo "Verbunden<br>";}

  mysql_select_db($DB_NAME);
  //if ($DEBUG) {echo "DB ausgewählt<br>";}
  $q = "select id,s0,s1,s2,datum,name,kurz,beschreibung from legende where s1 <> \"\" order by s0 DESC,s1 DESC,s2 DESC";
  $result = mysql_query($q)    or die("Query Fehler...");
  //if ($DEBUG) {echo "Query ok<br>";}

  mysql_close($db);

  print_table_list($ID);
  
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "<table>\n";

  //Header
  $field_num = mysql_num_fields($result);
  echo "<tr>\n";
  //for ($i=0; $i<$field_num; $i++) {
  //        echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
  echo "\t<td width=75px><i>DATUM</i></td>\n";
  echo "\t<td width=220px><i>NAME</i></td>\n";
  echo "\t<td><i>KURZ</i></td>\n";
  echo "\t<td><i></i></td>\n";
  //lfdnr,name,vorname,orga}
  echo "</tr>\n";

  //Daten
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    for ($i=4; $i<$field_num-1; $i++)
    {
      // aufruf der Deateildaten
      if ($i==0)
      {
        echo "\t<td>";
        echo "</td>\n";
      }else
      {
        echo "\t<td>".$row[$i]."&nbsp;</td>\n";
      };
    }
    echo "\t  <td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\"\n>";
    print_menu_icon ("_text");
    echo "\t  </a></td>\n";
    echo "</tr>";
    echo "<tr>";
    echo "\t<td>";
    echo "</td>\n";
    echo "\t<td>";
    echo "</td>\n";
    echo "\t<td >\n";
    $zeile=explode("\n",$row[7]);
    //		$anz  = count($zeile);
    echo "\t$zeile[0]&nbsp;........<br>\n";
    echo "</td>\n";
    echo "</tr>";
    echo "<tr height=20>";
    echo "<td>\n";
    echo "</td>\n";
    echo "</tr>";
  }
  echo "</table>";


  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

  
};

function print_table_list($ID)
{
  global $PHP_SELF;

  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);
  $q= "SELECT S0,datum, count(S0) as ANZ FROM legende where s1 <> \"\"
group by S0,datum
order by s0 DESC";
  $result = mysql_query($q) ;
  $style = $GLOBALS['style_menu_tab1'];

  $style = "id=\"style_datalist\"";
  echo "<div $style >";
  echo "<!--  MENU Spalte   -->\n";

  if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $q;
    die($message);

  } else
  {
    $i=0;
    while ($row = mysql_fetch_row($result))
    {
      $pages[$i+1][0] = $row[1];
      $pages[$i+1][1] = $row[2];
      $i++;
    }
  }
  // Hearderzeile einfuegen
  $pages[0][0] = "Einträge";
  $pages[0][1] = "";
  echo "<div >";
  echo "<p>";
  echo " ";
  echo "</p >";
  echo "</div >";


  $style = "id=\"menu\"";
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  echo "<table  > \n"; //width=\"100%\"
  echo "<tbody >";

  for($i=0; $i<count($pages); $i++)
  {
    $name = $pages[$i][0];
    $more = $pages[$i][1];
    echo "\t<tr> \n";
    echo "\t\t<td width=\"25\"> \n";
    if ($i>0)
    {
//      echo "<a href=\"$PHP_SELF?md=2&daten=$name&ID=$ID \" >";
      print_menu_icon("_db","Show Default MFD");
//      echo "</a>";
    } else
    {
      echo "";
    }

    echo "\t\t</td> \n";
    echo "\t\t<td> \n";
    echo "$name";
    echo "";
    echo "\t\t</td> \n";
    echo "\t\t<td> \n";
    if ($i>0)
    {
      echo "$more";
    }        
    echo "\t\t</td> \n";
    echo "\t</tr> \n";
  }

  echo "</tbody>";
  echo "</table>\n";
  echo '</div>';
}


/**
 * Erstellt ein Inputfeld mit der Textlaenge
 * die Size wird auf max 75 Zeichen begrenzt
 *
 * @param unknown $titel
 * @param unknown $pos
 * @param unknown $data
 * @param unknown $width
 * @param unknown $readonly
 */
function print_edit_spalte($titel,$pos, $data, $width, $is_readonly)
{
  if($is_readonly)
  {
    $readonly = "readonly";
  } else
  {
    $readonly = "";
  }

  if($width >75)
  {
    $size = 75;
  } else
  {
    $size = $width;
  }
  $titel = ucwords(strtolower($titel));
  echo "<td width=75 ><i>$titel</i></td>\n";
  echo "<td width=50>\n";
  echo "<INPUT TYPE=\"TEXT\" NAME=\"row[$pos]\" SIZE=$size MAXLENGTH=$width $readonly VALUE=\"$data\"\n";
  echo "</td>\n";
}

/**
 * Erstellt eine Textarea als Input. Die Textarea wird durch ckEditor ersetz
 * bei readonly=true wird nur der Text angezeigt
 * @param unknown $titel  des Feldes
 * @param unknown $pos    index des $row
 * @param unknown $data		vorhandene Daten
 * @param unknown $is_readonly true = als Text / false = als Eingabe feld
 */
function print_edit_text($titel,$pos, $data, $is_readonly)
{
  $name = "row[$pos]";  // dies ist der Name des Elementres das ersetzt werden soll
  $titel = ucwords(strtolower($titel));
  echo "  <td width=75px ><i>$titel</i></td>\n";
  echo "<td >\n";
  if ($is_readonly)
  {
    $anz  = count(explode("\n",$data));
    if ($anz < 5) {
      $anz=5;
    }
    $len = strlen($data) / 60;
    if($len>$anz) {
      $anz=$len+$anz;
    }

    echo "<textarea   name=\"$name\" readonly COLS=\"60\" ROWS=\"$anz\" >"; //class=\"ckeditor\"
    echo $data;
    echo "</textarea>";
  } else
  {
    echo "\t<td><i>$titel</i></td>\n";
    //  echo "\t<td><TEXTAREA NAME=\"$name\" COLS=50 ROWS=12></TEXTAREA>&nbsp;</td>\n";
    echo "<td>\n";
    echo "<textarea   name=\"$name\"  COLS=\"60\" ROWS=\"14\" >"; //class=\"ckeditor\"
    echo $data;
    echo "</textarea>";

    echo "<!--  Text editor Konfiguration-->";
    echo "  <script type=\"text/javascript\">";
    echo " CKEDITOR.replace('$name',{
    toolbar: 'ForumToolbar',
    removeButtons : 'Table',
    uiColor : '#9AB8F3',
    height : '250px'
  } );";
    echo "  </script>";
    echo "</td>\n";
  }
  echo "\t&nbsp;<br>\n";
  echo "</td>\n";

}

/**
 * Erstellt ein Radio button mit dem Value true
 * @param unknown $titel
 * @param unknown $pos
 * @param unknown $data
 * @param unknown $is_readonly
 */
function print_edit_bool($titel, $pos, $data, $is_readonly)
{
  $titel = ucwords(strtolower($titel));
  $name = "row[$pos]";
  echo "  <td width=75 ><i>$titel</i></td>\n";
  echo "<td >\n";
  echo "<td>\n";
  echo "<input type=\"radio\" class=\"Radio\" name=\"$name\" value=\"true\"> $titel tru<br>\n";
  echo "<input type=\"radio\" class=\"Radio\" name=\"$name\" value=\"false\"> $titel false\n";
  echo "</td>";
}

/**
 * Erstellt ein Radiobutton mit dem value <J>
 * @param unknown $titel
 * @param unknown $pos
 * @param unknown $data
 * @param unknown $is_readonly
 */
function print_edit_janein($titel, $pos, $data, $is_readonly)
{
  $titel = ucwords(strtolower($titel));
  $name = "row[$pos]";
  if(!stripos($data, "ja"))
  {
    $select_ja = "selected";
  } else
  {
    $select_nein = "selected";
  }
  echo "  <td width=75 ><i>$titel</i></td>\n";
  echo "<td >\n";
  echo "<td>\n";
  echo "<select name=\"$name\" size=\"1\"> \n";
  echo "<option $select_ja >ja</option> \n";
  echo "<option $select_nein>nein</option> \n";
  echo "</select> \n";
  echo "</td>";
}


/**
 * Erstellt eine Detailmaske zu einem Datensatz
 * $is_info = true erstellt eine readonly Ansicht
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $next
 * @param unknown $is_info = true , erstellt als default eine redonly ansicht
 */
function print_maske($mfd, $id, $ID,$next,$row, $is_info=true)
{
  global $PHP_SELF;
  $mfd_name = $mfd["mfd"];

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  /*
   * +----------------------------+
  * |		|		 |	 	 	    	 	    |
  * |		|		 |	 	|	   |	 	|   |
  * +----------------------------+
  *
  * +----------------------------+
  * |		|												|
  * |		|												|
  * |		|												|
  * +----------------------------+
  *
  * +----------------------------+
  * |														|
  * |														|
  * |														|
  * |														|
  * +----------------------------+
  *
  * +----------------------------+
  * |		[SUBMIT]  [RESET]				|
  * +----------------------------+
  */
  //  FORMULAR
  echo "\n";
  echo "<FORM ACTION=\"$PHP_SELF?=md=0&amp;ID=$ID\" METHOD=GET>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

  echo "<table  background=\"layout/back/paper.jpg\"> ";
  echo "<tr>";
  echo "<td>";
  //Detail Header
  echo "<TABLE WIDTH=\"680\">\n";
  echo "<tr>\n";  // ID
  echo "  <td width=75 ></td>\n";
  echo "  <td width=50><b>$mfd_name</b></td>\n";
  echo "</tr>\n";  // ID
  echo "</TABLE>\n";

  echo "<TABLE WIDTH=\"680\">\n";
  echo "<tr>\n";  // ID
  echo "  <td width=75 ><b>ID</b></td>\n";
  echo "  <td width=50>$row[0]&nbsp;</td>\n";
  echo "</tr>\n";
  //  einfache Datenfelder
  echo "<tr>\n";
  print_edit_spalte("JAHR", 1, $row[1], 12, $is_info);
  print_edit_spalte("TAG", 2,$row[2],12,$is_info);
  print_edit_spalte("S2", 3, $row[3], 12,$is_info);
  echo "</tr>\n";
  echo "</table>\n";

  echo "<TABLE WIDTH=\"680\">\n";
  echo "<tr>\n";  // Historie
  print_edit_spalte("DATUM", 6, $row[6],12,$is_info);
  echo "</tr>\n";
  echo "<tr>\n";  // Name
  print_edit_spalte("NAME", 4, $row[4], 50,$is_info);
  echo "</tr>\n";
  echo "<tr>\n";  // Kurz
  print_edit_spalte("KURZ", 5, $row[5], 75, $is_info);
  echo "</tr>\n";
  echo "</table>\n";
  // Text Datenfelder
  echo "<TABLE WIDTH=\"680\">\n";
  echo "<tr>\n";  // Text
  print_edit_text("", 7, $row[7], $is_info);
  echo "</tr>\n";
  echo "</TABLE>\n";

  // Button Zeile
  if (!$is_info)
  {
    echo "<TABLE WIDTH=\"680\">\n";
    echo "\t<tr>\n";
    echo "\t<td></td>\n";
    echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\"> </td>\n";
    echo "\t<td> <INPUT TYPE=\"RESET\" VALUE=\"RESET\">			</td>\n";
    echo "\t</tr>\n";
    echo "</table>";
  };

  echo "</td>";
  echo "</tr>";
  echo "</table> ";

  echo "</FORM>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";


};


function print_detail_info($id, $ID,$next)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  $mfd_list = get_mfd("legende");
  //$mfd_cols = get

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  //if ($DEBUG) {echo "Verbunden<br>";}

  mysql_select_db($DB_NAME);
  //if ($DEBUG) {echo "DB ausgewählt<br>";}

  $result = mysql_query("select id,s0,s1,s2,name,kurz,datum,beschreibung from legende where id=\"$id\"")
  or die("Query Fehler...");
  $row = mysql_fetch_row($result);
  mysql_close($db);

  print_maske($mfd_list, $id, $ID,$next,$row, true);
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

$BEREICH = 'INTERN';


$md     = GET_md(0);
$daten  = GET_daten("");
$id    = GET_id("");
$ID     = GET_SESSIONID("");

session_id ($ID);
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


print_header("Legenden");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
print_kopf($logo_typ,$header_typ,"Intern",$anrede,$menu_item);

switch ($md):
case 2: // Ansehen des Datesatzes als Form
  $menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
      8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
default:  // MAIN-Menu
  $menu = array (0=>array("icon" => "99","caption" => "LEGENDEN","link" => ""),
  1=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
  );
  endswitch;

  print_menu_status($menu);


  switch ($md):
case 2:
    print_detail_info($id,$ID,0);
  break;
default:
  print_leg_liste($ID);
  break;
  endswitch;

  print_md_ende();

  print_body_ende();

  ?>