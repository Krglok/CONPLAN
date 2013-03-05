<?php

/*
 Projekt : CONPLAN

Datei   :  $RCSfile: head.inc,v $

Datum   :  $Date: 2002/05/24 13:02:18 $  /

Rev.    :  $Revision: 1.8 $   / 1.0

Author  :  $Author: windu $  / duda

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

//include "config.inc";



function print_header ($NAME)
{
	echo "<HTML>\n";
	echo "<!-- PHP ".phpversion()." / Drachenhorst Framework V 2.0 / 2008-->\n";
	echo "<HEAD>\n";
	echo "<TITLE></TITLE>\n";
	echo "<META NAME=\"Description\" CONTENT=\"Drachenhorst \">\n";
	echo "<META NAME=\"Keywords\" CONTENT=\"LARP $NAME\">\n";
	echo "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
	echo"  <title>Drachenhorst $NAME </title>";
	echo"  <style><!--
			.header {background-color: #C0C0C0;}
			.th,td {vertical-align: top; font: 10pt \"ocr a extended\" \"Comic Sans MS\"}
			.input { font: 10pt \"ocr a extended\" \"Comic Sans MS\"}
			//--></style>\n";
	echo "</HEAD>\n";
	echo "\n";
}

function print_body($back_typ)
{
	global $bg_path;

	echo "<BODY Text=\"black\" BGColoR=\"#F5EAE4\"  LINK=\"black\" VLINK=\"#408080\" ";
	print_background ($back_typ);
	echo " >\n";
	echo "<FONT COLOR=\"black\" SIZE=2 FACE=\"Comic Sans MS\">\n";
	echo"<CENTER>";  // setzt diegesamte Anzeige auf Center
	//echo "<TABLE WIDTH=100%  BORDER=1 BGColoR=\"\" >\n";
}

function print_body_ende()
{
	//echo "</TABLE>\n";
	echo "</FONT>\n";
	echo "</BODY>\n";
	echo "</HTML>\n";
};

function print_kopf ($logo_typ, $header_typ,$bereich,$anrede)
{
	global $spieler_id;
	global $img_path;
	echo "<TABLE WIDTH=\"950\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n\n";
	echo "  <TR>\n";
	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"100%\" HEIGHT=\"100\"BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "        <TR >\n";
	echo "          <TD rowspan=4 WIDTH=\"120\"><!-- Row:1, Col:1   KOPF LOGO-->\n";
	echo "          <TABLE WIDTH=\"100%\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "          <TR>\n";
	echo "          <TD>\n";
	print_header_icon($logo_typ);
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          </TABLE>\n";
	echo "          </TD>\n";
	echo "          <TD  ALIGN=\"CENTER\" WIDTH=\"570\">\n";
	echo "          <TABLE WIDTH=\"100%\" BORDER=\"0\" BGCOLOR=\"\"  >\n";
	echo "          <TR>\n";
	echo "          <TD ALIGN=\"CENTER\">\n";
	print_header_icon($header_typ);
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          </TABLE>\n";
	echo "          </TD>\n";
	echo "          <TD >\n";
	echo "          <TABLE WIDTH=\"200\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "          <TR>\n";
	echo "          <TD align=left >\n";
	echo "            &nbsp;<B>$bereich</b>\n";
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          <TR>\n";
	echo "          <TD align=left >\n";
	echo "            &nbsp;<B></b>\n";
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          <TR>\n";
	echo "          <TD >\n";
	echo "            <b>$anrede";
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          </TABLE>\n";
	echo "          </TD>\n";
	echo "        </TR>\n";
	echo "      </TABLE>\n";
	echo "    </TD>\n\n";
	echo "  </TR>\n\n";
	echo "</TABLE>\n";
	echo "\n\n";
};



function print_md()
{
	echo "<!--  Menu und Daten   -->\n";
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
	echo "<!--  Menu Spalte   -->\n";
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
	echo "<!--  Menu Spalte ENDE   -->\n\n";
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
	echo "<!--  DATEN Spalte   -->\n";
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
	echo "<!--  ENDE DATEN Spalte   -->\n";
};


?>