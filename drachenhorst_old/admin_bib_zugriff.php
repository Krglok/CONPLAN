<?php
/*
 Projekt :  ADMIN

Datei   :  admin_bib_zugriff.php

Datum   :  2002/06/08

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <con_konst>
- Anzege der aktuellen SL-Zugriffe
- Efassen neuer Datensätze (SL-Zugriff)
- Bearbeiten vorhandener Datensätze (aktueller Con)
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes (SL-Zugriff)

Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.

Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

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
include "bib_lib.inc";

//-----------------------------------------------------------------------------
function print_liste($ID,$select)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$felder = " * ";
	$where  = "  ";
	switch ($select) :
	case 1:
		$order  = "order by bereich_id,user_id,bib_zugriff";
	break;
	case 2:
		$order  = "order by user_id,bereich_id,bib_zugriff";
		break;
	default :
		$order = "";
		break;
		endswitch;


		$q = "select $TABLE.*,bib_bereich.bereich,bib_bereich.bereich_name,spieler.name,spieler.vorname from $TABLE "
		." left outer join bib_bereich on bib_bereich.id=$TABLE.bereich_id "
		." left outer join user_liste on user_liste.id=$TABLE.user_id "
		." left outer join spieler on spieler.id=user_liste.spieler_id "
				.$order;

		$result = mysql_query($q)  or die("Query Fehler:".$q);


		mysql_close($db);


		echo "  <TD\n>"; //Daten bereich der Gesamttabelle
		echo "<table border=1 BGCOLOR=\"\">\n";

		echo "<tr>\n";
		$field_num = mysql_num_fields($result);
		for ($i=0; $i<$field_num-4; $i++)
		{
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
		echo "</tr>\n";
		echo "<hr>\n";
		//Liste der Datensätze
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
					echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
					print_menu_icon (9);
					echo "\t</a></td>\n";
				} else
				{
					switch ($i) :
					case 1 :
						echo "\t<td>$row[1] $row[5]&nbsp;$row[6]</td>\n";
					break;
					case 2:
						echo "\t<td>$row[2] $row[7],&nbsp;$row[8]</td>\n";
						break;
					case 3:
						echo "\t<td>$row[$i]&nbsp;</td>\n";
						break;
					case 4:
						echo "\t<td>$row[$i]&nbsp;</td>\n";
						break;
					default :
						break;
						endswitch;
				};
			}
			echo "<tr>";
		}
		echo "</table>";
		echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$felder = " * ";
	$where  = "  ";
	$order  = "order by user_id,bereich_id,bib_zugriff";


	$q = "select $TABLE.*,bib_bereich.bereich,bib_bereich.bereich_name,spieler.name,spieler.vorname from $TABLE "
	." left outer join bib_bereich on bib_bereich.id=$TABLE.bereich_id "
	." left outer join user_liste on user_liste.id=$TABLE.user_id "
	." left outer join spieler on spieler.id=user_liste.spieler_id "
			.$order;

	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	//lfdnr,name,vorname,orga}
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
				print_menu_icon (4);
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_info($id,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;

	//Anzeigen von Contage als einfache Maske
	//function view() {

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler...");

	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	mysql_close($db);

	//Daten bereich
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name($result,$i);
		$type[$i]       =  mysql_field_type ($result, $i);
	}
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($type[$i]!="blob")
		{
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
			//        echo "\t<td width=100>$type[$i]&nbsp;</td>\n";
			echo "<tr>";
		} else
		{
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=50 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
		}
	}
	echo "</table>";
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};


function insert($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="insert INTO  $TABLE  (";
	$q = $q."$field_name[1]";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]";
	};

	$q = $q.") VALUES (\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",\"$row[$i]\" ";
	};
	$q = $q.")";
	//  echo $q;

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	//  $q ="insert INTO con_tage (tag,von,bis,bemerkung,kosten,leg_id,text) VALUES ( \"$tag\",\"$von\",\"$bis\",\"$bemerkung\",\"$kosten\",\"$leg_id\",\"$text\"";
	$result = mysql_query($q) or die("InsertFehler....$q.");

	mysql_close($db);

};


function update($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="update $TABLE  SET ";
	$q = $q."$field_name[1]=\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]=\"$row[$i]\" ";
	};
	$q = $q."where id=\"$row[0]\" ";

	//  echo $q;
	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$result = mysql_query($q) or die("update Fehler....$q.");
	/**/
	mysql_close($db);

};


function loeschen($id,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)     or die("Fehler beim verbinden!");

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$q = "delete from $TABLE where id=\"$id\" ";
	//  echo $q;
	$result = mysql_query($q) or die("Delete Fehler....$q.");
	/**/
	mysql_close($db);

};

