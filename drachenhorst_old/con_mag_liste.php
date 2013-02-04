<?
/*
 Projekt :   CONPLAN

Datei   :   con_mag_liste.php

Datum   :   2002/05/14

Rev.    :   2.0

Author  :   Olaf Duda

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

$Log: mag_liste.php,v $
Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Revision 1.1  2002/05/03 20:26:51  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.1  2002/03/09 18:27:02  windu
Korrekturen und neue Aufnahme

Revision 1.5  2002/03/02 08:25:12  windu
erweitert auf allgmeine Maske zur Bearbeitung einer MySQL-Datei.
Kann als Basis für spezielle Ausprägungen benutzt werden.

Revision 1.4  2002/03/01 05:22:28  windu
Als Allgemeinenes Bearbeitungsmodul ausgebaut.
Die SQL-Anbindung fehlt noch .

Revision 1.3  2002/02/26 18:27:02  windu
keyword Test

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_summe($ID)
/*
 Übersicht der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);


	$q = "select count(NAME)as Anzahl from $TABLE ";
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


	$q = "select ID,GRP,count(NAME)as Anzahl from $TABLE group by grp order by grp DESC";
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
				echo "\t<td> Anzahl Sprüche in \n";
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

//-----------------------------------------------------------------------------
function print_liste($ID, $grp)
{
	//  &grp  beinhaltet die aktuele Gruppe der Datebsaetze (Spruchliste)

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;

	if ($grp=="")
	{
		print_summe($ID);
		exit;
	}

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id, grp,nr,stufe,name,spruchdauer,MUK,RAR,GEIST from $TABLE where grp=\"$grp\" order by grp DESC, stufe";
	//  $q = "select id, grp,nr,stufe,name,spruchdauer from $TABLE order by grp DESC, nr";
	$result = mysql_query($q)  or die("Query List...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<INPUT TYPE=\"hidden\" NAME=\"grp\"   VALUE=\"$grp\">\n";
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
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&grp=$grp\"> \n";
				print_menu_icon (9);
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&grp=$grp\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID,$grp)
{
	//  &grp  beinhaltet die aktuele Gruppe der Datebsaetze (Spruchliste)

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE  order by grp DESC, nr";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<INPUT TYPE=\"hidden\" NAME=\"grp\"   VALUE=\"$grp\">\n";
	echo "<table width=680 border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-7; $i++)
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
		for ($i=0; $i<$field_num-7; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&grp=$grp\">\n";
				print_menu_icon (4);
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

function print_info($id,$grp)
{
	//  &grp  beinhaltet die aktuele Gruppe der Datebsaetze (Spruchliste)

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;

	//Anzeigen von Contage als einfache Maske
	//function view() {

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler...");

	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	mysql_close($db);

	//Daten bereich
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"grp\"   VALUE=\"$grp\">\n";
	echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
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
		switch ($i) :
		case 0 :
			break;
		case 1 :
			echo "<tr>";
			echo "\t<td width=\"100\">Gruppe&nbsp;</td>\n";
			echo "\t<td width=\"20\"><input name=\"\" size=\"2\" readonly value=\"$row[$i]\"></td>\n";
			break;
		case 2 :
			//        echo "\t<td width=\"50\">$field_name[$i]&nbsp;</td>\n";
			echo "\t<td width=\"50\"><input name=\"\" size=\"2\" readonly value=\"$row[$i]\"></td>\n";
			break;
		case 3 :
			echo "\t<td width=\"50\">$field_name[$i]&nbsp;</td>\n";
			echo "\t<td width=\"50\"><input name=\"\" size=\"1\" readonly value=\"$row[$i]\"></td>\n";
			echo "\t<td >&nbsp;</td>\n";
			echo "<tr>";
			echo "</TABLE>";
			break;
		case 4 :
			echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
					BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
			echo "<tr>";
			echo "\t<td width=100>Spruchname&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" maxlength=\"50\" size=\"30\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 5 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"row[$i]\" size=\"30\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 6 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"row[$i]\" size=\"30\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 7 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input readonly type=\"text\" name=\"row[$i]\" size=\"30\" value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 8 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" size=\"30\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 9 :
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=75 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
			break;
		case 10 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" size=\"30\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 11 :
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=75 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
			break;
		case 12 :
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=75 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
			break;
		case 13 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" maxlength=$len\"1\" size=\"1\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 14 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" maxlength=\"1\" size=\"1\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		case 15 :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" maxlength=\"1\" size=\"1\" readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
		default :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input type=\"text\" name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
			endswitch;
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

function print_maske($id,$ID,$next,$erf,$grp)
{
	//
	//  $id   beinhaltet den zu bearbeitenden Datensatz
	//  $ID beinhaltet den User des Programms (authetifizierung)
	//  $next beinhaltet die nächste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//  &grp  beinhaltet die aktuele Gruppe der Datebsaetze (Spruchliste)
	//
	// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
	//
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;

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

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"grp\"   VALUE=\"$grp\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t<td><center><b>Spruchdetails</b></td>\n";
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);
		//
		// das Feld Grp soll mit den uebergebenen Wert vorbelegt wsein
		if ($field_name[$i] == 'grp'  )
		{
			$row[$i] = $grp;
		}
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
				//          echo "\t<td width=100>$len[$i]&nbsp;</td>\n";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";

				echo "<tr>";
			} else
			{
				echo "<tr>";
				//          echo "\t<td><b></b></td>\n";
				//          echo "\t<td width=100>$len[$i]&nbsp;</td>\n";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "<tr>";
			}
		} else
		{
			echo "<tr>";
			//        echo "\t<td width=100>$len[$i]&nbsp;</td>\n";
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



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];
$grp = $_GET['grp'];


session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];
$user_id 		= $_SESSION[user_id];

if ($ID == "")
{
	$session_id = 'FFFF';
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

if (getuser($user,$pw) != "TRUE")
{
	header ("Location: main.php");  // Umleitung des Browsers
	//       zur PHP-Web-Seite.
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}
else
{
	$l1 = (int) $user_lvl;
	$l2 = (int) $lvl_sl[14];
	if ($l1 >= $l2)
	{
		header ("Location: main.php?md=0");  /* Umleitung des Browsers
		zur HTML-StartSeite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

$TABLE = "mag_list";
$TABLE1 = "mag_grp";

switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row);
header ("Location: $PHP_SELF?md=0&ID=$ID");  /* Umleitung des Browsers
zur PHP-Web-Seite. */
exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
Code ausgeführt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=0&ID=$ID");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($id);
	header ("Location: $PHP_SELF?md=3&ID=$ID");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;


	print_header("SL Bereich");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

	print_kopf(7,9,"Magieliste","Sei gegrüsst Meister ");


	echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();

	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&grp=$grp")
		);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&grp=$grp")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&grp=$grp")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&grp=$grp")
	);
	break;
