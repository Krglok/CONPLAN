<?php

/*
 Projekt :  ADMIN

Datei   :  admin_menu.php

Datum   :  2002/02/26

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <menu_item>
Es wird die mfd verwaltung verwendet. Der mfd wird manuell erezugt.
- Liste der Datensätze
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Löschen  eines Datensatzes

Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.

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
include_once '_mfd_lib.inc';

/**
 * Erzeugt eine liste der Tabelle der Datenbank als Menu
 */
function print_sub_list($ID,$sub)
{
  global $PHP_SELF;

  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);
  $q= "SELECT ID, ref_bereich, sub FROM menu_sub ";
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
      $pages[$i+1] = $row[1]." | ".$row[2];
      $subs[$i+1] = $row[2];
      $i++;
    }
  }
  // Hearderzeile einfuegen
  $pages[0] = "SubBereiche";
  $tableanz = count($pages);
  echo "<div >";
  echo "<p>";
  echo " ";
  echo "</p >";
  echo "</div >";


  $style = "id=\"menu\"";
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  echo "<table  border=\"1\"> \n"; //width=\"100%\"
  echo "<tbody >";

  for($i=0; $i<count($pages); $i++)
  {
  $name = $pages[$i];
  echo "\t<tr> \n";
		echo "\t\t<td width=\"25\"> \n";
		if ($i>0)
		{
		echo "<a href=\"$PHP_SELF?md=0&daten=$name&sub=$subs[$i]&ID=$ID \" >";
		print_menu_icon("_db","Edit SubBereich");
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
		  echo "<a href=\"$PHP_SELF?md=1&daten=$name&sub=$subs[$i]&ID=$ID \"> ";
		  print_menu_icon("_branch","Preview Menu in separatem Fenster");
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


function make_mfd_list($bereich, $sub)
{
	$mfd_list = array(
			"mfd"=>"menu_item", 
			"table"=>"menu_item",
			"tite"=>"MenuItems",
			"fields"=>"menu_item.ID,bereich,sub,item_titel,item_typ,item_icon,item_link,item_sort",
			"join"=>"", //join menu_bereich on bereich = \"$bereich\" join menu_sub on menu_sub.ref_bereich = menu_bereich.ID  ",
			"where"=>"sub=\"$sub\" ", 
			"order"=>"item_sort");
	return $mfd_list;
}

function make_mfd_cols($mfd_list)
{
	global $mfd_col;
	global $mfd_cols;
	$fields = make_mfd_fieldlist($mfd_list["fields"]);
	$i=0;
		// Reihenfolge der menu_item nach spalte item_sort
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = "ID";
		$mfd_col['mfd_width'] = 5;
		$mfd_cols[$i] = $mfd_col;
	$i=1;
		// Reihenfolge der menu_item nach spalte item_sort
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = "Bereich";
		$mfd_col['mfd_width'] = 15;
		$mfd_cols[$i] = $mfd_col;
	$i=2;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = "SubBereich";
		$mfd_col['mfd_width'] = 15;
		$mfd_cols[$i] = $mfd_col;
	$i=3;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = $fields[$i];
		$mfd_col['mfd_width'] = 35;
		$mfd_cols[$i] = $mfd_col;
	$i=4;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = $fields[$i];
		$mfd_col['mfd_width'] = 5;
		$mfd_cols[$i] = $mfd_col;
	$i=5;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = $fields[$i];
		$mfd_col['mfd_width'] = 15;
		$mfd_cols[$i] = $mfd_col;
	$i=6;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = $fields[$i];
		$mfd_col['mfd_width'] = 55;
		$mfd_cols[$i] = $mfd_col;
	$i=7;
		$mfd_col['mfd_name'] = $mfd_list["mfd"];
		$mfd_col['mfd_titel'] = "MenuItem";
		$mfd_col['mfd_pos'] = $i;
		$mfd_col['mfd_field'] = $fields[$i];
		$mfd_col['mfd_field_titel'] = $fields[$i];
		$mfd_col['mfd_width'] = 5;
		$mfd_cols[$i] = $mfd_col;
		
	return $mfd_cols;

}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist


$BEREICH = 'ADMIN';


$md     = GET_md(0);
$id     = GET_id(0);
$daten  = GET_daten("");
$sub    = GET_sub("");

$ID     = GET_SESSIONID("");
$p_md   = POST_md(0);
$p_id 	= POST_id(0);
$p_row 	= POST_row("");

session_start($ID);
$user       = $_SESSION["user"];
$user_lvl   = $_SESSION["user_lvl"];
$spieler_id = $_SESSION["spieler_id"];
$user_id 	= $_SESSION["user_id"];

if ($ID == "")
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

if (is_admin()==FALSE)
{
  $session_id = 'FFFF';
  header ("Location: main.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}


print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Meister ";

print_kopf($admin_typ,$header_typ,"Menu Konfigurator",$anrede,$menu_item);



$mfd_list = make_mfd_list($BEREICH, $sub);
$mfd_cols = make_mfd_cols($mfd_list);

switch($p_md):
case 5: // Insert -> Erfassen
	mfd_insert($mfd_list, $p_row);
	$md = 0;
break;
case 6: // Update -> Edit
	mfd_update(mfd_list, $p_row);
	$md = 0;
	break;
	endswitch;

switch ($md):
case 2: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "MENUITEMS","link" => "$PHP_SELF?md=1&ID=$ID"),
		        1=>array("icon" => "1","caption" => "NEU","link" => ""),
				2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 4:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "MENUITEMS","link" => "$PHP_SELF?md=1&ID=$ID"),
		        1=>array("icon" => "1","caption" => "ÄNDERN","link" => ""),
	            2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 10: // main
	$menu = array (0=>array("icon" => "7","caption" => "MENUITEMS","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "MENUITEMS","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Neu","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_config.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu_status($menu);

switch ($md):
case 2:
	mfd_erf($id,$ID,$mfd_list,$mfd_cols);
	break;
case 4:
	mfd_edit($id,$ID,$mfd_list,$mfd_cols);
	break;
case 10:
	break;
default:
    print_sub_list($ID,$sub);
	print_mfd_liste($ID,$mfd_list,$mfd_cols);
	break;
endswitch;

	print_md_ende();


	?>