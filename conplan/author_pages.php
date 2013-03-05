<?php

/*
 Projekt :  ADMIN

Datei   :  author_pages.php

Datum   :  2013/02/15

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für HTML Dateien
- Liste der HTML in ./pges
- Erfassen neuer Dateien
- Bearbeiten vorhandener Dateien

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
include_once '_edit.inc';


function get_pagesdir($dir,$file_extend)
{
	if ($handle = opendir($dir)) 
	{
		/* This is the correct way to loop over the directory. */
		$i = 0;
		$dir_entry[$i] = $dir;
		while (false !== ($entry = readdir($handle))) 
		{
		  $pos = stripos($entry,$file_extend);
//          echo $file_extend."/".$entry.":".$pos."<br>\n";
		  if ( $pos === false )
		  {
		    //echo $file_extend."/".$entry."\n";
		  } else
		  {
   			$i++;
    		$dir_entry[$i] = $entry;
    		//    		echo "$entry <br>\n";
		  }
		}
		closedir($handle);
	}
	return $dir_entry;
}


function get_pages_list($path)
{
//	$dir = './pages';
	$file_extend = "htm";
	$pages =  get_pagesdir($path,$file_extend);
	return $pages;
}

function get_images_list()
{
	$dir = './images';
	$file_extend = "";
	$images =  get_pagesdir($dir,$file_extend);
	return $images;
}

function print_pages_list($path,$ID,$sub)
{
	global $PHP_SELF;
	$pages = get_pages_list($path,".html");
	
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
    		echo "<a href=\"$PHP_SELF?md=2&daten=$name&ID=$ID&sub=$sub \" >";
    		print_menu_icon("_editor","Edit Html Datei");
    		echo "</a>";
        	echo "\t\t</td> \n";
        	echo "\t\t<td> \n";
        	echo "$name";
        	echo "";
        	echo "\t\t</td> \n";
        	echo "\t\t<td> \n";
        	if ($i>0)
        	{
          		echo "<a href=\"$PHP_SELF?md=3&daten=$name&ID=$ID&sub=$sub \"> ";
          		print_menu_icon("_text","Preview Html Datei in separatem Fenster");
          		echo "</a>";
        	}
        	echo "";
        	echo "";
        	echo "\t\t</td> \n";
        	echo "\t</tr> \n";
		} else
		{
		  echo "<a href=\"$PHP_SELF?md=1&ID=$ID&sub=$sub \" >";
		  print_menu_icon("_plus","Neue Html Datei");
		  echo "</a>";
		  echo "\t\t</td> \n";
		  echo "\t\t<td> \n";
		  echo "<b>Neu</b>";
		  echo "";
		  echo "\t\t</td> \n";
		  echo "\t\t<td> \n";
          echo "";
  		  echo "";
    	  echo "\t\t</td> \n";
    	  echo "\t</tr> \n";
		}
	}
	
	echo "</tbody>";
	echo "</table>\n";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
}


function pages_edit ($path,$name,$ID,$sub)
{
  global $PHP_SELF;

  $lines = lese_html_lines ($path,$name);
  $next  = 6;
	
  $style = $GLOBALS["style_datatable"];
  echo "<div $style >";
//  echo "Dateiname: ".$name;
  
  echo "<!--  DATEN Spalte   -->\n";
    echo "<p>";
	echo "<FORM ACTION=\"$PHP_SELF?md=3&daten=$name&ID=$ID&sub=$sub\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$name\">\n";
	
//	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"   VALUE=\"$ID\">\n";
	echo "<p>";
	echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"RESET\" VALUE=\"Reset\">";
	echo "</p>";
	
	$text = $lines[0];
	for ($i=1; $i<count($lines); $i++)
	{
	  $text = $text.$lines[$i];
	}
	echo "<textarea   name=\"editor1\"  COLS=\"80\" ROWS=\"34\" >"; //class=\"ckeditor\"
    echo $text;
	echo "</textarea>";
  
  echo "<!--  Text editor Konfiguration-->";
  echo "  <script type=\"text/javascript\">";
  echo " CKEDITOR.replace('editor1',{	
  toolbar: 'Full',
  uiColor : '#9AB8F3',
  height : '450px'
  } );";
    echo "  </script>";
  echo "</p>";
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
  
} 

