<?php

/*
 Projekt : LARP

Datei   :  $RCSfile: i_liste.php,v $

Datum   :  $Date: 2002/03/08 21:21:45 $  /

Rev.    :  $Revision: 1.1 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Interne Forum abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es koennen normale HTML Seiten ausgegeben werden.
Subseiten werden mit eigenen PHP-scripten erzeugt.
Die zugehoerigen HTML Seiten koenen in einem Subdir sein
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

#1  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
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


function print_thema_liste($ID,$foren_id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
    global $PHP_SELF;

	if ($foren_id=='')
	{
		$foren_id = 1;
	}
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "SELECT  * from forum_post where foren_id=\"$foren_id\" AND post_id=\"0\" order by id DESC LIMIT 20";
	$result = mysql_query($q) or die("ForumList Fehler...");


	//Macht aus einem Resultset eine HTML Tabelle

	echo "\n";
	echo "<TD>\n";
	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	//Header
	$field_num = mysql_num_fields($result);
	echo "\t<tr>\n";
	echo "\t<td width=\"300\"><b>Thema</b></td>\n";
	echo "\t<td width=\"75\"><b>Author</b></td>\n";
	echo "\t<td width=\"75\"><b>Datum</b></td>\n";
	echo "\t<td width=\"30\"><b> </b></td>\n";
	echo "\t<td width=\"30\"><b> </b></td>\n";
	echo "\t<td><b>Anwort</b></td>\n";
	echo "\n</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
		$count = mysql_fetch_row(mysql_query("select count(*) from forum_post where post_id = \"$row[0]\""));
		echo "\t<tr>\n";
		echo "\t  <td>$row[6]&nbsp;</td>\n";
		echo "\t  <td>$row[4]&nbsp;</td>\n";
		echo "\t  <td>$row[5]&nbsp;</td>\n";
		echo "\t  <td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&foren_id=$row[1]&post_id=$row[0]\"\n>";
		//echo "\t  <IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Zeige Thema und Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon ("_list","Öffne Thema");
		echo "\t  </a></td>\n";
		
		echo "\t  <td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[0]&betreff=Re:$row[6]\">\n";
		//echo "\t  <IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon ("_text");
		echo "\t  </a>\n";
		echo "\t  </td>\n";
		echo "\t  <td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[0]&betreff=Re:$row[6]&next=1\" &post_id=$row[0]>\n";
		//echo "\t  <IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon ("_add");
		echo "\t  </a>\n";
		echo "\t&nbsp;&nbsp;&nbsp;&nbsp;$count[0]";
		echo "\t  </td>\n";
		echo "\t</tr>\n";
	}
	echo "\t</table>\n";
	echo "  </TD>\n";
	mysql_close($db);

};


function print_thema($ID,$foren_id,$id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $PHP_SELF;
	//Macht aus einem Resultset eine HTML Tabelle

	if ($foren_id=='')
	{
		$foren_id = 1;
	}
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	$q = "SELECT * from forum_post where foren_id=\"$foren_id\" AND (post_id = \"$id\" OR id=\"$id\") order by id";
	$result = mysql_query($q)    or die("Query Fehler...");
	mysql_close($db);

	//  FORMULAR
	echo "\n";
	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	//    echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "</FORM>";

	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	//Header
	$field_num = mysql_num_fields($result);
	echo "<tr>\n";
// 	echo "\t<td width=\"30\"><b>Lesen</b></td>\n";
 	echo "\t<td ><b></b></td>\n";
 	echo "\t<td></td>\n";
 	echo "\t<td width=\"300\"><b>Thema</b></td>\n";
	echo "\t<td width=\"75\"><b>Author</b></td>\n";
	echo "\t<td width=\"75\"><b>Datum</b></td>\n";
	echo "\t<td width=\"50\"><b>Anwort</b></td>\n";
	echo "</tr>\n";

	//Daten
	$row = mysql_fetch_row($result);
	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	echo "<tr>";
// 	echo "\t<td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[0]\">\n";
// 	//echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
// 	print_menu_icon ("_page");
// 	echo "\t</a></td>\n";
	echo "\t<td><img src=\"images/button_orange.gif\"></td>\n";
 	echo "\t<td></td>\n";
	echo "\t<td>$row[6]&nbsp;</td>\n";
	echo "\t<td>$row[4]&nbsp;</td>\n";
	echo "\t<td>$row[5]&nbsp;</td>\n";
	echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[0]&betreff=Re:$row[6]&next=2\">\n";
	//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon ("_edit");
	echo "\t</td>\n";
	echo "\t<tr>\n";
	echo "<tr>";
 	echo "\t<td></td>\n";
//	echo "\t<td></td>\n";
	echo "\t<td ></td>\n";
	echo "\t<td>$row[7]&nbsp;</td>\n";
	echo "\t<tr>\n";
//     echo "</table>";
// 	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
// 			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
    while ($row = mysql_fetch_row($result))
	{
		// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
		echo "<tr>";
 		echo "\t<td></td>\n";
	    echo "\t<td><img src=\"images/button_orange.gif\"></td>\n";
// 		echo "\t<td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]\">\n";
// 		//echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
// 		print_menu_icon ("_page");
// 		echo "\t</a></td>\n";
		echo "\t<td>$row[6]&nbsp;</td>\n";
		echo "\t<td>$row[4]&nbsp;</td>\n";
		echo "\t<td>$row[5]&nbsp;</td>\n";
		echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]&betreff=Re:$row[6]&next=2\">\n";
		//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
		print_menu_icon ("_edit");
		echo "\t</td>\n";
		echo "\t<td>\n";
		echo "\t</td>\n";
		echo "\t<tr>\n";
		echo "<tr>";
 		echo "\t<td></td>\n";
		echo "\t</a></td>\n";
 		echo "\t<td></td>\n";
// 		echo "\t<td></td>\n";
		echo "\t<td>$row[7]&nbsp;</td>\n";
		echo "\t<tr>\n";
	}
	echo "</table>\n";

};

function print_thema_lesen($ID,$foren_id,$id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
    global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	$q = "select * from forum_post where id=\"$id\"";
	$result = mysql_query($q) or die("select Fehler....$q.");

	mysql_close($db);

	//  Daten
	//
	echo "<TD>\n";/// Spalte für Datenbereich

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	//    echo "<CAPTION>Beitrag Lesen</CAPTION>\n";

	$row = mysql_fetch_row($result);
	if ($row[3] == 0)
	{
		$row[3] = $row[0];
	}

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
	echo "<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"$row[1]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"top_id\" VALUE=\"$row[2]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$row[2]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"betreff\" VALUE=\"Re:$row[6]\">\n";

	echo "<tr>\n";
	echo "<td>\n";
	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"100\"> </td>\n";
	echo "\t<td><B>Beitrag Lesen</b></td>\n";
	echo "\t<td ></td>\n";
	echo "\t<td>\n";
	echo "\t<td WIDTH=\"35\" ><a href=\"$PHP_SELF?md=4&ID=$ID&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]&betreff=re:$row[6]\"&next=2>\n";
	//echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
	print_menu_icon ("_edit");
	echo "\t</td>\n";
	echo "\t</table>\n";
	echo "  </td>\n";
	echo "  </tr>\n";
	echo "  <tr>\n";
	echo "  <td>\n";
	echo "\t<table border=0 BGCOLOR=\"\"  >\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"75\"><B>Datum</B></td>\n";
	echo "\t<td WIDTH=\"100\">$row[5]</td>\n";
	echo "\t<td ><B>Author</B></td>\n";
	echo "\t<td>$row[4]</td>\n";
	echo "\t</table>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>";
	echo "\t<table border=0 BGCOLOR=\"\"  >\n";
	echo "\t<tr>\n";
	echo "\t<td WIDTH=\"75\"><b>Betreff:</b></td>\n";
	echo "\t<td BGCOLOR=\"#E2D7CF\">$row[6]</td>\n";
	echo "\t</table>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	//C
	//#E9E0DA
	echo "<td  WIDTH=\"400\" HEIGHT=\"200\" BGCOLOR=\"#E9E0DA\">$row[7]</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</FORM>\n";
	echo "</TD>\n"; //  ENDE Spalte Datenbereich
}


function print_thema_erf($ID,$id, $foren_id, $post_id, $author, $datum, $betreff, $text, $user_id,$next)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
    global $PHP_SELF;
	// DAtenbank zugriff =============================================================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	/*
	 $q = "select spieler_id,id,username from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$spieler_id=$row[0];
	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$spieler_id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$author = $row[2]." ".$row[1];
	*/
	$author = get_spieler($_SESSION["spieler_id"]);
	$user_id = $_SESSION["user_id"];
