<?php
/*
 Projekt :  MAIN

Datei   :  main.php

Datum   :  2002/06/12

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird der Oeffentliche Teil der HP abgewickelt.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es werden Datenbanklisten generiert.
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

1.1  2004/01/27   Länge des Kalenders geaendert, kw1, kw2 nicht LIMIT des SELECT
#1   20.11.2007		Länge des Kalenders geändert, "AND  < kw2 "  entfernt, damit alle
folgenden Wochen angezeigt werden.
Folgejahr mit abgefragt durch "OR jahr =$j1
Order Klausel geaendert auf "jahr,kw"

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


function print_news()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"500\"  BORDER=\"0\" BGCOLOR=\"\" >";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news order by id DESC LIMIT 10")
	or die("Query Fehler...");

	while ($row = mysql_fetch_row($result))
	{
		echo "        <TR>";
		echo "        <FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
		echo "\t<td width=\"95\">".$row[0]."&nbsp;<BR>";
		echo "</td>\n";
		echo "\t<td>$row[1]<BR>$row[2]<BR>$row[3]<BR>";
		//      echo "<HR>";
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



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

print_header("Hauptseite");

print_body(2);

print_kopf(1,2,"Öffentlich","Sei gegrüsst Freund ");
//    echo "<CENTER><B> Sei gegrsst Auserwï¿½lter </B></CENTER> \n";


$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$daten = $_GET['daten'];

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";

$menu = array (0=>array("icon" => "99","caption" => "<B>Hauptseite</B>","link" => ""),
		1=>array ("icon" => "7","caption" => "Übersicht","link" => "$PHP_SELF?md=0&daten=main.html"),
		2=>array ("icon" => "5","caption" => "News","link" => "$PHP_SELF?md=1&daten=news.php"),
		3=>array ("icon" => "5","caption" => "Termine","link" => "$PHP_SELF?md=4"),
		4=>array ("icon" => "5","caption" => "Liberi Effera","link" => "http://www.liberi-effera.de/"),
		5=>array ("icon" => "13","caption" => "Innerer Zirkel","link" => "$PHP_SELF?md=2&daten=slogin.html"),
		6=>array ("icon" => "0","caption" => "",""),
		10=>array ("icon" => "7","caption" => "Kurzdarstellung","link" => "$PHP_SELF?md=6&daten=kurzdars.html"),
		11=>array ("icon" => "7","caption" => "LPD","link" => "$PHP_SELF?md=7&daten=lpd.html"),
		12=>array ("icon" => "1","caption" => "Unsere Regeln","link" => "main_regeln.php?md=0"),
		13=>array ("icon" => "7","caption" => "Unser Spielgebiet","link" => "$PHP_SELF?md=2&daten=weg_viet.html"),
		14=>array ("icon" => "1","caption" => "Unsere Spieler","link" => "main_spieler.php?md=0"),
		20=>array ("icon" => "0","caption" => "",""),
		21=>array ("icon" => "1","caption" => "Das Land","link" => "main_land.php?md=0&daten=land/land.html"),
		22=>array ("icon" => "1","caption" => "Neue Chronik","link" => "main_chronik.php"),
		23=>array ("icon" => "1","caption" => "Ausrüstung","link" => "main_ausruestung.php"),
		24=>array ("icon" => "1","caption" => "Bilder","link" => "main_bilder.php?md=0"),
		30=>array ("icon" => "0","caption" => "",""),
		31=>array ("icon" => "1","caption" => "Draskoria","link" => "http://draskoria.game-host.org:8090/\"target=_blank\""),
		32=>array ("icon" => "1","caption" => "Download","link" => "main_download.php","daten"=>""),
		33=>array ("icon" => "5","caption" => "Links","link" => "$PHP_SELF?md=2&daten=links.html"),
		34=>array ("icon" => "7","caption" => "Ich","link" => "$PHP_SELF?md=2&daten=spieler/olaf.html"),
		35=>array ("icon" => "10","caption" => "Impressum","link" => "$PHP_SELF?md=7&daten=Impressum.html")
);

// Erstellt den Tabellenkopf fuer den Bereich Menue / Daten
print_md();
// Erstellt aus linke Mnue
print_menu($menu);
// Auuwahlder Aktion durch md
// und erstellen das Datenbereiches
switch ($md):
case 0: // MAIN MEN?
	$daten='main.html';
print_data($daten);
break;
case 1:
	print_news();
	break;
case 2: // MAIN MEN?
	print_data($daten);
	break;
case 3: // MAIN MEN?
	print_sc_liste();
	break;
case 4: // MAIN MEN?
	print_kalender();
	break;
case 6: // MAIN MEN?
	print_data($daten);
	break;
case 7:
	print_data($daten);
	break;
default: // MAIN MEN?    print_data($daten);
	print_news();
	break;
	endswitch;

	// Abschluss der Tabelle fuer Bereich Menue / Daten
	print_md_ende();
	// Erstellt Body Ende
	print_body_ende();



	?>