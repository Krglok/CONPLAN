<?php
/*
 Projekt : CONPLAN

Datei   :

Datum   :  $date$  / 03.02.2013

Rev.    :  $rev$   / 3.0

Author  :  $author$  / krglok

Beschreibung :
Diese Datei definiert die BAsisdaten für die Anwendung
- DB-Verbindung
- automatische Pfade
- globale Variablen

Ver 3.0
Es werden CSS-Dateien verwendet.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

ACHTUNG!! Die php-Skripte muessen alle im Basis verzeichnis sein, sonst stimmt die
Verzeichnus logik nicht !!

Die config-variablen werden erweitert.
Variable fuer die Layoutpfade
Variable fuer die Styletypen
$LOG$
*/

include_once '_db.inc';

// Default Session fuer Gäste
$session_id ="FFFF";    // die Default Einstellung fuehrt zu einem Fehler
                        // die Session muss im Hauptprogramm initialisiert werden session_start($ID)

// allgemeine Konfigurationsparameter
$version = "3.0.0";
$grp_name="Drachenhorst";			// Refrenzname fuer Homepage
//$path_conplan	= "./conplan/";     // Hier werden die Bilder der Conplanung abgelegt
$php_main   ="main.php";
$php_admin  ="admin_main.php";
$php_subsl  ="larp.php";
$php_sl     ="con_main.php";
$php_author ="larp.php";
$php_intern ="larp.php";
//automtische initialisierung des parent
$parent = GET_parent("");

function get_parentlink()
{
	global $parent;
	global $PHP_SELF;
	
  if($parent == "")
  {
  	$parent = $PHP_SELF;
  }
	return "&amp;parent=".$parent;
}

// Pfade die automatisch verwendet werden  ------------
$path_img 		= "./images";		// Dies sind die Content Bilder
//$bg_path  = './layout1/back/';    // wird entfernt, da nur noch layout pfade gueltig sind
$path_bilder	= "./BILDER/";		// Dies sind die Bilder der Bildgallerie und thumbnails
$path_thumbnail	= "./BILDER/thumb/";// Dies sind die thumbnails der Bildgallerie
$path_base		= "./BILDER/BASE/";	// Dies sind die Gruppenbilder der Bildgallerie
$path_download 	= "./download/";	// Hier sind die Downloads abgelegt
$path_char		= "./chars/";		// Hier werden charakter Bilder abgelegt, fuer Charakterverwaltung
$path_land		= "./land/";		// hier werden die Bilder fuer Laender und Karten abgelegt
$path_html		= "./pages/";		// Hier werden die embeded html.pages abgelegt
$path_regeln	= "./regeln/";      // Hier werden ide regeln.html, regeln.images abgelegt

// Layout pfade
$layout_path = "layout";			// css-dateien
$layoutButton_path = "./layout/button/";	// buttons fuer das layout
$layoutImages_path = "./layout/images/";	// images fuer das layout
$layoutBack_path = "./layout/back/";		// backgrnd images fuer das layout


// pfad fuer die Login Seite wird mehrfach gebraucht und soll konfigurierbar sein
// md = der menupunkt unter den der Login erreichbar ist
// daten = die html-seite , die das Formular enthält
$loginRef = "http://www.drachen-horst.de/main.php?md=2&daten=slogin.html";

// globale Variablen  ---------------------------------
$background_pic    = "back.jpg";     	  // default Hintergrund bild
$background_color  = "silver";            // sollte auf Hintergrundbild abgestimmt sein
$text_color  = "black";             // default Textfarbe sollte mit BG_pic abgestimmt sein

// Header images
$logo_typ = "logo.gif";
$header_typ = "drachenhorst.gif";
$admin_typ = "mag_drag_s.gif";

$anrede = array("formel"=>"Sei gegrüsst Freund","name"=>"Gast");

// Menu Icons, die Icons muesse GIF sein !!!!
$menu_add 		= "_add";		// Insert Datensatz
$menu_db 		  = "_db";		// db zugriff
$menu_del 		= "_del";   	// delete Datensatz
$menu_edit 		= "_edit";		// edit Datensatz
$menu_folder	= "_folder";	// Weitere Menupage
$menu_help 		= "_help";		// help page oder function
$menu_kalender 	= "_kalender";	// kalender funktion
$menu_key 		= "_key";		// login logo
$menu_list 		= "_list";		// list page
$menu_page 		= "_page";		// html seite oder einzal page
$menu_point 	= "_point";		// einfacher punkt
$menu_printer 	= "_printer";	// drucken
$menu_stop 		= "_stop";		// zurück / back
$menu_text 		= "_text";		// text page
$menu_tool 		= "_tool";		// tools
$menu_zip 		= "_zip";		// download

