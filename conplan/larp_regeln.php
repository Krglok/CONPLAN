<?php

/*
 Projekt :  CONPLAN

Datei   :  larp_regeln_liste.php

Datum   :  2002/06/01

Rev.    :   3.0

Author  :  Olaf Duda

beschreibung : realisiert die Anzeigeunktionen für die Regelliste
- Liste der Kapitel als dynamisches Menu
- Anzeige der Details ohne Bearbeitung
 

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


#1   20.11.2007		Länge des Kalenders geändert, "AND  < kw2 "  entfernt, damit alle
folgenden Wochen angezeigt werden.
Folgejahr mit abgefragt durch "OR jahr =$j1
Order Klausel geaendert auf "jahr,kw"

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

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";



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
	global $KAP;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE  where  kapitel=\"$KAP\" order by kapitel,absatz,item";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if (($i!=0) AND ($i!=6) AND ($i!=8))
		{
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
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
				//        echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&KAP=$KAP\">\n";
				//        echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				//        echo "\t</a></td>\n";
			} else
			{
				if (($i!=6) AND ($i!=8))
				{
					echo "\t<td>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&KAP=$KAP\">\n";
		//echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon ("_text");
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
};


function print_info($id,$ID)
//==========================================================================
// Function     : print_info
//--------------------------------------------------------------------------
// Beschreibun  : Anzeige der Detail der Bildergalerie  mit
//                - KAP = Topid_id
//                - Sortiernummer
//                - Lfdnummer des Bildes
//                - Name des Bildes
//                - Image des Bildes
//                - Beschreibung als Langtext
//                Anzeige als Tabelle
//
// Argumente    : $id = recordnummer des Bildes
//                $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $KAP;
    global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	//  $q = "select * from $TABLE where id=$id";
	$q = "select regelwerk.ID,kapitel,absatz,item,typ,kurz,COALESCE(concat(regelwerk.text,mag_list.wirkung),regelwerk.text) as text,index_1,index_2,regelwerk.stufe,regelwerk.muk,regelwerk.mk from regelwerk left outer join mag_list on mag_list.name = regelwerk.kurz where  regelwerk.ID=$id order by kapitel,absatz,item;";
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
	echo "<INPUT TYPE=\"hidden\" NAME=\"KAP\"  VALUE=\"$KAP\">\n";
	echo "<TABLE WIDTH=\"950\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name($result,$i);
		$type[$i]       =  mysql_field_type ($result, $i);
	}
	for ($i=1; $i<$field_num; $i++)
	{
		if ($i == 1)
		{
			echo "<tr>";
			echo "\t<td width=60>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td width=40>$row[$i]</td>\n";
			echo "\t<td ></td>\n";
		};
		if ($i == 2)
		{
			echo "\t<td width=60>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td width=40>$row[$i]</td>\n";
			echo "\t<td ></td>\n";
		};
		if ($i == 3)
		{
			echo "\t<td width=60>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td width=40>$row[$i]</td>\n";
			echo "\t<td></td>\n";
			echo "\t<td ></td>\n";
			echo "\t<td ></td>\n";
			echo "\t<td ></td>\n";
			echo "\t<td ></td>\n";
			echo "\t<td ></td>\n";
			echo "\t<td width=40><a href=\"$PHP_SELF?md=0&ID=$ID&KAP=$KAP\">\n";
			print_menu_icon ("_stop");
			echo "</td>\n";
			echo "\t<td ></td>\n";
		};
		if ($i == 5)
		{
			echo "<tr>";
			echo "\t<td width=60>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td colspan=7 ><b>$row[$i]</b></td>\n";
			echo "\t<td width=50>$field_name[9]</td>\n";
			echo "\t<td width=40 >$row[9]</td>\n";
			echo "\t<td width=50>$field_name[10]</td>\n";
			echo "\t<td width=40 >$row[10]</td>\n";
			echo "\t<td width=50>$field_name[11]</td>\n";
			echo "\t<td width=40 >$row[11]</td>\n";
			echo "\t<td ></td>\n";
			echo "</tr>";
		};
		if ($i == 6)
		{
			echo "</table>";
			echo "<TABLE WIDTH=\"950\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
					BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
			echo "<tr>";
			echo "\t<td width=60><b></b></td>\n";
			echo "\t<td width=800> \n";
			$zeile=explode("\n",$row[6]);
			$anz  = count($zeile);
			for ($ii=0; $ii<$anz; $ii++)
			{
				$zeile[$ii] = rtrim($zeile[$ii]);
				$zeile[$ii] = str_replace("  ", "&nbsp;&nbsp;", $zeile[$ii]);
				echo "\t<FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">$zeile[$ii]<BR>\n";
			}
			echo "BLOB";
			echo "\t</td> \n";
			echo "<tr>";
			echo "</table>";
		}
	}
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};




function make_kap_menu($ID)
//==========================================================================
// Function     :  regel_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Menü aus der Tabelle <bilder_topic>
//                Der erste Eintrag wird ignoriert
//
// Argumente    :
//
// Returns      : $menu = array
//
//==========================================================================
//  2=>array("icon" => "1","caption" => "KAP 1","link" => "$PHP_SELF?md=11&ID=$ID"),
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,kapitel,kurz from $TABLE where absatz=\"0\" AND item=\"0\" order by kapitel";
	$result = mysql_query($q)  or die("Query Menu...");
	$anz = mysql_num_rows($result);
	mysql_close($db);

	//  $row = mysql_fetch_row($result);

	$menu = array (0=>array("icon" => "99","caption" => "REGELWERK","link" => ""));
	for ($i=1; $i<$anz; $i++)
	{
		$row = mysql_fetch_row($result);
		$menu[$i] = array("icon" => "_list","caption" => "$row[2]","link" => "$PHP_SELF?md=11&ID=$ID&KAP=$row[1]&LISTE=$row[1]");
	}
	$menu[50] = array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID");

	return  $menu;

};

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------

// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------

$BEREICH = 'INTERN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
$ID     = GET_SESSIONID("");
$id   = GET_id("0");

$p_md   = POST_md("md");
$p_row  = POST_row("0");
$LISTE  = GET_LISTE("");
$KAP    = GET_KAP("");

session_id ($ID);
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
// ---------------------------------------------------------------
// ---------    GLOBALE DATEN initialisieren   -------------------
//$KAP   = 0;
$TABLE  = "regelwerk";    // Haupttabelle für das Modul
$TABLE1 = "";           // Nebemtabelle für das Modul

// ---------------------------------------------------------------

print_header("Regelwerk");

print_body(2);


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
print_kopf($logo_typ,$header_typ,"Regelwerk",$anrede,$menu_item);


//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

// ---------------------------------------------------------------
// --------  MENÜ DATEN            -------------------------------

switch ($md):
case 1: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
			2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	break;

default:  // MAIN-Menu
	$menu = make_kap_menu($ID);
	endswitch;


	// ---------------------------------------------------------------
	// ------ FUNKTION AUFRUFE  DER MENÜPUNKTE  ----------------------

	switch ($md):
case 2:
		Print_info($id, $ID);
	break;
default:
	print_menu($menu);
	print_liste($ID);
	break;
endswitch;

	print_md_ende();

	print_body_ende();

	?>