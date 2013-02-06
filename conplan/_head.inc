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
	echo"  <title>$grp_name $NAME </title>";
	echo"  <link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/konzept1.css\">";
	echo"  <style>  </style>\n";
	echo "</HEAD>\n";
	echo "\n";
}

/**
 * Erstellt den Body Anfang einer Html Seite
 * Das Layout wird aus dem css geholt siehe print_header
 */
function print_body()
{

	echo "<BODY id=\"div_1\" ";
	//print_background ($back_typ);  //background ist m layout enthalten
	echo " >\n";
}

/**
 * Erstellt das Body ende und das page ende
 */
function print_body_ende()
{
  echo "</div>\n";
//  echo "</div>\n";
  echo "</BODY>\n";
  echo "</HTML>\n";
};

function print_kopf ($logo_typ, $header_typ,$bereich,$anrede, $ref)
{
  $typ = $GLOBALS['menu_key'];
  $info = "Login aufrufen";
  
//  echo "<div id=\"div_1\">\n";
  echo "<div id=\"page_1\">\n";
    echo "  <div id=\"header1\">\n";
      echo "    <div id=\"header1left\">\n";
      print_header_icon($GLOBALS["logo_typ"],$GLOBALS['style_header1left_img']);
      echo "    </div>\n";

      echo "    <div id=\"header1main\">\n";
      print_header_icon($GLOBALS["header_typ"],$GLOBALS['style_header1main_img']);
      echo "    </div>\n";
      
      echo "    <div id=\"header1right\">\n";
      echo "      <p>$bereich</p>\n";
      echo "      <p>$anrede</p>\n";
        if ($typ != "")
        {
          echo "      <div id=\"menu_status_r\">\n";
          print_menu_icon($typ,$info);
          print_menu_ref("Login", $ref);
          echo "    	</div>\n";
        } else
        {
          echo "      <p>$ref</p>\n";
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
 * Erzeugt einen Linkentrag mit default style
 * @param unknown $caption  sichtbarer text
 * @param unknown $ref  linkdaten, voll qualifiziert
 */
function print_menu_ref($caption, $ref)
{
  echo "            <A HREF=\"$ref\" > $caption </A>\n";
};


/**
 * Erzeugt ein Menu mit default style
 * @param unknown $menu  array mit menu daten
 */
function print_menu ($menu)
{
  global $user_lvl, $lvl_admin,$lvl_sl;
  
  //   menü spalte
  echo "<!---  Menu Spalte   --->\n";
  //  stellt die breite der Menüspalte ein !!!
  $style = $GLOBALS['style_menu_tab1'];
  echo "<div $style >\n";
  
  //  separate div pro Menu item
  $style = $GLOBALS['style_menu_head'];
  echo "\t<div  ><!-- Row:1, Col:1 -->\n";
  echo "\t</div >\n";
  
  reset ($menu);
  while (list($key, $item) = each ($menu))
  {
  	if ($key!=99)  // sl oder user menu
  	{
  		if ($key!=98)  // User Menu
  		{
  		    $style = $GLOBALS['style_menu_list'];
  			echo "\t<div $style ><!-- Row:1, Col:1 -->\n";
  			$item = $menu[$key];
  			$item["caption"] = substr($item["caption"],0,16);
  			if ($key!=0) 
  			{
  			 print_menu_icon($item["icon"]);
  			 print_menu_ref($item["caption"],$item["link"]);
  			};
            echo "\t</div >\n";
  		} else     // SL - menu
  		{  
  		    $style = $GLOBALS['style_menu_list'];
  			$l1 = (int) $user_lvl;
  			$l2 = (int) $lvl_sl[14];
  			if ($l1 <= $l2)
  			{
              echo "\t<div $style ><!-- Row:1, Col:1 -->\n";
  			  $item = $menu[$key];
              if ($key!=0) 
              {
                print_menu_icon($item["icon"]);
                print_menu_ref($item["caption"],$item["link"]);
              };
              echo "\t</div >\n";
  			};
  		}
  	} else // admin menu
  	{
  	  $style = $GLOBALS['style_menu_list'];
      $l1 = (int) $user_lvl;
      $l2 = (int) $lvl_admin[14];
      if ($l1 <= $l2)
      {
        echo "\t<div $style ><!-- Row:1, Col:1 -->\n";
        $item = $menu[$key];
        if ($key!=0) 
        {
          print_menu_icon($item["icon"]);
          print_menu_ref($item["caption"],$item["link"]);
        };
        echo "\t</div >\n";
      };
  	}
  }
  
  echo "</div>\n";
  echo "<!---  Menu Spalte ENDE   --->\n\n";
};

/**
 * Gibt eine Htnl Datei im Datentab aus, default style
 * @param unknown $html_file
 */
function print_data($html_file)
{
	$ishead = 'true';
	$html_file = $GLOBALS['path_html'].$html_file;
	$file = fopen ($html_file, "r");
	if (!$file)
	{
		echo "<p>Datei konnte nicht ge&uuml;ffnet werden.\n";
		exit;
	};
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	while (!feof ($file))
	{
		$line = fgets ($file, 1024);
		/* Funktioniert nur, wenn Titel und title-Tags in einer Zeile stehen */
		if ($ishead!='true')
		{
			if (preg_match ("</head>", $line, $out, PREG_OFFSET_CAPTURE))
			{
				$ishead = 'false';
			} else
			{
				if (preg_match ("</body>", $line, $out, PREG_OFFSET_CAPTURE))
				{
					$ishead = 'false';
				} else
				{
					if (preg_match ("<body>", $line, $out, PREG_OFFSET_CAPTURE))
					{
						$ishead = 'false';
					} else
					{
						echo $line;
					};
				};
			};
		} else
		{  //preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
		  
			if (preg_match("</head>", $line, $out, PREG_OFFSET_CAPTURE))
			{
				$ishead = 'false';
			};
			if (preg_match ("</body>", $line, $out))
			{
				$ishead = 'false';
			};
		}
		//echo $line;

	};
	fclose($file);
	echo "</div>\n";
	echo "<!---  ENDE DATEN Spalte   --->\n";
};


?>