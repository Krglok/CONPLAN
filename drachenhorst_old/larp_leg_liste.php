<?php
/*
 Projekt : LARP

Datei   :  larp_leg_liste.php

Datum   :  2002/05/24

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <Legende>
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



//-----------------------------------------------------------------------------
function print_leg_liste($ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	//Anzeigen von Legendenliste
	//function view() {

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	//if ($DEBUG) {echo "Verbunden<br>";}

	mysql_select_db($DB_NAME);
	//if ($DEBUG) {echo "DB ausgewählt<br>";}
	$q = "select id,s0,s1,s2,datum,name,kurz,beschreibung from legende where s1 <> \"\" order by s0 DESC,s1 DESC,s2 DESC";
	$result = mysql_query($q)    or die("Query Fehler...");
	//if ($DEBUG) {echo "Query ok<br>";}

	mysql_close($db);

	echo "  <TD\n>";
	echo "<table width=680 border=1 BGCOLOR="."  >\n";

	//Header
	$field_num = mysql_num_fields($result);
	echo "<tr>\n";
	//for ($i=0; $i<$field_num; $i++) {
	//        echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	echo "\t<td width=75><b>DATUM</b></td>\n";
	//            echo "\t<td><b>JAHR</b></td>\n";
	//            echo "\t<td><b>TAG</b></td>\n";
	//            echo "\t<td><b>EXT</b></td>\n";
	echo "\t<td width=120><b>NAME</b></td>\n";
	echo "\t<td><b>KURZ</b></td>\n";
	echo "\t<td><b></b></td>\n";
	//lfdnr,name,vorname,orga}
	echo "</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=4; $i<$field_num-1; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td>";
				echo "</td>\n";
			}else
			{
				echo "\t<td>".$row[$i]."&nbsp;</td>\n";
			};
		}
		echo "\t  <td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\"\n>";
		print_menu_icon (7);
		echo "\t  </a></td>\n";
		echo "</tr>";
		echo "<tr>";
		echo "\t<td>";
		echo "</td>\n";
		echo "\t<td>";
		echo "</td>\n";
		echo "\t<td >\n";
		$zeile=explode("\n",$row[7]);
		$anz  = count($zeile);
		for ($ii=0; $ii<3; $ii++)
		{
			echo "\t$zeile[$ii]&nbsp;<br>\n";
		}
		echo "</td>\n";
		echo "</tr>";
		echo "<tr height=20>";
		echo "<td>\n";
		echo "</td>\n";
		echo "</tr>";
	}
	echo "</table>";
	echo "  </TD\n>";

};

//-----------------------------------------------------------------------------
function print_maske($id, $ID,$next,$erf)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	//Anzeigen von Legendenliste
	//function view() {

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	//if ($DEBUG) {echo "Verbunden<br>";}

	mysql_select_db($DB_NAME);
	//if ($DEBUG) {echo "DB ausgewählt<br>";}

	if ($erf!=0)
	{
		$row = array(0=>"",
				1=>"",
				2=>"",
				3=>"",
				4=>"",
				5=>"",
				6=>"",
				7=>""
		);
	} else
	{
		$result = mysql_query("select id,s0,s1,s2,name,kurz,datum,beschreibung from legende where id=\"$id\"")
		or die("Query Fehler...");
		$row = mysql_fetch_row($result);

	};

	mysql_close($db);

	echo "  <TD\n>";
	//  FORMULAR
	echo "\n";
	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=GET>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"6\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

	echo "<TABLE WIDTH=\"680\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>\n";  // ID
	echo "  <td width=75 ><b>ID</b></td>\n";
	echo "  <td width=50>$row[0]&nbsp;</td>\n";
	echo "  <td width=50 ><b>JAHR</b></td>\n";
	echo "  <td width=50>$row[1]&nbsp;</td>\n";
	echo "  <td width=50><b>TAG</b></td>\n";
	echo "  <td width=50>$row[2]&nbsp;</td>\n";
	echo "  <td width=50><b>S2</b></td>\n";
	echo "  <td width=50>$row[3]&nbsp;</td>\n";
	echo "  <td ><b>&nbsp;</b></td>\n";
	echo "</tr>\n";
	echo "</table>\n";

	echo "<TABLE WIDTH=\"680\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>\n";  // Historie
	echo "  <td width=75 ><b>DATUM</b></td>\n";
	echo "  <td BGCOLOR=\"#E9E0DA\">$row[6]&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";  // Name
	echo "  <td width=75 ><b>NAME</b></td>\n";
	echo "  <td  BGCOLOR=\"#E9E0DA\">$row[4]&nbsp;</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";  // Kurz
	echo "  <td><b>KURZ</b></td>\n";
	echo "  <td BGCOLOR=\"#E9E0DA\">$row[5]&nbsp;</td>\n";
	echo "</tr>\n";
	echo "</table>\n";

	echo "<TABLE WIDTH=\"680\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>\n";  // Text
	echo "  <td width=75 ><b></b></td>\n";
	//  echo "\t<td><TEXTAREA NAME=\"beschreibung\" COLS=80 ROWS=30  readonly>$row[7]</TEXTAREA>&nbsp;</td>\n";
	echo "<td  WIDTH=\"600\"  BGCOLOR=\"#E9E0DA\">\n";
	$zeile=explode("\n",$row[7]);
	$anz  = count($zeile);
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "\t&nbsp;<br>\n";
	echo "</td>\n";

	echo "</tr>\n";
	if ($next!=0)
	{
		echo "\t<tr>\n";
		echo "\t<td></td>\n";
		echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
				</td>\n";
		echo "\t</tr>\n";
	};
	echo "</table>";
	echo "</FORM>";
	echo "  </TD\n>";

};




// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
$c_md 	= $_COOKIE['md'];


$md = $_GET['md'];
$ID = $_GET['ID'];
$id = $_GET['id'];


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

// Prüfung ob User  berechtigt ist
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

print_header("Charakterliste");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(5,2,"Charakter Verwaltung","Sei gegrüsst $spieler_name ");


//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id \n";


print_md();

switch ($md):
case 2: // Ansehen des Datesatzes als Form
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
			8=>array("icon" => "6","caption" => "Zurück","link" => "$PHO_SELF?md=0&ID=$ID")
	);
	break;
default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "LEGENDEN","link" => ""),
	1=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	endswitch;

	print_menu($menu);


	switch ($md):
case 2:
		print_maske($id,$ID,0,0);
	break;
default:
	print_leg_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>