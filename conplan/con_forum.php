<?php

/*
 Projekt : LARP

Datei   :  $RCSfile: i_liste.php,v $

Datum   :  $Date: 2002/03/08 21:21:45 $  /

Rev.    :  3.0

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

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_forum_lib.inc';



// // ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
$BEREICH = 'INTERN';


$md     = GET_md(0);
$g_id       = GET_id("0");
$g_post_id  = GET_post_id("0");
$g_datum    = GET_datum("");
$g_betreff  = GET_betreff("");
$g_text     = GET_text("");
$g_next     = "";

$p_md = POST_md("");
$p_top_id   = POST_top_id("0");
$p_post_id  = POST_post_id("0");
$p_author   = POST_author("gast");
$p_datum    = POST_datum("");
$p_betreff  = POST_betreff("??");
$p_text     = POST_text("");
$p_user_id  = POST_user_id("0");


$daten  = GET_daten("");
$ID     = GET_SESSIONID("");

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

print_header("Interner Bereich");
print_body(2);

$foren_id = 4;   // Internes Forum

switch ($p_md):
  case 5:
  	$err = erf_thema($ID, $foren_id, $p_top_id, $p_post_id, $p_author, $p_datum, $p_betreff, $p_text, $p_user_id);
  //    $md = 2;
  break;
  case 6:
  	$err = upd_thema($p_id, $foren_id, $p_top_id, $p_post_id, $p_author, $p_datum, $p_betreff, $p_text, $p_user_id);
    //echo $md ;
  break;
  default:
  break;
endswitch;

switch ($md):
case 1:
	$menu = array (0=>array("icon" => "99","caption" => "FORUM","link" => ""),
	2=>array("icon" => "_tadd","caption" => "Neues Thema","link" => "$PHP_SELF?md=3&ID=$ID"),
	3=>array("icon" => "_stop","caption" => "Verlassen","link" => "larp.php?md=0&ID=$ID")
	);
	break;
case 2:
	$menu = array (0=>array("icon" => "99","caption" => "THEMA","link" => ""),
	//1=>array("icon" => "_stop","caption" => "THEMA","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück ","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 3:  // neues Themne
	$menu = array (0=>array("icon" => "99","caption" => "NEU","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 4:  // neue Antwort , ACHTUNG id kreuzverweis
	$menu = array (0=>array("icon" => "99","caption" => "NEU","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=2&ID=$ID&post_id= $g_post_id")
	);
	break;
case 5:
	$menu = array (0=>array("icon" => "99","caption" => "EDIT","link" => ""),
	3=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=2&ID=$ID&post_id= $g_post_id")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "FORUM","link" => ""),
	2=>array("icon" => "_add","caption" => "Neues Thema","link" => "$PHP_SELF?md=4&ID=$ID"),
	3=>array("icon" => "_stop","caption" => "Zurück","link" => "con_main.php?md=0&ID=$ID")
	);
	break;
	endswitch;

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
print_kopf($logo_typ,$header_typ,"INTERN",$anrede,$menu_item);
	
print_menu_status($menu);


switch ($md):
case 1:
	print_thema_liste($ID,$foren_id,$user);
	break;
case 2:
	$g_id = $g_post_id;
	print_thema($ID,$foren_id,$g_id,$user);
	break;
case 3:
	print_thema_erf($ID,$g_id, $foren_id, $g_post_id, $spieler_name, $g_datum, $g_betreff, $g_text, $user_id,$g_next,1);
  	break;
case 4:
	print_thema_erf($ID,$g_id, $foren_id, $g_post_id, $spieler_name, $g_datum, $g_betreff, $g_text, $user_id,$g_next,2);
	break;
case 5:
	print_thema_upd($ID,$g_id,2);
	break;
default:
	break;
	endswitch;

	//    print_md_ende();

	print_body_ende();
	?>