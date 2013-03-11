<?php
/*
 Projekt : CONPLAN

Datei   :  conmain.php

Datum   :  2002/05/30

Rev.    :  2.0

Author  :  $Author: windu $  / duda

beschreibung :  ist das Main Menü für den SL-Bereich
bietet einige Info-Listen
- Magie
- Traenke
- Artefakte
- Conplanung
Von hier aus werden die Unterprogramme für die Con-Planung aufgerufen

Ueber das Script wird der SL/CONPLAN Teil der HP abgewickelt.
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

$Log: conmain.php,v $
Revision 1.3  2002/05/30 07:27:03  windu
Einbringen des Aktuellen Con-Tages
mit  SL Zugriffsbegrenzung

Revision 1.2  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

Revision 1.1  2002/05/03 20:26:51  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.8  2002/03/10 09:38:13  windu
korrektur der listen und rücksprungadressen

Revision 1.7  2002/03/09 18:27:02  windu
Korrekturen und neue Aufnahme

Revision 1.6  2002/03/08 21:20:43  windu
Ideenliste aus spieler bereich wird im
SLBereich als ToDo-List verwendet

Revision 1.5  2002/03/07 21:52:53  windu
korrekturen, Anpassung der Masken und Vorgaben

Revision 1.4  2002/03/03 21:02:26  windu
detaillierung erweitert bei ablauf
Referenz eingeführt bei conplan

Revision 1.3  2002/02/26 18:41:39  windu
keyword aktiviert


Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!--  DATEN Spalte   -->\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";

function print_main_data($ID)
{

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  
	echo "      <TABLE WIDTH=\"100%\" BORDER=\"1\" BGCOLOR=\"\" >\n";
	echo "        <TR>\n";
	echo "          <TD><!-- Row:1, Col:1 -->\n";
	echo "            <BR>\n";
	echo "            &nbsp; Dies ist der SL-Bereich des Inneren Zirkel <br>\n";
	echo "            <BR>\n";
	echo "            &nbsp; Hier werden die Planungen und der Plot der Spiele erstellt<BR>\n";
	echo "            <BR>\n";
	echo "            Es gibt verschieden Bereiche für <BR>\n";
	echo "            <TABLE  >\n";
	echo "            <TR>\n";
	echo "            <TD width=\"90\">\n";// item
	echo "            <LI>Legenden\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            beschreiben den globalen Hintergrund der Geschichte und ordnet die CON-Tage in diesen Kontext ein.
			Eine Legende muss nicht zu einem Con Tag gehören. Somit können Zwischensequenzen dargestellt werden.<BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>CON Tage \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \nbeschreibt die Veranstaltung und ist die Referenz für die Planung und die Anmeldung<BR>
			Über diese Maske werden die anderen Daten aufgerufen<BR>
			<LI>das Feld S0 = Tag-Referenz<BR>
			<LI>das Feld S1 = Ablauf-Referenz<BR>
			<BR> ";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Ablauf\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            beschreibt den Regieplan oder den Roten Faden für den CON-Tag.
			Dies können globale Ereigniss des Tages oder Gruppen sein.<BR>\n";
	//echo "            <UL>\n";
	echo "            Verweise auf :\n";
	echo "              <LI>ORT _________[R_ORT]\n";
	echo "              <LI>NSC _________[R_NSC]\n";
	echo "              <LI>GRUPPE ______[R_GRP]\n";
	echo "              <LI>SC __________[R_SC]\n";
	echo "              <BR><BR>\n";
	//echo "            </UL>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Orte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            beschreibt die einzelne Orte des Spiels, Aufbau, wer oder was da zu finden ist etc.<BR>\n";
	echo "            Verweise auf : \n";
	echo "            <LI>NSC _________[R_NSC]\n";
	echo "            <LI>ARTEFAKT_____[R_GRP]\n";
	echo "            <LI>BUCH _________[R_SC]\n";
	echo "            <BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>NSC\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            beschreibt die  Aufgaben und Motivation der NSC <BR>\n";
	echo "            Verweis auf : \n";
	echo "            <LI>ORT _________[R_ORT]\n";
	echo "            <LI>SPIELER _____[R_CHAR]\n";
	echo "            <LI>GRUPPE ______[R_GRP]\n";
	echo "            <BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Gerüchte\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            beschreibt die Informationen , die im Spiel vorhanden sind oder verteilt werden sollen. Die Gerüchte sind an NSC oder SC gebunden und verweisen auf Orte , Artefakte oder Personen<BR>\n";
	echo "            Verweis auf : \n";
	echo "            <LI>NSC _________[R_NSC]\n";
	echo "            <BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Bücher \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \nbeschreibt die Schriftstücke innerhalb des Spiels. (Briefe, Schriftrollen, Legenden, Bücher ...<BR>";
	echo "            Verweis auf : \n";
	echo "            <LI>ORT _________[R_ORT]\n";
	echo "            <LI>SC___________[R_SC]\n";
	echo "            <LI>NSC _________[R_NSC]\n";
	echo "            <BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Artefakte<BR>\n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            sind die INTIME Gegenstände im Spiel.Alles wonach ein normaler Spieler ausschau hält. Die Artefakte können magisch oder nichtmagisch sein. Die Zuordnung zum CON bezieht sich darauf, wann der Gegenstand zum ersten Mal im Spiel aufgetaucht ist. <BR> \n";
	echo "            Verweis auf : \n";
	echo "            <LI>ORT _________[R_ORT]\n";
	echo "            <LI>SC___________[R_SC]\n";
	echo "            <LI>NSC _________[R_NSC]\n";
	echo "            <BR><BR>\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI>Magie \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            ist eigentlich kein Planungselement. Aber Erfahrungsgemäß werden häufig Sprüche und Spruchrollen im Spiel benötigt. Dieser Punkt dient als Referenz.\n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            <TR>\n";
	echo "            <TD>\n";// item
	echo "            <LI> \n";
	echo "            </TD>\n";
	echo "            <TD>\n";// Erklärung zu item
	echo "            \n";
	echo "            </TD>\n";
	echo "            </TR>\n";
	echo "            </TABLE  >\n";
	echo "          </TD>\n";
	echo "        </TR>\n";
	echo "      </TABLE>\n";
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";
};

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$BEREICH = 'SL';


$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");

$ID     = GET_SESSIONID("");
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

if (is_sl()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}
  
  
print_header("SL Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"<b>SL Bereich</b>",$anrede,$menu_item);

switch ($md):
case 10:
	$menu = array (0=>array("icon" => "7","caption" => "HILFE","link" => ""),
			2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
default:
	$menu = array (0=>array("icon" => "0","caption" => "SL-MAIN","link" => ""),
	1=>array("icon" => "_list","caption" => "Legenden","link" => "con_legende.php?md=0&ID=$ID"),
	2=>array("icon" => "_list","caption" => "Magie","link" => "con_magie.php?md=0&ID=$ID"),
	3=>array("icon" => "_list","caption" => "Artefakte","link" => "con_artefakt.php?md=0&ID=$ID"),
//	4=>array("icon" => "_folder","caption" => "Planung","link" => "con_liste.php?md=0&ID=$ID"),
	5=>array("icon" => "_folder","caption" => "SL-Forum","link" => "con_forum.php?md=0&ID=$ID"),
	6=>array("icon" => "_folder","caption" => "NSC","link" => "con_nsc_liste.php?md=0&ID=$ID"),
	7=>array("icon" => "_list","caption" => "Regelwerk","link" => "con_regel_liste.php?md=0&ID=$ID"),
	8=>array ("icon" => "_list","caption" => "Bibliothekar","link" => "con_bib_liste.php?md=0&ID=$ID"),
	9=>array("icon" => "_list","caption" => "Tränke","link" => "con_trank_liste.php?md=0&ID=$ID"),
	10=>array("icon" => "_list","caption" => "Pflanzen","link" => "con_trankstoff_liste.php?md=0&ID=$ID"),
	17=>array("icon" => "_help","caption" => "Hilfe","link" => "$PHP_SELF?md=10&ID=$ID&item=conplan"),
	18=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	endswitch;

	print_menu($menu);


	switch ($md):
case 10:
		print_hilfe($ID,$item,$id);
	break;
default:
    $daten="con_main.html"; 
	print_pages($daten);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>