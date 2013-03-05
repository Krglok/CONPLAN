<?php

/*
 Projekt : MAIN

Datei   :  main_forum.php

Datum   :  2002/05/24

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung :
Realisiert ein oeffentliches Forum
Es gibt keine Zugriffsverwaltung und keine Rechte !
Das Forum ermoeglicht zweigliederige Beitraege mit der Hierarchie
- THEMA
- BEITRAG
Die Themen koenen erfasst aber NICHT bearbeitet werden.

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


*/


include "config.inc";
include "lib.inc";
include "head.inc";



function print_thema_liste($foren_id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	//Macht aus einem Resultset eine HTML Tabelle


	if ($forum_id=='')
	{
		$forum_id = 1;
	}
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "SELECT  * from forum_post where foren_id=\"$forum_id\" AND post_id=\"0\" order by id DESC LIMIT 20";

	$result = mysql_query($q) or die("ForumList Fehler...");


	echo "\n";
	echo "<TD>\n";
	echo "\t <TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\" >\n";
	echo "\t<tr>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t<a href=\"$PHP_SELF?md=4&ID=$ID&id=0&post_id=0\"> \n";
	//      echo "\t  <IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon (2);
	echo "\t</td>\n";
	echo "\t<td width=\"100\"><b></b>\n";
	echo "\tNeues Thema\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td ><b></b>\n";
	echo "\t</td>\n";
	echo "\t</tr>\n";
	echo "\t</TABLE>\n";

	echo "\n";
	echo "\t <TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\">\n";

	//Header

	echo "\t<tr>\n";
	echo "\t<td width=\"30\"><b>Liste</b></td>\n";
	echo "\t<td width=\"300\"><b>Thema</b></td>\n";
	echo "\t<td width=\"75\"><b>Author</b></td>\n";
	echo "\t<td width=\"75\"><b>Datum</b></td>\n";
	echo "\t<td width=\"50\"><b>Lesen</b></td>\n";
	echo "\t<td><b>Anwort</b></td>\n";
	echo "\n</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		$count = mysql_fetch_row(mysql_query("select count(*) from forum_post where post_id = \"$row[0]\""));
		echo "\t<tr>\n";
		echo "\t  <td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&forum_id=$row[1]&post_id=$row[0]\"\n>";
		//echo "\t  <IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Zeige Thema und Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (5);
		echo "\t  </a></td>\n";
		echo "\t  <td>$row[6]&nbsp;</td>\n";
		echo "\t  <td>$row[4]&nbsp;</td>\n";
		echo "\t  <td>$row[5]&nbsp;</td>\n";
		echo "\t  <td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[0]&betreff=Re:$row[6]\">\n";
		//echo "\t  <IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (7);
		echo "\t  </a>\n";
		echo "\t  </td>\n";
		echo "\t  <td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]&betreff=Re:$row[6]\">\n";
		//echo "\t  <IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (3);
		echo "\t  </a>\n";
		echo "\t&nbsp;&nbsp;&nbsp;&nbsp;$count[0]";
		echo "\t  </td>\n";
		echo "\t</tr>\n";
	}
	echo "\t</table>\n";
	echo "  </TD>\n";

	mysql_close($db);
};


