<?
/*
 Projekt :  MAIN

Datei   :  main_download

Datum   :  2002/06/01

Rev.    :   3.0

Author  :  Windu

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

Ver 3.0 / 04.02.2013
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


/**
 * Erstellt eine Liste der Download Dateien als Link
 * 
 * @param unknown $ID  Session ID
 */
function print_liste($ID)
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


	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	echo "<table>\n";

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

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
};



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

$BEREICH = 'PUBLIC';

print_header("Download");
//print_body(2);


// Steuerparameter und steuerdaten
$md=GET_md(0);
$daten=GET_daten("");
$item=GET_item("main");
$sub=GET_sub("");

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Download","Sei gegrüsst Suchender ",$menu_item);


$TABLE = "download";

switch ($md):
default:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "1","caption" => "DOWNLOAD","link" => ""),
			8=>array("icon" => "_stop","caption" => "Zurück","link" => "main.php?md=0")
	);
	print_menu_status($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>