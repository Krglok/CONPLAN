<?php

/*
 Projekt : ADMIN

Datei   :  admin_con.php,v $

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  Olaf Duda

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

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite


$Log: conadmin.php,v $
Revision 1.4  2002/06/01 10:40:00  windu
Erweiterung um bilder_admin

Revision 1.3  2002/05/30 07:22:21  windu
ADmin-Funktion für
Einbringen des Aktuellen Con-Tages
mit neuer Tabelle con_konst

Revision 1.2  2002/05/24 13:11:52  windu
neue icons im menü

Revision 1.1  2002/05/03 20:23:41  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.4  2002/03/09 18:28:52  windu
Korrekturen und Aufteilung in LIB.INC

Revision 1.3  2002/02/26 18:42:40  windu
keyword aktiviert

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


function print_main_data()
{
	global $DB_HOST, $DB_USER, $DB_PASS;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"100%\"  BORDER=\"1\" BGCOLOR=\"\" >";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news")
	or die("Query Fehler...");

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
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
};



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
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
else
{
	$l1 = (int) $user_lvl;
	$l2 = (int) $lvl_admin[14];
	if ($l1 >= $l2)
	{
		header ("Location: main.php?md=0");  /* Umleitung des Browsers
		zur HTML-StartSeite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(8,2,"Admin Bereich","Sei gegrüsst Meister ");


echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();

switch ($md):
case 1:
	$menu = array (0=>array("icon" => "7","caption" => "ADMIN","link" => ""),
			1=>array ("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
case 2:
	break;
default:
	$menu = array (0=>array("icon" => "7","caption" => "ADMIN","link" => ""),
	1=>array ("icon" => "1","caption" => "Spieler","link" => "admin_sc.php?md=0&ID=$ID"),
	2=>array ("icon" => "1","caption" => "News","link" => "admin_news.php?md=1&ID=$ID"),
	3=>array ("icon" => "1","caption" => "Anmeldung","link" => "admin_anmelde.php?md=0&ID=$ID"),
	4=>array ("icon" => "1","caption" => "Hilfe","link" => "admin_hilfe.php?md=0&ID=$ID"),
	5=>array ("icon" => "5","caption" => "CON-SL","link" => "admin_sl.php?md=0&ID=$ID"),
	6=>array ("icon" => "5","caption" => "Bilder","link" => "admin_bilder.php?md=0&ID=$ID"),
	8=>array ("icon" => "1","caption" => "Charakter","link" => "admin_char.php?md=0&ID=$ID"),
	9=>array ("icon" => "5","caption" => "Download","link" => "admin_down.php?md=0&ID=$ID"),
	10=>array ("icon" => "1","caption" => "Kalender","link" => "admin_kal.php?md=0&ID=$ID"),
	11=>array ("icon" => "1","caption" => "Bibliothek","link" => "admin_bib.php?md=0&ID=$ID"),
	12=>array ("icon" => "1","caption" => "Bib-Zugriff","link" => "admin_bib_zugriff.php?md=0&ID=$ID"),
	13=>array ("icon" => "1","caption" => "Bib-Bereich","link" => "admin_bib_bereich.php?md=0&ID=$ID"),
	14=>array ("icon" => "1","caption" => "Bib-Thema","link" => "admin_bib_thema.php?md=0&ID=$ID"),
	15=>array ("icon" => "1","caption" => "Bib-Item","link" => "admin_bib_item.php?md=0&ID=$ID"),
	20=>array ("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")

	);

	endswitch;

	print_menu($menu);

	switch ($md):
case 1:
		print_data("main.html");
	break;
default:
	print_data("admin_logo.html");
	break;
	endswitch;

	print_md_ende();
	print_body_ende();

	?>