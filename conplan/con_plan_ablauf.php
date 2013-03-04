<?php
/*
 Projekt :  CONPLAN

Datei   :  con_ablauf_liste.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Datensätze
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

$Log: ablauf_liste.php,v $
Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Revision 1.1  2002/05/03 20:26:51  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.5  2002/03/10 09:38:13  windu
korrektur der listen und rücksprungadressen

Revision 1.4  2002/03/09 18:27:02  windu
Korrekturen und neue Aufnahme

Revision 1.3  2002/03/03 21:02:26  windu
detaillierung erweitert bei ablauf
Referenz eingeführt bei conplan

Revision 1.2  2002/03/03 11:13:13  windu
kleine Korrekturen

Revision 1.1  2002/03/02 11:36:36  windu
abgeleitet aus _liste.php

Revision 1.5  2002/03/02 08:25:12  windu
erweitert auf allgmeine Maske zur Bearbeitung einer MySQL-Datei.
Kann als Basis für spezielle Ausprägungen benutzt werden.

Revision 1.4  2002/03/01 05:22:28  windu
Als Allgemeinenes Bearbeitungsmodul ausgebaut.
Die SQL-Anbindung fehlt noch .

Revision 1.3  2002/02/26 18:27:02  windu
keyword Test

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
function print_liste($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TAG;


  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $q = "select id,s0,s1,s2,name,kurz,r_nsc,r_sc from $TABLE where S0=\"$TAG\" order by S0,S1,S2";
  $result = mysql_query($q)  or die("Query Fehler...");

  mysql_close($db);


$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!---  DATEN Spalte   --->\n";
    
  echo "<table >\n";

  //Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    echo "\t<td><font size=-1><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
  };
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
        echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
        print_menu_icon ("_editor","Datensatz bearbeiten");
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td>$row[$i]&nbsp;</td>\n";
      };
    }
    echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\"> <font size=+1>\n";
    print_menu_icon ("_tinfo","Datensatz ansehen");
    echo "\t</a></td>\n";
    echo "<tr>";
  }
  echo "</table>";

echo '</div>';
echo "<!---  ENDE DATEN Spalte   --->\n";
  
};

function print_loeschen($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TAG;


  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $q = "select id,s0,s1,s2,name,kurz,r_grp from $TABLE where S0=\"$TAG\" order by S0,S1,S2";
  $result = mysql_query($q)  or die("Query Fehler...");

  mysql_close($db);


$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!---  DATEN Spalte   --->\n";
  
  echo "<table >\n";

  // Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
  };
  //lfdnr,name,vorname,orga}
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
        echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
        print_menu_icon ("_tdel");
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
echo "<!---  ENDE DATEN Spalte   --->\n";
  
};

function print_info($id,$ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $TABLE;
  global $TAG;
  global $PHP_SELF;
  
  //Anzeigen von Contage als einfache Maske
  //function view() {

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $q = "select * from $TABLE where id=$id";
  $result = mysql_query($q)
  or die("Query Fehler: ".$q);

  $field_num = mysql_num_fields($result);
  $row = mysql_fetch_row($result);

  mysql_close($db);

  //Daten bereich
$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!---  DATEN Spalte   --->\n";

  
  echo "<FORM ACTION=\"$PHP_SELF?md=0&TAG=$TAG&ID=$ID\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
  echo "<TABLE >\n";

  for ($i=0; $i<$field_num; $i++)
  {
    $field_name[$i] =  mysql_field_name($result,$i);
    $type[$i]       =  mysql_field_type ($result, $i);
    $len[$i]        =  get_fieldtyp_width($type[$i]);
  }
  for ($i=0; $i<$field_num-1; $i++)
  {
//     if ($type[$i]=="date") {
//       $len[$i] = 10;
//     }
//     if ($type[$i]=="int") {
//       $len[$i] = 5;
//     }
    //      if ($type[$i]!="blob")
    {
      switch ($i):
      case 0:
        echo "<tr>";
        echo "<TABLE >\n";
        echo "<tr>";
        echo "\t<td width=100><B> ABLAUF </B></td>\n";
        echo "\t<td><input name=\"\" maxlength=5 size=5 readonly value=$row[1]></td>\n";
        echo "</tr>";
        break;
      case 2:
        echo "<tr>";
        echo "\t<td width=50>$field_name[$i]&nbsp;$i</td>\n";
        echo "\t<td><input name=\"\" maxlength=5 size=5 readonly value=$row[$i]></td>\n";
        break;
      case 3:
        echo "\t<td width=50>$field_name[$i]&nbsp;$i</td>\n";
        echo "\t<td><input name=\"\" maxlength=5 size=5 readonly value=$row[$i]></td>\n";
        break;
      case 4:
        echo "\t<td width=50>$field_name[$i]&nbsp;$i</td>\n";
        echo "\t<td><input name=\"\" maxlength=5 size=5 readonly value=$row[$i]></td>\n";
        echo "</tr>";
        break;
      case 5:
        echo "<table>";
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]:</td>\n";
        echo "\t<td><input name=\"\" maxlength=$len[$i] size=50 readonly value=\"$row[$i]\"> $len[$i]</td>\n";
        echo "</tr>";
        break;
      case 6:
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]/KURZ</td>\n";
        echo "\t<td><input name=\"\" maxlength=50 size=50 readonly value=\"$row[$i]\"></td>\n";
        echo "</tr>";
        echo "</table>";
        break;
      case 7:
        echo "<table>";
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=50 size=50 readonly value=\"$row[$i]\"></td>\n";
        break;
      case 8:
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=50 size=50 readonly value=\"$row[$i]\"></td>\n";
        echo "</tr>";
        break;
      case 9:
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=50 size=50 readonly value=\"$row[$i]\"></td>\n";
        echo "</tr>";
        break;
      case 10:
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
        break;
      case 11:
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
        echo "</tr>";
        echo "</tr>";
        break;
      case 12:
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
        echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
        echo "</tr>";
        echo "</tr>";
        echo "</table>";
        break;
      case 13:
        echo "<table>";
        echo "<tr>";
        echo "\t<td width=100><b> </b></td>\n";
        echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=80 ROWS=60 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
        echo "</tr>";
        echo "</table>";
        break;
      default:
//         echo "<tr>";
//         echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
//         echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
//         //        echo "\t<td width=100>$type[$i]&nbsp;</td>\n";
//         echo "</tr>";
        break;
        endswitch;

    }
  }
  echo "</table>";
echo '</div>';
echo "<!---  ENDE DATEN Spalte   --->\n";
  
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


function loeschen($id)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $TABLE;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)     or die("Fehler beim verbinden!");

  if (mysql_select_db($DB_NAME) != TRUE) {
    echo "Fehler DB";
  };
  /**/
  $q = "delete from $TABLE where id=\"$id\" ";
  //  echo $q;
  $result = mysql_query($q) or die("Delete Fehler....$q.");
  /**/
  mysql_close($db);

};

