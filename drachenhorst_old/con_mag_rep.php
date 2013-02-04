<?
/*
 Projekt :  CONPLAN

Datei   :  con_mag_rep.php

Datum   :  2002/05/14

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Reportfunktionen für die Datei <$TABLE>
Es wird eine Layout mit einem einfachen  Menü verwendet
damit der DIN A4  ausdruck möglich ist ohne unnötigen Rand

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


$Log: mag_rep.php,v $
Revision 1.1  2002/05/14 19:12:03  windu
Erweiterung um Reportfunktion

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_liste($ID)
/*
 Übersicht der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select ID,GRP,STUFE,count(NAME)as Anzahl from $TABLE group by grp,stufe order by grp DESC,stufe , NR";
	$result = mysql_query($q)  or die("Query Fehler :".$q);

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	echo "\t<td><b> Gruppe </b></td>\n";
	echo "\t<td><b> Stufe 1 </b></td>\n";
	echo "\t<td><b> Stufe 2 </b></td>\n";
	echo "\t<td><b> Stufe 3 </b></td>\n";
	echo "\t<td><b> Stufe 4 </b></td>\n";
	echo "\t<td><b> Stufe 5 </b></td>\n";
	echo "\t<td><b> Stufe 6 </b></td>\n";
	echo "\t<td><b> Stufe 7 </b></td>\n";
	echo "\t<td><b> Stufe 8 </b></td>\n";
	echo "\t<td><b> Stufe 9 </b></td>\n";
	echo "</tr>\n";
	$grp="";
	//Liste der Datensätze
	echo "<tr>";
	while ($row = mysql_fetch_row($result))
	{
		// aufruf der Deateildaten
		if ($row[1]<>$grp)
		{
			echo "</tr>";
			$grp=$row[1];
			echo "<tr>";
			echo "\t<td>\n";
			echo "\t$row[1] \n";
			echo "\t</td>\n";

			echo "\t<td>\n";
			echo "\t$row[3] \n";
			echo "\t</td>\n";
		} else
		{
			echo "\t<td>\n";
			echo "\t$row[3] \n";
			echo "\t</td>\n";
		};
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_liste_grp($ID,$grp)
/*
 Übersicht der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	//  $q = "select ID,GRP,NR,STUFE,NAME,MUK,RAR,GEIST  from $TABLE order by GRP DESC ,NR";
	$q = "select ID,GRP,STUFE,NR,NAME,KOSTEN,MUK,RAR,GEIST from $TABLE where grp=\"$grp\" order by grp DESC,stufe , NR";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=45> \n";
	print_header_icon (7);
	echo "\t</td>\n";
	echo "\t<td align=right> \n";
	echo "  Spruchlisten eines Bereiches &nbsp;&nbsp;&nbsp;\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<table border=1 WIDTH=\"690\"  BGCOLOR=\"\">\n";
	// Menüzeile
	echo "<tr>\n";
	echo "\t<td><a href=\"$PHP_SELF?md=0&ID=$ID&grp=$grp\">\n";
	print_menu_icon (6);
	echo "\t</a></td>\n";
	echo "\t<td>Zurück\n";
	echo "</tr>\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
	};
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=1&ID=$ID&id=$row[0]&grp=$grp\">\n";
				print_menu_icon (7);
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


function print_blatt($id,$ID,$grp)
/*
 Realisiert eine Einzelblatt des Datensatzes mit allen relevanten Details
ähnlich der Info-funktion in den Datenmasken.
Das Layout wird speziell angepasst um das DIN A$ format zu gewährleisten
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;

	//  Erstellen eines reports
	//

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	// Felder werden explizit angegeben,
	// die Reihenfolge der Definition ist die Reihenfolge in der Ergebnisliste
	//
	$q = "select id,GRP,NR,STUFE,NAME,SPRUCHDAUER,KOSTEN,WIRKDAUER,WIRKBEREICH,REICHWEITE,WIRkUNG,PATZER,AUSFUEHRUNG,MUK,RAR,GEIST from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler...");
	//  anzahl zeile in Ergebnis -------------------------------------
	$field_num = mysql_num_fields($result);
	// Auflösung Datenzeilen in Ergebnis -----------------------------
	$row = mysql_fetch_row($result);
	// auflösen der Feldnamen und Type in einfache Tabellen ----------
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  ucfirst (mysql_field_name($result,$i));
		$type[$i]       =  mysql_field_type ($result, $i);
	};

	mysql_close($db);
	//
	//Daten bereich
	//
	//      Datentypenerkennung für NICT Strings -----
	//      if ($type[$i]=="date") { $len[$i] = 10; }
	//      if ($type[$i]=="int") { $len[$i] = 5; }
	//      if ($type[$i]!="blob")
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";
	// Menüzeile
	echo "<tr>\n";
	echo "</tr>\n";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=45> \n";
	print_header_icon (7);
	echo "\t</td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50><b>$field_name[1]&nbsp;</b></td>\n";
	echo "\t<td width=50><b>$field_name[2]&nbsp;</b></td>\n";
	echo "\t<td width=50><b>$field_name[13]&nbsp;</b></td>\n";
	echo "\t<td width=50><b>$field_name[14]&nbsp;</b></td>\n";
	echo "\t<td width=50><b>$field_name[15]&nbsp;</b></td>\n";
	echo "\t<td align=right> \n";
	echo " SPRUCHBESCHREIBUNG &nbsp;&nbsp;&nbsp;\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&grp=$grp\">\n";
	print_menu_icon (6);
	echo "\t</a>\n";
	echo "\tZurück\n";
	//      echo "\t<td width=45></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50>$row[1]</td>\n";
	echo "\t<td width=50>$row[2] </td>\n";
	echo "\t<td width=50>$row[13]</td>\n";
	echo "\t<td width=50>$row[14] </td>\n";
	echo "\t<td width=50>$row[15] </td>\n";
	echo "\t<td width=50><b>&nbsp;</b></td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=45> \n";
	echo "\t</td>\n";
	echo "\t<td width=65></td>\n";
	echo "\t<td > </td>\n";
	echo "</tr>";
	echo "<tr height=20>";
	echo "\t<td width=45> \n";
	echo "\t</td>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";// Name
	echo "\t<td width=100><b>$field_name[4]&nbsp;</b></td>\n";
	echo "\t<td >$row[4]</td>\n";
	echo "\t<td </b></td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>"; // Stufe und Kosten
	echo "\t<td width=100><b>$field_name[3]&nbsp;</b></td>\n";
	echo "\t<td width=30>$row[3]&nbsp; </td>\n";
	echo "\t<td width=20> </b></td>\n";
	echo "\t<td width=50><b>Zusatzkosten&nbsp;</b></td>\n";
	echo "\t<td >$row[6] </td>\n";
	echo "\t<td> </b></td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>"; // Spruchdauer
	echo "\t<td width=100><b>$field_name[5]&nbsp;</b></td>\n";
	echo "\t<td >$row[5] </td>\n";
	echo "\t<td > </td>\n";
	echo "<tr>";

	echo "<tr>"; // Spruchname
	echo "\t<td width=70><b>$field_name[7]&nbsp;</b></td>\n";
	echo "\t<td >$row[7]</td>\n";
	echo "\t<td></td>\n";
	echo "</tr>";

	echo "<tr>";
	echo "\t<td width=50><b>$field_name[8]&nbsp;</b></td>\n";
	echo "\t<td >$row[8] </td>\n";
	echo "\t<td></td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td width=50><b>$field_name[9]&nbsp;</b></td>\n";
	echo "\t<td >$row[9] </td>\n";
	echo "\t<td > </td>\n";
	echo "</tr>";
	echo "</table>\n";  // Ende der Tabllle

	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td width=100><b>Wirkung&nbsp;</b></td>\n";
	//      echo "\t<td width=70><b></b>$field_name[10]&nbsp;</td>\n";
	$zeile=explode("\n",$row[10]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "</td>\n";
	echo "<tr>\n";

	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td width=100><b>Patzer</b>&nbsp;</td>\n";
	$zeile=explode("\n",$row[11]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "</td>\n";
	echo "<tr>\n";

	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"
			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td width=100><b>Ausführung</b>&nbsp;</td>\n";
	$zeile=explode("\n",$row[12]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "</td>\n";
	echo "<tr>\n";

	echo "</table>\n";  // Ende der Tabllle
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_liste_1($ID,$grp)
/*
 einfache der vorhandenen Datensätze
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select GRP,STUFE,NR,NAME,SPRUCHDAUER,KOSTEN,MUK,RAR,GEIST  from $TABLE where GRP=\"$grp\" order by grp,stufe,nr";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".ucfirst (mysql_field_name($result,$i))."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			echo "\t<td>$row[$i]&nbsp;</td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];
$grp = $_GET['grp'];


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
	$l2 = (int) $lvl_sl[14];
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

$TABLE = "mag_list";

print_header("SL Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

//  echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

switch ($md):
case 1:
	print_md();
//     Einzellblatt darstellung DIN A4
print_blatt($id, $ID, $grp);
break;
case 2:
	//     Listendarstellung
	print_md();
	print_liste_grp($ID,$grp);
	break;
case 3:
	print_md();
	//     Listendarstellung
	break;
case 4:
	print_md();
	//     Listendarstellung
	break;
case 5:
	//     Listendarstellung
	print_md();
	break;
default:
	print_kopf(7,9,"Magieliste","Sei gegrüsst Meister ");
	print_md();
	$menu = array (0=>array("icon" => "99","caption" => "REPORT MAGIE","link" => ""),
			10=>array("icon" => "5","caption" => "Neutrale Magie","link" => "$PHP_SELF?md=2&ID=$ID&grp=NT"),
			11=>array("icon" => "5","caption" => "Runenmagei","link" => "$PHP_SELF?md=2&ID=$ID&grp=RU"),
			12=>array("icon" => "5","caption" => "Elementarmagie","link" => "$PHP_SELF?md=2&ID=$ID&grp=EL"),
			13=>array("icon" => "5","caption" => "Rituale","link" => "$PHP_SELF?md=2&ID=$ID&grp=RI"),
			14=>array("icon" => "5","caption" => "Koboldmagie","link" => "$PHP_SELF?md=2&ID=$ID&grp=KO"),
			20=>array("icon" => "","caption" => "","link" => ""),
			22=>array("icon" => "5","caption" => "Weisse Magie","link" => "$PHP_SELF?md=2&ID=$ID&grp=WM"),
			24=>array("icon" => "5","caption" => "Heilmagie","link" => "$PHP_SELF?md=2&ID=$ID&grp=HM"),
			25=>array("icon" => "5","caption" => "Drachenmagie","link" => "$PHP_SELF?md=2&ID=$ID&grp=DR"),
			30=>array("icon" => "","caption" => "","link" => ""),
			32=>array("icon" => "5","caption" => "Schwarze Magie","link" => "$PHP_SELF?md=2&ID=$ID&grp=SM"),
			34=>array("icon" => "5","caption" => "Nekromantie","link" => "$PHP_SELF?md=2&ID=$ID&grp=NE"),
			36=>array("icon" => "5","caption" => "Daemonologie","link" => "$PHP_SELF?md=2&ID=$ID&grp=DM"),
			37=>array("icon" => "5","caption" => "Daemonen Magie","link" => "$PHP_SELF?md=2&ID=$ID&grp=DA"),
			50=>array("icon" => "6","caption" => "Zurück","link" => "con_mag_liste.php?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>