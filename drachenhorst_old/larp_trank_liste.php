<?
/*
 Projekt :   LARP

Datei   :  larp_trank_liste.php

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
function print_liste($ID,$grp)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	if ($grp=='')
	{
		$grp="TRANK";
	}

	$q = "select id, grp,stufe,name from $TABLE where grp=\"$grp\" order by grp DESC, stufe";
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
				echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";
				print_menu_icon (7);
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

	$q = "select id,grp,stufe,name,wirkung from $TABLE where id=$id";
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





// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

$md = $_GET['md'];
$ID = $_GET['ID'];
$id = $_GET['id'];
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

// Prüfung ob User  berechtigt ist
if (getuser($user,$pw) != "TRUE")
{
	$session_id = 'FFFF';
	//  echo "ID:$session_id ";
	chdir("..");
	//  Bei fehlendem oder falscher Rechten ins ROOT HTML
	header ("Location: ../larp.html");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
}

print_header("Trankliste");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(10,2,"Trankliste","Sei gegrüsst $spieler_name ");


//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id \n";

$TABLE = "trank_list";


print_md();

switch ($md):
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
			8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;

default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "TRAENKE","link" => ""),
	1=>array("icon" => "1","caption" => "TRANK","link" => "$PHP_SELF?md=1&ID=$ID&grp=TRANK"),
	2=>array("icon" => "1","caption" => "GIFT","link" => "$PHP_SELF?md=1&ID=$ID&grp=GIFT"),
	3=>array("icon" => "1","caption" => "HEILUNG","link" => "$PHP_SELF?md=1&ID=$ID&grp=HEIL"),
	9=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	endswitch;

	print_menu($menu);

	//echo $TAG;

	switch ($md):
case 1:
		//
		print_liste($ID,$grp);
	break;
case 2:
	Print_info($id, $ID);
	break;
default:
	print_liste($ID,$grp);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>