function print_maske($id,$ID,$next,$erf,$ref1_id, $ref2_id)
{
	//
	//  $id   beinhaltet den zu bearbeitenden Datensatz
	//  $ID beinhaltet den User des Programms (authetifizierung)
	//  $next beinhaltet die nächste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//  $ref1_id  PK des Bereiches
	//  $ref2_id  PK des Users
	//
	// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
	//
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;

	//Anzeigen von Contage als einfache Maske
	//function view() {
	if ($erf == 0 )
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
		$ref1_id = $row[1];    // vorbesetzen  der ref_id BEREICH
		$ref2_id = $row[2];    // vorbesetzen  der ref_id BEREICH
	} else
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");


		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);

		$row[1] = $ref1_id;    // vorbesetzen  der ref_id BEREICH
		$row[2] = $ref2_id;    // vorbesetzen  der ref_id BEREICH
		$row[3] = "public";    // vorbelgter Wert
		$row[4] = "read";      // vorbelgter Wert
	}
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";

	echo "<TABLE WIDTH=\"500\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t<td><center><b>$TABLE</b></td>\n";
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);

	}
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($i==0)
		{
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input readonly  type=\"text\" name=\"row[$i]\" SIZE=\"5\" MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
			echo "</tr>";
		}
		else
		{
			switch($i) :
			case 1 :
				echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input readonly  type=\"text\" name=\"row[$i]\" SIZE=\"5\" MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">\n";
			echo get_bib_bereich($ref1_id);
			echo "\t</td>";
			echo "</tr>";
			break;
			case 2 :
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input readonly  type=\"text\" name=\"row[$i]\" SIZE=\"5\" MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">\n";
				echo get_spieler(get_spieler_id($ref2_id));
				echo "\t</td>";
				echo "</tr>";
				break;
			case 3 :
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td>\n";
				echo "\t<select name=\"row[$i]\"  MAXLENGTH=25 >\n";
				echo "\t<option selected> $row[$i]\n";
				echo "\t<option value=\"public\">  PUBLIC\n";
				echo "\t<option value=\"privat\">  PRIVAT\n";
				echo "\t<option value=\"protect\">  PROTECT\n";
				echo "\t</select> \n";
				echo "\t</td>";
				echo "</tr>";
				break;
			case 4 :
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td>\n";
				echo "\t<select name=\"row[$i]\"  MAXLENGTH=25 >\n";
				echo "\t<option selected> $row[$i]\n";
				echo "\t<option value=\"read\">  read\n";
				echo "\t<option value=\"write\">  write\n";
				echo "\t</select> \n";
				echo "\t</td>";
				echo "</tr>";
				break;
			case 4 :
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td>\n";
				echo "\t<select name=\"row[$i]\" MAXLENGTH=25 >\n";
				echo "\t<option selected> $row[$i]\n";
				echo "\t</select> \n";
				echo "\t</td>";
				echo "</tr>";
				break;
			default:
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
				echo "</tr>";
				break;
				endswitch;
				//          echo "<tr>";
				//          echo "\t<td><b></b></td>\n";
				//          echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=70 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				//          echo "<tr>";
		}
	}


	echo "\t<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "\t</tr>\n";

	echo "</table>";
	echo "  </TD\n>"; //ENDE  Datenbereich der Gesamttabelle

};


function print_Ref1($ID,$next)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from bib_bereich order by bereich";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	echo "BEREICHE\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Datenfelder
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=$next&ID=$ID&ref1_id=$row[0]\">\n";
				print_menu_icon (11,"Auswahl");
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_Ref2($ID,$next,$ref1_id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select s.id,s.name,s.vorname,u.username,u.id from spieler as s, user_liste as u where s.id=u.spieler_id order by s.name, s.vorname";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table width=\"400\"border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	echo "Bereich : ".get_bib_bereich($ref1_id);
	echo "</tr>";

	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=$next&ID=$ID&ref2_id=$row[4]&ref1_id=$ref1_id\">\n";
				print_menu_icon (11);
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "</tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];
$ref1_id = $_GET['ref1_id'];
$ref2_id = $_GET['ref2_id'];


session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];
$user_id 		= $_SESSION[user_id];

if ($ID == "")
{
	$session_id = 'FFFF';
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

if (getuser($user,$pw) != "TRUE")
{
	header ("Location: main.php");  // Umleitung des Browsers
	//       zur PHP-Web-Seite.
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}
else
{
	$l1 = (int) $user_lvl;
	$l2 = (int) $lvl_admin[14];
	if ($l1 >= $l2)
	{
		header ("Location: main.php?md=0");  /* Umleitung des Browsers
		zur HTML-StartSeite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Admin Bereich","Sei gegrüsst Meister ");


echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id / ref1_id : $ref1_id / ref2_id : $ref2_id";


$TABLE = "bib_zugriff";

print_md();

switch ($p_md):
case 5: // Anlegen eines neuen des DAtensatzes
	//  Insert SQL
	insert($p_row);
$md=0;
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	$md=0;
	break;
default:  // MAIN-Menu
	break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($id,$ID);
	$md=3;
	break;
default:  // MAIN-Menu
	break;
	endswitch;

	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 8: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "BEREICH","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 9: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "USER","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 10:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "BIB-Zugriff","link" => ""),
	1=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=8&ID=$ID"),
	2=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID"),
	3=>array("icon" => "5","caption" => "Nach Bereich","link" => "$PHP_SELF?md=0&ID=$ID&id=1"),
	9=>array("icon" => "6","caption" => "Zurück","link" => "../larp/admin_con.php?md=0&ID=$ID")
	);
	break;

default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "BIB-Zugriff","link" => ""),
	1=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=8&ID=$ID"),
	2=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID"),
	3=>array("icon" => "5","caption" => "Nach User","link" => "$PHP_SELF?md=10&ID=$ID&id=1"),
	9=>array("icon" => "6","caption" => "Zurück","link" => "admin_con.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu($menu);

	//echo $TAG;

	switch ($md):
case 1:
		//
		print_maske($ID_id, $ID, 5, 1, $ref1_id, $ref2_id);
	break;
case 2:
	//
	Print_info($id, $ID);
	break;
case 3:
	//
	print_loeschen($ID);
	break;
case 4:
	//
	print_maske($id,$ID,6,0, $ref1_id, $ref2_id);
	break;
case 8:
	//
	print_Ref1($ID,9);
	break;
case 9:
	//
	print_Ref2($ID,1,$ref1_id);
	break;
case 10:
	print_liste($ID,2);
	break;
default:
	print_liste($ID,1);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>