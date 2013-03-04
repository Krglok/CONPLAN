<?php

/*
 Projekt : CONPLAN

Datei   :  $RCSfile: slogin.php,v $

Datum   :  $Date: 2002/05/03 20:23:41 $  /

Rev.    :  3.0

Author  :  $Author: windu $  / duda

beschreibung :  Der script erzeugt den Übergang in den
internen PHP Bereich.
Es ist eine automatische Weiterleitunhg.

KEINE  Ausgaben  erlaubt !!!!!!!!!


$Log: slogin.php,v $
Revision 1.1  2002/05/03 20:23:41  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.2  2002/02/26 18:42:41  windu
keyword aktiviert

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.
Das Session managment wird modifiziert um es sicherer zu machen.

*/

include_once "_config.inc";
include_once "_login.inc";
include_once "_log_lib.inc";
//include "_lib.inc";
//include "_head.inc";


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist


$user   = POST_user("user");
$pw     = POST_pw();

$md    =GET_md(0);
$daten =GET_daten("");
$sub   =GET_sub("main");
$item  =GET_item("main");
$ID    =GET_SESSIONID("0");



// Holt User daten aus der Datenbank und startet die session
if (checkuser($user,$pw) == TRUE)
{
//    session_id($ip);
	$session_id =  session_id();  // die Session ID
	$SID        = $_SESSION["ID"];
    $text = $PHP_SELF."?md=$md&daten=$daten&user=$user&pw=$pw : checkuser TRUE : ID=$SID ";
    log_write_info($text);
	//	echo "check TRUE";
    header ("Location: larp.php?md=0&ID=$SID");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird. */
} else
{
//    echo $ID."/".$SID;
    $text = $PHP_SELF."?md=$md&daten=$daten&user=$user&pw=$pw : checkuser FALSE  : ID=$SID ";
    log_write_error($text);
    header ("Location: main.php?md=2&daten=slogin.html");
	/* Umleitung des Browsers
	 zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */

}


?>