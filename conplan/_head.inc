<?php

/*
 Projekt : CONPLAN

Datum   :  $date$  / 03.02.2013 

Rev.    :  $rev$   / 3.0

Author  :  @author oduda


beschreibung :	Funktonssammlung fuer den Aufbau einer
Drachenhorst HTML Seite

function admin_kopf ()
function print_header ($NAME)
function print_body($back_typ)
function print_body_ende()
function print_kopf ($logo_typ, $header_typ,$bereich,$anrede)
function print_md()
function print_menu_ref($typ, $ref)
function print_menu ($menu)
function print_data($html_file)

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include_once "_config.inc";
include_once "_lib.inc";


/**
 * erstellt einne html Header mit css-Layout 
 * @param unknown $NAME, enthält den Seitennamen
 */
function print_header ($NAME)
{
	global $grp_name ;
	global $layout_path ;
	global $version ;
	 
	echo "<HTML>\n";
	echo "<!-- PHP ".phpversion()." / Drachenhorst Framework $version / 2013-->\n";
	echo "<HEAD>\n";
	echo "<TITLE></TITLE>\n";
	echo "<META NAME=\"Description\" CONTENT=\"$grp_name \">\n";
	echo "<META NAME=\"Keywords\" CONTENT=\"LARP $NAME\">\n";
	echo "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
	echo"  <title>$grp_name $NAME </title> \n";
	echo"  <link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/konzept1.css\">  \n";
	echo"  <script src=\"js/test1.js\" type=\"text/javascript\"></script>  \n";
	echo "</HEAD>\n";
	echo "\n";
}

/**
 * Erstellt den Body Anfang einer Html Seite
 * Das Layout wird aus dem css geholt siehe print_header
 */
function print_body()
{
  $style = $GLOBALS['style_page_1'];
  echo "<body  ";
	//print_background ($back_typ);  //background ist m layout enthalten
  echo " >\n";
  // anfang seiten definition
  echo "<div $style >\n";
}

/**
 * Erstellt das Body ende und das page ende
 */
function print_body_ende()
{
  // ende der Seiten div
  echo "</div>\n";
//  echo "</div>\n";
  echo "</body>\n";
  echo "</html>\n";
};

function print_kopf ($logo_typ, $header_typ,$bereich,$anrede, $menu_item)
{
 
  $info = "Login aufrufen";
  $formel = $anrede["formel"];
  $name   = $anrede["name"];
//  echo "<div id=\"div_1\">\n";
      $style = $GLOBALS["style_header_1"];
      echo "  <div $style >\n";
      $style = $GLOBALS["style_headerleft"];
      echo "    <div $style >\n";
      print_header_icon($GLOBALS["logo_typ"]);
      echo "    </div>\n";
      $style = $GLOBALS['style_headermain'];
      echo "    <div $style >\n";
      print_header_icon($GLOBALS["header_typ"]);
      echo "    </div>\n";
      $style = $GLOBALS['style_headerright'];
      echo "    <div $style >\n";
      echo "      <p>$bereich</p>\n";
      echo "      <p>$formel</p>\n";
      echo "      <p>$name</p>\n";
      if ($menu_item['icon'] != "0")
        {
          $style = "id=\"headermenuitem\""; //$GLOBALS['style_menu_item'];
          echo "      <div $style >\n";
            print_menu_item($menu_item);
//           print_menu_icon($typ,$info);
//           print_menu_ref("Login", $ref);
          echo "    	</div>\n";
        } else
        {
          $caption = $menu_item['caption'];
          echo "      <p>$caption</p>\n";
        }
      echo "    </div>\n";
    echo "  </div>\n";
  echo "\n\n";
};


/**
 * Kommentar fuer anfang menu/daten
 */
function print_md()
{
  echo "<!---  Menu und Daten   --->\n";
};

/**
 * Kommentar fuer Ende Menu/Daten
 */
function print_md_ende()
{
  echo "<!---  ENDE Menu und Daten   --->\n";
};

/**
 * Entfernt  <head> und <body> 
 * @param unknown $lines
 * @return Ambigous <string, unknown>
 */
function get_htmlbody($lines)
{
    $outline[0] = "";
    $ishead = false;
    $index = 0;
	for($i=0; $i<count($lines); $i++)
	{
	    $line = $lines[$i];
		/* Funktioniert nur, wenn Titel und title-Tags in einer Zeile stehen */
		if ($ishead != true)
		{
		    if (preg_match ("</head>", $line, $out, PREG_OFFSET_CAPTURE))
			{
			  $ishead = false;
			} else
			{
				if (preg_match ("</body>", $line, $out, PREG_OFFSET_CAPTURE))
				{
				  $ishead = false;
				} else
				{
					if (preg_match ("<body>", $line, $out, PREG_OFFSET_CAPTURE))
					{
					  $ishead = false;
					} else
					{
// 						if (preg_match ("<table>", $line, $out, PREG_OFFSET_CAPTURE))
// 						{
// 							$outline[$index] = "<table> ";
// 							$index++;
// 						} else
// 						{
// 						}
						$outline[$index] =  $line;
						$index++;
					};
				};
			};
		} else
		{  //preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
			
			if (preg_match("</head>", $line, $out, PREG_OFFSET_CAPTURE))
			{
			  $ishead = false;
			};
			if (preg_match ("</body>", $line, $out, PREG_OFFSET_CAPTURE))
			{
			  $ishead = false;
			};
		}
	}
	//echo $line;
	return $outline;
}

/**
 * Lese html file und erzeugt array of textlines
 * @param unknown $html_file
 * @return boolean|string
 */
function read_html_page($html_file)
{
	// pruefe ob File vorhanden
	$file = fopen ($html_file, "r");
	// keine leere seite anzeigen
	if (sizeof($html_file) == 0 ) { return false; }

	$file = fopen ($html_file, "r");

	//     $style = $GLOBALS['style_status1'];
	//     echo '<p $style> Caught exception: ',  $e->getMessage()," </p>\n";
	//   	return;

	if (!$file)
	{
		$style = $GLOBALS['style_status1'];
		echo "<p $style > n";
		echo "<p $style>Datei konnte nicht ge&ouml;ffnet werden.</p>\n";
		echo "</p> \n";
		return false;
	};
	$i=0;
	while (!feof ($file))
	{
		$lines[$i] = fgets ($file, 1024);
		$i++;
	};
	fclose($file);

	return $lines;
}


/**
 * Bindet einen html file in den Dtabereich ein
 * der pfa ist der defaultpfad ./pages
 * @param unknown $html_file
 */
function print_pages($html_file)
{
  // keine leere seite anzeigen
  if (sizeof($html_file) == 0 ) { return; }
   
  $path_file = $GLOBALS['path_html'].$html_file;
  print_data($path_file);
}
/**
 * Gibt eine Htnl Datei im Datentab aus, default style
 * @param unknown $html_file
 */
function print_data($html_file)
{
  // pruefe ob File vorhanden
  // keine leere seite anzeigen
  if (sizeof($html_file) == 0 ) { return; }
  	
  $lines = read_html_page($html_file);
  
  if($lines == false) { return; }
  // header und body entfernen
  $outline = get_htmlbody($lines);
  // Zeilen ausgeben als datatab
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!---  DATEN Spalte   --->\n";
  for($i=0; $i<count($outline); $i++)
  {
  	echo $outline[$i];
  }
  echo "</div>\n";
  echo "<!---  ENDE DATEN Spalte   --->\n";
};


?>