<?php
/*
 Projekt :  CONPLAN

Datei   :  con_plan.php

Datum   :  2002/06/08

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :  ist das Main Menü für die Planung eines CONs
Kann nur über Contage sinnvoll aufgerufen werden,
da die globale Variable   $tag  gesetzt sein muss
um die richtige Referenz in der Datenbank zu erzeugen.

Von hier aus werden die Unterprogramme für die Con-Planung aufgerufen

Ueber das Script wird der SL/CONPLAN Teil der HP abgewickelt.
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

$Log: conplan.php,v $
Revision 1.5  2002/06/08 14:21:59  windu
Korrektur Aufruf über con_sl , falscher  Parameter

Revision 1.4  2002/05/30 07:41:11  windu
korrektur : falsche location für Fehlerfall  SL-zugriiff !!

Revision 1.3  2002/05/30 07:27:03  windu
Einbringen des Aktuellen Con-Tages
mit  SL Zugriffsbegrenzung

Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Revision 1.1  2002/05/03 20:26:51  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.5  2002/04/20 07:28:12  windu
Menü Erweiterung um Side Map etc.

Revision 1.4  2002/03/10 09:38:13  windu
korrektur der listen und rücksprungadressen

Revision 1.3  2002/03/09 18:27:02  windu
Korrekturen und neue Aufnahme

Revision 1.2  2002/03/03 21:02:26  windu
detaillierung erweitert bei ablauf
Referenz eingeführt bei conplan

Revision 1.1  2002/03/02 11:36:36  windu
abgeleitet aus _liste.php

*/


include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


function get_tag_name($tag)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select bemerkung from con_tage where tag=\"$tag\"";
	$result = mysql_query($q)
	or die("Query Fehler...");
	mysql_close($db);
	$row = mysql_fetch_row($result);

	return $row[0];
}

function get_ablauf($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_ablauf";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1,S2";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";

}

/**
 * get_orte()
 *
 * @param $tag
 * @return
 */
function get_orte($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_orte";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1,S2";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";
}

/**
 * get_nsc()
 *
 * @param $tag
 * @return
 */
function get_nsc($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_nsc";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";
}

function get_geruecht($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_geruecht";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<6; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";
}

function get_buch($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_buch";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<5; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";
}

function get_artefakte($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "artefakte";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by name";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<5; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "<hr>";
}


function print_main_data($ID)
{

	global  $TAG;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"100%\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "        <TR>\n";
	echo "          <TD><!-- Row:1, Col:1 -->\n";
	echo "            <FONT size=+0>\n";
	echo "            &nbsp; Dies ist das Planungsübersicht für den CON-Tag \n";
	echo "            <B>$TAG &nbsp;&nbsp;".get_tag_name($TAG)."<B>";
	echo "            <BR>\n";
	echo "            <BR>\n";
	echo "            <TABLE  >\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Ablauf\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_ablauf($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Orte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_orte($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>NSC\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_nsc($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Gerüchte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_geruecht($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Bücher \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_buch($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Artefakte \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	get_artefakte($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            </TABLE  >\n";
	echo "          </TD>\n";
	echo "        </TR>\n";
	echo "      </TABLE>\n";
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
};

function ref_ablauf($tag)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_ablauf";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by S1,S2";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			echo "\t<td  BGCOLOR=\"silver\" >$row[$i]&nbsp;</td>\n";
		}
		ref_orte($tag,$row[2]);
		ref_nsc($tag,$row[2]);
		ref_geruecht($tag,$row[2]);
		ref_buch($tag,$row[2]);
	}
	echo "</table>";

}


/**
 * ref_orte()
 *
 * @param $tag
 * @param $ref
 * @return
 */
function ref_orte($tag,$ref)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_orte";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" AND s1=\"$ref\" order by S1,S2";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "ORTE \n";
	echo "</td>";
	echo "<td colspan=3>";
	echo "<table width=\"100%\" border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
}

function ref_nsc($tag,$ref)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_nsc";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" AND s1=\"$ref\" order by S1";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "NSC \n";
	echo "</td>";
	echo "<td colspan=3>";
	echo "<table width=\"100%\" border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<7; $i++)
		{
			// aufruf der Deateildaten
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
}

function ref_geruecht($tag,$ref)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_geruecht";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" AND S1=\"$ref\" order by S1"; //AND S1=\"$ref\"
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "Geruecht \n";
	echo "</td>";
	echo "<td colspan=3>";
	echo "<table width=\"100%\" border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<6; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
}

function ref_buch($tag,$ref)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "con_buch";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" AND s1=\"$ref\" order by S1";
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "Buch \n";
	echo "</td>";
	echo "<td colspan=3>";
	echo "<table width=\"100%\" border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=3; $i<5; $i++)
		{
			// aufruf der Deateildaten
			$s = substr($row[$i],0,50);
			echo "\t<td>$s&nbsp;</td>\n";
			//        echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
}