function print_maske($id,$ID,$next,$erf)
{
  //
  //  $id   beinhaltet den zu bearbeitenden Datensatz
  //  $ID beinhaltet den User des Programms (authetifizierung)
  //  $next beinhaltet die nächste zu rufende Funktion
  //  $erf  steurt die Variablen initialisierung
  //
  // durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
  //
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $TABLE;
  global $TAG;
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
    $row[1] = $TAG;
  };
  /**/

$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!---  DATEN Spalte   --->\n";
  
  echo "<FORM ACTION=\"$PHP_SELF?md=0&TAG=$TAG&ID=$ID\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
  echo "<TABLE >\n";
  echo "\t<tr>\n";
  echo "\t<td width=100></td>\n";
  echo "\t<td><center><b>$TABLE</b></td>\n";
  echo "\t</tr>\n";
  for ($i=0; $i<$field_num; $i++)
  {
    $field_name[$i] =  mysql_field_name ($result, $i);
    $type[$i]       =  mysql_field_type ($result, $i);
    $len[$i]        =  mysql_field_len  ($result,$i);

  }
  for ($i=0; $i<$field_num; $i++)
  {
    if ($type[$i]=="date") {
      $len[$i] = 10;
    }
    if ($type[$i]=="int") {
      $len[$i] = 5;
    }
    if ($i!=0)
    {
      if ($type[$i]!="blob")
      {
        echo "<tr>";
        echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

        echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";

        echo "<tr>";
      } else
      {
        echo "<tr>";
        echo "\t<td><b></b></td>\n";
        echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=80 ROWS=65>$row[$i]</TEXTAREA>&nbsp;</td>\n";
        echo "<tr>";
      }
    } else
    {
      echo "<tr>";
      echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
      echo "<td><input type=\"text\" name=\"\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
      echo "<tr>";
    }
  }


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
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$BEREICH = 'SUBSL';


$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$ID     = GET_SESSIONID("");
$TAG    = GET_TAG("0");
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
  header ("Location: larp.php");  // Umleitung des Browsers
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

$TABLE = "con_ablauf";

switch ($p_md):
case 5:  // MAIN-Menu
  insert($p_row);
  $md =0;
  break;
case 6: // Update eines bestehnden Datensatzes
  // Update SQL
  update($p_row);
  $md=0;
  break;
default :
  break;
endswitch;

switch ($md):
case 7: // Delete eines bestehenden Datensatzes
    // SQL delete
  loeschen($id);
  $md=3;
default :
  break;
endswitch;


switch ($md):
case 1: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "1","caption" => "ABLAUF $TAG","link" => ""),
        1=>array("icon" => "1","caption" => "ERFASSEN","link" => ""),
        2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
    );
    break;
case 2: // Ansehen / INFO eines Datensatzes
  $menu = array (0=>array("icon" => "1","caption" => "ABLAUF $TAG","link" => ""),
  1=>array("icon" => "1","caption" => "ANSEHEN","link" => ""),
  8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  );
  break;
case 3: // Delete eines bestehenden Datensatzes
  $menu = array (0=>array("icon" => "99","caption" => "ABLAUF $TAG","link" => ""),
  1=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  );
  break;
case 4: // Anzigen Bearbeiten Form
  $menu = array (0=>array("icon" => "99","caption" => "ABLAUF $TAG","link" => ""),
  1=>array("icon" => "1","caption" => "BEARBEITEN","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  );
  break;
default:  // MAIN-Menu
  $menu = array (0=>array("icon" => "99","caption" => "ABLAUF $TAG","link" => ""),
  1=>array("icon" => "_tadd","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG"),
  2=>array("icon" => "_tdelete","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&TAG=$TAG"),
  3=>array("icon" => "_printer","caption" => "Drucken","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG"),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "con_plan.php?md=0&ID=$ID&TAG=$TAG")
  );
  endswitch;

  print_menu_status($menu);

  switch ($md):
case 1:
    //
    print_maske($id,$ID,5,1);
  break;
case 2:
  Print_info($id, $ID);
  break;
case 3:
  //
  print_loeschen($ID);
  break;
case 4:
  //
  print_maske($id,$ID,6,0);
  break;
default:
  print_liste($ID);
  break;
  endswitch;

  print_md_ende();

  print_body_ende();

  ?>