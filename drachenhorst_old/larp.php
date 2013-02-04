<?php
/*
 Projekt :  LARP

Datei   :  larp.php

Datum   :  2002/06/12 17:39:02

Rev.    :  2.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Interne Teil der HP abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
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

function print_main_data()
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"500\"  BORDER=\"0\" BGCOLOR=\"\" >";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news order by id DESC limit 10")
	or die("Query Fehler.news..");

	while ($row = mysql_fetch_row($result))
	{
		echo "        <TR>";
		echo "        <FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
		echo "\t<td width=\"85\">".$row[0]."&nbsp;</td>\n";
		echo "\t<td>".$row[1]."<BR>".$row[2]."<BR>".$row[3];
		echo "<HR>";
		echo "</td>\n";
		echo '        </TR>';
	}

	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n";
	//  echo "    <TD>\n";
	//  echo "    .\n";
	//  echo "    </TD>\n";
};




// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$ID = $_GET['ID'];


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

if (getuser($user,$pw) != "TRUE")
{
	header ("Location: main.php");  // Umleitung des Browsers
	//       zur PHP-Web-Seite.
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

if ($md == 99)
{
	session_destroy();
	header ("Location: main.php");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

print_header("Interner Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Interner Bereich","Sei gegrüsst $spieler_name ");

//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();


switch ($md):
case 1: //  SPIELERLISTE
	$menu = array (0=>array("icon" => "99","caption" => "Termine","link" => ""),
			1=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
case 2:
	break;
default: // MAIN MENÜ
	$menu = array (0=>array("icon" => "99","caption" => "INTERN","link" => "$PHP_SELF?md=0&ID=$ID"),
	1=>array ("icon" => "1","caption" => "Spieler","link" => "larp_sc_liste.php?md=1&ID=$ID"),
	2=>array ("icon" => "1","caption" => "Forum Intern","link" => "larp_forum_1.php?md=1&ID=$ID"),
	3=>array ("icon" => "1","caption" => "Forum MC","link" => "larp_forum_2.php?md=1&ID=$ID"),
	4=>array ("icon" => "5","caption" => "Anmeldung","link" => "larp_anmelde_liste.php?md=0&ID=$ID"),
	5=>array ("icon" => "5","caption" => "Bilder","link" => "larp_bild_liste.php?md=0&ID=$ID"),
	6=>array ("icon" => "5","caption" => "Neue Bilder","link" => "larp_bild_liste1.php?md=0&ID=$ID"),
	7=>array ("icon" => "5","caption" => "Termine","link" => "$PHP_SELF?md=1&ID=$ID"),
	8=>array ("icon" => "5","caption" => "Download","link" => "larp_download.php?md=0&ID=$ID"),
	9=>array ("icon" => "1","caption" => "Regelwerk","link" => "larp_regeln_liste.php?md=0&ID=$ID"),
	10=>array ("icon" => "1","caption" => "GdW","link" => "/gdw_bib/  \"target=_blank\""),
	11=>array ("icon" => "5","caption" => "Liberi Effera","link" => "http://www.liberi-effera.de/ \"target=_blank\""),
	20=>array ("icon" => "0","caption" => "","link" => ""),
	21=>array ("icon" => "1","caption" => "Charakter","link" => "char_liste.php?md=0&ID=$ID"),
	23=>array ("icon" => "5","caption" => "Legenden","link" => "larp_leg_liste.php?md=0&ID=$ID"),
	24=>array ("icon" => "5","caption" => "Sprueche","link" => "larp_mag_liste.php?md=0&ID=$ID"),
	25=>array ("icon" => "5","caption" => "Traenke","link" => "larp_trank_liste.php?md=0&ID=$ID"),
	26=>array ("icon" => "1","caption" => "Bibliothek","link" => "larp_gdw_liste.php?md=0&ID=$ID"),
	27=>array ("icon" => "1","caption" => "Bibliothekar","link" => "larp_gdw.php?md=0&ID=$ID"),
	29=>array ("icon" => "6","caption" => "ENDE","link" => "larp.php?md=99&ID=$ID"),
	30=>array ("icon" => "1","caption" => "Draskoria","link" => "http://draskoria.game-host.org:8090/ \"target=_blank\""),
	98=>array ("icon" => "1","caption" => "SL ","link" => "conmain.php?md=0&ID=$ID"),
	99=>array ("icon" => "1","caption" => "Admin","link" => "admin_con.php?md=0&ID=$ID")
	);
	endswitch;

	//    7=>array ("icon" => "4","caption" => "Map","link" => "larp_map.php?md=0&ID=$ID"),

	print_menu($menu);

	switch ($md):
case 1:
		print_kalender();
	break;
case 2:
	break;
case 4:
	break;
case 5:
	break;
default:
	print_main_data();
	break;
	endswitch;

	print_md_ende();

	?>