<?php

/*
 Projekt :  BIBLIOTHEK

Datei   :  bib_lib.inc

Datum   :  2008/07/11

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Enthält allgemiengültige Funktionen
Für alle Bereiche
BIBLIOTHEK



function get_bib_bereich($id)

*/


/*
 Holt den Bereichnamen  zu einer bereich_id
aus der Bibliothek Bereich Tabelle
*/
function get_bib_bereichname($id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select bereich_name from bib_bereich where id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	mysql_close($db);
	return $row1[0];
};

/*
 Holt den Bereich Kennzeichner zu einer bereich_id
aus der Bibliothek Bereich Tabelle
*/
function get_bib_bereich($id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select bereich from bib_bereich where id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	mysql_close($db);
	return $row1[0];
};

/*
 Holt das Zugriffsrecht (public/privat/protect) fuer eine bereich_id
aus der Bibliothek Zugriffs Tabelle
*/
function get_bib_zugriff($id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select bib_zugriff from bib_zugriff where bereich_id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	mysql_close($db);
	return $row1[0];
};

/*
 Holt das Schreibrecht (read/write) fuer eine bereich_id
aus der Bibliothek Zugriffs Tabelle
*/
function get_bib_recht($id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select bib_recht from bib_zugriff where bereich_id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	mysql_close($db);
	return $row1[0];
};





?>