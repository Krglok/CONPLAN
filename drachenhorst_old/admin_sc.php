<?php

/*
 Projekt :  ADMIN

Datei   :  admin_sc.php

Datum   :  2002/05/03

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Datensätze
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

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


function print_sp_liste($user,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	//Macht aus einem Resultset eine HTML Tabelle

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "SELECT s.id,s.name,s.vorname,s.orga,s.charakter,s.email,s.telefon,u.username from spieler s,user_liste u where s.id=u.spieler_id order by name";
	$result = mysql_query($q)
	or die("Fehler Liste...$q");


	mysql_close($db);


	echo "    <TD>\n";
	echo "<table border=1 BGCOLOR="."  >\n";

	//Header
	$field_num = mysql_num_fields($result);
	$anzahl    = mysql_num_rows($result);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "Anzahl";
	echo "</td>";
	echo "<td>";
	echo $anzahl;
	echo "</td>";
	echo "</tr>";
	echo "<tr>\n";
	echo "\t<td><b>ID</b></td>\n";
	echo "\t<td><b>Name</b></td>\n";
	echo "\t<td><b>Vorname</b></td>\n";
	echo "\t<td><b>Orga</b></td>\n";
	echo "\t<td><b>Charakter</b></td>\n";
	echo "\t<td><b>email</b></td>\n";
	echo "\t<td><b>Telefon</b></td>\n";
	echo "\t<td><b>user</b></td>\n";
	echo "</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]\">$row[$i]</a></td>\n";
			}
			else
			{
				echo "<td>$row[$i].&nbsp;</td>\n";
			}
		}
		echo "<tr>";
	}
	echo "</table>";
	echo "    </TD>\n";

};

function print_ref_liste($user,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	//Macht aus einem Resultset eine HTML Tabelle

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$q = "SELECT s.id,s.name,s.vorname,s.orga,s.charakter,s.email,s.telefon,u.username from spieler s,user_liste u where s.id=u.spieler_id order by name";
	$result = mysql_query($q)
	or die("Fehler Liste...$q");


	mysql_close($db);


	//  echo "    <TD>\n";
	echo "<table width=700 border=1 BGCOLOR="."  >\n";

	//Header
	$field_num = mysql_num_fields($result);
	$anzahl    = mysql_num_rows($result);
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "Anzahl";
	echo "</td>";
	echo "<td>";
	echo $anzahl;
	echo "</td>";
	echo "</tr>";
	echo "<tr>\n";
	echo "\t<td><b>ID</b></td>\n";
	echo "\t<td><b>Name</b></td>\n";
	echo "\t<td><b>Vorname</b></td>\n";
	echo "\t<td><b>Orga</b></td>\n";
	echo "\t<td><b>Charakter</b></td>\n";
	echo "\t<td width=200><b>bemerkung</b></td>\n";
	echo "\t<td><b></b></td>\n";
	echo "\t<td><b></b></td>\n";
	echo "</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<5; $i++)
		{
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]\">$row[$i]</a></td>\n";
			}
			else
			{
				echo "<td>$row[$i].&nbsp;</td>\n";
			}
		}
		echo "<td>&nbsp;</td>\n";
		echo "<tr>";
	}
	echo "</table>";
	//    echo "    </TD>\n";

};


function insert_sp($name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q ="insert into spieler (name,vorname,charakter,email,telefon,geb,bemerkung) VALUES (\"$name\",\"$vorname\",\"$charakter\",\"$email\",\"$telefon\",\"$geb\",\"$bemerkung\")";
	$result = mysql_query($q) or die("insert Fehler....$q.");


	$u_id = mysql_insert_id();
	$pw = "_"."$vorname";
	$q = "insert into user_liste (username,spieler_id,pword,lvl) VALUES (\"$vorname\",\"$u_id\",password(\"$pw\"),\"256\")";
	$result = mysql_query($q) or die("insert Fehler....$q.");
	mysql_close($db);

}

function update_sp($id,$name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q ="update spieler SET name=\"$name\",vorname=\"$vorname\",charakter=\"$charakter\",email=\"$email\",telefon=\"$telefon\",geb=\"$geb\",bemerkung=\"$bemerkung\" where id=\"$id\"";
	$result = mysql_query($q) or die("update Fehler....$q.");

	mysql_close($db);

}

function print_sp_maske($id,$user,$next,$erf,$ID)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	// DAtenbank zugriff =============================================================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	//  echo "$user/$user_id/$result\n";
	if ($erf ==1)
	{
		$name      = "";
		$vorname   = "";
		$charakter = "";
		$email     = "";
		$telefon   = "";
		$geb       = "";
		$bemerkung = "";
		$username  = "";

	} else
	{
		$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$id\" ";
		$result = mysql_query($q) or die("select Fehler....$q.");
		$row = mysql_fetch_row($result);

		$id        = $row[0];
		$name      = $row[1];
		$vorname   = $row[2];
		$charakter = $row[3];
		$email     = $row[4];
		$telefon   = $row[5];
		$geb       = $row[6];
		$bemerkung = $row[7];

		$q = "select spieler_id,id,username from user_liste where spieler_id=\"$id\"";
		$result = mysql_query($q) or die("select Fehler....$q.");
		$row = mysql_fetch_row($result);
		$username = $row[2];
	}
	mysql_close($db);
	// Datenbank Ende ================================================================

	// SUB-Funktion Start ======
	//  Daten
	//
	echo "<TD>\n";/// Spalte für Datenbereich

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

	echo "<table border=1 BGCOLOR="."  >\n";
	if ($erf ==1)
	{
		echo "<CAPTION>Erfassen der Spieler Daten</CAPTION>\n";
	} else
	{
		echo "<CAPTION>Bearbeiten der Spieler Daten</CAPTION>\n";
	};

	echo "<tr>\n";
	echo "\t<td WIDTH=\"75\"><b>ID</b></td>\n";
	echo "<td>$id&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Name</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"name\" SIZE=30 MAXLENGTH=30 VALUE=\"$name\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Vorname</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"vorname\" SIZE=30 MAXLENGTH=30 VALUE=\"$vorname\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Charakter</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"charakter\" SIZE=30 MAXLENGTH=30 VALUE=\"$charakter\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>email</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"email\" SIZE=30 MAXLENGTH=30 VALUE=\"$email\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Telefon</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"telefon\" SIZE=30 MAXLENGTH=30 VALUE=\"$telefon\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Geburtstag</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"geb\" SIZE=30 MAXLENGTH=30 VALUE=\"$geb\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Bemerkung</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"bemerkung\" SIZE=30 MAXLENGTH=30 VALUE=\"$bemerkung\">&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "\t<td><b>Username</b></td>\n";
	echo "<td><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=30 MAXLENGTH=30 VALUE=\"$username\">&nbsp;</td>\n";
	//  echo "<td>$username&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "</tr>\n";
	if ($next!=0)
	{
		echo "<tr>\n";
		echo "\t<td></td>\n";
		echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
				</td>\n";
		echo "</tr>\n";
	};
	echo "</table>\n";
	echo "</FORM>\n";
	echo "</TD>\n"; //  ENDE Spalte Datenbereich

}


function print_user_maske($id,$user,$next,$erf,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	if ($erf==1)
	{
		$username  = "";
	} else
	{
		$q = "select spieler_id,id,username from user_liste where username=\"$user\"";
		$result = mysql_query($q) or die("select Fehler....$q.");
		$row = mysql_fetch_row($result);
		$username = $row[2];

		$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$row[0]\" ";
		$result_1 = mysql_query($q) or die("select Fehler....$q.");
	};


	mysql_close($db);

	//  Daten
	//
	echo "<TD>\n";/// Spalte für Datenbereich

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";

	$row = mysql_fetch_row($result_1);
	$id = $row[0]; // User_id  setzen
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

	echo "<table border=1 BGCOLOR="."  >\n";
	echo "<CAPTION>Bearbeiten der User Daten</CAPTION>\n";
	echo "<tr>";
	echo "  \t<td><b>Username</b></td>\n";
	echo "  <td><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=30 MAXLENGTH=30 VALUE=\"$username\">&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "  \t<td><b>altes Pasword</b></td>\n";
	echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"alt_pw\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "  \t<td><b>Passwort</b></td>\n";
	echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"pw_1\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "  \t<td><b>Kontrolle</b></td>\n";
	echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"pw_2\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td></td>\n";
	echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><b>Spielername</b></td>\n";
	echo "<td>&nbsp;$row[1]</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><b>Vorname</b></td>\n";
	echo "<td>&nbsp;$row[2]</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><b>Charakter</b></td>\n";
	echo "<td>&nbsp;$row[3]</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><b>email</b></td>\n";
	echo "<td>&nbsp;$row[4]</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "</tr>";
	echo "</table>";
	echo "</FORM>";
	echo "</TD>\n"; //  ENDE Spalte Datenbereich
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
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


echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();

switch ($p_md):
case 5: // Insert SQL
	insert_sp($name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung);
echo "Daten gespeichert ";
$md = 0;
break;
case 6:  //Update SQL
	update_sp($id,$name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung);
	$md=0;
	break;
default: //
	break;
	endswitch;


	switch ($md):
case 1: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
				1=>array ("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 2: // Ansehen
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	1=>array ("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 3: // Löschen
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	1=>array ("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 4: // BEARBEITEN
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	1=>array ("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 7: // erfassen
	$menu = array (0=>array("icon" => "7","caption" => "DRUCK LISTE","link" => "")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "SPIELER","link" => ""),
	1=>array ("icon" => "3","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID"),
	2=>array ("icon" => "1","caption" => "User","link" => "$PHP_SELF?md=0&ID=$ID"),
	3=>array ("icon" => "1","caption" => "Druckliste","link" => "$PHP_SELF?md=7&ID=$ID"),
	5=>array ("icon" => "6","caption" => "Zurück","link" => "admin_con.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu($menu);

	switch ($md):
case 1:
		print_sp_maske($id,$user,5,1,$ID);
	break;
case 2:
	print_sp_maske($id,$user,0,0,$ID);
	break;
case 3:
	break;
case 4:
	print_sp_maske($id,$user,6,0,$ID);
	break;
case 7:
	print_ref_liste($user,$ID);
	break;
default:
	print_sp_liste($user,$ID);
	break;
	endswitch;

	print_md_ende();

	?>