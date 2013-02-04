<?
/*
 Projekt :  CONPLAN

Datei   :  con_art_liste.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  $Author: windu $  / duda

beschreibung : realisiert die Bearbeitungsfunktionen f�r die Datei <$TABLE>
- Liste der Datens�tze
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


$Log: art_liste.php,v $
Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Revision 1.1  2002/05/03 20:26:51  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.1  2002/03/09 18:27:02  windu
Korrekturen und neue Aufnahme

Revision 1.5  2002/03/02 08:25:12  windu
erweitert auf allgmeine Maske zur Bearbeitung einer MySQL-Datei.
Kann als Basis f�r spezielle Auspr�gungen benutzt werden.

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
function print_liste($ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$order = " order by datum DESC ";
	$q = "select id,author,datum,betreff,text,kategorie from $TABLE $order";
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
	//Liste der Datens�tze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			switch ($i) :
			case 0:
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]\">\n";
			print_menu_icon (9);
			echo "\t</a></td>\n";
			break;
			case 1:
				echo "\t<td width=\"75\" >$row[$i]&nbsp;</td>\n";
				break;
			case 2:
				echo "\t<td width=\"80\" >$row[$i]&nbsp;</td>\n";
				break;
			case 3:
				echo "\t<td width=\"180\" >$row[$i]&nbsp;</td>\n";
				break;
			default:
				echo "\t<td>$row[$i]&nbsp;</td>\n";
				break;
				endswitch;

		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
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


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$order = " order by datum DESC ";
	$q = "select id,author,datum,betreff,text,kategorie from $TABLE $order";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<6; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	//lfdnr,name,vorname,orga}
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datens�tze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<6; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]\">\n";
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

function print_info($id,$ID)
{
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
		switch ($i) :
		case 0 :
			echo "<tr>";
		echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
		echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
		echo "<tr>";
		break;
		case 7 :
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=75 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
			break;
		default :
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
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
	//  $next beinhaltet die n�chste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//
	// durch $next kann die Maske sowohl f�r Erfassen als auch Bearbeiten benutzt werden.
	//
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $spieler_id;
	global $user_id;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	if ($erf == 0 )
	{

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
	} else
	{

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");


		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);

		$row[1] = get_author($spieler_id);
		$row[2] = date("Y-m-d");
		$row[6] = $user_id;
		$row[7] = "N";
	}

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
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
				if ($i!=5)
				{
					echo "<tr>";
					echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

					echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";

					echo "<tr>\n";
				} else
				{
					echo "<tr>";
					echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
					//    'INTIME','ORGA','SPIELER','SL','WEB'
					echo "<td>\n";
					echo "<SELECT NAME=\"row[$i]\">\n";
					echo "<OPTION VALUE=\"INTIME\">INTIME\n";
					echo "<OPTION VALUE=\"ORGA\">ORGA\n";
					echo "<OPTION VALUE=\"SPIELER\">SPIELER\n";
					echo "<OPTION VALUE=\"SL\">SL\n";
					echo "<OPTION VALUE=\"WEB\">WEB\n";
					echo "</SELECT>\n";
					echo "</td>\n";
					echo "<tr>\n";
				};
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
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
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
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Pr�fung ob User  berechtigt ist

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
	// Code ausgef�hrt wird.
}

if (getuser($user,$pw) != "TRUE")
{
	header ("Location: main.php");  // Umleitung des Browsers
	//       zur PHP-Web-Seite.
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgef�hrt wird.
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
		Code ausgef�hrt wird. */
	};
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgef�hrt wird. */
};

$TABLE = "idea_post";

switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row);
header ("Location: $PHP_SELF?md=0&ID=$ID");  /* Umleitung des Browsers
zur PHP-Web-Seite. */
exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
Code ausgef�hrt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=0&ID=$ID");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgef�hrt wird. */
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
	Code ausgef�hrt wird. */
	break;
default :
	break;
	endswitch;

	print_header("SL Bereich");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";

	print_kopf(1,9,"Artefakte","Sei gegr�sst Meister ");


	echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();

	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "L�SCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "IDEEN","link" => ""),
	1=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID"),
	2=>array("icon" => "4","caption" => "L�schen","link" => "$PHP_SELF?md=3&ID=$ID"),
	9=>array("icon" => "6","caption" => "Zur�ck","link" => "conmain.php?md=0&ID=$ID")
	);
	endswitch;

	print_menu($menu);

	//echo $TAG;

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