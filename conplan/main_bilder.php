<?php
/*
 Projekt :  MAIN

Datei   :  main_bilder.php

Datum   :  2002/06/08

Rev.    :  2.1

Author  :  OlafDuda

beschreibung :
Dies ist eine Bildergalerie fuer den oeffentlichen Bereich
Die Bilder sind in Kapitel oder Topics gegliedert.
Die Verwaltung der Topics geschieht in einem separaten Modul.

Realisiert die Bearbeitungsfunktionen für die Datei <bilder>
- Übersicht als HTML
- Liste der Datensätze mit Bilder
- Anzeige der Details ohne Bearbeitung

Die Bilder werden in einen Standardpfad gespeichert.

/BILDER/           > für die aufgeladene Bilder
/BILDER/BASE/      > für spezielle Gruppenbilder
/BILDER/thumb/     > für thumbnails der Bilder

Es werden HTML Seiten angezeigt,
die folgenden Subdir  werden werden relativ benutzt

./BILDER  2)

Die images kommen ebenfalls aus dem Verzeichnis

./BILDER

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

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

#3  08.07.2008  Bilder Pfad absolute setzen auf /BILDER/


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





function print_liste($ID,$TAG,$LISTE)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Bilder liste  mit
//                - Name des Bildes
//                - Bild_image
//                - Ref-Symbol mit LINK auf Detailansicht
//
// Argumente    : $ID = Session_ID
//                $TAG = Refnummer des Topic
//                $LISTE = NAME des Tages
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where tag=\"$TAG\" order by tag,sort,lfd";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	//  echo "<table border=0 BGCOLOR=\"\">\n";
	echo "\t <TABLE  BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"1\" >\n";

	// Kopfzeile
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		$row1 = mysql_fetch_row($result);
		$row2 = mysql_fetch_row($result);
		echo "<tr>\n";
		// Spalet 1
		if ($row[0]!="")
		{
			echo "\t<td>$row[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t</a></td>\n";
		}
		// Spalet 2
		echo "\t<td>&nbsp;</td>\n";
		if ($row1[0]!="")
		{
			echo "\t<td>$row1[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t</a></td>\n";
		}
		// Spalet 3
		echo "<tr>";
		// Spalet 1
		echo "\t<td> \n";
		if ($row[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t<IMG SRC=\"BILDER/thumb/$row[0]$row[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			$zeile=explode("\n",$row[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
			  if (isset($zeile[$ii]))
			  {
				echo "\t$zeile[$ii]&nbsp;<br>\n";
			  }
			}
			echo "\t</td>\n";
		}
		// Spalet 2
		echo "\t<td>&nbsp;</td>\n";
		echo "\t<td> \n";
		if ($row1[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t<IMG SRC=\"BILDER/thumb/$row1[0]$row1[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			//        echo "\t<td>$row1[5]&nbsp;</td>\n";
			$zeile=explode("\n",$row1[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
			  if (isset($zeile[$ii]))
			  {
			    echo "\t$zeile[$ii]&nbsp;<br>\n";
			  }
			}
			echo "\t</td>\n";
		}
		// Spalet 3
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_info($id,$ID,$TAG,$LISTE)
//==========================================================================
// Function     : print_info
//--------------------------------------------------------------------------
// Beschreibun  : Anzeige der Detail der Bildergalerie  mit
//                - Tag = Topid_id
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
	global $PHP_SELF;
	

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
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"  VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"  VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\" VALUE=\"$TAG\">\n";

	echo "<TABLE WIDTH=\"\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=30>$row[1]</td>\n";
	echo "\t<td width=30>$row[2]</td>\n";
	echo "\t<td width=30>$row[3]</td>\n";
	echo "\t<td>$row[4]</td>\n";
	echo "\t<td>\n";
	echo "\t<a href=\"$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE\"> \n";
	print_menu_icon ("_stop");
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "<TABLE WIDTH=\"\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td>\n";
	echo "\t<IMG SRC=\"BILDER/$row[0]$row[6]\" BORDER=\"0\"  TITLE=\"$row[4]\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	$zeile=explode("\n",$row[5]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};



function print_maske($id,$ID,$next,$erf,$TAG)
{
	//==========================================================================
	// Function     :  print_maske
	//--------------------------------------------------------------------------
	// Beschreibung : Bearbeiten der Felder der Tabelle <bilder>
	//                Die Abfrage MUSS alle Felder beinhalten
	//                linke Spalte = Feldnamem
	//                rechte Spalte = Feld
	//
	//                Button = SUBMIT und CANCEL
	//                Durch Switch auf die Feldnummer wird die Maske
	//                individuell gestaltet.
	//
	//                durch $next kann die Maske sowohl für Erfassen als auch
	//                Bearbeiten benutzt werden.
	//
	// Argumente    : $ID = Session_ID
	//                $id   beinhaltet den zu bearbeitenden Datensatz
	//                $next beinhaltet die nächste zu rufende Funktion
	//                $erf  steurt die Variablen initialisierung
	//                      0 = Bearbeiten der Daten
	//                      1 = Erfassen neuer Daten
	//                $TAG  referenziert die Kategorie
	//
	// Returns      : --
	//
	//==========================================================================
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;

	if ($erf == 0 )
	{    // BEARBEITEN-Modus  selectierten Datensatz lesen
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		//  Felder = ID,tag,sort,lfd,name,beschreibung,link

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);

	} else
	{     // ERFASSEN MODUS - Referenz auf Bildergruppe (Bilder_Topic)
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select id,name,tag,sort from $TABLE1 where tag=\"$TAG\" order by tag,sort";
		$result1 = mysql_query($q) or die("Query ERF TABLE 1");

		//  Felder = ID,tag,sort,lfd,name,beschreibung,link
		$q = "select * from $TABLE where id=0";
		$result = mysql_query($q) or die("Query ERF TABLE");

		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);
	}

	echo "  <TD>\n";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";

	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	if ($erf == 0 )
	{    // BEARBEITEN-Modus  selectierten Datensatz lesen
		echo "\t<td><center><b>BEARBEITEN BILDER</b></td>\n";
	}else
	{
		echo "\t<td><center><b>NEUE BILDER</b></td>\n";
	}
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);

	}

	//  Felder = ID,tag,sort,lfd,name,beschreibung,link
	for ($i=1; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}

		switch($i):
		case 1 :   // Feld ersetzen durch auswahltabelle
			echo "<tr>";
		if ($erf == 1)  // NUR beim erfassen aktivieren
		{
			$row1 = mysql_fetch_row($result1);
			echo "\t<td width=100>Tag&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$TAG\" READONLY> $row1[1]</td>\n";
			/*
			 echo "\t<td> \n";
			echo "\t<SELECT NAME=\"row[$i]\"><BR>\n";
			// Auswahltabelle kommt aus Tabelle  <bilder_topic>
			$row1 = mysql_fetch_row($result1);
			while ($row1 = mysql_fetch_row($result1))
			{
			echo "\t<OPTION VALUE=\"$row1[0]\">$row1[1]<BR> \n";
			}
			echo "\t</SELECT>\n";
			echo "\t</td \n";
			*/
		} else
		{
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
		}
		echo "</tr>\n";
		break;
		case 6 :
			if ($erf == 1)  // NUR beim erfassen aktivieren
			{
				echo "<tr>";
				echo "<td>\n";
				echo "</td>\n";
				echo "<td>\n";
				echo "\t<input type=file name=bild accept=image/*>\n";
				echo "</td>\n";
				echo "</tr>";
			} else
			{
				echo "<tr>";
				echo "<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i]  VALUE=\"$row[$i]\"></td>\n";
				echo "</tr>";
			}
			break;
		default:
			if ($type[$i]!="blob")
			{
				echo "<tr>";
				echo "<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
				echo "</tr>";
			} else
			{
				echo "<tr>";
				echo "<td><b></b></td>\n";
				echo "<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "</tr>";
			}
			break;
			endswitch;
	}

	echo "<tr>\n";
	echo "<td></td>\n";
	echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "</tr>\n";

	echo "</table>";
	echo "  </TD>\n"; //ENDE  Datenbereich der Gesamttabelle

};

