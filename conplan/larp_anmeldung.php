<?php
/*
 Projekt : LARP

Datei   :  anmelde_liste.php

Datum   :  2002/05/30

Rev.    :   3.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Datensaetze
- Efassen neuer Datensaetze
- Bearbeiten vorhandener Datensaetze
- Anzeige der Details ohne Bearbeitung
- Loechen  eines Datensatzes

- Liste der Datensätze
-Keine Verwaltungsfunktionen !!
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es koennen normale HTML Seiten ausgegeben werden.
Subseiten werden mit eigenen PHP-scripten erzeugt.
Die zugehoerigen HTML Seiten koenen in einem Subdir sein
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

#3  01.09.2008    Abfrage bein Löschen geändert $err == 1

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

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
include_once '_mfd_lib.inc';

//-----------------------------------------------------------------------------
function print_liste($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TAG;
	global $ID;

	$table = "con_anmeldung";
	
	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $table where tag=\"$TAG\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
	echo "<table>\n";
	echo "<tbody>\n";
	echo "<tr>\n";
	echo "<td width=\"200px\" >\n";
	echo "<B>ANMELDUNG für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td width=\"25px\">\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";
	echo "</tbody>\n";
	echo "</table>\n";
	
	echo "<table>\n";
	echo "<tbody>\n";
	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch ($i):
		case 3:
			//      echo "\t<td><b>Orga</b></td>\n";
			break;
		case 4:
			echo "\t<td width=\"25px\"><i>Abw</i></td>\n";
			break;
		case 5:
			echo "\t<td width=\"25px\"><i>Tav</i></td>\n";
			break;
		case 6:
			echo "\t<td width=\"25px\"><i> WC</i></td>\n";
			break;
		case 7:
			echo "\t<td width=\"25px\"><i>NSC</i></td>\n";
			break;
		case 8:
			echo "\t<td width=\"25px\"><i>Auf</i></td>\n";
			break;
		case 9:
			echo "\t<td width=\"25px\"><i>Orga</i></td>\n";
			break;
		default:
			echo "\t<td><i>".mysql_field_name($result,$i)."</i></td>\n";
			break;
			endswitch;
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				if ($user_id == $row[11])
				{
					echo "\t<td>\n";
					if ($user !="gast")
					{
						echo "\t<a href=\"$PHP_SELF?md=".mfd_edit."&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
					}
					//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
					print_menu_icon ("_edit","Anmeldung bearbeiten");
					echo "\t</a></td>\n";
				} else
				{
					echo "\t<td></td>\n";
				}
			} else
			{
				if ($i != 3)
				{
					if ($i == 10)
					{
						$lines=explode("\n",$row[$i]);
						$anz  = count($lines);
//						echo "\t<td>\n";
						print_textblock_td($lines);
// 						for ($ii=0; $ii<$anz; $ii++)
// 						{
// 							echo "\t$zeile[$ii]&nbsp;<br>\n";
// 						}
//						echo "</td>\n";
					} else
					{
						echo "\t<td>$row[$i]&nbsp;</td>\n";
					}
				}
			};
		}
		if ($user_id == $row[11])
		{
			echo "\t<td><a href=\"$PHP_SELF?md=".mfd_info."&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
			print_menu_icon ("_text","Anmeldung ansehen");
			echo "\t</a></td>\n";

			echo "\t<td><a href=\"$PHP_SELF?md=".mfd_del."&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
			print_menu_icon ("_del","Anmeldung löschen!");
			echo "\t</a></td>\n";
		}
	  echo "</tr>\n";
	}
	echo "</tbody>\n";
	echo "</table>";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
};

//-----------------------------------------------------------------------------
function info_liste($spieler,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TAG;

	$table = "con_anmeldung";
	
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $table where spieler_id=\"$spieler\" order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);

	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
	echo "<table\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch ($i):
		case 3:
			//      echo "\t<td><b>Orga</b></td>\n";
			break;
		case 4:
			echo "\t<td><b>Abw</b></td>\n";
			break;
		case 5:
			echo "\t<td><b>Tav</b></td>\n";
			break;
		case 6:
			echo "\t<td><b> WC</b></td>\n";
			break;
		case 7:
			echo "\t<td><b>NSC</b></td>\n";
			break;
		case 8:
			echo "\t<td><b>Auf</b></td>\n";
			break;
		case 9:
			echo "\t<td><b>Orga</b></td>\n";
			break;
		default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	echo "</tr>\n";

	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td>\n";
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=".mfd_info."&ID=$ID&id=$row[0]\">\n";
		print_menu_icon ("_text");
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
};


//-----------------------------------------------------------------------------
function tage_liste($spieler,$ID,$TAG)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE1;

	$table = "con_anmeldung";
	
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where substring(von,1,4)>\"0000\" order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);

	$style = $GLOBALS['style_datatable'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
	echo "<table >\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num-1; $i++)
		{
			if ($row[1]==$TAG)
			{
				$bgcolor="silver";
			} else
			{
				$bgcolor="";
			}

			// aufruf der Deateildaten
			switch ($i):
			case 0 :
				echo "\t<td width=\"30\"> \n";
			//print_menu_icon (9);
			echo "\t</a></td>\n";
			break;
			case 1:
				echo "\t<td width=\"20\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 2:
				echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 3:
				echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 4:
				echo "\t<td width=\"30\" align=RIGHT  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 5:
				echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 6:
				echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			case 7:
				if ($row[1]==$TAG)
				{
					echo "\t<td width=\"250\" bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td width=\"250\" bgcolor=\"$bgcolor\" >$row[$i]&nbsp;</td>\n";
				}
				break;
			case 8:
				//        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
				break;
			default :
				endswitch;
		};
		 
		echo "<tr>";
	}
	echo "</table>";

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
};


function check_datum()
{
  global $TAG;
  $table = "con_tage";
  // Zugriff auf CON-TAGE
  $q = "select * from $table where tag=$TAG";
  $result1 = mysql_query($q) or die("Query $TABLE1");
  $row1 = mysql_fetch_array ($result1);

  $datum = strftime("%Y-%m-%d");
  //echo "$TAG / $datum / $row1[6]\n";
  if ($datum > $row1[6])
  {
    echo "  <TABLE>\n";
    echo "    <TR HEIGHT=30>\n";
    echo "    <TD > <CENTER><B>ANMELDUNGSCHLUSS !&nbsp;".print_datum($row1[6])."&nbsp;&nbsp;&nbsp;</TD>\n";
    echo "    </TR>\n";
    echo "  </TABLE>\n";
    return true;
  }
  return false;
}

function print_anmeld_erf($mfd_list, $id, $user, $ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TAG;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	if (check_datum()==true)
	{
	  exit;
	}

	$next = mfd_insert;
	
	$mfd_list["where"] = "id=\"0\"";
	// Zugriff aufCON_Anmeldung
	
	$result = mfd_data_result($mfd_list);
	//
	$row = mysql_fetch_array ($result);
		
	for ($i=0; $i<12; $i++)
	{
		$row[$i] = "";
	};
	$row[11] = get_user_id($user);
	$row[2] = get_author($row[11]);
	$row[3] = get_mail($row[11]);
	$row[6] = 1;

	$table = "con_tage";
	$mfd_tage = make_mfd_table($table, $table);
	$mfd_tage["where"] = "tag = $TAG";
	
	$result = mfd_data_result($mfd_tage);
	$row_tage = mysql_fetch_array ($result);
	// Die Tage daten werden an den Datensatz angehängts 20ff
	for ($i=0; $i<10; $i++)
	{
	  $row[20+$i] = $row_tage[$i];
	};
	
	
	print_maske($id, $ID, $next, $row);
}	

/**
 * 
 * @param unknown $id
 * @param unknown $user
 * @param unknown $ID
 */
