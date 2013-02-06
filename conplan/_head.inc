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
	$grp_name = $GLOBALS[grp_name];
	$layout_path = $GLOBALS[layout_path];
	$version = $GLOBALS[version];
	 
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

function print_body_ende()
{
	//echo "</TABLE>\n";
	echo "</BODY>\n";
	echo "</HTML>\n";
};

function print_kopf ($logo_typ, $header_typ,$bereich,$anrede, $ref)
{
	$typ = 13;
	$info = "Login aufrufen";
	
	echo "<div id=\"div_1\">\n";
	echo "  <div id=\"header1\">\n";
	echo "    <div id=\"header1left\">\n";
	print_header_icon($GLOBALS["logo_typ"]);
	echo "    </div>\n";
	echo "    <div id=\"header1main\">\n";
	print_header_icon($GLOBALS["header_typ"]);
	echo "    </div>\n";
	echo "    <div id=\"header1right\">\n";
	echo "      <p>$bereich</p>\n";
	echo "      <p>$anrede</p>\n";
	echo "      <div id=\"menu_status_r\">\n";
	if ($typ != "")
	{
		print_menu_icon($typ,$info);
		print_menu_ref($typ, $ref);
	}
	echo "    	</div>\n";
	echo "    </div>\n";
	echo "  </div>\n";
	echo "</div>\n";
	echo "\n\n";
};



function print_md()
{
	echo "<!---  Menu und Daten   --->\n";
	echo "<TABLE WIDTH=950px  BORDER=\"1\" CELLPADDING=\"0\" CELLSPACING=\"0\" BGColoR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\" >\n";
	echo "<TR>\n";
};

function print_md_ende()
{
	echo "</TR>\n";
	echo "</TABLE>\n";

};



function print_menu_ref($typ, $ref)
{
	switch ($typ) :
	case 1:
		echo "            <A HREF=\"$ref\" >";
	break;
	case 2:
		echo "            <A HREF=\"$ref\" >";
		break;
	case 3:
		echo "            <A HREF=\"$ref\" >";
		break;
	case 4:
		echo "            <A HREF=\"$ref\" >";
		break;
	case 5:
		echo "            <A HREF=\"$ref\" >";
		break;
	default:
		echo "            <A HREF=\"$ref\" >";
		endswitch;

};


function print_menu ($menu)
{
	global $user_lvl, $lvl_admin,$lvl_sl;

	//   menü spalte
	echo "<!---  Menu Spalte   --->\n";
	//  stellt die breite der Menüspalte ein !!!
	echo "<TD WIDTH=155>\n";

	//  separate Tabelle fuer Menu !!
	echo "\t<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<TR >\n";
	echo "\t<TD WIDTH=150px>\n";
	echo "\t\t<TABLE WIDTH=\"145px\" BORDER=\"0\" BGCOLOR=\"\" >";

	reset ($menu);
	while (list($key, $item) = each ($menu))
	{
		if ($key!=99)
		{
			if ($key!=98)
			{
				echo "\t\t<TR HEIGHT=30>\n";
				echo "\t\t<TD><!-- Row:1, Col:1 -->\n";
				$item = $menu[$key];
				$item[caption] = substr($item[caption],0,16);
				if ($key!=0) {
					print_menu_ref($item[icon],$item[link]);
				};
				print_menu_icon($item[icon]);
				echo "\t\t</A>\n";
				if ($key!=0)
				{
					echo "\t\t$item[caption]\n";
				} else
				{
					echo "\t\t<B>$item[caption]\n";
				};
				echo "\t\t</TD>\n";
				echo "\t\t</TR>\n";
			} else
			{
				$l1 = (int) $user_lvl;
				$l2 = (int) $lvl_sl[14];
				if ($l1 <= $l2)
				{
					echo "\t\t<TR HEIGHT=30>\n";
					echo "\t\t<TD><!-- Row:1, Col:1 -->\n";
					$item = $menu[$key];
					if ($key!=0) {
						print_menu_ref($item[icon],$item[link]);
					};
					print_menu_icon($item[icon]);
					echo "\t\t</A>\n";
					//            echo "\t\t$item[caption]\n";
					echo "\t\t<B>$item[caption]\n";
					echo "\t\t</TD>\n";
					echo "\t\t</TR>\n";
				};
			}
		} else
		{
			$l1 = (int) $user_lvl;
			$l2 = (int) $lvl_admin[14];
			if ($l1 <= $l2)
			{
				echo "\t\t<TR HEIGHT=30>\n";
				echo "\t\t<TD><!-- Row:1, Col:1 -->\n";
				$item = $menu[$key];
				if ($key!=0) {
					print_menu_ref($item[icon],$item[link]);
				};
				print_menu_icon($item[icon]);
				echo "\t\t</A>\n";
				echo "\t\t<B>$item[caption]\n";
				echo "\t\t</TD>\n";
				echo "\t\t</TR>\n";
			};
		}
	}

	echo "\t\t</TABLE>\n";
	echo "\t</TD>\n";
	echo "\t</TR>\n";
	echo "\t</TABLE\n>";
	echo "</TD>\n";
	echo "<!---  Menu Spalte ENDE   --->\n\n";
};

function print_data($html_file)
{
	$ishead = 'true';
	$file = fopen ($html_file, "r");
	if (!$file)
	{
		echo "<p>Datei konnte nicht ge&uuml;ffnet werden.\n";
		exit;
	};
	echo "<P>";
	echo "<!---  DATEN Spalte   --->\n";
	echo "<TD>\n";
	echo "\t<TABLE  BORDER=0 BGCOLOR=\"\" BORDERCOLOR=\"#008000\" BORDERCOLORDARK=\"#008040\"
			BORDERCOLORLIGHT=\"#008F00\">\n";
	echo "\t<TR >\n";
	echo "\t<TD>\n";
	echo "\t<TABLE WIDTH=100% BORDER=0 BGCOLOR=\"\" BORDERCOLOR=\"#008000\" BORDERCOLORDARK=\"#008040\"
			BORDERCOLORLIGHT=\"#008F00\">\n";
	echo "\t<TR >\n";
	echo "\t<TD>\n";

	while (!feof ($file))
	{
		$line = fgets ($file, 1024);
		/* Funktioniert nur, wenn Titel und title-Tags in einer Zeile stehen */
		if ($ishead!='true')
		{
			if (eregi ("</head>", $line, $out))
			{
				$ishead = 'false';
			} else
			{
				if (eregi ("</body>", $line, $out))
				{
					$ishead = 'false';
				} else
				{
					if (eregi ("<body>", $line, $out))
					{
						$ishead = 'false';
					} else
					{
						echo $line;
					};
				};
			};
		} else
		{
			if (eregi ("</head>", $line, $out))
			{
				$ishead = 'false';
			};
			if (eregi ("</body>", $line, $out))
			{
				$ishead = 'false';
			};
		}
		//echo $line;

	};
	fclose($file);
	echo "\t</TD>\n";
	echo "\t</TR >\n";
	echo "\t</TABLE>\n";
	echo "\t</TD>\n";
	echo "\t</TR >\n";
	echo "\t<TD >\n";
	echo "&nbsp;";
	echo "\t</TD >\n";
	echo "\t</TR >\n";
	echo "\t</TABLE>\n";
	echo "</TD>\n";
	echo "<!---  ENDE DATEN Spalte   --->\n";
};


?>