function print_thema($foren_id,$post_id,$id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	//Macht aus einem Resultset eine HTML Tabelle

	if ($forum_id=='')
	{
		$forum_id = 1;
	}
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	$q = "SELECT * from forum_post where foren_id=\"$forum_id\" AND (post_id = \"$post_id\" OR id=\"$post_id\") order by post_id";
	$result = mysql_query($q)
	or die("Query Fehler...");


	mysql_close($db);


	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);
	//  FORMULAR
	echo "\n";
	echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	//    echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "</FORM>";

	echo "    <TD>\n";

	echo "\t <TABLE WIDTH=\"700\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	echo "\t<tr>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t<a href=\"$PHP_SELF?md=1&ID=$ID&id=$row[0]\"> \n";
	//echo "\t<IMG SRC=\"images/stop.gif\" BORDER=\"0\" HEIGHT=\"18\" WIDTH=\"18\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
	print_menu_icon (6);
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"100\"><b></b>\n";
	echo "\tZurück\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td ><b></b>\n";
	echo "\t</td>\n";
	echo "\t</tr>\n";
	echo "\t</TABLE>\n";

	echo "\t <TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";

	//Header
	echo "<tr>\n";
	echo "\t<td width=\"30\"><b>Lesen</b></td>\n";
	echo "\t<td width=\"30\"><b>Lesen</b></td>\n";
	echo "\t<td width=\"300\"><b>Thema</b></td>\n";
	echo "\t<td width=\"75\"><b>Author</b></td>\n";
	echo "\t<td width=\"80\"><b>Datum</b></td>\n";
	echo "\t<td width=\"50\"><b>Anwort</b></td>\n";
	echo "\t<td><b></b></td>\n";
	echo "</tr>\n";

	//Daten
	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	echo "<tr>";
	echo "\t<td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$post_id\">\n";
	//echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon (7);
	echo "\t</a></td>\n";
	echo "\t<td width=\"30\"></td>\n";
	echo "\t<td>$row[6]&nbsp;</td>\n";
	echo "\t<td>$row[4]&nbsp;</td>\n";
	echo "\t<td>$row[5]&nbsp;</td>\n";
	echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$post_id&betreff=Re:$row[6]\">\n";
	//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon (2);
	echo "\t</td>\n";
	echo "\t<td>\n";
	echo "\t</td>\n";
	echo "\t<tr>\n";
	echo "<tr>";
	echo "\t</a></td>\n";
	echo "\t<td></td>\n";
	echo "\t<td></td>\n";
	echo "\t<td>$row[7]&nbsp;</td>\n";
	echo "\t<tr>\n";

	while ($row = mysql_fetch_row($result))
	{
		// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
		echo "<tr>";
		echo "\t<td width=\"30\"></td>\n";
		echo "\t<td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$post_id\">\n";
		//echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "\t<td>$row[6]&nbsp;</td>\n";
		echo "\t<td>$row[4]&nbsp;</td>\n";
		echo "\t<td>$row[5]&nbsp;</td>\n";
		echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$post_id&betreff=Re:$row[6]\">\n";
		//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon (2);
		echo "\t</td>\n";
		echo "\t<td>\n";
		echo "\t</td>\n";
		echo "\t<tr>\n";
		echo "<tr>";
		echo "\t</a></td>\n";
		echo "\t<td></td>\n";
		echo "\t<td></td>\n";
		echo "\t<td>$row[7]&nbsp;</td>\n";
		echo "\t<tr>\n";
	}
	echo "</table>\n";
	echo "    </TD>\n";
};

