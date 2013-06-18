<?php

/*
 Projekt :  ADMIN

Datei   :  admin_edit.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für eine Tabelle.
Es werden automatisch daten nach dem MFD Schema erstellt.
MFD = Main Formular Data, beschreibt eine Tabelle und die
Daten dieser Tabelle die in einer Datenliste angezeigt
werden sollen.
Mit diesem Schema koennen einheitliche Anzeige- und
Bearbeitungsfunktionen benutzt werden, da die Funktionen nicht
an die Tabelleneigenschaften gebunden sind.
Das MFD Schema wird als Library abgelegt und bietet die Funktionen
- Anzeige einer Datenliste mit Bearbeitungsaufruf  und Deleteaufruf
- Anzeige einer Detailmaske nach Standardscheme mit Speichern
zum Editieren (Update) eines Datensatzes
zum erfassen (Insert) eines Datensatzes


Es wird eine Session Verwaltung benutzt, die den User prueft.

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

$style = $GLOBALS['style_datatab'];
echo "<div $style >";
echo "<!--  DATEN Spalte   -->\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_edit.inc';
include_once '_mfd_lib.inc';


/**
 * Zeigt die Default definition fuer eine Tabelle und
 * ermoeglicht das abspeichern der Definition in der MFD Datenbank
 * @param unknown $table
 * @param unknown $ID
 */
function show_mfd_def($table, $ID)
{
  global $PHP_SELF;
	$mfd = show_mfd($table, $ID);
	$next = 5;	// Insert mfd Data
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<p>";
	echo "<FORM ACTION=\"$PHP_SELF?md=2&daten=mfd_list&ID=$ID\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	//	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$name\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"0\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[1]\"   VALUE=\"ADMIN\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[2]\"   VALUE=\"main\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[3]\"   VALUE=\"".$mfd['mfd']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[4]\"   VALUE=\"".$mfd['table']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[5]\"   VALUE=\"".$mfd['table']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[6]\"   VALUE=\"".$mfd['fields']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[7]\"   VALUE=\"".$mfd['join']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[8]\"   VALUE=\"".$mfd['where']."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[9]\"   VALUE=\"".$mfd['order']."\">\n";
	echo "</p>";
	echo "<p>";
	echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"RESET\" VALUE=\"Reset\">";
	echo "</p>";
	
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	return;
}

/**
 * Zeigt die Default Definition der Columns fuer eine Tabelle
 * und ermoeglicht das Abspeichern in der Definition
 * @param unknown $table
 * @param unknown $ID
 */
function show_mfd_col_def($table, $ID)
{
  global $PHP_SELF;
  
	show_mfd_cols($table, $ID);
	$next = 6;	// Insert mfd Data
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<p>";
	echo "<FORM ACTION=\"$PHP_SELF?md=3&daten=$table&ID=$ID\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	//	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$name\">\n";
	echo "</p>";
	echo "<p>";
	echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"RESET\" VALUE=\"Reset\">";
	echo "</p>";
    echo "</form>";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
  return;
}

function show_mfd_docu($table, $ID)
{
	global $PHP_SELF;
	$mfd = show_mfd($table, $ID);
	echo '------------------<br>';
	$mfd_Cols = show_mfd_cols($table, $ID);
	
  return;
}


/**
 * Erzeugt eine liste der Tabelle der Datenbank als Menu
 */
function print_table_list($ID)
{
	global $PHP_SELF;

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$q= "show tables";
	$result = mysql_query($q) ;
	$style = $GLOBALS['style_menu_tab1'];

	$style = "id=\"style_datalist\"";
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<div $style >";
	echo "<!--  MENU Spalte   -->\n";

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		$i=0;
		while ($row = mysql_fetch_row($result))
		{
			$pages[$i+1] = $row[0];
			$i++;
		}
	}
	// Hearderzeile einfuegen
	$pages[0] = "Tabellen";
	$tableanz = count($pages);
	echo "<div >";
	echo "<p>";
	echo " ";
	echo "</p >";
	echo "</div >";


	$style = "id=\"menu\"";
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<table  > \n"; //width=\"100%\"
	echo "<tbody >";

	for($i=0; $i<count($pages); $i++)
	{
		$name = $pages[$i];
		echo "\t<tr> \n";
			echo "\t\t<td width=\"25\"> \n";
		if ($i>0)
		{
			echo "<a href=\"$PHP_SELF?md=2&daten=$name&ID=$ID \" >";
			print_menu_icon("_db","Show Default MFD");
			echo "</a>";
		} else
		{
			echo '.';
		}
		echo "\t\t</td> \n";
		
		echo "\t\t<td width=\"25\"> \n";
		if ($i>0)
		{
			echo "<a href=\"$PHP_SELF?md=4&daten=$name&ID=$ID \" >";
			print_menu_icon("_txt","Show Table Docu");
			echo "</a>";
		} else
		{
			echo $tableanz;
		}

		echo "\t\t</td> \n";
		echo "\t\t<td> \n";
		echo "$name";
		echo "";
		echo "\t\t</td> \n";
		echo "\t\t<td> \n";
		if ($i>0)
		{
			echo "<a href=\"$PHP_SELF?md=3&daten=$name&ID=$ID \"> ";
			print_menu_icon("_branch","Show Default MFD COLS");
			echo "</a>";
		}        echo "";
		echo "";
		echo "\t\t</td> \n";
		echo "\t</tr> \n";
	}

	echo "</tbody>";
	echo "</table>\n";
	echo '</div>';

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

// <head>
// ...
// <script src="/ckeditor/ckeditor.js"></script>
// </head>

$BEREICH = 'ADMIN';


$md     = GET_md(0);
$id     = GET_id(0);
$daten  = GET_daten("");

$ID     = GET_SESSIONID("");
$p_md   = POST_md(0);
$p_id 	= POST_id(0);
$p_row 	= POST_row("");
$p_editor1 = POST_editor1("");

session_start($ID);
$user       = $_SESSION["user"];
$user_lvl   = $_SESSION["user_lvl"];
$spieler_id = $_SESSION["spieler_id"];
$user_id 	= $_SESSION["user_id"];

if ($ID == "")
{
	$session_id = 'FFFF';
	echo "session";
	//  header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

if (is_admin()==FALSE)
{
	$session_id = 'FFFF';
	echo "Admin";
	//  header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}


print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"Menu Konfigurator",$anrede,$menu_item);


switch($p_md):
case 5: // Insert -> Erfassen
	// erzeuge mfd fuer Tabelle in die der insert gemacht werden soll
	$mfd_list = make_mfd_table("mfd_list", "mfd_list");
	mfd_insert($mfd_list, $p_row);
	$md = 0;
	break;
case 6: // Insert -> Erfassen
    insert_mfd_cols($daten,$daten);
	$md = 0;
	break;
	endswitch;



	switch ($md):
case 2: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "TABLE","link" => "$PHP_SELF?md=1&ID=$ID"),
				1=>array("icon" => "1","caption" => "MFD","link" => ""),
				2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 3:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "TABLE","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array("icon" => "1","caption" => "MFD-COLS","link" => ""),
	2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 10: // main
	$menu = array (0=>array("icon" => "7","caption" => "TABLE","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "TABLE","link" => "$PHP_SELF?md=1&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu_status($menu);

	switch ($md):
case 2:
	show_mfd_def($daten,$ID);
	break;
case 3:
	show_mfd_col_def($daten,$ID);
	break;
case 4:
	show_mfd_docu($daten,$ID);
	break;
case 10:
	break;
default:
	print_table_list($ID);
	break;
	endswitch;

	print_md_ende();

	?>