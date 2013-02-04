<?
/*
 Projekt :  MAIN

Datei   :  main_download

Datum   :  2002/06/01

Rev.    :   2.0

Author  :  OlafDuda

beschreibung :
Es gibt keine Zugriffsverwaltung und keine Rechte !
realisiert die Download Liste aus der Datenbank
- Liste der Datensätze
- es werden automatisch links fuer den Download erzeugt.
- es werden nur Datensaetze mit dem Wert PUBLIC angezeigt
Keine Verwaltungsfunktionen !!

Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !


REVISION
#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite


*/

include "config.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_liste($ID)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_info>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,groesse,kurz,path from $TABLE where bereich='public'";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=\"1\" CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			// aufruf der Deateildaten
			switch ($i):
			case 0:
				echo "\t<td><a href=\"download/$row[4]\">\n";
			//echo "\t<IMG SRC=\"larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Download\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			print_menu_icon (12);
			echo "\t</a></td>\n";
			break;
			case 1:
				echo "\t<td>$row[$i]&nbsp;</td>\n";
				break;
			case 2:
				echo "\t<td>$row[$i]&nbsp;kb</td>\n";
				break;
			case 3 :
				echo "<td  WIDTH=\"350\"  >\n";
				$zeile=explode("\n",$row[$i]);
				$anz  = count($zeile);
				for ($ii=0; $ii<$anz; $ii++)
				{
					echo "\t$zeile[$ii]&nbsp;<br>\n";
				}
				echo "\t&nbsp;<br>\n";
				echo "</td>\n";
				break;
			default :
				echo "\t<td>$row[$i]&nbsp;</td>\n";
				break;
				endswitch;
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

print_header("Download");

print_body(2);

print_kopf(1,2,"Download","Sei gegrüsst Suchender ");


$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$id = $_GET['id'];

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";


$TABLE = "download";

print_md();

switch ($md):
default:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "DOWNLOAD","link" => ""),
			8=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
	);
	print_menu($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>