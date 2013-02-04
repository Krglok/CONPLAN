<?php
/*
 Projekt :  CONPLAN

Datei   :  con_regel_liste.php

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Kapitel als dynamisches Menu
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

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

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";



//-----------------------------------------------------------------------------
function print_liste($ID, $KAP)
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

	$q = "select * from $TABLE  where  kapitel=\"$KAP\" order by kapitel,absatz,item";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if (($i!=6)  AND ($i!=8))
		{
			if (($i!=0))
			{
				echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			} else
			{
				echo "\t<td><b> </b></td>\n";
			};
		};
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
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&KAP=$KAP\">\n";
				//        echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				print_menu_icon (9);
				echo "\t</a></td>\n";
			} else
			{
				if (($i!=6) AND ($i!=8))
				{
					echo "\t<td>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&KAP=$KAP\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID)
//==========================================================================
// Function     : print_loeschen
//--------------------------------------------------------------------------
// Beschreibun  : Darstellen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Loeschfunktion <loeschen>
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

	$q = "select * from $TABLE where S0=\"$KAP\"";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	//lfdnr,name,vorname,orga}
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
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&KAP=$KAP\">\n";
				echo "\t<IMG SRC=\"../larp/images/stop.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"20\" ALT=\"Datensatz Löschen\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&KAP=$KAP\">\n";
		echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Datensatz Ansehen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

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
			print_menu_icon (6);
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



function insert($row)
//==========================================================================
// Function     :  insert
//--------------------------------------------------------------------------
// Beschreibun  :  Fügt einen Datensatz in eine Tabelle ein
//                 Die Daten liegen als Array vor
//                 die Spalten sind identisch mit
//                 den Feldern der Tabelle.
//                 Ebenso die Reihemfolge der Felder !
//
// Argumente    :  $row = zu speichernde Daten
//
// Returns      :  --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="insert INTO  $TABLE  (";
	$q = $q."$field_name[1]";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]";
	};

	$q = $q.") VALUES (\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",\"$row[$i]\" ";
	};
	$q = $q.")";
	//  echo $q;

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	$result = mysql_query($q) or die("InsertFehler....$q.");

	mysql_close($db);

};


function update($row)
//==========================================================================
// Function     : update
//--------------------------------------------------------------------------
// Beschreibung : Update eines Datensatzes in einer Tabelle
//                 Die Daten liegen als Array vor
//                 die Spalten sind identisch mit
//                 den Feldern der Tabelle.
//                 Ebenso die Reihemfolge der Felder !
//                 Die Recordnummer liegt in $row[0]
//
// Argumente    : $row = die zu speichernde Daten
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="update $TABLE  SET ";
	$q = $q."$field_name[1]=\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]=\"$row[$i]\" ";
	};
	$q = $q."where id=\"$row[0]\" ";

	//  echo $q;
	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$result = mysql_query($q) or die("update Fehler....$q.");
	/**/
	mysql_close($db);

};


function loeschen($id)
//==========================================================================
// Function     :  loeschen
//--------------------------------------------------------------------------
// Beschreibun  :  Loescht einen Datensatz aus einer Tabelle
//
// Argumente    :  $id = Recordnummer (PRIMARY)
//                 $ID = Sessionmanagnet
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)     or die("Fehler beim verbinden!");

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$q = "delete from $TABLE where id=\"$id\" ";
	//  echo $q;
	$result = mysql_query($q) or die("Delete Fehler....$q.");
	/**/
	mysql_close($db);

};