//	echo "Author : $_SESSION[spieler_id] / $author user_id : $user_id";
	mysql_close($db);
	// Datenbank Ende ================================================================

	//  Daten
	//
	if ($next==2)
	{
		$id = $post_id;
	};
	$d = getdate();
	$datum = $d["year"]."-".$d["mon"]."-".$d["mday"];
	echo "<!---  Daten Spalte    --->\n";

	//  FORMULAR
	echo "\n";
	echo "\t<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"5\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"$foren_id\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$post_id\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"user_id\" VALUE=\"$user_id\">\n";
	echo "\t<INPUT TYPE=\"hidden\" NAME=\"next\" VALUE=\"$next\">\n";

	echo "\t<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<P Align=LEFT><B>Lass deine Ideen sprühen\n";

	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)

	echo "\t<td><b>Author</b></td>\n";
	echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"author\" SIZE=30 MAXLENGTH=30 VALUE=\"$author \">&nbsp;</td>\n";
	echo "\t</tr>\n";
	echo "\t<tr>\n";
	echo "\t<td><b>Datum</b></td>\n";
	//    $datum = getdate();
	echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"datum\" SIZE=30 MAXLENGTH=30 VALUE=\"$datum\">&nbsp;</td>\n";
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

	echo "<!---  Daten Spalte ENDE   --->\n\n";
}

