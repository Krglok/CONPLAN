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

// DB-Verbindung
$DB_HOST='192.168.5.173';	// dies ist WICHTIG !!!!
$DB_NAME='db42039950';		//
$DB_USER='admin';			// Achtung user muss vorhanden sein und die rechte auf die DB haben
$DB_PASS='';				// !!
$TBL_USER='user_liste';		// Tabellname fuer die Userliste m, muss bestimmte Felder beinhalten
//$DB_INTERN='db42039950';	// Alternative DB not used !!!

// Default Session fuer Gäste
$session_id ="FFFF";

// allgemeine Konfigurationsparameter
$version = "3.0.0";
$grp_name="Drachenhorst";			// Refrenzname fuer Homepage

// Pfade die automatisch verwendet werden  ------------
$path_img 		= "./images";		// Dies sind die Content Bilder
//$bg_path  = './layout1/back/';    // wird entfernt, da nur noch layout pfade gueltig sind
$path_bilder	= "./BILDER/";		// Dies sind die Bilder der Bildgallerie und thumbnails
$path_thumbnail	= "./BILDER/thumb/";// Dies sind die thumbnails der Bildgallerie
$path_base		= "./BILDER/BASE/";	// Dies sind die Gruppenbilder der Bildgallerie
$path_download 	= "./download/";	// Hier sind die Downloads abgelegt
$path_char		= "./chars/";		// Hier werden charakter Bilder abgelegt, fuer Charakterverwaltung
$path_land		= "./land/";		// hier werden die Bilder fuer Laender und Karten abgelegt
$path_conplan	= "./conplan/";     // Hier werden die Bilder der Conplanung abgelegt
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

// Menu Icons
$menu_add 		= "_add.gif";		// Insert Datensatz
$menu_db 		= "_db.gif";		// db zugriff
$menu_del 		= "_del.gif";   	// delete Datensatz
$menu_edit 		= "_edit.gif";		// edit Datensatz
$menu_folder	= "_folder.gif";	// Weitere Menupage
$menu_help 		= "_help.gif";		// help page oder function
$menu_kalender 	= "_kalender.gif";	// kalender funktion
$menu_key 		= "_key.gif";		// login logo
$menu_list 		= "_list.gif";		// list page
$menu_page 		= "_page.gif";		// html seite oder einzal page
$menu_point 	= "_point.gif";		// einfacher punkt
$menu_printer 	= "_printer.gif";	// drucken
$menu_stop 		= "_stop.gif";		// zurück / back
$menu_text 		= "_text.gif";		// text page
$menu_tool 		= "_tool.GIF";		// tools
$menu_zip 		= "_zip.gif";		// download

//class, id Namen Basis Page
$css_konzept1 = "konzept1.css";

$style_div_1 = "id=\"div_1\"";
$style_page_1 = "id=\"page_1\"";
// horizontaler header oben in der seite
$style_header_1 = "id=\"header1\"";
$style_headerleft = "id=\"header1left\"";
$style_header1left_img = "id=\"header1left_img\"";
$style_header1main = "id=\"header1main\"";
$style_header1main_img = "id=\"header1main_img\"";
$style_header1right = "id=\"header1right\"";
$style_bereich_head = "id=\"#bereich_head\"";
// horizontale Statuszeuile unterhalb des Headers
$style_status1 = "id=\"status1\"";
$style_status_menu = "id=\"status_menu\"";
$style_status_menu_r = "id=\"status_menu_r\"";
$style_status_zurueck = "id=\"status_zurueck\"";
// vertikales Menu in eigenem div unterhalb des Headers und Status
$style_menu_tab1 = "id=\"menu_tab1\"";
$style_menu_head = "id=\"menu_head\"";
$style_menu_space = "id=\"menu_space\"";
$style_menu_folder = "id=\"menu_folder\"";
$style_menu_list = "id=\"menu_list\"";
$style_menu_page = "id=\"menu_page\"";
$style_menu_zurueck = "id=\"menu_zurueck\"";
$style_menu_folder_img = "id=\"menu_folder_img\"";
$style_menu_list_img = "id=\"menu_list_img\"";
$style_menu_page_img = "id=\"menu_page_img\"";
$style_menu_zurueck_img = "id=\"menu_zurueck_img\"";
$style_menu_link = "id=\"menu_link\"";
// datenbereich neben Menu , unterhalb des Headers
$style_datatab = "id=\"datatab\"";		// default layout fuer Datenbereich