function print_anmeld_edit($mfd_list,$id,$user,$ID)
{

  global $TAG;

  $next = mfd_update;
	$mfd_list["where"] = "id=$id ";
	// Zugriff aufCON_Anmeldung
	
	$result = mfd_data_result($mfd_list);
	//
	$row = mysql_fetch_array ($result);
	
	
	$table = "con_tage";
	$mfd_tage = make_mfd_table($table, $table);
	$mfd_tage["where"] = "tag = $TAG";
	
	$result = mfd_data_result($mfd_tage);
	$row_tage = mysql_fetch_array ($result);
	// Die Tage daten werden an den Datensatz angehängts 20ff
	for ($i=0; $i<10; $i++)
	{
	  $row[20+$i] = $row_tage[$i];
	};
  
  print_maske($id, $ID, $next, $row);
}

function print_anmeld_del($mfd_list,$id,$user,$ID)
{
  global $TAG;

  $next = mfd_delete;
  $mfd_list["where"] = "id=$id ";
  // Zugriff aufCON_Anmeldung

  $result = mfd_data_result($mfd_list);
  //
  $row = mysql_fetch_array ($result);
  
  $table = "con_tage";
  $mfd_tage = make_mfd_table($table, $table);
  $mfd_tage["where"] = "tag = $TAG";

  $result = mfd_data_result($mfd_tage);
  $row_tage = mysql_fetch_array ($result);
  // Die Tage daten werden an den Datensatz angehängts 20ff
  for ($i=0; $i<10; $i++)
  {
    $row[20+$i] = $row_tage[$i];
  };

  print_maske($id, $ID, $next, $row);
}