//class, id Namen Basis Page
$css_konzept1 = "konzept1.css";

$style_page_1 = "id=\"page\"";
// horizontaler header oben in der seite
$style_header_1 = "id=\"headertab\"";
$style_headerleft = "id=\"headertableft\"";
$style_headermain = "id=\"headertabmidle\"";
$style_headerright = "id=\"headertabright\"";
// horizontale Statuszeile unterhalb des Headers
$style_status1 = "id=\"status\"";
$style_status_menu = "id=\"statusmenu\"";
$style_status_menu_r = "id=\"statusmenur\"";
// vertikales Menu in eigenem div unterhalb des Headers und Status
$style_menu_tab1 = "id=\"menu\"";
$style_menu_head = "id=\"menuheader\"";
$style_menu_item = "id=\"menuitem\"";
// datenbereich neben Menu , unterhalb des Headers
$css_datalist = "datalist.css";
// Datenbereich fuer Datensatzliste
$style_datatab = "id=\"datatab\"";
$style_datatable = "id=\"datatable\"";
// Datensatz counter ??
$style_data_list_count  = "id=\"data_list_count\"";
//Datensatzlisten im Datenbereich
$style_datalist = "id=\"datalist\"";
// Eingabe fuer Detailmaske, variable breite
$style_data_detail = "id=\"data_detail\"";
// textspalte ohne fuer Detailmaske, feste breite
$style_data_text = "id=\"data_text\"";


// Zugriffsrechte -------------------------------------
// ACHTUNG nicht aendern beinhaltet das Rechte system !!
define("lvl_public",512);
define("lvl_user",511);
define("lvl_author",255);
define("lvl_subsl",63);
define("lvl_sl",15);
define("lvl_admin",3);

define("itemtyp_link",0);
define("itemtyp_pages",1);
define("itemtyp_daten",2);

function GET_md ($value = 0) 
{
	if (isset($_GET['md'])==true)
	{
		return $_GET['md'];
	}
	return $value;
}

function GET_daten($value = "")
{
	if (isset($_GET['daten'])==true)
	{
		return $_GET['daten'];
	}
	return $value;
}

function GET_id($value = -1)
{
	if (isset($_GET['id'])==true)
	{
		return $_GET['id'];
	}
	return $value;
}

function GET_item($value = "")
{
	if (isset($_GET['item'])==true)
	{
		return $_GET['item'];
	}
	return $value;
}

function GET_sub($value = "main")
{
	if (isset($_GET['sub'])==true)
	{
		return $_GET['sub'];
	}
	return $value;
}

function GET_TAG($value = "0")
{
  if (isset($_GET['TAG'])==true)
  {
    return $_GET['TAG'];
  }
  return $value;
}

function GET_LISTE($value = "0")
{
  if (isset($_GET['LISTE'])==true)
  {
    return $_GET['LISTE'];
  }
  return $value;
}



function GET_post_id($value = "0")
{
  if (isset($_GET['post_id'])==true)
  {
    return $_GET['post_id'];
  }
  return $value;
}

// function GET_author($value="gast")
// {
//   if (isset($_GET['author'])==true)
//   {
//     return $_GET['author'];
//   }
//   return $value;
// }


function GET_datum($value="0")
{
  if (isset($_GET['datum'])==true)
  {
    return $_GET['datum'];
  }
  $today = getdate();
  $value = $today["year"]."-".$today["mon"]."-".$today["mday"];
  return $value;
}

function GET_betreff($value="")
{
  if (isset($_GET['betreff'])==true)
  {
    return $_GET['betreff'];
  }
  return $value;
}

function GET_text($value="")
{
  if (isset($_GET['text'])==true)
  {
    return $_GET['text'];
  }
  return $value;
}


function GET_KAP($value="")
{
  if (isset($_GET['KAP'])==true)
  {
    return $_GET['KAP'];
  }
  return $value;
}


function GET_grp($value="")
{
  if (isset($_GET['grp'])==true)
  {
    return $_GET['grp'];
  }
  return $value;
}

function GET_sc($value="")
{
	if (isset($_GET['sc'])==true)
	{
		return $_GET['sc'];
	}
	return $value;
}


function GET_parent($value="")
{
	if (isset($_GET['parent'])==true)
	{
		return $_GET['parent'];
	}
	return $value;
}


function GET_SESSIONID($value = "")
{
	if (isset($_GET['ID'])==true)
	{
		return $_GET['ID'];
	}
	return $value;
}

function POST_md($value=0)
{
	if (isset($_POST['md'])==true)
	{
		return $_POST['md'];
	}
	return $value;
}

