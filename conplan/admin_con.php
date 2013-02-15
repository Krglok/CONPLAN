<?php

/*
 Projekt : ADMIN

Datei   :  admin_con.php,v $

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird der Interne Teil der HP abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis

./

Die images kommen aus dem Verzeichnis

./images

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

Die zugehoerigen HTML Seiten sollten in einem Subdir sein 2)
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite


$Log: conadmin.php,v $
Revision 1.4  2002/06/01 10:40:00  windu
Erweiterung um bilder_admin

Revision 1.3  2002/05/30 07:22:21  windu
ADmin-Funktion für
Einbringen des Aktuellen Con-Tages
mit neuer Tabelle con_konst

Revision 1.2  2002/05/24 13:11:52  windu
neue icons im menü

Revision 1.1  2002/05/03 20:23:41  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.4  2002/03/09 18:28:52  windu
Korrekturen und Aufteilung in LIB.INC

Revision 1.3  2002/02/26 18:42:40  windu
keyword aktiviert

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";

//-----------------------------------------------------------------------------
function print_liste($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TAG;


  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  //  $q = "select c.id,c.tag,c.user_id,u.username,s.name,s.vorname from con_konst as c, user_liste as u, spieler as s where c.user_id=u.ID AND u.spieler_id=s.id order by tag DESC ,c.user_id";
  $q = "select $TABLE.* , con_tage.bemerkung,  spieler.name, spieler.vorname  from $TABLE "
  ." left outer join con_tage on con_tage.tag=$TABLE.tag "
  ." left outer join user_liste on user_liste.id=$TABLE.user_id "
  ." left outer join spieler on spieler.id=user_liste.spieler_id "
  ." order by tag DESC , user_id";

  $result = mysql_query($q)  or die("Query Fehler :".$q);

  $q = "select * from con_konst where id=1";
  $result1 = mysql_query($q)  or die("Query Fehler...");

  mysql_close($db);


  echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

  //Kopfzeile
  $row1 = mysql_fetch_row($result1);
	echo "<tr>";
	echo "<td colspan=3>";
	echo "Aktueller Con\n";
	echo "</td>";
	echo "<td>";
	echo "$row1[1]";
	echo "</td>";
	echo "</tr>";
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
      echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
      print_menu_icon ("_db");
				echo "\t</a></td>\n";
      } else
      {
      echo "\t<td>$row[$i]&nbsp;</td>\n";
};
}
echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
print_menu_icon ("_point");
		echo "\t</a></td>\n";
echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function tage_liste($ID)
{
global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
global $PHP_SELF;
global $TABLE;
global $TABLE1;

$TAG   = get_akttag();

$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

mysql_select_db($DB_NAME);

	$q = "select * from con_tage where substring(von,1,4)>\"0000\" order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=100% BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		  {
		  if ($row[1]==$TAG)
		    {
				$bgcolor="silver";
		    } else
		    {
		    $bgcolor="";
		}

		// aufruf der Deateildaten
		switch ($i):
		case 0 :
				echo "\t<td width=\"30\"> \n";
		//print_menu_icon (9);
			echo "\t</a></td>\n";
			break;
			case 1:
			echo "\t<td width=\"20\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 2:
			echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 3:
			echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 4:
			echo "\t<td width=\"30\" align=RIGHT  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 5:
			echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 6:
			echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			break;
			case 7:
			if ($row[1]==$TAG)
			{
					echo "\t<td width=\"250\" bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
		} else
		{
		  echo "\t<td width=\"250\" bgcolor=\"$bgcolor\" >$row[$i]&nbsp;</td>\n";
		}
		break;
			case 8:
			  //        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
			  break;
			default :
			  endswitch;
		};
			
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TAG;
  global $PHP_SELF;
  

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  //  $q = "select * from $TABLE where S0=\"$TAG\"";
  $q = "select $TABLE.* , con_tage.bemerkung,  spieler.name, spieler.vorname  from $TABLE "
  ." left outer join con_tage on con_tage.tag=$TABLE.tag "
  ." left outer join user_liste on user_liste.id=$TABLE.user_id "
  ." left outer join spieler on spieler.id=user_liste.spieler_id "
  ." order by tag DESC , user_id";
	$result = mysql_query($q)  or die("Query Fehler:".$q);

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

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
      print_menu_icon ("_del");
      echo "\t</a></td>\n";
  } else
  {
    echo "\t<td>$row[$i]&nbsp;</td>\n";
  };
}
echo "<tr>";
}
echo "</table>";
echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

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
	// $TABLE.* , con_tage.bemerkung, user_liste.username
	$q = "select $TABLE.* , con_tage.bemerkung,  spieler.name, spieler.vorname  from $TABLE "
	." left outer join con_tage on con_tage.tag=$TABLE.tag "
	." left outer join user_liste on user_liste.id=$TABLE.user_id "
	." left outer join spieler on spieler.id=user_liste.spieler_id "
			." where $TABLE.id=$id "
			;
	$result = mysql_query($q)
	or die("Query Fehler: ".$q);

			$field_num = mysql_num_fields($result);
			$row = mysql_fetch_row($result);

			mysql_close($db);

			//Daten bereich
			echo "  <TD\n>";  //Daten bereich der Gesamttabelle

			echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
			echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
			echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
			echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
			echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
			echo "<TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
					BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

			for ($i=0; $i<$field_num; $i++)
	{
	$field_name[$i] =  mysql_field_name($result,$i);
	$type[$i]       =  mysql_field_type ($result, $i);
			}
			for ($i=0; $i<$field_num; $i++)
			{
			if ($type[$i]=="date") {
					$len[$i] = 10;
			}
			  if ($type[$i]=="int") {
					$len[$i] = 5;
			}
			  if ($type[$i]=="string") {
					$len[$i] = 50;
}
			  if ($type[$i]!="blob")
			  {
					echo "<tr>";
					echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
					echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
					//        echo "\t<td width=100>$type[$i]&nbsp;</td>\n";
					echo "<tr>";
					} else
					{
					  echo "<tr>";
					  echo "\t<td><b></b></td>\n";
					  echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=50 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
					  echo "<tr>";
					}
					}
					    echo "</table>";
			echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

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


function loeschen($id,$ID)
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
  if (count($row)==1)  // ergebnis ist leer = ERFASSEN
		{
		for ($i=0; $i<$field_num; $i++)
  {
  $row[$i] = "";
  };
  $row[2] = $id;
  };
  /**/

  echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
  echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
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
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
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
			    echo "  </TD\n>"; //ENDE  Datenbereich der Gesamttabelle

			    };


			    function print_ID($ID)
			    {
			    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
			    global $PHP_SELF;
	global $TABLE;
			        global $TAG;


			        $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select s.id,s.name,s.vorname,u.username,u.id from spieler as s, user_liste as u where s.id=u.spieler_id order by s.name, s.vorname";
			        $result = mysql_query($q)  or die("Query Fehler...");

mysql_close($db);


echo "  <TD\n>"; //Daten bereich der Gesamttabelle
echo "<table border=1 BGCOLOR=\"\">\n";

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
				echo "\t<td><a href=\"$PHP_SELF?md=1&ID=$ID&ID_id=$row[4]&TAG=$TAG\">\n";
    print_menu_icon (9,"Auswahl des Datensatzes !");
				echo "\t</a></td>\n";
} else
{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$BEREICH = 'ADMIN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$md     = GET_md(0);
$id     = GET_id(0);
$daten  = GET_daten("");

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


print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"Admin Bereich",$anrede,$menu_item);

