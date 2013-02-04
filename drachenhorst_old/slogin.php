<?php

/*
 Projekt : CONPLAN

Datei   :  $RCSfile: slogin.php,v $

Datum   :  $Date: 2002/05/03 20:23:41 $  /

Rev.    :  $Revision: 1.1 $   / 1.0

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

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];
$p_md = $_POST['md'];

$user   = $_POST[user];
$pw     = $_POST[pw];



if (checkuser($user,$pw) == "TRUE")
{
	$session_id = session_id();
	header ("Location: larp.php?md=0&ID=$session_id");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird. */
}
else
{

	header ("Location: main.php?md=0");
	/* Umleitung des Browsers
	 zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */

}


?>