function make_bild_menu()
//==========================================================================
// Function     :  make_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Menü aus der Tabelle <bilder_topic>
//                Der erste Eintrag wird ignoriert
//
// Argumente    :
//
// Returns      : $menu = array
//
//==========================================================================
//  2=>array("icon" => "1","caption" => "Tag 1","link" => "$PHP_SELF?md=11&ID=$ID"),
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE1;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 order by tag desc,sort ";
	$result = mysql_query($q)  or die("Query Menu...");
	$anz = mysql_num_rows($result);
	mysql_close($db);

	$row = mysql_fetch_row($result);

	$menu = array (0=>array("icon" => "99","caption" => "BILDER","link" => ""));
	$menu[1] = array("icon" => "_stop","caption" => "Zurück","link" => "main.php?md=0");
	for ($i=2; $i<$anz; $i++)
	{
		$row = mysql_fetch_row($result);
		//    $menu = array($i=>array("icon" => "1","caption" => "$row[1]","link" => "$PHP_SELF?md=11&TAG=$row[2]"));
		$menu[$i] = array("icon" => "_list","caption" => "$row[1]","link" => "$PHP_SELF?md=11&TAG=$row[2]&LISTE=$row[1]");
	}

	return  $menu;

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------




// print_header("Bilderliste");

// print_body(2);

// print_kopf(1,2,"Öffentlich","Sei gegrüsst Freund ");


// $c_md = $_COOKIE['md'];
// $p_md = $_POST['md'];
// $md = $_GET['md'];
// $id = $_GET['id'];
// $TAG = $_GET['TAG'];
// $LISTE = $_GET['LISTE'];

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";

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
$TAG = GET_TAG("1");
$LISTE = GET_LISTE("");

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Öffentlich",$anrede,$menu_item);

$TABLE = "bilder";
$TABLE1 = "bilder_topic";

//print_md();

switch ($md):
case 0:  // MAIN-Menu
	$menu = make_bild_menu();
    print_menu($menu);
    $daten='pages/main_bild_base.html';
    print_data($daten);
break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	Print_info($id, $ID,$TAG,$LISTE);
	break;
case 11:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "$LISTE","link" => ""),
	8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID,$TAG,$LISTE);
	break;
default:  // die einzelnen Bildseiten 11-xx
	$menu = make_bild_menu();
	print_menu($menu);
	print_main();
	break;
	endswitch;

	//print_md_ende();

	print_body_ende();

	?>