function erf_thema($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $PHP_SELF;

	// Datenbankzugriff =====================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

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
$BEREICH = 'INTERN';
$PHP_SELF = $_SERVER['PHP_SELF'];

// $g_top_id   = $_GET['top_id'];
$g_id       = GET_id("0");
$g_post_id  = GET_post_id("0");
$g_datum    = GET_datum("");
$g_betreff  = GET_betreff("");
$g_text     = GET_text("");
$g_next     = "";

$p_md = POST_md()['md'];
$p_top_id   = POST_top_id("0");
$p_post_id  = POST_post_id("0");
$p_author   = POST_author("gast");
$p_datum    = POST_datum("");
$p_betreff  = POST_betreff("??");
$p_text     = POST_text("");
$p_user_id  = POST_user_id("0");


$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
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



$foren_id = 2;   // Internes Forum

switch ($p_md):
case 5:
	$err = erf_thema($ID, $foren_id, $p_top_id, $p_post_id, $p_author, $p_datum, $p_betreff, $p_text, $p_user_id);
$md = 2;
break;
default:
	break;
	endswitch;

	switch ($md):
case 1:
	$menu = array (0=>array("icon" => "99","caption" => "FORUM","link" => ""),
	2=>array("icon" => "_add","caption" => "Neues Thema","link" => "$PHP_SELF?md=4&ID=$ID"),
	3=>array("icon" => "_stop","caption" => "Verlassen","link" => "larp.php?md=0&ID=$ID")
	);
	break;
case 2:
	$menu = array (0=>array("icon" => "99","caption" => "THEMA","link" => ""),
	//1=>array("icon" => "_stop","caption" => "THEMA","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück ","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 3:
	$menu = array (0=>array("icon" => "99","caption" => "LESEN","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück Forum","link" => "$PHP_SELF?md=1&ID=$ID"),
	3=>array("icon" => "_stop","caption" => "Zurück Thema","link" => "$PHP_SELF?md=2&ID=$ID&post_id=$g_post_id")
	);
	break;
case 4:
	$menu = array (0=>array("icon" => "99","caption" => "NEUER BEITRAG","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID&id=g_id")
	);
	break;
case 5:
	$menu = array (0=>array("icon" => "99","caption" => "FORUM","link" => ""),
	3=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "FORUM","link" => ""),
	2=>array("icon" => "_add","caption" => "Neues Thema","link" => "$PHP_SELF?md=4&ID=$ID"),
	3=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
	endswitch;

print_header("Interner Bereich");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Intern","Sei gegrüsst $spieler_name ",$menu_item);
	
print_menu($menu);


switch ($md):
case 1:
		print_thema_liste($ID,$foren_id,$user);
	break;
case 2:
	$g_id = $g_post_id;
	print_thema($ID,$foren_id,$g_id,$user);
	break;
case 3:
	print_thema_lesen($ID,$foren_id,$g_id,$user);
	break;
case 4:
	print_thema_erf($ID,$g_id, $foren_id, $g_post_id, $spieler_name, $g_datum, $g_betreff, $g_text, $user_id,$g_next);
	break;
case 5:
	echo "UPDATE";
	break;
default:
	break;
	endswitch;

	//    print_md_ende();

	print_body_ende();

	?>