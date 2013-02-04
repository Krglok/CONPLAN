<?php

/*
 Projekt : LARP

Datei   :  $RCSfile: sc_liste.php,v $

Datum   :  $Date: 2002/02/26 18:42:41 $  /

Rev.    :  $Revision: 1.3 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Interne Teil der SC liste abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.

Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis

./

Die images kommen aus dem Verzeichnis

./images

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

Die zugehoerigen HTML Seiten sollten in einem Subdir sein 2)
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.



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


function print_main_data()
{
	global $DB_HOST, $DB_USER, $DB_PASS;

	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"100%\"  BORDER=\"1\" BGCOLOR=\"\" >\n";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db("drachenhorst");

	$result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news")
	or die("Query Fehler...");

	while ($row = mysql_fetch_row($result))
	{
		echo "        <TR>\n";
		echo "        <FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
		echo "\t<td width=\"75\">".$row[0]."&nbsp;</td>\n";
		echo "\t<td>".$row[1]."<BR>".$row[2]."<BR>".$row[3]."</td>\n";
		echo '        </TR>\n';
	}

	mysql_close($db);
	echo '      </TABLE>\n';
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
};

function print_sp_liste()
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	//Macht aus einem Resultset eine HTML Tabelle
	function result_to_table($result)
	{

		echo "    <TD>\n";
		echo "<table border=1 BGCOLOR="."  >\n";

		//Header
		$field_num = mysql_num_fields($result);
		echo "<tr>\n";
		echo "\t<td><b>ID</b></td>\n";
		echo "\t<td><b>Name</b></td>\n";
		echo "\t<td><b>Vorname</b></td>\n";
		//  echo "\t<td><b>Orga</b></td>\n";
		echo "\t<td><b>Charakter</b></td>\n";
		echo "\t<td><b>email</b></td>\n";
		echo "\t<td><b>Telefon</b></td>\n";
		echo "</tr>\n";

		//Daten
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num; $i++)
			{
				//                if ($i==0) {
				//echo "\t<td><a href=\"".$PHP_SELF."?op=detail&user_id=$row[$i]\">$row[$i]</a></td>\n";
				//                }
				//        echo "\t<td>".$row[$i]."&nbsp;</td>\n";
				if ($i==5)
				{
					echo "\t<td><a href=\"mailto:$row[$i]\"> $row[$i]</a></td>\n";
				} else
				{
					echo "\t<td>".$row[$i]."&nbsp;</td>\n";
				};
			}
			echo "<tr>\n";
		}
		echo "</table>\n";
		echo "    </TD>\n";
	}


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$result = mysql_query("SELECT id,name,vorname,charakter,email,telefon from spieler where (name <> \"XX\" and  name <> \"??\")")
	or die("Query Fehler...");

	result_to_table($result);

	mysql_close($db);
};

function print_sp_upd($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS;

	// SUB-Funktion Start ======
	function result_to_table($id,$user,$result)
	{
		//  Daten
		//
		echo "<TD>\n";/// Spalte für Datenbereich

		//  FORMULAR
		echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

		echo "<table border=1 BGCOLOR="."  >\n";
		echo "<CAPTION>Bearbeiten der Spieler Daten</CAPTION>\n";

		$row = mysql_fetch_row($result);

		echo "<tr>\n";
		echo "\t<td WIDTH=\"75\"><b>ID</b></td>\n";
		echo "<td>".$row[0]."&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Name</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"name\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[1]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Vorname</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"vorname\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[2]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Charakter</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"charakter\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[3]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>email</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"email\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[4]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Telefon</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"telefon\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[5]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Geburtstag</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"geb\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[6]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td><b>Bemerkung</b></td>\n";
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"bemerkung\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[7]\">&nbsp;</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "\t<td></td>\n";
		echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
				</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</FORM>\n";
		echo "</TD>\n"; //  ENDE Spalte Datenbereich
	} // Funktion Ende =====

	// DAtenbank zugriff =============================================================
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db("drachenhorst") ;

	$q = "select spieler_id,id,username from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$id=$row[0];
	//  echo "$user/$id/$result\n";

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");

	result_to_table($id,$user, $result);

	mysql_close($db);
	// Datenbank Ende ================================================================
}

function update_sc($id,$name,$vorname,$charakter,$email,$telefon,$geb,$bemerkung)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q ="update spieler SET name=\"$name\",vorname=\"$vorname\",charakter=\"$charakter\",email=\"$email\",telefon=\"$telefon\",geb=\"$geb\",bemerkung=\"$bemerkung\" where id=\"$id\"";
	$result = mysql_query($q) or die("insert Fehler....$q.");

	mysql_close($db);

}

function print_user_upd($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	function result_to_table($id,$user,$result_1)
	{
		//  Daten
		//
		echo "<TD>\n";/// Spalte für Datenbereich

		//  FORMULAR
		echo "<FORM ACTION=\"$PHP_SELFE\" METHOD=POST>\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"5\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";

		$row = mysql_fetch_row($result_1);
		$id = $row[0]; // User_id  setzen
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

		echo "<table border=1 BGCOLOR="."  >\n";
		echo "<CAPTION>Bearbeiten der User Daten</CAPTION>\n";
		echo "<tr>";
		echo "  \t<td><b>Username</b></td>\n";
		echo "  <td><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=30 MAXLENGTH=30 VALUE=\"$user\">&nbsp;</td>\n";
		echo "</tr>";
		echo "<tr>";
		echo "  \t<td><b>Paswort alt</b></td>\n";
		echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"alt_pw\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
		echo "</tr>";
		echo "<tr>";
		echo "  \t<td><b>Passwort neu</b></td>\n";
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

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select spieler_id,id,username from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$row[0]\" ";
	$result_1 = mysql_query($q) or die("select Fehler....$q.");

	result_to_table($id,$user,$result_1);

	mysql_close($db);
}

function update_user($user,$id,$username,$alt_pw,$pw_1,$pw_2)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	$q = "select pword from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	$check = $row[0];

	$q = "select old_password(\"$alt_pw\");";
	$result = mysql_query($q) or die($q);
	$row = mysql_fetch_row($result) ;
	//  echo "$row[0] / $check";  // nur zum testen !!

	if ($check==$row[0])
	{
		if ($pw_1==$pw_2)
		{
			$q ="update user_liste SET username=\"$username\",pword=old_Password(\"$pw_1\") where username=\"$user\"";
			$result = mysql_query($q) or die("Update Fehler....$q.");
			$err = "Daten gespeichert";
		} else
		{
			$err = "Passwort ungleich  Kontrolle / Datensatz nicht gespeichert";
		};
	} else
	{
		$err = "Passwort falsch Datensatz nicht gespeichert";
	};
	mysql_close($db);
	return $err;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
$c_md = $_COOKIE['md'];

$p_md = $_POST['md'];
$p_id					= $_POST['id'];
$p_name				= $_POST['name'];
$p_vorname		= $_POST['vorname'];
$p_charakter	= $_POST['charakter'];
$p_email			= $_POST['email'];
$p_telefon		= $_POST['telefon'];
$p_geb				= $_POST['geb'];
$p_bemerkung	= $_POST['bemerkung'];

$p_username		= $_POST['username'];
$p_alt_pw			= $_POST['alt_pw'];
$p_pw_1				= $_POST['pw_1'];
$p_pw_2				= $_POST['pw_2'];

$g_md = $_GET['md'];
$ID 	= $_GET['ID'];


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
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

print_header("Interner Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Interner Bereich","Sei gegrüsst $spieler_name ");


//echo "Record_id : $p_id / GET : $md / ID :$ID / Spieler = $spieler_id / user = $user / UserName = $p_username";

print_md();

if ($user=="gast")
{
	$g_md=1;
};

switch ($p_md):
case 3:
	$err = update_sc($p_id,$p_name,$p_vorname,$p_charakter,$p_email,$p_telefon,$p_geb,$p_bemerkung);
echo $err;
$g_md = 1;
break;
case 5:
	$err = update_user($user,$p_id,$p_username,$p_alt_pw,$p_pw_1,$p_pw_2);
	$g_md = 1;
	break;
default:
	break;
	endswitch;


	switch ($g_md):
case 1:
		$menu = array (0=>array("icon" => "99","caption" => "SPIELER","link" => ""),
				1=>array("icon" => "3","caption" => "Bearbeiten","link" => "$PHP_SELFE?md=2&ID=$ID"),
				2=>array("icon" => "3","caption" => "User","link" => "$PHP_SELFE?md=4&ID=$ID"),
				3=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
		);
		break;
case 2:
	$menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELFE?md=1&ID=$ID")
	);
	break;
case 4:
	$menu = array (0=>array("icon" => "99","caption" => "USER","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELFE?md=1&ID=$ID")
	);
	break;
default:
	$menu = array (0=>array("icon" => "99","caption" => "SPIELER","link" => ""),
	1=>array("icon" => "3","caption" => "Bearbeiten","link" => "$PHP_SELFE?md=2&ID=$ID"),
	2=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu($menu);

	switch ($g_md):
case 1:
		print_sp_liste();
	break;
case 2:
	print_sp_upd($user);
	break;
case 3:
	echo "UPDATE";
	break;
case 4:
	print_user_upd($user);
	break;
case 5:
	echo "UPDATE";
	break;
default:
	//        print_sp_liste();
	break;
	endswitch;

	print_md_ende();


	?>