function print_preview($path,$name,$ID,$sub)
{
  
  print_pages_list($path,$ID,$sub);
  echo "<!--  Preview Spalte   -->\n";
//  echo $name;
  $html_file = $path."/".$name;
  print_data($html_file);	
  echo "<!--  ENDE Preview Spalte   -->\n";
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

$BEREICH = 'AUTHOR';


$md     = GET_md(0);
$id     = GET_id(0);
$daten  = GET_daten("");
$sub    = GET_sub("");

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

if (is_author()==FALSE)
{
  header ("Location: main.php?md=0");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}


print_header_admin("Authoren Bereich");

print_body();

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
$anrede["formel"] = "Sei gegrüsst Author ";

print_kopf($admin_typ,$header_typ,"HTML Pages",$anrede,$menu_item);

$bereich = "AUTHOR";

if ($sub == "")
{
  $path ="./regeln";
} else
{
  $path ="./".$sub;
}

switch($p_md):
case 5: // Insert -> Erfassen
//	insert($p_row);
    echo $path."/".$p_id;
	schreibe_hmtl_lines($path,$p_id,$p_editor1);
	$daten = $p_id;
    echo "Insert speichern";
	$md = 3;
break;
case 6: // Insert -> Erfassen
//	update($p_row);
	schreibe_hmtl_lines($path,$p_id,$p_editor1);
//    echo "Update speichern";
    $md = 3;
	break;
	endswitch;


//mneu aufbereitung 
switch ($md):
case 1: // erfassen
		$menu = array (0=>array("icon" => "7","caption" => "HTML Pages","link" => ""),
		        1=>array("icon" => "1","caption" => "NEU","link" => ""),
				2=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
case 2:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "HTML Pages","link" => ""),
		        2=>array("icon" => "1","caption" => "ÄNDERN","link" => ""),
	            9=>array ("icon" => "1","caption" => $daten,"link" => ""),
	            10=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
case 3:  //Bearbeiten
	$menu = array (0=>array("icon" => "7","caption" => "HTML Pages","link" => ""),
		        2=>array("icon" => "1","caption" => "PREVIEW","link" => ""),
		        9=>array ("icon" => "1","caption" => $daten,"link" => ""),
		        3=>array("icon" => "_list","caption" => "SPIELER","link" => "$PHP_SELF?md=0&sub=spieler&ID=$ID"),
		        4=>array("icon" => "_list","caption" => "LAND","link" => "$PHP_SELF?md=0&sub=land&ID=$ID"),
		        5=>array("icon" => "_list","caption" => "HELP","link" => "$PHP_SELF?md=0&sub=help&ID=$ID"),
		        
	            10=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	break;
default: // main
	            $menu = array (
            	0=>array("icon" => "7","caption" => "HTML Pages","link" => ""),
            	1=>array ("icon" => "_list","caption" => "REGELN","link" => "$PHP_SELF?md=0&sub=regeln&ID=$ID"),
		        3=>array("icon" => "_list","caption" => "SPIELER","link" => "$PHP_SELF?md=0&sub=spieler&ID=$ID"),
		        4=>array("icon" => "_list","caption" => "LAND","link" => "$PHP_SELF?md=0&sub=land&ID=$ID"),
		        5=>array("icon" => "_list","caption" => "HELP","link" => "$PHP_SELF?md=0&sub=help&ID=$ID"),
	            10=>array ("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
	);
	break;
	endswitch;

	print_menu_status($menu,$ID);

switch ($md):
case 1:
	//pages_new($daten);
	break;
case 2:
    // Edit
	pages_edit($path,$daten,$ID,$sub);
	break;
case 3:
    // preview  
	print_preview($path,$daten,$ID,$sub);
	break;
	
default:
	print_pages_list($path,$ID,$sub);
	break;
endswitch;

	print_md_ende();


	?>