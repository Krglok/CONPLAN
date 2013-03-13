<?php
/*
 Projekt :  MAIN

Datei   :  help.php

Datum   :  2002/06/12

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Hilfe aufgerufen.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es wird Datenbankeintraegen gesucht, ansonsten wird die Hilfe
HTML Page aufgerufen.
Die Hilfe Seiten werden in einem separaten Fenster aufgerufen.

Ver 3.0 / 04.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once '_mfd_lib.inc';
include_once "_head.inc";
//include_once '_log_lib.inc';

function print_help_header()
{
  global $grp_name ;
  global $layout_path ;
  global $version ;

  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
  echo "<!-- PHP ".phpversion()." / Drachenhorst Framework $version / 2013-->\n";
  echo "<HEAD>\n";
  echo "<meta http-equiv=\"Content-type\" content=\"text/html;\">"; //charset=UTF-8
  echo "<META NAME=\"Description\" CONTENT=\"$grp_name \">\n";
  echo "<META NAME=\"Keywords\" CONTENT=\"LARP HELP\">\n";
  echo "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
  echo"  <link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/help1.css\">  \n";
  echo"</head> \n";
  echo"<body > \n";
}

function print_help_body_ende()
{
  echo "</body> \n";
  echo "</html> \n";
}


function print_menue_help_header($icon, $caption, $style)
{
  echo "\t <div $style >\n";
	print_menu_icon($icon,"Hilfesystem");
  echo "$caption \n";
  echo "\t </div >\n";
}

function print_menu_help ($menu)
{
  //   menü spalte
  echo "<!--  Menu Spalte   -->\n";
  //  stellt die breite der Menüspalte ein !!!
  $style = "id=status";
  echo "<div $style >\n";

  //  separate div pro Menu item
  //   $style = $GLOBALS['style_menu_head'];
  //   echo "\t<div  ><!-- Row:1, Col:1 -->\n";
  //   echo "\t</div >\n";
  $item = $menu[0];
  $is_sub = $item["icon"];
  $caption = $item["caption"];
  if (isset($item["itemtyp"])==false)
  {
    $itemtyp = "0";
  }
  
  $styleheader = "id=statusheader";
  if ($is_sub != "")
  {
    print_menue_help_header($item["icon"],$caption, $styleheader);
  } else
  {
    print_menue_header($caption, $styleheader);
  }

  $style = "id=statusitem";

  reset ($menu);
  $i = 0;
  foreach ($menu as $item)
  {
    echo "\t\t<div $style ><!-- Row:1, Col:1 -->\n";
    // das erste Ellement ist der Header !!
    if ($i > 0)
    {
      //echo $i;
      if ($item["icon"] == "1")
      {
        print_menue_header($item["caption"], $styleheader);
      } else {
        print_menu_item($item);
      }
    }
    echo "\t\t</div >\n";
    $i++;
  }
  if ($is_sub == "0")    // Codierung des Menuheader Icon
  {
    if (is_author()==TRUE)
    {
      print_menu_item($menu_item_author);
    }
    if (is_subsl()==TRUE)
    {
      print_menu_item($menu_item_subsl);
    }
    if (is_sl()==TRUE)
    {
      print_menu_item($menu_item_sl);
    }
    if (is_admin()==TRUE)
    {
      print_menu_item($menu_item_admin);
    }
  }
  //  echo "\t\t</div >\n";
  echo "\t</div >\n";
  echo "<!--  Menu Spalte ENDE   -->\n\n";
};


function get_help_page($item, $md, $datem, $sub)
{
  $table = "hilfe";
  $mfd_list = make_mfd_table($table, $table);
  $mfd_cols = make_mfd_cols_default($table, $table);
  $mfd_list["where"] = "help_modul=\"$item\" ";
  $result = mfd_data_result($mfd_list);
  $row_num = mysql_num_rows($result);
  $row = mysql_fetch_assoc($result);
  if ($row_num > 0)
  {  
    return $row["text"];
  } else
  {
    return false;
  }
}

function print_html($lines)
{
  if($lines == false)
  {
    $lines[0] = "NO HTML LINES";
  }
  // header und body entfernen
  // Zeilen ausgeben als datatab
  $style = "id=\"page\"";
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  for($i=0; $i<count($lines); $i++)
  {
    echo $lines[$i];
  }
  echo "</div>\n";
  echo "<!--  ENDE DATEN Spalte   -->\n";

}


function get_menu_hilfe($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
  // manuelles main menu
  $menu = array (
      0=>array("icon" => "_help","caption" => "Hilfeseite","link" => "ss","itemtyp"=>"0"),
      1=>array("icon" => "1","caption" => "$titel","link" => "","itemtyp"=>"0")

  );
  return $menu;
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keine user pruefung, da es eine public seite ist
$BEREICH = 'HILFE';
// Steuerparameter und steuerdaten
$md     =GET_md(0);
$item   =GET_item("");
$sub    =GET_sub("main");
$daten  =GET_daten("");

$helppage = get_help_page($item, $md, $daten, $sub);
if ($helppage == false)
{
  $html_file = "./help/help.html";
  print_help_header("Hilfeseite");
  print_data($html_file);
  echo "Kein Help-Datensatz";
  
} else
{
  print_help_header("Hilfeseite");
  $menu = get_menu_hilfe($md, $PHP_SELF, "", $item, 0, $daten, $sub, $PHP_SELF);
  print_menu_help($menu);
  $lines = explode("\n", $helppage);
  print_html($lines);
  print_help_body_ende();

}


?>