<?php

/*
 Projekt :  ADMIN

Datei   :  admin_edit.php

Datum   :  2013/02/14

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <menu_item>

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

function new_edit ()
{
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!---  DATEN Spalte   --->\n";
  echo "Editor";
  echo "<p>";
  echo "<form method=\"post\">";
  echo "<textarea name=\"editor1\">&lt;p&gt;Initial value.&lt;/p&gt;</textarea>";
echo "<!--  Text editor Konfiguration-->";  
echo "  <script type=\"text/javascript\">";
echo "  CKEDITOR.replace( 'editor1' ,"; 
echo "	{ ";
echo "	  toolbar: [";
echo "	            { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },"; 
echo "	            // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.";
echo "	            [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],";      
echo "	            // Defines toolbar group without name.";
echo "	            '/',";                                          
echo "	            // Line break - next group will be placed in new line.";
echo "	            { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },";
echo "	            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },";
echo "	            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] }";
echo "	          ]";	  
echo "    ,uiColor : '#9AB8F3'";    
echo "	  ,	language: 'de'";
echo "  }";
echo "  );";
echo "  </script>";
  echo "</p>";
  echo "<p>";
  echo "<input type=\"submit\">";
  echo "</p>";
  echo "</script>";
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
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
default: // main
	$menu = array (0=>array("icon" => "7","caption" => "MENUITEMS","link" => "$PHP_SELF?md=1&ID=$ID"),
	1=>array ("icon" => "_plus","caption" => "Editor","link" => "$PHP_SELF?md=2&ID=$ID"),
	5=>array ("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu_status($menu);

switch ($md):
case 2:
	new_edit();
	break;
case 4:
	
	break;
case 10:
	break;
default:
	if (!$p_editor1)
	{
	echo $p_editor1;  
	
	}
	break;
endswitch;

	print_md_ende();


	?>