function print_anmeld_info($mfd_list,$id,$user,$ID)
{

  global $TAG;

  $next = 0;
  $mfd_list["where"] = "id=$id ";
  // Zugriff aufCON_Anmeldung

  $result = mfd_data_result($mfd_list);
  //
  $row = mysql_fetch_array ($result);


  $table = "con_tage";
  $mfd_tage = make_mfd_table($table, $table);
  $mfd_tage["where"] = "tag = $TAG";

  $result = mfd_data_result($mfd_tage);
  $row_tage = mysql_fetch_array ($result);
  // Die Tage daten werden an den Datensatz angehängts 20ff
  for ($i=0; $i<10; $i++)
  {
    $row[20+$i] = $row_tage[$i];
  };

print_maske($id, $ID, $next, $row,true);
}

/**
 * Maske fuer Anmeldung
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $next
 * @param unknown $row
 */
function print_maske($id, $ID, $next,$row, $is_readonly=false)
{	
	global $TAG;
	global $ID;
	global $PHP_SELF;
  /**/
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

		echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST  >\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[1]\"   VALUE=\"$TAG\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[11]\"   VALUE=\"$row[11]\">\n";

		echo "<TABLE>\n";
		echo "    <TR HEIGHT=\"30\">\n";
		echo "    <TD colspan=6> <CENTER><B>ANMELDUNG&nbsp;&nbsp;&nbsp;&nbsp;</TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=75><!-- Row:2, Col:1 -->\n";
		echo "        <i>Tag : </i>\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=\"55\"><!-- Row:2, Col:2 -->\n";
		echo "        <B>$row[21]\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=\"55\"><!-- Row:3, Col:1 -->\n";
		echo "        <i>vom &nbsp;</i>\n";
		echo "        </TD>\n";
		echo "        <TD  WIDTH=\"85\"><!-- Row:4, Col:1 -->\n";
		echo "        <B>$row[22]\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=55><!-- Row:5, Col:1 -->\n";
		echo "        <i>&nbsp;bis</i>\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=\"85\"><!-- Row:6, Col:1 -->\n";
		echo "        <b>$row[23]</b>\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";
		echo "<table> \n";
		echo "<tr> \n";
		$data = $row[28];
    $titel= "text";
    $pos  = 8;
		print_mfd_edit_text($titel,$pos, $data, true);	
		echo "<td width=\"100px\"> \n";
		echo "&nbsp;";	
		echo "</td> \n";
		echo "</TR>\n";
		echo "</TABLE>\n";

		echo "    <TABLE >\n";
		echo "    <TR HEIGHT=10>\n";
		echo "    <TD></TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=\"75\"><!-- Row:1, Col:1 -->\n";
		echo "        Name\n";
		echo "        </TD>\n";
		echo "        <TD colspan=4><!-- Row:1, Col:2 -->\n";
		echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[2]\">\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD  ><!-- Row:4, Col:1 -->\n";
		echo "        email\n";
		echo "        </TD>\n";
		echo "        <TD colspan=4><!-- Row:4, Col:2 -->\n";
		echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[3]\">\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";
		echo "<TABLE >\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=75><!-- Row:2, Col:1 --></TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        WC\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:2, Col:2 -->\n";
		if ($row[6]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[6]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[6]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        Abwasch\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:2, Col:2 -->\n";
		if ($row[4]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[4]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[4]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        Taverne\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:2 -->\n";
		if ($row[5]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[5]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[5]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";
		echo "<TABLE >\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=75><!-- Row:2, Col:1 --></TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        NSC\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:2, Col:2 -->\n";
		if ($row[7]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[7]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[7]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        Aufbau\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:2, Col:2 -->\n";
		if ($row[8]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[8]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[8]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:1 -->\n";
		echo "        Orga\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=60><!-- Row:2, Col:2 -->\n";
		if ($row[9]==1)
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[9]\" VALUE=\"1\" CHECKED>\n";
		} else
		{
			echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[9]\" VALUE=\"1\">\n";
		}
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";
		echo "<TABLE >\n";
		echo "    <TR>\n";
		$data = $row[10];
		$titel= "Bemerkung";
		$pos  = 10;
		print_mfd_edit_text($titel,$pos, $data, false);
		echo "<td width=\"100px\"> \n";
		echo "&nbsp;";
		echo "</td> \n";
		echo "</TR>\n";
		if (!$is_readonly)
		{
    	echo "<TR>\n";
    	echo "<TD><!-- Row:5, Col:1 -->\n";
    	echo "</TD>\n";
    	echo "<TD colspan=2><!-- Row:5, Col:2 -->\n";
    	echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">\n";
    	echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
    	echo "<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">\n";
    	echo "</TD>\n";
    	echo "<TD><!-- Row:5, Col:2 -->\n";
    	echo "</TD>\n";
    	echo "</TR>\n";
		}
		echo "</TABLE>\n";
		echo "</FORM>\n";
	echo '</div>';
	
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

  $BEREICH = 'INTERN';
  
  
  $g_md   = GET_md(0);
  $daten  = GET_daten("");
  $sub    = GET_sub("main");
  $item   = GET_item("");
  $ID     = GET_SESSIONID("");
  $g_id   = GET_id("0");
  
  $p_md   = POST_md(0);
  $p_row  = POST_row("");
  
  session_id ($ID);
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
  
  if (is_user()==FALSE)
  {
    echo "no lvl";
    header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
    // Code ausgeführt wird.
  }
  
  $TAG   = get_akttag();
  
  print_header("Con Anmeldung");
  
  print_body(2);
  
  $spieler_name = get_spieler($spieler_id); //Auserwählter\n";
  
  $menu_item = $menu_item_help;
  $anrede["name"] = $spieler_name;
  print_kopf($logo_typ,$header_typ,"INTERN",$anrede,$menu_item);
  
  $ref_mfd = "con_anmeldung";
  
  $mfd_list= make_mfd_table($ref_mfd,$ref_mfd);
  $mfd_cols = make_mfd_cols_default($ref_mfd,$ref_mfd);
  
//   echo $mfd_list["table"]."/".$mfd_list["fields"]."<br>\n";
//   echo $p_row[4].$p_row[5].$p_row[6].$p_row[7]."\n";
  
  switch ($p_md):
  case mfd_insert: // Anlegen eines neuen des DAtensatzes
  	//  Insert SQL
  	mfd_insert($mfd_list, $p_row);
    $g_md= 0;
    break;
  case mfd_update: // Update eines bestehnden Datensatzes
  	// Update SQL
  	mfd_update($mfd_list,$p_row);
  	$g_md= 0;
  	break;
  case mfd_delete:
    mfd_delete($mfd_list, $p_row[0]);
    $g_md=0;
  default:  // MAIN-Menu
  endswitch;
  
  
 	switch ($g_md):
  case mfd_add: // Erfassen eines neuen Datensatzes
  		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
  				2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  		);
  		break;
  case mfd_info: // Ansehen / INFO eines Datensatzes
  	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
  	8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  	);
  	break;
  case mfd_del: // Delete eines bestehenden Datensatzes
  	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
  	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  	);
  	break;
  case mfd_edit: // Anzigen Bearbeiten Form
  	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
  	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  	);
  	break;
  case mfd_list:  // Meine Anmelde Liste
  	$menu = array (0=>array("icon" => "7","caption" => "MEINE ANMELDUNGEN","link" => ""),
  	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  	);
  	break;
  case 11:  // Meine Anmelde Liste
  	$menu = array (0=>array("icon" => "7","caption" => "CON-LISTE","link" => ""),
  	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
  	);
      break;
  default:  // MAIN-Menu
  	$menu = array (0=>array("icon" => "99","caption" => "CON-ANMELDUNG","link" => ""),
  	1=>array("icon" => "_add","caption" => "Neu","link" => "$PHP_SELF?md=".mfd_add."&ID=$ID&TAG=$TAG"),
  	5=>array("icon" => "_list","caption" => "alle Anmeldungen","link" => "$PHP_SELF?md=".mfd_list."&ID=$ID&TAG=$TAG"),
//  	6=>array("icon" => "_list","caption" => "Con Liste","link" => "$PHP_SELF?md=".mfd_list."&ID=$ID&TAG=$TAG"),
  	9=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID&TAG=$TAG")
  	);
  	endswitch;
  
  	print_menu_status($menu);
  
  	//echo $TAG;
  
	switch ($g_md):
  case mfd_add:
  		//
  		print_anmeld_erf($mfd_list,$g_id,$user,$ID);
  	break;
  case mfd_info:
    print_anmeld_info($mfd_list,$g_id,$user,$ID);
  	break;
  case mfd_del:
  	//
    print_anmeld_del($mfd_list,$g_id,$user,$ID);
    break;
  case mfd_edit:
  	//
  	print_anmeld_edit($mfd_list,$g_id,$user,$ID);
  	break;
//   case 11:
//    tage_liste($spieler_id,$ID,$TAG);
//   	break;
  case mfd_list:
   	info_liste($spieler_id,$ID);
  	break;
  default:
  	print_liste($user);
  	break;
 	endswitch;
  
  	print_md_ende();
  
  	print_body_ende();

	?>