$TABLE = "con_konst";


print_md();

switch ($p_md):
case 5: // Anlegen eines neuen des DAtensatzes
  //  Insert SQL
  insert($p_row);
$md=0;
break;
case 6: // Update eines bestehnden Datensatzes
  // Update SQL
  update($p_row);
  $md=0;
  break;
default:  // MAIN-Menu
  endswitch;

  switch ($md):
case 7: // Delete eines bestehenden Datensatzes
    // SQL delete
    loeschen($id,$ID);
  $md=3;
  break;
default:  // MAIN-Menu
  endswitch;


  switch ($md):
case 1: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
        2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
case 2: // Ansehen / INFO eines Datensatzes
  $menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
  8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
case 3: // Delete eines bestehenden Datensatzes
  $menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&")
  );
  break;
case 4: // Anzigen Bearbeiten Form
  $menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
case 8: // Anzigen Bearbeiten Form
  $menu = array (0=>array("icon" => "7","caption" => "CON-TAG","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
case 9:  // MAIN-Menu
  $menu = array (0=>array("icon" => "99","caption" => "AUSWAHL","link" => ""),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );

  break;
case 10:  // MAIN-Menu
  $menu = array (0=>array("icon" => "99","caption" => "CON-SL","link" => ""),
//   1=>array("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=9&ID=$ID"),
//   2=>array("icon" => "_del","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID"),
//   3=>array("icon" => "_db","caption" => "CON-Tag setzen","link" => "$PHP_SELF?md=8&ID=$ID&id=1"),
//   4=>array("icon" => "_folder","caption" => "CON-Zugriff","link" => "$PHP_SELF?md=0&ID=$ID&id=1"),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
  );
  break;
default:  // MAIN-Menu
  $menu = array (0=>array("icon" => "99","caption" => "CON-SL","link" => ""),
  1=>array("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=9&ID=$ID"),
  2=>array("icon" => "_del","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID"),
  3=>array("icon" => "_db","caption" => "CON-Tag setzen ","link" => "$PHP_SELF?md=8&ID=$ID&id=1"),
  4=>array("icon" => "_list","caption" => "CON-Liste","link" => "$PHP_SELF?md=10&ID=$ID&id=1"),
  9=>array("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
  );
  break;
  endswitch;

  print_menu($menu);


  switch ($md):
case 1:
    //
    print_maske($ID_id,$ID,5,1);
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
case 8:
  //
  print_maske($id,$ID,6,0);
  break;
case 9:
  //
  print_ID($ID);
  break;
case 10:
  //
  tage_liste($ID);
  break;
default:
  print_liste($ID);
  break;
  endswitch;

  print_md_ende();

  print_body_ende();

  ?>
	