function POST_id($value=0)
{
	if (isset($_POST['id'])==true)
	{
		return $_POST['id'];
	}
	return $value;
}

function POST_row($value=0)
{
	if (isset($_POST['row'])==true)
	{
		return $_POST['row'];
	}
	return $value;
}

function POST_top_id($value = "0")
{  if (isset($_POST['top_id'])==true)
{
  return $_POST['top_id'];
}
return $value;
}

function POST_post_id($value="0")
{
  if (isset($_POST['post_id'])==true)
  {
    return $_POST['post_id'];
  }
  return $value;
}

function POST_author($value="gast")
{
  if (isset($_POST['author'])==true)
  {
    return $_POST['author'];
  }
  return $value;
}


function POST_datum($value="0")
{
  if (isset($_POST['datum'])==true)
  {
    return $_POST['datum'];
  }
  $today = getdate();
  $value = $today["year"]."-".$today["mon"]."-".$today["mday"];
  return $value;
}

function POST_betreff($value="")
{
  if (isset($_POST['betreff'])==true)
  {
    return $_POST['betreff'];
  }
  return $value;
}

function POST_text($value="")
{
  if (isset($_POST['text'])==true)
  {
    return $_POST['text'];
  }
  return $value;
}

function POST_user_id($value="")
{
  if (isset($_POST['user_id'])==true)
  {
    return $_POST['user_id'];
  }
  return $value;
}


/**
 * Schreibt einfachen text mit dem Style_status1
 * @param unknown $wert
 */
function print_status($wert)
{
  global $style_status1;
  echo "<p $style_status1>$wert </p> \n";
}

/**
 * prueft $text auf <"> und ersetzt es durch <blank>
 * die funktion wird benoetigt im SQL string zu formatieren
 * @param unknown $text
 */
function sql_textcheck($text)
{
  $char=chr(9);
  $text=str_replace($char," ",$text);
  $char="\"";
  return str_replace($char," ",$text);
}

function get_script_name($PHP_SELF)
{
  $len = strlen($PHP_SELF);
  return substr($PHP_SELF,strrpos($PHP_SELF,"/")+1,$len);
}

$PHP_SELF = $_SERVER['PHP_SELF'];  // Globale Variable fuer den Scriptnamen
$help_name = get_script_name($PHP_SELF);
$help_link = "help_view.php?md=0&item=$help_name";
$ID="";  // default wert fuer Session ID
$menu_item_header = array ("icon" => "1", "caption" => "Default","link" => "","itemtyp"=>"0");
$menu_item_pages = array ("icon" => "1", "caption" => "Pages","link" => "","itemtyp"=>"0");
$menu_item_help = array ("icon" => $menu_help, "caption" => "Hilfe","link" => "javascript:openHelp('$help_link')","itemtyp"=>"0");
$menu_item_ich 	= array ("icon" => "$menu_page","caption" => "Ich","link" => "ich.html","itemtyp"=>"2");
$menu_item_imp 	= array ("icon" => "$menu_help","caption" => "Impressum","link" => "impressum.html","itemtyp"=>"2");
$menu_item_login= array ("icon" => "$menu_key","caption" => "Innerer Zirkel","link" => "slogin.html","itemtyp"=>"2");
$menu_item_default = array("icon" => $menu_stop,"caption" => "Zurück","link" => "$php_main?md=0","itemtyp"=>"0");
//$menu_item = array("icon" => "","caption" => "??","link" => "??","itemtyp"=>0);
$menu_items = array(99=>$menu_item_default);

/**
   default menu fuer main bereich
 */
$menu_default = array (
		0=>$menu_item_header,
		34=>$menu_item_default
);


/**
	Default Menu fuer die main.php
 */
$menu_default_main = array (
    0=>$menu_item_header,
    35=>$menu_item_imp,
    36=>$menu_item_ich
);

/**
	Default Menu fuer main_pages, wird benutzt wenn kein Menue in der Menutabelle vorhanden ist
 */
$menu_default_pages = array (
		0=>$menu_item_pages,
		34=>$menu_item_default
);

$menu_bereich = array("PK"=>0, "bereich"=>"","titel"=>"","lvl"=>0);
$menu_bereiche = array("PUBLIC"=>$menu_bereich, "SL"=>$menu_bereich, "AUTHOR"=>$menu_bereich, "ADMIN"=>$menu_bereich);

$menu_sub = array("ID"=>0, "ref_bereich"=>0, "sub"=>"", "titel"=>"", "html"=>"", "images"=>"");
$menu_sub_bereich = array(0=>$menu_sub);



?>
