<?
/*
 Projekt : CONPLAN

Datei   :

Datum   :  $date$  / 05.01.02

Rev.    :   $rev$   / 1.0

Author  :  $author$  / duda

Beschreibung :

Diese Datei definiert die BAsisdaten für die Anwendung

- DB-Verbindung
- automatische Pfade
- globale Variablen


$LOG$
*/

// DB-Verbindung
//$DB_HOST='192.168.5.173';
$DB_HOST='db77.puretec.de';
$DB_NAME='db42039950';
//$DB_USER='admin';
$DB_USER='p6951176';
//$DB_PASS='';
$DB_PASS='3b5AWVyS';
$TBL_USER='user_liste';
$DB_INTERN='db42039950';

$session_id ="FFFF";

// Pfade die automatisch verwendet werden  ------------
$img_path = 'images';
$bg_path  = 'back/';
$pic_path  = 'bilder';

// globale Variablen  ---------------------------------
$bg_pic    = 'back_green.jpg';     // grünes Hintergrund bild
$bg_color  = '$000000';            // sollte auf Hintergrundbild abgestimmt sein
$tx_color  = 'yellow';             // sollte mit BG_pic abgestimmt sein

// Zugriffsrechte -------------------------------------
$lvl_spieler = array(0=>256,1=>512,14=>3840);
$lvl_sl      = array(0=>16,1=>32,14=>240);
$lvl_admin   = array(0=>1,1=>2,14=>15);

$user_lvl = 3840;

?>
