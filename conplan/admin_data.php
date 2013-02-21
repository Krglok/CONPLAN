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
	echo "<!---  DATEN Spalte   --->\n";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_edit.inc';


$field_item = array
(
		"Field" => "",
		"Type" => "",
		"Null" => "",
		"Key" => "",
		"Default" => "",
		"Extra" => ""   //auto_increment
);

/**
 * Fragt die Feldliste in der Datenabnk ab.
 * ACHTUNG ! die Datenbank connection muss vorhanden sein !
 * @param unknown $table
 */
function get_fieldlist($table)
{
	$result = mysql_query("SHOW COLUMNS FROM $table");
	return $result;
}

/**
 * Ermittelt die Default Width anhand des Datentyp
 * @param unknown $typ
 * @return number|multitype:
 */
function get_fieldtyp_width($typ)
{
	if (stripos($typ,"int")>0)
	{
		return 8;
	} else if(stripos($typ,"varchar")>0)
	{
		$s =  explode("(",$typ);
		$len = explode(")",$s[1]); 
		return $len;
	} else if(stripos($typ,"text")>0)
	{
		return 12;
	} else if(stripos($typ,"enum")>0)
	{
	   return 5;
	} else 
	{
	  return 10;
	}
}

/**
 * erzeugt automatisch die col-definitionen fuer eine Tabelle
 * @param unknown $table
 */
function get_mfd_fields_default($table,$mfd_name)
{
	$result = get_fieldlist($table);
	
	$i=0;
	while ($row = mysql_fetch_row($result))
	{
	  // 0 = Field, 1 = Type, 2 Null, 3 = Key, 4Defaault, 5=Extra
		$mfd_col["mfd_name"]	= $mfd_name;
		$mfd_col["mfd_titel"]	= $table;
		$mfd_col["mfd_pos"]		= $i; 
		$mfd_col["mfd_field"]	= $row[0];
		$mfd_col["mfd_field_titel"] = $row[0]; 
		$mfd_col["mfd_width"]	= get_fieldtyp_width($row[1]);
		$mfd_cols[$i] = $mfd_col;
		$i++;
	}
	return $mfd_cols;
}

/**
 * erstellt eine Tabelle , formatiert fuer Datatab
 * mit den definition einer tabelle nach mfd schema
 * @param unknown $table
 */
function show_table_info($table,$ID)
{
    print_table_list($ID);
    $mfd_name = "mfd_".$table;
	$mfd_cols = get_mfd_fields_default($table, $mfd_name);
	
	$style = $GLOBALS['style_datatab'];
	echo "<div $style > \n";
	echo "<!---  DATEN Spalte   --->\n";
	echo "<TABLE border=\"1\"> \n";
	echo "<TBODY> \n";
		echo "<TR> \n>";
			echo "<TD>\n";
  		echo "Tabelle";
			echo "</TD> \n";
			
			echo "<TD> \n";
	  	echo "<b>".$table."</b>";
			echo "</TD> \n";
				
			echo "<TD> \n";
			echo "";
			echo "</TD> \n";
		echo "</TR> \n";

		echo "<TR> \n";
			echo "<TD> \n";
			echo "Fieldname \n";
			echo "</TD> \n";
				
			echo "<TD> \n";
			echo "Titel \n";
			echo "</TD> \n";
			
			echo "<TD> \n";
			echo "Width \n";
			echo "</TD> \n";
		echo "</TR> \n";
	foreach ($mfd_cols as $mfd_col)
	{
		echo "<TR> \n";
		echo "<TD> \n";
		echo $mfd_col["mfd_field"];
		echo "</TD> \n";
		
		echo "<TD> \n";
		echo $mfd_col["mfd_titel"];
		echo "</TD> \n";
			
		echo "<TD> \n";
		echo $mfd_col["mfd_width"];
		echo "</TD> \n";
		echo "</TR> \n";
		
	}		
	echo "</TBODY> \n";
	echo "</TABLE> \n";
	echo '</div> \n';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
}

/**
 * erzeugt eine komma separatet list der Feldnamen 
 * @param unknown $table
 * @return string
*/
function get_fieldname_list($table)
{
	$result = get_fieldlist($table);
	$list = "";
	foreach($result as $row)
	{
		$list = $list.",".$row["Field"];
	}
	return $list;
}

/**
 * erzeugt eine mfd definition fuer eine tabelle
 * @param unknown $table
 * @return string
 */
function make_mfd_table($table, $mfd_name)
{
	$mfd_list['mfd'] = mfd_name;
	$mfd_list['table'] = $table;
	$mfd_list['titel'] = $table;
	$mfd_list['fields'] = get_fieldname_list($table);
	$mfd_list['join'] = "";
	$mfd_list['where'] = "id > 0";
	$mfd_list['order'] = "id";
	return $mfd_list;
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

	$style = "id=\"style_datatab\"";
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
    echo "<div $style >";
    echo "<!---  MENU Spalte   --->\n";
    
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
  echo "<div >";
  echo "<p>";
  echo " ";
  echo "</p >";
  echo "</div >";


  $style = "id=\"menu\"";
  echo "<div $style >";
  echo "<!---  DATEN Spalte   --->\n";
  echo "<table  border=\"1\"> \n"; //width=\"100%\"
  echo "<tbody >";

  for($i=0; $i<count($pages); $i++)
    {
    $name = $pages[$i];
    echo "\t<tr> \n";
		echo "\t\t<td width=\"25\"> \n";
		if ($i>0)
      {
    		echo "<a href=\"$PHP_SELF?md=2&daten=$name&ID=$ID \" >";
    		print_menu_icon("_db","Edit Html Datei");
    		    echo "</a>";
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
		  print_menu_icon("_branch","Preview Html Datei in separatem Fenster");
		      echo "</a>";
  }
  echo "";
  echo "";
		echo "\t\t</td> \n";
		echo "\t</tr> \n";
	}

	echo "</tbody>";
	echo "</table>\n";
    echo '</div>';
	echo '</div>';
    echo "<!---  ENDE DATEN Spalte   --->\n";
	
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
$PHP_SELF = $_SERVER['PHP_SELF'];

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

$bereich = "PUBLIC";
$sub     = "main";
$item		 = "regeln";


switch($p_md):
case 5: // Insert -> Erfassen
//	insert($p_row);
	$md = 0;
break;
case 6: // Insert -> Erfassen
//	update($p_row);
	$md = 0;
	break;
	endswitch;



	switch ($md):
case 2: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "DATA","link" => "$PHP_SELF?md=1&ID=$ID"),
		        1=>array("icon" => "1","caption" => "NEU","link" => ""),
				2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 4:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "DATA","link" => "$PHP_SELF?md=1&ID=$ID"),
		        1=>array("icon" => "1","caption" => "ÄNDERN","link" => ""),
	            2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
	);
	break;
case 10: // main
	$menu = array (0=>array("icon" => "7","caption" => "DATA","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Erfassen","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "DATA","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Editor","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu_status($menu);

switch ($md):
case 2:
    show_table_info($daten,$ID);
	break;
case 4:
	break;
case 10:
	break;
default:
  print_table_list($ID);
  break;
endswitch;

print_md_ende();

?>