<?php

/*
 Projekt :  ADMIN

Datei   :  admin_news.php

Datum   :  2002/02/26

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


#3  10.07.2008    LIMIT 10 fuer adtenliste

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite


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


function print_news_liste($ID,$limit)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"500\"  BORDER=\"0\" BGCOLOR=\"\" >";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT id,datum,text_1,text_2,Text_3 from news order by id DESC LIMIT $limit")
	or die("Query Fehler...");

	while ($row = mysql_fetch_row($result))
	{
		echo "\t<TR>";
		echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]\">\n";
		print_menu_icon ("_db");
		echo "\t</a></td>\n";
		echo "\t<td width=\"85\">".$row[1]."&nbsp;<br><br><br><br></td>\n";
		echo "\t<td>".$row[2]."<BR>".$row[3]."<BR>".$row[4];
		echo "<HR>";
		echo "</td>\n";
		echo '        </TR>';
	}

	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
};


function print_sp_erf($id,$next,$erf,$ID)
//
//  $id   beinhaltet den zu bearbeitenden Datensatz
//  $next beinhaltet die nächste zu rufende Funktion
//  $erf  steurt die Variablen initialisierung
//
// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
//
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	//  Daten
	//
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	if ($erf==1)
	{
		$d = getdate();
		$row[0] = 0;
		$row[1] = $d[year]."-".$d[mon]."-".$d[mday];
		$row[2] = "";
		$row[3] = "";
		$row[4] = "";

	} else
	{
		$q = "select id,datum,text_1,text_2,text_3 from news where id=\"$id\" ";
		$result = mysql_query($q) or die("select Fehler....$q");
		$row = mysql_fetch_row($result);

	};


	mysql_close($db);



	echo "<TD>\n";  /// Spalte für Datenbereich

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$row[0]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"   VALUE=\"$ID\">\n";

	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>\n";

	echo "\t<td WIDTH=\"75\"><b>ID</b></td>\n";
	echo "<td>\"$row[0]\"&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Datum</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[1]\" SIZE=12 MAXLENGTH=12 VALUE=\"$row[1]\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Zeile 1</b></td>\n";

	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[2]\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Zeile 2</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[3]\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Zeile 3</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[4]\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[4]\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td></td>\n";
	echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</FORM>\n";

	echo "</TD>\n"; //  ENDE Spalte Datenbereich
};

function insert($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};

	$q ="insert into news (datum,text_1,text_2,text_3) VALUES (\"$row[1]\",\"$row[2]\",\"$row[3]\",\"$row[4]\")";
	$result = mysql_query($q) or die("insert Fehler....$q.");

	mysql_close($db);

}

function update($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};

	$q ="update news set datum=\"$row[1]\",text_1=\"$row[2]\", text_2=\"$row[3]\", text_3=\"$row[4]\"  where id=\"$row[0]\"";
	$result = mysql_query($q) or die("Fehler....$q.");

	mysql_close($db);

}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
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




switch($p_md):
case 5: // Insert -> Erfassen
	insert($p_row);
$md = 0;
break;
case 6: // Insert -> Erfassen
	update($p_row);
	$md = 0;
	break;
	endswitch;



	switch ($md):
case 2: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => "$PHP_SELF?md=1&ID=$ID"),
				1=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 4:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 10: // main
	$menu = array (0=>array("icon" => "7","caption" => "NEWS","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
	2=>array ("icon" => "_list","caption" => "Letzten 10 News","link" => "$PHP_SELF?md=1&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "NEWS","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
	2=>array ("icon" => "_list","caption" => "Alle News","link" => "$PHP_SELF?md=10&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu($menu);

	switch ($md):
case 2:
		print_sp_erf($id,5,1,$ID);
	break;
case 4:
	print_sp_erf($id,6,0,$ID);
	break;
case 10:
	print_news_liste($ID,1000);
	break;
default:
	print_news_liste($ID,10);
	break;
	endswitch;

	print_md_ende();


	?>