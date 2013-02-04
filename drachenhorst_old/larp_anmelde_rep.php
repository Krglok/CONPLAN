<?php
/*
 Projekt : LARP

Datei   :  anmelde_rep.php

Datum   :  $Date: 2002/05/30 07:21:50 $  / 05.02.02

Rev.    :   $Rev$   / 1.0

Author  :  $Author: windu $  / duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Datensätze
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

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
include "login.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_liste($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=600 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td colspan=4>\n";
	echo "<B>ANMELDUNG für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch($i):
		case 0:
			echo "\t<td width=40><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
		break;
		case 2:
			echo "\t<td width=50><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
		case 3:
			echo "\t<td width=50><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
		case 4:
			echo "\t<td width=50><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
		case 5:
			echo "\t<td width=50><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
		case 6:
			echo "\t<td width=40><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
		default:
			echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
			break;
			endswitch;
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		};
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function print_alpha($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" order by name";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=600 BGCOLOR=\"\">\n";
	echo "<tr >\n";
	echo "<td WIDTH=\"50\">\n";
	echo "</td>\n";
	echo "<td colspan=4>\n";
	echo "<B>ALPHABETISCH für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	echo "<td WIDTH=\"50\">\n";
	echo "</td>\n";

	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch($i):
		case 0:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
		break;
		case 2:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 3:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 4:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 5:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 6:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	echo "</tr>\n";
	echo "<td WIDTH=\"50\">\n";
	echo "</td>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		echo "<td WIDTH=\"50\">\n";
		echo "</td>\n";
		for ($i=0; $i<$field_num-1; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		};
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle
};

//-----------------------------------------------------------------------------
function print_nsc($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" AND nsc=\"1\" order by nsc";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=650 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td colspan=4>\n";
	echo "<B>NSC-Liste für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch($i):
		case 0:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
		break;
		case 2:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 3:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 4:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 5:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 6:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	echo "\t<td width=120><b>Rolle</b></td>\n";
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		};
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "\t<td width=120><b>.</b></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function print_scl($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" AND nsc<>\"1\" order by nsc";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=650 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td colspan=4>\n";
	echo "<B>SC-Liste für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch($i):
		case 0:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
		break;
		case 2:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 3:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 4:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 5:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 6:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	echo "\t<td width=120><b>Rolle</b></td>\n";
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		};
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "\t<td width=120><b>.</b></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function print_checkin($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" order by nsc";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "Jeder in der Spielerliste eingetragene Spieler muss die Umlage bezahlen !\n";
	echo "<table border=1 width=600 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td colspan=3>\n";
	echo "<B>ANMELDUNG für TAG $TAG \n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "17,5 EUR \n";
	echo "</td>\n";
	echo "<td>\n";
	echo " 5 EUR \n";
	echo "</td>\n";
	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch($i):
		case 0:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
		break;
		case 2:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 3:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 4:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 5:
			echo "\t<td width=50><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		case 6:
			echo "\t<td width=40><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
		default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	echo "\t<td width=60><b>Chekin</b></td>\n";
	echo "\t<td width=60><b>Umlage</b></td>\n";
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		};
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "<td>\n";
		echo ".\n";
		echo "</td>\n";
		echo "<td>\n";
		echo ".\n";
		echo "</td>\n";
		echo "<tr>";
	}
	echo "<tr>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b><HR></b></td>\n";
	echo "\t<td ><b><HR></b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b>Chekin </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b>Summe</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b>Umlagen </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b>Summe</b></td>\n";
	echo "\t<td ><b> </b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function print_abrech($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select tag,name,abwasch,taverne,wc,nsc,aufbau,orga from $TABLE where tag=\"$TAG\" order by nsc";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 width=600 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td width=200 >\n";
	echo "<B>ABRECHNUNG für TAG $TAG \n";
	echo "</td>\n";
	echo "<td width=60>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td width=100>\n";
	echo "</td>\n";
	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "<td width=60>\n";
	echo "Anzahl \n";
	echo "</td>\n";
	echo "<td>\n";
	echo "Kosten \n";
	echo "</td>\n";
	echo "\t<td ><b>Einnahmen</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Angemeldete Spieler<b></td>\n";
	echo "\t<td ><b></b>$anzahl</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Anwesende Spieler</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b></b>17,5 EUR/Person</td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b><HR></b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "<td width=60>\n";
	echo "Anzahl \n";
	echo "</td>\n";
	echo "<td>\n";
	echo "Kosten \n";
	echo "</td>\n";
	echo "\t<td ><b>Ausgaben</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Platzkosten</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b></b>2,5 EUR/Person</td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Cola</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Bier</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>ABS</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Wasser</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Saft</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Fleisch</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Würste</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Salate</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Grillkohle</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Krautsalat</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Köfte</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Fladenbrot</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Brot</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>Auflage</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b><HR></b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>Summe Ausgaben</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b><HR></b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b></b></td>\n";
	echo "\t<td ><b>Überschuss</b></td>\n";
	echo "\t<td ><b>.</b></td>\n";
	echo "</tr>\n";

	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$g_md = $_GET['md'];
$g_id = $_GET['id'];

$p_md = $_POST['md'];
$p_row = $_POST['row'];

$ID = $_GET['ID'];


session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];

if ($ID == "")
{
	$session_id = 'FFFF';
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}


if (getuser($user,$pw) != "TRUE")
{
	$session_id = 'FFFF';
	//  echo "ID:$session_id ";
	chdir("..");
	//  Bei fehlendem oder falscher Rechten ins ROOT HTML
	header ("Location: ../larp.html");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
}
else
{
	// Prüfung des Zugriffsrecht über Lvl
	//
	if ($user_lvl <= $lvL_sl[14])
	{
		header ("Location: ../larp.html");  /* Umleitung des Browsers
		zur PHP-Web-Seite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
};

$TAG   = get_akttag();
$TABLE = "con_anmeldung";
$TABLE1= "con_tage";

print_header("Con Anmeldung");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Con Anmeldung Reports","Sei gegrüsst $spieler_name ");


//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();

switch ($g_md):
case 0:
	$menu = array (0=>array("icon" => "99","caption" => "ANMELDE-LISTEN","link" => ""),
			1=>array("icon" => "5","caption" => "Alphabet","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG"),
			2=>array("icon" => "5","caption" => "NSC","link" => "$PHP_SELF?md=2&ID=$ID&TAG=$TAG"),
			3=>array("icon" => "5","caption" => "SC","link" => "$PHP_SELF?md=3&ID=$ID&TAG=$TAG"),
			4=>array("icon" => "5","caption" => "Checkin ","link" => "$PHP_SELF?md=4&ID=$ID"),
			5=>array("icon" => "5","caption" => "Abrechnung","link" => "$PHP_SELF?md=5&ID=$ID&TAG=$TAG"),
			9=>array("icon" => "6","caption" => "Zurück","link" => "larp_anmelde_liste.php?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 1: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ALPHABET","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "NSC","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 3: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "Checkin","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;

default:  // MAIN-Menu
	endswitch;


	//echo $TAG;

	switch ($g_md):
case 1:
		//
		print_menu($menu);
	print_alpha($user);
	break;
case 2:
	print_menu($menu);
	print_nsc($g_id, $user);
	break;
case 3:
	print_menu($menu);
	print_scl($g_id, $user);
	break;
case 4:
	//
	print_menu($menu);
	print_checkin($g_id, $user);
	break;
case 5:
	//
	print_menu($menu);
	print_abrech($g_id, $user);
	break;
default:
	print_menu($menu);
	print_liste($user);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>