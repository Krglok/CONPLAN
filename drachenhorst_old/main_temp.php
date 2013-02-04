<?php

/*
 Projekt : CONPLAN

Datei   :  $RCSfile: larp.php,v $

Datum   :  $Date: 2002/06/12 17:39:02 $  /

Rev.    :  $Revision: 1.6 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :


$Log: larp.php,v $
Revision 1.6  2002/06/12 17:39:02  windu
neue bersicht und neuer modulname

Revision 1.5  2002/06/08 14:38:31  windu
update fr Bilder

Revision 1.4  2002/05/24 13:10:56  windu
neue icons im men

Revision 1.3  2002/05/09 08:50:44  windu
Newsliste auf 10 Eintrï¿½e begrenzt

Revision 1.2  2002/05/03 20:18:26  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.7  2002/03/10 09:37:08  windu
anpassung an neue Seiten
hilfe_admin
larp_map

Revision 1.6  2002/03/08 21:21:59  windu
Ideenliste fr Spieler als Forum realisiert

Revision 1.5  2002/03/07 21:54:18  windu
Anmeldung ist neu

Revision 1.4  2002/03/03 11:11:55  windu
Erweiterung um Ideen und Legende
ADMIN und SL Funktionen nur noch bei Berechtigung sichtbar

Revision 1.3  2002/02/26 18:42:41  windu
keyword aktiviert

*/

include "config.inc";
include "login.inc";
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
		echo "\t      <td width=\"85\">".$row[0]."&nbsp;</td>\n";
		echo "\t      <td>".$row[1]."<BR>".$row[2]."<BR>".$row[3];
		echo "<HR>";
		echo "</td>\n";
		echo '        </TR>';
	}

	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n"; // Ende der Datenspalte
};


function print_data()
{
	echo "    <TD>\n";
	$text =
	'Dies ist eine eine eingebettete Seite fuer &nbsp;den oeffentlichen Teile.<br> <br> Hier sollen einfach HTML Seiten eingebunden werden koennen.<br> <br> z.B. Bilder &nbsp; &nbsp;<img  style="width: 110px; height: 124px;" alt=""  src="images/feminist.gif"><br> <br> Ich hoffe dies funktioniert &nbsp;so wie ich es nir denke !!'
	.'<br> Es funktioniert GUT !!!';
	echo $text;
	echo "    .\n";
	echo "    </TD>\n";

}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------

//session_start ($ID);
session_start ($ID);
print_header("KOPF_FRAME");

print_body(4);

print_kopf(1,2,"Öffentlich","Sei gegrüsst Freund ");
//    echo "<CENTER><B> Sei gegrsst Auserwï¿½lter </B></CENTER> \n";

print_md();

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md = $_GET['md'];
$THEMEN = $_GET['THEMEN'];

echo "COOKIE : $c_md / POST : $p_md / GET : $g_md / THEMEN :$THEMEN ";

switch ($md):
case 1: //  SPIELERLISTE
	$menu = array (0=>array("icon" => "99","caption" => "KALENDER","link" => ""),
			1=>array("icon" => "6","caption" => "Zurck","link" => "$PHP_SELF?md=0")
	);
	break;
default: // MAIN MENUE
	$menu = array (0=>array("icon" => "99","caption" => "HAUPTMENÜ","link" => "$PHP_SELF?md=0"),
	1=>array ("icon" => "1","caption" => "News","link" => "$PHP_SELF?md=0"),
	2=>array ("icon" => "1","caption" => "Embedded","link" => "$PHP_SELF?md=2"),
	3=>array ("icon" => "1","caption" => "Forum Intern","link" => "f_liste.php?md=1"),
	4=>array ("icon" => "1","caption" => "Ideen","link" => "i_liste.php?md=1"),
	5=>array ("icon" => "1","caption" => "Anmeldung","link" => "anmelde_liste.php?md=0"),
	6=>array ("icon" => "1","caption" => "Bilder","link" => "bilder_liste.php?md=0"),
	7=>array ("icon" => "1","caption" => "Termine","link" => "$PHP_SELF?md=1"),
	8=>array ("icon" => "1","caption" => "Download","link" => "../larp/down_liste.php?md=0"),
	9=>array ("icon" => "1","caption" => "Regeln","link" => "r_liste.php?md=0"),
	10=>array ("icon" => "0","caption" => "<HL COLOR=GRAY>","link" => ""),
	11=>array ("icon" => "1","caption" => "Charakter","link" => "../chars/char_liste.php?md=0"),
	12=>array ("icon" => "1","caption" => "Bibliothek","link" => "bib_liste.php?md=0"),
	13=>array ("icon" => "1","caption" => "Legenden","link" => "l_liste.php?md=0"),
	14=>array ("icon" => "1","caption" => "Sprueche","link" => "m_liste.php?md=0"),
	15=>array ("icon" => "1","caption" => "Traenke","link" => "t_liste.php?md=0"),
	16=>array ("icon" => "1","caption" => "Bibliothek","link" => "../bibliothek/gdw_liste.php?md=0"),
	19=>array ("icon" => "6","caption" => "ENDE","link" => "larp.php?md=99"),
	90=>array ("icon" => "0","caption" => "<HL COLOR=GRAY>","link" => ""),
	91=>array ("icon" => "1","caption" => "Bib-Zugriff","link" => "bibzug_admin.php?md=0"),
	);
	endswitch;

	// erstellen das linken Menue
	print_menu($menu);

	// Erstellen des Datenbereichs
	switch ($md):
case 1:
		print_kalender();
	break;
case 2:
	print_data();
	break;
case 4:
	break;
case 5:
	break;
default:
	print_main_data();
	break;
	endswitch;
	// Erstellen des rechten Menue
	//    print_menu($menu);

	print_md_ende();


	?>