default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "MAGIE","link" => ""),
	1=>array("icon" => "2","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&grp=$grp"),
	2=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&grp=$grp"),
	3=>array("icon" => "5","caption" => "Drucken","link" => "con_mag_rep.php?md=0&ID=$ID&grp=$grp"),
	9=>array("icon" => "","caption" => "","link" => ""),
	10=>array("icon" => "1","caption" => "Neutrale Magie","link" => "$PHP_SELF?md=9&ID=$ID&grp=NT"),
	11=>array("icon" => "1","caption" => "Runenmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=RU"),
	12=>array("icon" => "1","caption" => "Elementar Magie","link" => "$PHP_SELF?md=9&ID=$ID&grp=EL"),
	13=>array("icon" => "1","caption" => "Rituale","link" => "$PHP_SELF?md=9&ID=$ID&grp=RI"),
	14=>array("icon" => "1","caption" => "Koboldmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=KO"),
	15=>array("icon" => "1","caption" => "Bardenmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=BA"),
	20=>array("icon" => "","caption" => "","link" => ""),
	22=>array("icon" => "1","caption" => "Weisse Magie","link" => "$PHP_SELF?md=9&ID=$ID&grp=WM"),
	24=>array("icon" => "1","caption" => "Heilmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=HM"),
	25=>array("icon" => "1","caption" => "Drachenmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=DR"),
	26=>array("icon" => "1","caption" => "Priestermagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=PR"),
	30=>array("icon" => "","caption" => "","link" => ""),
	32=>array("icon" => "1","caption" => "Schwarze Magie","link" => "$PHP_SELF?md=9&ID=$ID&grp=SM"),
	34=>array("icon" => "1","caption" => "Nekromantie","link" => "$PHP_SELF?md=9&ID=$ID&grp=NE"),
	36=>array("icon" => "1","caption" => "Daemonologie","link" => "$PHP_SELF?md=9&ID=$ID&grp=DM"),
	37=>array("icon" => "1","caption" => "Daemonenmagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=DA"),
	40=>array("icon" => "6","caption" => "Zurück","link" => "conmain.php?md=0&ID=$ID&grp=$grp")
	);
	endswitch;

	print_menu($menu);

	switch ($md):
case 1:
		//
		print_maske($id,$ID,5,1,$grp);
	break;
case 2:
	Print_info($id,$grp);
	break;
case 3:
	//
	print_loeschen($ID,$grp);
	break;
case 4:
	//
	print_maske($id,$ID,6,0,$grp);
	break;
default:
	print_liste($ID,$grp);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>