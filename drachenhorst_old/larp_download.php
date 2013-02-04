<?
/*
 Projekt : LARP

Datei   :   $RCSfile: larp_download.php,v $

Datum   :   2002/06/01

Rev.    :   2.0

Author  :  Olaf Duda

beschreibung :
realisiert die Download Liste
- Liste der Datensätze
-Keine Verwaltungsfunktionen !!
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es koennen normale HTML Seiten ausgegeben werden.
Subseiten werden mit eigenen PHP-scripten erzeugt.
Die zugehoerigen HTML Seiten koenen in einem Subdir sein
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


*/

include "config.inc";
include "login.inc";
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


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,groesse,kurz,path from $TABLE ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

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
			// aufruf der Deateildaten
			switch ($i):
			case 0:
				echo "\t<td><a href=\"download/$row[4]\">\n";
			//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Download\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			print_menu_icon(9);
			echo "\t</a></td>\n";
			break;
			case 1:
				echo "\t<td>$row[$i]&nbsp;</td>\n";
				break;
			case 2:
				echo "\t<td>$row[$i]&nbsp;kb</td>\n";
				break;
			case 3 :
				echo "<td  WIDTH=\"350\"  BGCOLOR=\"#E9E0DA\">\n";
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
$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$ID = $_GET['ID'];

$TABLE = "download";

session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];

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
	header ("Location: main.php");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
}
else
{
	// Prüfung des Zugriffsrecht über Lvl
	//
	if ($user_lvl <= $lvL_sl[14])
	{
		header ("Location: main.php");  /* Umleitung des Browsers
		zur PHP-Web-Seite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
	$session_id = '01';
	//  echo "ID:$session_id  Remote $REMOTE_ADDR";
};

print_header("Download");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Interner Bereich","Sei gegrüsst $spieler_name ");


echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();

switch ($g_md):
default:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "DOWNLOAD","link" => ""),
			8=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	print_menu($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>