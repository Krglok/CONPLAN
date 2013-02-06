<?
/*
 Projekt : CONPLAN

Datei   :

Datum   :  $date$  / 05.01.02

Rev.    :   $rev$   / 3.0

Author  :  $author$  / krglok

Beschreibung :

Diese Datei definiert die BAsisdaten für die Anwendung

- DB-Verbindung
- automatische Pfade
- globale Variablen

VER 3.0
Ver 3.0
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

Die config-variablen werden erweitert. 

$LOG$
*/

// DB-Verbindung
$DB_HOST='192.168.5.173';
$DB_NAME='db42039950';
$DB_USER='admin';
$DB_PASS='';
$TBL_USER='user_liste';
$DB_INTERN='db42039950';

$session_id ="FFFF";

$grp_name="Drachenhorst";			// Refrenzname fuer omepage
// Pfade die automatisch verwendet werden  ------------
$img_path = './images';
//$bg_path  = './layout1/back/';    // wird entfernt, da nur noch layout pfade gueltig sind
$pic_path  = './BILDER';
$layout_path = "./layout";			// css-dateien
$layoutButton_path = "/button/";	// buttons fuer das layout
$layoutImages_path = "/images/";	// images fuer das layout
$layoutBack_path = "/back/";		// backgrnd images fuer das layout

$loginRef = "http://www.drachen-horst.de/main.php?md=2&daten=slogin.html";

// globale Variablen  ---------------------------------
$bg_pic    = 'back.jpg';     	  // default Hintergrund bild
$bg_color  = 'silver';            // sollte auf Hintergrundbild abgestimmt sein
$tx_color  = 'black';             // default Textfarbe sollte mit BG_pic abgestimmt sein

// Zugriffsrechte -------------------------------------
$lvl_spieler = array(0=>256,1=>512,14=>3840);
$lvl_sl      = array(0=>16,1=>32,14=>240);
$lvl_admin   = array(0=>1,1=>2,14=>15);

$user_lvl = 3840;

?>
