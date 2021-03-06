<?php

/*
 Projekt :  MAIN

Datei   :  main_sub.php

Datum   :  2013/03/13

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird die Subbereich Land abgewickelt.
Die Subseiten sind HTML Seiten in einem Verzeichnis.
Es gibt keine Zugriffsverwaltung und keine Rechte !
Es werden HTML Seiten angezeigt,
die folgenden Subdir  werden werden relativ benutzt

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

include "_config.inc";
include "_lib.inc";
include "_head.inc";



function print_pages_list($sub,$ID,$menu)
{
	global $PHP_SELF;
	$path=$sub;
	$pages = get_pages_htm($path);
//  echo $path.":".$pages[1];
	for($i=1; $i<count($pages); $i++)
	{
// 	  if ($i==1)
// 	  {
// 	    $pages[$i] = $pages[$i].".html";
// 	  }
	  $name = substr($pages[$i],0,strpos($pages[$i],"."));
		$menuitem["icon"] 		= "_text";
		$menuitem["caption"] 	= ucfirst($name);
		$menuitem["link"] 		= $PHP_SELF."?md=1&amp;daten=$pages[$i]&amp;sub=$path&amp;ID=$ID";
		$menuitem["itemtyp"] 	= "0";
		$menu[$i+1] = $menuitem;
	}
	return $menu;
}


function get_menu_subbereich($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
	switch ($md):
	case mfd_add: // Erfassen eines neuen Datensatzes
		$menu = array (
		0=>array("icon" => "1","caption" => $titel,"link" => ""),
		99=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&amp;daten=$name&amp;sub$sub&amp;ID=$ID")
		);
		break;
	default:  // MAIN-Menu
		$menu = array (
		0=>array("icon" => "0","caption" => $titel,"link" => ""),
		99=>array("icon" => "_stop","caption" => "Zur�ck","link" => get_home($home)."?md=0&amp;ID=$ID")
		);
		$menu=print_pages_list($sub,$ID,$menu);
		break;
	endswitch;
		return $menu;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
	$BEREICH = 'PUBLIC';

	$md 		= GET_md(0);					// aktuelle Funktion
	$daten	=	GET_daten("");			// daten referenz fuer html etc
	$sub 		= GET_sub("");
	$id			= GET_id(0);
	
	print_header("Subbereich");
	print_body();
	
	$menu_item = $menu_item_help;
	print_kopf($logo_typ,$header_typ,"�ffentlich",$anrede,$menu_item);
	
	$titel = ucfirst($sub);
	$home = "main.php";
	$menu = get_menu_subbereich($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);
	
	print_menu($menu);
	switch ($md):
	case 1:
		$page=$sub.'/'.$daten;
		print_data($page);
	break;
	
	default: // MAIN MEN�
		$page=$sub.'/'.$sub.".html";
		print_data($page);
		break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>