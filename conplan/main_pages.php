<?php

/*
 Projekt :  MAIN

Datei   :  main_land.php

Datum   :  2013/02/09

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die dyn. Menuabwicklung realaisiert.
Das Menu wird aus der Datenbank gelesen.
Es gibt keine Zugriffsverwaltung und keine Rechte ! 
d.h. das Script ist fuer den Public Bereich.
Es werden HTML Seiten angezeigt.
Die html-seiten kommen aus dem Verzeichnis
./pages 
Die images kommen aus dem Verzeichnis
./images

Datenbank:
TABLE `menu_bereich` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `bereich` varchar(45) DEFAULT NULL,
  `bereich_titel` varchar(45) DEFAULT NULL,
  `bereich_lvl` int(11) DEFAULT NULL,

TABLE `menu_sub` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_bereich` int(11) NOT NULL,
  `sub` varchar(45) DEFAULT NULL,
  `sub_bereich` varchar(45) DEFAULT NULL,
  `sub_titel` varchar(45) DEFAULT NULL,
  `sub_html` varchar(200) DEFAULT 'pages/',
  `sub_images` varchar(200) DEFAULT 'images/',

TABLE `menu_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` int(11) NOT NULL,
  `item` varchar(45) DEFAULT NULL,
  `item_titel` varchar(45) DEFAULT NULL,
  `item_typ` int(11) DEFAULT NULL,
  `item_icon_typ` int(11) DEFAULT NULL,
  `item_icon` varchar(45) DEFAULT NULL,
  `item_link` varchar(200) DEFAULT NULL,
  `item_sort` int(11) DEFAULT NULL,

TABLE `menu_page` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ref_sub` int(11) NOT NULL,
  `page` varchar(45) DEFAULT NULL,
  `page_titel` varchar(100) DEFAULT NULL,
  `page_typ` int(11) DEFAULT '1',
  `page_icon_typ` int(11) DEFAULT NULL,
  `page_icon` varchar(45) DEFAULT NULL,
  `page_layout` varchar(45) DEFAULT 'default',
  `page_text` text,





Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";



function print_table_info($result)
{

  $fields = mysql_num_fields($result);
  $rows   = mysql_num_rows($result);
  $table  = mysql_field_table($result, 0);
  echo "<table>";
  echo "<tr>";
  echo "<td>";
  echo "Table:";
  echo "</td>";
  echo "<td>";
  echo "<b> $table </b>";
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td width=45 > <b>type </b>  </td>  \n";
  echo "<td width=105 ><b> name </b> </td>  \n";
  echo "<td width=45 > <b>len</b>  </td> \n";
  echo "<td  > <b>flags</b> </td>\n";
  echo "</tr>";

  for ($i=0; $i < $fields; $i++)
  {
    $type  = mysql_field_type($result, $i);
    $name  = mysql_field_name($result, $i);
    $len   = mysql_field_len($result, $i);
    $flags = mysql_field_flags($result, $i);
    echo "<tr>";
    echo "<td width=45 > $type   </td>  \n";
    echo "<td width=105 > <b> $name</b>  </td>  \n";
    echo "<td width=45 > $len  </td> \n";
    echo "<td  > $flags </td>\n";
  echo "</tr>";
  }

  echo "</table>";
}

function print_table_infos($table, $daten)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
  
  mysql_select_db($DB_NAME);
  //$table = 'menu_bereich';
  
  $q = "SELECT * FROM $table ";
  //where bereich = \"$bereich\" and sub= \"$sub\"  order by item_sort";
  
  $result = mysql_query($q) or die("select Fehler....$q. \n");
  
  print_table_info($result);
}


function Print_tab_row($row,$pk)
{
  echo "\t\t <td>";
  echo "$pk";   
  echo "\t\t </td>";
  foreach ($row as $col)
  {
    echo "\t\t <td>";
    echo "$col";   
    echo "\t\t </td>";
  }
  echo "\t\t <td>";
  echo "*";   
  echo "\t\t </td>";
}


function print_row_head($mfd_cols)
{

  echo "<tr>\n";
  echo "\t\t<td> PK </td>";
  foreach ($mfd_cols as $mfd_col)
  {
    $titel = $mfd_col['mfd_field_titel'];
    $width = $mfd_col['mfd_width'];
    echo "\t\t<td width=\"$width\" ><b> $titel </b></td>\n";
  };
  echo "</tr>\n";
}


function print_tab_list($mfd, $daten)
{
  $result = mfd_data_result($mfd);
  $mfd_cols = mfd_data_cols($mfd);
  
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >  \n";
  echo "<!---  DATEN Spalte   --->\n";
//  print_table_info($result);
  
  echo "<table>";
  echo "\t <tbody>";
    // Reihenfolge der Row im resultset
      print_row_head($mfd_cols);
      $i = 0;
      while ($row = mysql_fetch_row($result))
      {
        $i++;
        echo "\t\t <tr>";
        print_tab_row($row,$i);  
        echo "\t\t </tr>";
      }
  
  echo "\t </tbody>";
  echo "</table>";

  echo "</div>\n";
  echo "<!---  ENDE DATEN Spalte   --->\n";
  
}



// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// dies ist ein Modul fuer den PUBLC Bereich, keine User pruefung , kein passwort
$BEREICH = 'PUBLIC';

print_header("Land");
print_body(2);

$md=GET_md(0);
$daten=GET_daten("");
$sub=GET_sub("main");
$menu=GET_item("regeln");

// Helpmenu im Header
$menu_item = $menu_item_help; 
print_kopf($logo_typ,$header_typ,"Öffentlich","Sei gegrüsst Freund ",$menu_item);

//echo "POST : $p_md / GET : $md / THEMEN :$THEMEN ";
/*
    1=>array ("icon" => "7","caption" => "bekannte Länder","link" => "$PHP_SELF?md=1&daten=land.html"),
    2=>array ("icon" => "7","caption" => "Kaarborg","link" => "$PHP_SELF?md=1&daten=land_1.html"),
    3=>array ("icon" => "7","caption" => "Whurola","link" => "$PHP_SELF?md=1&daten=land_2.html"),
    4=>array ("icon" => "7","caption" => "Kaer","link" => "$PHP_SELF?md=1&daten=land_3.html"),
    5=>array ("icon" => "15","caption" => "Online Welt","link" => "$PHP_SELF?md=1&daten=DraskoriaOnline.html"),
 */

$menu = array (0=>array("icon" => "99","caption" => "PAGES","link" => "","target"=>""),
    1=>array("icon" => "6","caption" => "Zurück","link" => "main.php?md=0")
);


if ($menu == '')
{
	print_menu($menu_default);
} else
{
	// Erstellt ein dynamisches Menu
	print_menu(get_menu_items($BEREICH, $sub));
	
}

switch ($md):
case 1:
	// html seiten als link
	// $daten entaelt den dateinamen mit vollstaendigem pfad
	print_data($daten);
  break;
case 2:
	// html seiten aus verzeichnis pages
	// $daten entaelt den dateinamen
  print_pages($daten);
  break;
case 100:
  // $daten kommt vom Client  $item kommt vom ServerMenu
  $sub = 'main'; 
  print_table_infos($daten,$sub);
  break;
case 101:
  // $daten kommt vom Client  $item kommt vom ServerMenu
  $sub = 'main'; 
  $daten = "menu_item";
  print_tab_list($daten,$sub);
  break;
default: // MAIN MENÜ
    $daten='main.html';
    print_pages($daten);
    break;
endswitch;

  print_md_ende();

  print_body_ende();

  ?>