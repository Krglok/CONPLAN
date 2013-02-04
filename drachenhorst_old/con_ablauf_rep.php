<?
/*
 Projekt :  CONPLAN

Datei   :  con_ablauf_rep.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Reportfunktionen für die Datei <$TABLE>
Es wird eine Layout mit einem einfachen  Menü verwendet
damit der DIN A4  ausdruck möglich ist ohne unnötigen Rand

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

$Log: ablauf_rep.php,v $
Revision 1.1  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion


Abgleitet aus _liste  Rev. 1.7

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_liste($ID)
/*
 Übersicht der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select ID,S0,S1,S2,NAME,KURZ,R_GRP  from $TABLE where S0=\"$TAG\"  order by S0,S1,S2";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
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
				echo "\t<td>&nbsp;</td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=1&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};



function print_blatt($id,$ID)
/*
 Realisiert eine Einzelblatt des Datensatzes mit allen relevanten Details
ähnlich der Info-funktion in den Datenmasken.
Das Layout wird speziell angepasst um das DIN A$ format zu gewährleisten
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;

	//  Erstellen eines reports
	//

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	// Felder werden explizit angegeben,
	// die Reihenfolge der Definition ist die Reihenfolge in der Ergebnisliste
	//
	$q = "select ID,S0,S1,S2,NAME,KURZ,BESCHREIBUNG from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler : ".$q);
	//  anzahl zeile in Ergebnis -------------------------------------
	$field_num = mysql_num_fields($result);
	// Auflösung Datenzeilen in Ergebnis -----------------------------
	$row = mysql_fetch_row($result);
	// auflösen der Feldnamen und Type in einfache Tabellen ----------
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  ucfirst (mysql_field_name($result,$i));
		$type[$i]       =  mysql_field_type ($result, $i);
	};

	mysql_close($db);
	//
	//Daten bereich
	//
	//      Datentypenerkennung für NICT Strings -----
	//      if ($type[$i]=="date") { $len[$i] = 10; }
	//      if ($type[$i]=="int") { $len[$i] = 5; }
	//      if ($type[$i]!="blob")
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<TABLE WIDTH=\"900\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td><a href=\"$PHP_SELF?md=0&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
	print_menu_icon (6);
	echo "\t</a></td>\n";
	echo "</tr>";

	echo "<tr>";
	echo "\t<td width=50><b>$field_name[1]&nbsp;</b></td>\n";
	echo "\t<td width=50>$row[1]</td>\n";
	echo "\t<td width=50><b>$field_name[2]&nbsp;</b></td>\n";
	echo "\t<td width=50>$row[2] </td>\n";
	echo "\t<td width=50><b>$field_name[3]&nbsp;</b></td>\n";
	echo "\t<td width=50>$row[2] </td>\n";
	echo "\t<td > </td>\n";
	echo "<tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"900\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=120><b>$field_name[4]&nbsp;</b></td>\n";
	echo "\t<td width=150>$row[4]</td>\n";
	echo "\t<td width=10></b></td>\n";
	echo "\t<td width=200>$row[5] </td>\n";
	echo "\t<td > </td>\n";
	echo "<tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"900\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td width=120><b></b>$field_name[6]&nbsp;</td>\n";
	$zeile=explode("\n",$row[6]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "</td>\n";
	echo "<tr>\n";

	echo "</table>\n";  // Ende der Tabllle
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_liste_1($ID)
/*
 einfache der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select S0,S1,S2,NAME,KURZ,R_GRP, R_NSC  from $TABLE where S0=\"$TAG\" order by S0,S1";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table width=\"900\" border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			echo "\t<td>$row[$i]</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_liste_2($ID)
/*
 einfache der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select S0,S1,S2,NAME,KURZ,R_GRP, R_ORT  from $TABLE where S0=\"$TAG\" order by R_ORT,S1";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table width=\"900\" border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$p_row = $_POST['row'];


$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];
$TAG = $_GET['TAG'];


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

$TABLE = "con_ablauf";

print_header("SL Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";



//echo $TAG;

switch ($md):
case 1:
	//     Einzellblatt darstellung DIN A4
	print_blatt($id, $ID);
break;
case 2:
	//     Listendarstellung
	print_liste_1($ID);
	break;
case 3:
	//     Listendarstellung
	print_liste_2($ID);
	break;
case 4:
	//
	break;
default:
	print_kopf(9,0,"Con-Tage","Sei gegrüsst Meister ");


	echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();
	$menu = array (0=>array("icon" => "99","caption" => "REPORT ABLAUF","link" => ""),
			1=>array("icon" => "5","caption" => "Übersicht","link" => "$PHP_SELF?md=2&ID=$ID&TAG=$TAG"),
			9=>array("icon" => "6","caption" => "Zurück","link" => "con_ablauf_liste.php?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>