<?php

/*
 Projekt :  INTERN

Datei   :  larp_sub.php

Datum   :  2013/03/13

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script werden die Subbereich dargestellt.
Die Subseiten sind in der Datenbank gespeichert und werden als HTML angezeigt.
Es gibt keine Zugriffsverwaltung aber intern Rechte !
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

function get_sub_page($mfd_list, $sub, $page)
{
	$mfd_list["where"] = "ref_sub = $sub and page=$page";
	return mfd_data_result($mfd_list);
}


function print_sub_page($sub,$daten)
{
	$table = "menu_page";
	$mfd_list=make_mfd_table($table,$table);
	$mfd_cols = make_mfd_cols_default($table, $table);
	
	$result =  get_sub_page($mfd_list,$sub,$daten);
	
	while ($row = mysql_fetch_assoc($result))
	{
		$lines=explode("\n",$row["page_text"]);
		
		print_data_html($lines);
	}
}

function get_sub_pages_list($mfd_list, $sub)
{
	$mfd_list["fields"] = "page";
	$mfd_list["where"] = "ref_sub = $sub";
	$result = mfd_data_result($mfd_list);
	$i = 0;
	while ($row = mysql_fetch_assoc($result))
	{
	  $pages[$i] = $row["page_titel"];
	  $i++;
	}
	
	return $pages;
}


function print_pages_list($sub,$ID,$menu)
{
	global $PHP_SELF;
	$pages = get_sub_pages_list($sub);

	for($i=0; $i<count($pages); $i++)
	{
		$name = $pages[$i];
		$menuitem["icon"] 		= "_text";
		$menuitem["caption"] 	= ucfirst($name);
		$menuitem["link"] 		= $PHP_SELF."md=1&amp;daten=$name&amp;sub$sub&amp;ID=$ID";
		$menuitem["itemtyp"] 	= "0";
		$meu[$i+1] = $menuitem;
	}
	return $menu;
}


function get_menu_subbereich($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
	switch ($md):
	case 1: // Erfassen eines neuen Datensatzes
		$menu = array (
		0=>array("icon" => "1","caption" => $titel,"link" => ""),
		99=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$name&amp;sub$sub&amp;ID=$ID")
		);
		$menu = print_pages_list($sub,$ID,$menu);
		break;
	default:  // MAIN-Menu
		$menu = array (
		0=>array("icon" => "0","caption" => $titel,"link" => ""),
		2=>array("icon" => "_stop","caption" => "Zurück","link" => get_home($home)."?md=0&amp;ID=$ID")
		);
		endswitch;
		return $menu;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
	$BEREICH = 'INTERN';
	
	$md     = GET_md(0);
	$daten  = GET_daten("");
	$sub    = GET_sub("main");
	$item   = GET_item("");
	$ID     = GET_SESSIONID("");

	
	session_id ($ID);
	session_start();
	$user       = $_SESSION["user"];
	$user_lvl   = $_SESSION["user_lvl"];
	$spieler_id = $_SESSION["spieler_id"];
	$user_id 	= $_SESSION["user_id"];
	$SID        = $_SESSION["ID"];
	

	if ($ID != $SID)
	{
		header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
		exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
		// Code ausgeführt wird.
	}
	
	if (is_user()==FALSE)
	{
		//  echo "no lvl";
		header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
		exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
		// Code ausgeführt wird.
	}
	
	print_header("Subbereich");
	print_body();
	
	$menu_item = array("icon" => $menu_help, "caption" => "Help","link" => "javascript:openHelp()");
	print_kopf($logo_typ,$header_typ,"Öffentlich",$anrede,$menu_item);
	
	$titel = ucfirst($sub);
	$home = "main.php";
	
	$menu = get_menu_subbereich($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);
	
	print_menu($menu);

	switch ($md):
	case 1:
		//$page=$sub.'/'.$daten;
		print_sub_page($sub,$daten);
	break;
	
	default: // MAIN MENÜ
		$page=$sub.'/'.$sub;
		print_data($page);
		break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>