function print_thema_lesen($foren_id,$post_id,$id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	$q = "select * from forum_post where id=\"$id\"";
	$result = mysql_query($q) or die("select Fehler....$q.");

	mysql_close($db);
	//  Daten
	$row = mysql_fetch_row($result);
	//
	echo "<TD>\n";/// Spalte für Datenbereich

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

	echo "\t <TABLE WIDTH=\"500\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"1\" >\n";
	echo "\t<tr>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$id&post_id=$post_id\"> \n";
	//echo "\t<IMG SRC=\"images/stop.gif\" BORDER=\"0\" HEIGHT=\"18\" WIDTH=\"18\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
	print_menu_icon (6);
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"80\"><b></b>\n";
	echo "\tZurück\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"75\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td ><b></b>\n";
	echo "\t</td>\n";
	echo "\t</tr>\n";
	echo "\t</TABLE>\n";

	echo "\t <TABLE WIDTH=\"500\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	//    echo "<CAPTION>Beitrag Lesen</CAPTION>\n";

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	echo "<INPUT TYPE=\"hidden\" NAME=\"forum_id\" VALUE=\"$row[1]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"top_id\" VALUE=\"$row[2]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$post_id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"betreff\" VALUE=\"Re:$row[6]\">\n";

	echo "<tr>\n";
	echo "<td>\n";
	echo "\t <TABLE WIDTH=\"500\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"75\">$row[1] / $row[2] / $row[3] </td>\n";
	echo "\t<td><B><CENTER>Beitrag Lesen</b></td>\n";
	echo "\t<td ></td>\n";
	echo "\t<td>\n";
	echo "\t<td WIDTH=\"35\" ><a href=\"$PHP_SELF?md=4&ID=$ID&foren_id=$row[1]&top_id=$row[2]&post_id=$post_id&betreff=re:$row[6]\">\n";
	//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon (3);
	echo "\t</td>\n";
	echo "\t</table>\n";
	echo "  </td>\n";
	echo "  </tr>\n";
	echo "  <tr>\n";
	echo "  <td>\n";
	echo "\t <TABLE WIDTH=\"500\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"80\"><B>Datum</B></td>\n";
	echo "\t<td WIDTH=\"100\">$row[5]</td>\n";
	echo "\t<td WIDTH=\"75\" ><B>Author</B></td>\n";
	echo "\t<td WIDTH=\"150\" >$row[4]</td>\n";
	echo "\t<td></td>\n";
	echo "\t</table>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>";
	echo "\t <TABLE WIDTH=\"500\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"80\"><b>Betreff:</b></td>\n";
	echo "\t<td BGCOLOR=\"\">$row[6]</td>\n";
	echo "\t<td></td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td  WIDTH=\"400\" HEIGHT=\"200\" BGCOLOR=\"\">$row[7]</td>\n";
	echo "\t<td></td>\n";
	echo "\t</tr>\n";
	echo "\t</table>\n";
	echo "\t</FORM>\n";
	echo "\t</TD>\n"; //  ENDE Spalte Datenbereich
}


function print_thema_erf($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	// DAtenbank zugriff =============================================================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	$q = "select spieler_id,id,username from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$id=$row[0];
	//  echo "$user/$id/$result\n";

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$author = $row[2]." ".$row[1];

	mysql_close($db);
	// Datenbank Ende ================================================================

	//  Daten
	//
	$d = getdate();
	$datum = $d[year]."-".$d[mon]."-".$d[mday];
	echo "<!--  Daten Spalte    -->\n";
	echo "<TD>\n";/// Spalte für Datenbereich

	//  FORMULAR
	echo "\n";
	echo "\t<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"5\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"top_id\" VALUE=\"1\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"1\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$post_id\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"user_id\" VALUE=\"$id\">\n";

	echo "\t <TABLE WIDTH=\"700\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";
	echo "\t<tr>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t<a href=\"$PHP_SELF?md=1&ID=$ID&id=$id\"> \n";
	//echo "\t<IMG SRC=\"images/stop.gif\" BORDER=\"0\" HEIGHT=\"18\" WIDTH=\"18\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
	print_menu_icon (6);
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"100\"><b></b>\n";
	echo "\tZurück\n";
	echo "\t</td>\n";
	echo "\t<td width=\"30\"><b></b>\n";
	echo "\t</td>\n";
	echo "\t<td width=\"200\"><b></b>\n";
	echo "\t<B>Erfassen neues Thema\n";
	echo "\t</td>\n";
	echo "\t<td ><b></b>\n";
	echo "\t</td>\n";
	echo "\t</tr>\n";
	echo "\t</TABLE>\n";


	echo "\t <TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" >\n";

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)

	echo "<tr>\n";
	echo "\t<td WIDTH=\"75\"><b>ID</b></td>\n";
	echo "\t<td>\"0 \"&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td><b>Author</b></td>\n";
	echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"author\" SIZE=30 MAXLENGTH=30 VALUE=\"Gast \">&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td><b>Datum</b></td>\n";
	//    $datum = getdate();
	echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"datum\" SIZE=10 MAXLENGTH=10 VALUE=\"$datum\">&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td><b>Betreff</b></td>\n";
	echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"betreff\" SIZE=50 MAXLENGTH=50 VALUE=\"$betreff\">&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td><b>Text</b></td>\n";
	echo "\t<td><TEXTAREA NAME=\"text\" COLS=50 ROWS=12></TEXTAREA>&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "\t</tr>\n";
	echo "\t</table>\n";
	echo "\t</FORM>\n";

	echo "</TD>\n"; //  ENDE Spalte Datenbereich
	echo "<!--  Daten Spalte ENDE   -->\n\n";
}