//class, id Name datalist
$css_datalist = "datalist.css";
// Datenbereich fuer Datensatzliste
$style_datatab = "id=\"datatab\"";
$style_datatable = "id=\"datatable\"";

$style_datalist = "id=\"datalist\"";
// Datensatz counter ??
$style_data_list_count  = "id=\"data_list_count\"";
// Datensatz zeile
$style_datalist_tr = "id=\"datalist.tr\"";
//datensatz Headerzeile
$style_data_table_header  = "id=\"data_table_header\"";
// Edit spalte , link zur Detailseite
$style_data_table_edit = "id=\"data_table_edit\"";
// freie spalte zum ausgleich der festen breiten
$style_data_table_rest = "id=\"data_table_rest\"";
// Datensatz Zeile fuer Daten
$style_data_table_row = "id=\"data_table_row\"";
// Eingabe fuer Detailmaske, variable breite
$style_data_detail = "id=\"data_detail\"";
// Zeile fuer Detailmaske, pro Zeile ein datenfeld
$style_data_detail_row = "id=\"data_detail_row\"";
// textspalte ohne fuer Detailmaske, feste breite
$style_data_text = "id=\"data_text\"";


//class , id name Balkemnenu
$css_balkenmenu = "balkenmenu.css";
$style_balken_tab = "id=\"balken_tab\"";
$style_balken_menu1 = "id=\"balken_menu1\"";
$style_balken_menu2 = "id=\"balken_menu2\"";
$style_balken_menu_r = "id=\"balken_menu_r\"";
$style_balken_menu_img = "id=\"balken_menu_img\"";
$style_balken_data = "id=\"balken_data\"";
$style_balken_page = "id=\"balken_page\"";
$style_balken_page_h1 = "id=\"balken_page h1\"";
$style_balken_page_p = "id=\"balken_page p\"";


// Zugriffsrechte -------------------------------------
// ACHTUNG nicht aendern beinhaltet das Rechte system !!
$lvl_spieler = array(0=>256,1=>512,14=>3840);
$lvl_sl      = array(0=>16,1=>32,14=>240);
$lvl_admin   = array(0=>1,1=>2,14=>15);
$user_lvl = 3840;  // dies ist der Gastlevel

/**
 * Setzt die alten menutyp nummern in die neuen Menutyptexte um
 * Begrenzung auf die 9 standardtypen  , alle anderen werden auf 10 = _help umgesetzt  
 * Sonderfall 99 = _none, soll trennbalken erzeugen
 * @param unknown $typ
 * @return string|unknown
 */
function index2menutyp ($typ ) {
  global $menu_add,
  $menu_db, 
  $menu_del,
  $menu_edit,
  $menu_folder,
  $menu_help, 
  $menu_kalender,
  $menu_key, 	
  $menu_list, 	
  $menu_page, 	
  $menu_point, 	
  $menu_printer, 
  $menu_stop, 	
  $menu_text, 	
  $menu_tool, 	
  $menu_zip;
  
 switch ($typ) :
 case 99:
  return "_none";
  break;
 case 1:
  return $menu_folder;
  break;
 case 2:
  return $menu_add;
  break;
 case 3:
  return $menu_edit;
  break;
 case 4:
  return $menu_del;
  break;
 case 5:
  return $menu_list;
  break;
 case 6:
  return $menu_stop;
  break;
 case 7:
  return $menu_page;
  break;
 case 8:
  return $menu_printer;
  break;
 case 9:
  return $menu_db;
  break;
 default:
  return $menu_help;
 endswitch;

}

function print_status($wert)
{
  global $style_status1;
  echo "<p $style_status1>$wert </p> \n";
}

$PHP_SELF = $_SERVER['PHP_SELF'];


$menu_item_ich = array ("icon" => "7","caption" => "Ich","link" => "$PHP_SELF?md=2&daten=ich.html");
$menu_item_imp = array ("icon" => "10","caption" => "Impressum","link" => "$PHP_SELF?md=7&daten=impressum.html");

$menu_item_header = array("icon" => "99","caption" => "<B>Hauptseite</B>","link" => "");
$menu_item_default = array("icon" => "","caption" => "??","link" => "??");


$menu_default = array (
    0=>$menu_item_header,
    1=>$menu_item_default,
    10=>$menu_item_imp,
    11=>$menu_item_ich
);


?>
