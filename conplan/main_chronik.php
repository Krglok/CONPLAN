<?php
/*
 Projekt :  MAIN

Datei   :  main_chronik

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es werden Datenbanklisten für die Bibliothek angezeigt
im oeffentlichen Bereich
- zeigt eine Liste der Datensätze
- zeigt einen einzelnen Datensatz
- THEMA = HISTORIE   item = CHRONIK

Es wird kein Standardlayout verwendet.
- Hintergrund geaendert
- Hintergrund der Detailansicht geaendert

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
 
*/

include "_config.inc";
include "_lib.inc";
include "_head.inc";


//-----------------------------------------------------------------------------
function print_liste()
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_info>
//
// Argumente    :
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	//  $where = "where bereich = \"GDW\" AND zugriff=\"public\" ";
	$where = "where bereich = \"GDW\" AND zugriff = \"public\" AND thema = \"HISTORIE\" AND item = \"CHRONIK\" ";
	$order = " order by jahr DESC,sort DESC,titel";
	$q = "select ID,jahr,titel,kurz from $TABLE $where $order ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<FONT COLOR=\"#000000\" SIZE=3 FACE=\"Comic Sans MS\">";
	//  BACKGROUND=\"images/paper.jpg\"
	echo "<table border=1 BGCOLOR=\"\" BACKGROUND=\"images/paper.jpg\" >\n";

	//Kopfzeile
	echo "<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td  colspan=2><FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\" ><b>Auflistung der Titel</b></td>\n";
	echo "</tr>\n";
	//Liste der Datensätze
	$field_num = mysql_num_fields($result);
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=2&id=$row[$i]\">\n";
				print_menu_icon ("_page","Chronik lesen");
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td><FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_thema($ID)
//==========================================================================
// Function     : print_thema
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_items>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $THEMA;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE ";
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
				echo "\t<td><a href=\"$PHP_SELF?md=1&ID=$ID&id=$row[0]&THEMA=$row[1]\">\n";
				echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Kapitel Liste\" HSPACE=\"0\" VSPACE=\"0\">\n";
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

function print_items($ID)
//==========================================================================
// Function     : print_thema
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_titel>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE1;
	global $THEMA;
	global $ITEM;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 ";
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
				echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&THEMA=$THEMA&ITEM=$row(1)\">\n";
				echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Titel Liste\" HSPACE=\"0\" VSPACE=\"0\">\n";
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


function print_info($id)
//==========================================================================
// Function     : print_info
//--------------------------------------------------------------------------
// Beschreibun  : Anzeige eines Titels der Bibliothek
//                Keine Bearbeitung moeglich
//                -
//                -
//                -
//                -
//                -
//
// Argumente    : $id = recordnummer des Titels
//
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;
	$PHP_SELF = $_SERVER['PHP_SELF'];
	

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
//	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";

	echo "</tr>";
	echo "</table>";

	echo "<TABLE WIDTH=950 BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\" BACKGROUND=\" layout/back/paper.jpg\">\n";
	echo "<tr>";
	echo "\t<td width=40 > \n";
	echo "\t&nbsp;</td>\n";
	echo "\t<td width=700 > \n";
	echo "\t<DIV ALIGN=\"RIGHT\">\n";
	echo "\t<FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;Thema : \n";
	echo "\t<FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">";
	echo "\t $row[3]\n";
	echo "</DIV>";
	echo "\t<FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;Titel : \n";
	echo "\t<FONT  COLOR=#000000 SIZE=4 FACE=\"Comic Sans MS\">";
	echo "\t$row[4] \n";
	echo "\t</td>\n";
	echo "\t<td > \n";
	echo "\t<a href=\"$PHP_SELF?md=0\"> \n";
	//echo "\t<IMG SRC=\"../bib_logo/G.gif\" BORDER=\"0\" HEIGHT=\"50\" WIDTH=\"50\" ALT=\"Zurück\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	print_menu_icon ("_stop");
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td  ><FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td  ><FONT  COLOR=#000000 SIZE=2> Kurz <FONT  COLOR=#000000 SIZE=3> $row[5] </td>\n";
	echo "\t<td ><br>&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td ><FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td  >\n";
	echo "\t<FONT  COLOR=#000000 SIZE=2> Author : <FONT  COLOR=#000000 SIZE=3> $row[7] \n";
	echo "\t<b> &nbsp; &nbsp;&nbsp;&nbsp;</b>\n";
	echo "\t<FONT  COLOR=#000000 SIZE=2> Jahr :  <FONT  COLOR=#000000 SIZE=3> $row[9] \n";
	echo "\t <FONT  COLOR=#000000 SIZE=3>  $row[8]\n";
	echo "\t</td>\n";
	echo "</tr>";
	//  echo "<tr>";
	//    echo "\t<td><FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	//    echo "\t<td><TEXTAREA NAME=\"text\" COLS=70 ROWS=16 readonly>$row[6]</TEXTAREA>&nbsp;</td>\n";
	//  echo "</tr>";
	//  echo "<tr>";
	echo "<tr>";
	echo "\t<td><FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td >\n";
	$zeile=explode("\n",$row[6]);
	$anz  = count($zeile);
	for ($ii=0; $ii<$anz; $ii++)
	{
		$zeile[$ii] = rtrim($zeile[$ii]);
		$zeile[$ii] = str_replace("  ", "&nbsp;&nbsp;", $zeile[$ii]);
		echo "\t<FONT  COLOR=#000000  SIZE=3 FACE=\"Comic Sans MS\">$zeile[$ii]<BR>\n";
	}
	echo "\t</td>\n";
	echo "\t<td ><br>&nbsp;</td>\n";
	echo "</tr>";
	echo "</table>";
	//  echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};





// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

$BEREICH = 'PUBLIC';
print_header("Chronik");
print_body(1);

$PHP_SELF = $_SERVER['PHP_SELF'];
// Steuerparameter und steuerdaten
$md=GET_md(0);
$daten=GET_daten("");
$item=GET_item("main");
$sub=GET_sub("");
$id=GET_id(0);

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Öffentlich","Sei gegrüsst Freund ",$menu_item);

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";


$TABLE = "bib_titel";
$TABLE1 = "bib_item";


print_md();

switch ($md):
case 0:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "Neue Chronik","link" => ""),
			9=>array("icon" => "_stop","caption" => "Zurück","link" => "main.php?md=0")
	);
	print_menu($menu);
	print_liste();
	break;
case 2: // ANSEHEN Form
  $THEMA="GDW";
  $ITEM="CHRONIK";
  $menu = array (0=>array("icon" => "99","caption" => "Neue Chronik","link" => ""),
	1=>array("icon" => "1","caption" => "$THEMA","link" => "$PHP_SELF?md=0"),
	2=>array("icon" => "7","caption" => "$ITEM","link" => "$PHP_SELF?md=0"),
	3=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0")
	);
	//      print_menu($menu);
	print_info($id);
	break;
default:  // die einzelnen Bildseiten 11-xx
	//      $menu = make_bild_menu();
	$menu = array (0=>array("icon" => "99","caption" => "Neue Chronik","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
	);
	print_menu($menu);
	print_liste();
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>