function erf_thema($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $PHP_SELF;

	// Datenbankzugriff =====================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	//INSERT INTO forum_post (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id) VALUES (NULL, 1, 1, 0, 'Duda, Olaf', '0000-00-00', 'Ist Martin doof ?', 'Diese Frage beschäftigt uns schon lange !', NULL)
	$q ="INSERT INTO forum_post (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id) VALUES (NULL,\"$foren_id\", \"$top_id\", \"$post_id\", \"$author\", \"$datum\", \"$betreff\", \"$text\", \"$user_id\")";
	$result = mysql_query($q) or die("Insert Fehler....$q.");
	$err = "Daten gespeichert ";
	mysql_close($db);
	// Datenbank Ende =======================
	if ($post_id == 0)
	{
		header ("Location: $PHP_SELF?md=1&ID=$ID");  /* Umleitung des Browsers zur PHP-Web-Seite. */
	} else
	{
		header ("Location: $PHP_SELFE?md=2&ID=$ID&id=$id&post_id=$post_id");
	};
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	return $err;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];
$md       = $_GET['md'];
$id       = $_GET['id'];
$post_id  = $_GET['post_id'];

$foren_id = 1;

$top_id   = $_POST['top_id'];
$author   = $_POST['author'];
$datum    = $_POST['datum'];
$betreff  = $_POST['betreff'];
$text     = $_POST['text'];
$user_id  = $_POST['user_id'];


$user = "gast";
$pw   = "_gast";


switch ($p_md):
case 3:
	//         $err = update_forum($id,$name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung);
//         echo $err;
	$md = 1;
break;
case 5:
	$err = erf_thema($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id,$user);
	//         echo $err;
	$md = 2;
	break;
default:
	break;
	endswitch;


	switch ($md):
case 1:
		$menu = array (0=>array("icon" => "99","caption" => "Übersicht","link" => ""),
				2=>array("icon" => "2","caption" => "Neues Thema","link" => "$PHP_SELFE?md=4"),
				3=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
		);
		break;
case 2:
	$menu = array (0=>array("icon" => "99","caption" => "THEMA","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELFE?md=1&post_id=$post_id")
	);
	break;
case 4:
	$menu = array (0=>array("icon" => "99","caption" => "NEUES THEMA","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELFE?md=1")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "Übersicht","link" => ""),
	2=>array("icon" => "2","caption" => "Neues Thema","link" => "$PHP_SELFE?md=4"),
	3=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
	);
	break;
	endswitch;

	print_header("Allg. Forum");

	print_body(2);

	print_kopf(1,2,"Schwarzes Brett","Sei gegrüsst Freund ");

	//  echo "POST : $p_md / GET : $md / Record_id :$id / Forum : $foren_id / DataVar : $author/$betreff";

	print_md();

	print_menu($menu);

	$forum_id = 1;

	switch ($md):
case 1:
		print_thema_liste($forum_id,$user);
	break;
case 2:
	print_thema($forum_id,$post_id,$id,$user);
	break;
case 3:
	print_thema_lesen($forum_id,$post_id,$id,$user);
	//         echo "UPDATE";
	break;
case 4:
	print_thema_erf($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id,$user);
	break;
case 5:
	echo "UPDATE";
	break;
default:
	//        print_sp_liste();
	break;
	endswitch;


	print_md_ende();
	print_body_ende();

	?>