function print_maske($id,$ID,$next,$erf, $KAP)
{
	//==========================================================================
	// Function     :  print_maske
	//--------------------------------------------------------------------------
	// Beschreibung : Bearbeiten der Felder der Tabelle
	//                Die Abfrage MUSS alle Felder beinhalten
	//                linke Spalte = Feldnamem
	//                rechte Spalte = Feld
	//
	//                Button = SUBMIT und CANCEL
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
	//
	// Returns      : --
	//
	//==========================================================================
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;

	if ($erf == 0 )
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
	} else
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");


		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);

	}
	if (count($row)==1)
	{
		for ($i=0; $i<$field_num; $i++)
		{
			$row[$i] = "";
		};
	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"KAP\"  VALUE=\"$KAP\">\n";
	echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td><b>$TABLE</b></td>\n";
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);

	}
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($i!=0)
		{
			if ($type[$i]!="blob")
			{
				switch ($i):
				case 4:
					echo "<tr>";
				echo "\t<td >$field_name[$i]&nbsp;</td>\n";

				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">";
				echo " TE= Auswertung nur Text / FE=Auswertung Text und EP-Werten ";
				echo "</td>\n";
				break;
				default :
					echo "<tr>";
					echo "\t<td >$field_name[$i]&nbsp;</td>\n";

					echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
					break;
					endswitch;

					echo "<tr>";
			} else
			{
				echo "<tr>";
				echo "\t<td><b></b></td>\n";
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=87 ROWS=40>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "<tr>";
			}
		} else
		{
			echo "<tr>";
			echo "\t<td >$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
			echo "<tr>";
		}
	}


	echo "\t<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "\t</tr>\n";

	echo "</table>";
	echo "  </TD\n>"; //ENDE  Datenbereich der Gesamttabelle

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

	$menu = array (0=>array("icon" => "99","caption" => "REGELWERK","link" => ""),
			1=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=1&THEMEN=$THEMEN&ID=$ID"),
			2=>array("icon" => "0","caption" => "KAPITEL","link" => "$PHP_SELF?md=0&THEMEN=%&ID=$ID"),
	);

	for ($i=1+3; $i<=$anz+3; $i++)
	{
		$row = mysql_fetch_row($result);
		$menu[$i] = array("icon" => "1","caption" => "$row[2]","link" => "$PHP_SELF?md=11&ID=$ID&KAP=$row[1]&LISTE=$row[1]");
	}
	$menu[50] = array("icon" => "6","caption" => "Zurück","link" => "conmain.php?md=0&ID=$ID");

	return  $menu;

};

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$ID = $_GET['ID'];
$id = $_GET['id'];
$LISTE = $_GET['LISTE'];
$KAP = $_GET['KAP'];


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

// Prüfung ob User  berechtigt ist--------------------------------
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
// ---------------------------------------------------------------
// ---------    GLOBALE DATEN initialisieren   -------------------
$TABLE  = "regelwerk";    // Haupttabelle für das Modul


// ---------------------------------------------------------------
// --- Datenbank -------------------------------------------------
switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row);
header ("Location: $PHP_SELF?md=0&ID=$ID&KAP=$KAP");  /* Umleitung des Browsers
zur PHP-Web-Seite. */
exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
Code ausgeführt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=0&ID=$ID&KAP=$KAP");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
case 7: // Delete eines bestehenden Datensatzes
	// SQL delete
	loeschen($id);
	header ("Location: $PHP_SELF?md=0&ID=$ID&KAP=$KAP");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	print_header("Regelwerk");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

	print_kopf(9,0,"Con Planung ","Sei gegrüsst Meister ");

	echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();

	// --------  MENÜ DATEN            -------------------------------
	// ------ FUNKTION AUFRUFE  DER MENÜPUNKTE  ----------------------

	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
		);
		print_menu($menu);
		print_maske($id,$ID,5,1);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	Print_info($id, $ID);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	print_menu($menu);
	print_loeschen($ID);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&KAP=$KAP")
	);
	print_menu($menu);
	print_maske($id,$ID,6,0, $KAP);
	break;

default:  // MAIN-Menu
	$menu = make_kap_menu($ID);
	print_menu($menu);
	print_liste($ID, $KAP);
	break;
	endswitch;

	// ---------------------------------------------------------------

	print_md_ende();

	print_body_ende();