function ref_artefakte($tag,$ref)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$TABLE = "artefakte";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "select * from $TABLE where S0=\"$tag\" order by name";  // AND s1=\"$ref\"
	$result = mysql_query($q) or die("Query Fehler...");
	mysql_close($db);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "Buch \n";
	echo "</td>";
	echo "<td colspan=3>";
	echo "<table border=1 BGCOLOR=\"\">\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=2; $i<5; $i++)
		{
			// aufruf der Deateildaten
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
}

function print_ref_data($ID)
{

	global  $TAG;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"100%\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "        <TR>\n";
	echo "          <TD><!-- Row:1, Col:1 -->\n";
	echo "            <FONT size=+0>\n";
	echo "            &nbsp; Dies ist das Planungsübersicht für den CON-Tag \n";
	echo "            <B>$TAG &nbsp;&nbsp;".get_tag_name($TAG)."<B>";
	echo "            <BR>\n";
	echo "            <BR>\n";
	echo "            <TABLE  >\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Ablauf\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	ref_ablauf($TAG);
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Orte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo " <table>\n";
	echo " <tr>\n";
	echo " <td>\n";
	ref_orte($TAG,"");
	echo " </td>\n";
	echo " </tr>\n";
	echo " </table>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>NSC\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo " <table>\n";
	echo " <tr>\n";
	echo " <td>\n";
	ref_nsc($TAG,"");
	echo " </td>\n";
	echo " </tr>\n";
	echo " </table>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Gerüchte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo " <table>\n";
	echo " <tr>\n";
	echo " <td>\n";
	ref_geruecht($TAG,"");
	echo " </td>\n";
	echo " </tr>\n";
	echo " </table>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Bücher \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo " <table>\n";
	echo " <tr>\n";
	echo " <td>\n";
	ref_buch($TAG,"");
	echo " </td>\n";
	echo " </tr>\n";
	echo " </table>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Artefakte \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo " <table>\n";
	echo " <tr>\n";
	echo " <td>\n";
	get_artefakte($TAG);
	echo " </td>\n";
	echo " </tr>\n";
	echo " </table>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            </TABLE  >\n";
	echo "          </TD>\n";
	echo "        </TR>\n";
	echo "      </TABLE>\n";
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
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
	// Prüfung auf SL-Zugriff auf CONTAG
	if (get_sltag($user,$TAG) != "TRUE")
	{
		header ("Location: con_liste.php?md=0&ID=$ID");  /* Umleitung des Browsers
		zur PHP-Web-Seite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	}
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

print_header("SL Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(9,0,"Con Planung ","Sei gegrüsst Meister ");


echo "POST : $p_md / GET : $md / ID :$ID / TAG = $TAG";

print_md();

if ($TAG==0) {
	$TAG=15;
};

switch ($md):
case 10:
	$menu = array (0=>array("icon" => "99","caption" => "HILFE","link" => ""),
			2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "PLANUNG $TAG","link" => ""),
	1=>array("icon" => "1","caption" => "Ablauf","link" => "con_plan_ablauf.php?md=0&ID=$ID&TAG=$TAG"),
	2=>array("icon" => "1","caption" => "Orte","link" => "con_plan_orte.php?md=0&ID=$ID&TAG=$TAG"),
	3=>array("icon" => "1","caption" => "Nsc","link" => "con_plan_nsc.php?md=0&ID=$ID&TAG=$TAG"),
	4=>array("icon" => "1","caption" => "Gerüchte","link" => "con_plan_geruechte.php?md=0&ID=$ID&TAG=$TAG"),
	5=>array("icon" => "1","caption" => "Bücher","link" => "con_plan_buch.php?md=0&ID=$ID&TAG=$TAG"),
	6=>array("icon" => "1","caption" => "SC","link" => "con_plan_sc.php?md=0&ID=$ID&TAG=$TAG"),
	7=>array("icon" => "1","caption" => "Artefakte","link" => "con_plan_artefakt.php?md=0&ID=$ID&TAG=$TAG"),
	8=>array("icon" => "5","caption" => "Referenz","link" => "$PHP_SELF?md=5&ID=$ID&TAG=$TAG"),
	9=>array("icon" => "5","caption" => "Liste","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG"),
	10=>array("icon" => "10","caption" => "Hilfe","link" => "$PHP_SELF?md=10&ID=$ID&item=conplan"),
	11=>array("icon" => "6","caption" => "Zurück","link" => "con_liste.php?md=0&ID=$ID")
	);
	endswitch;

	print_menu($menu);


	switch ($md):
case 1:
		break;
case 2:
	break;
case 3:
	break;
case 4:
	break;
case 5:
	print_ref_data($ID);
	break;
case 10:
	print_hilfe($ID,$item,$id);
	break;
default:
	print_main_data($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>