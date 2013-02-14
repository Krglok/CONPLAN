<?php
/*
 Projekt : LARP

Datei   :  anmelde_liste.php

Datum   :  2002/05/30

Rev.    :   2.0

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
	echo "<!---  DATEN Spalte   --->\n";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";

//-----------------------------------------------------------------------------
function print_liste($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;
	global $ID;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where tag=\"$TAG\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	$anzahl    = mysql_num_rows($result);

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<table border=1 width=700 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	echo "<td colspan=4>\n";
	echo "<B>ANMELDUNG für TAG $TAG\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "$anzahl \n";
	echo "</td>\n";

	echo "</tr>\n";

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
	echo "<hr>\n";
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
						echo "\t<a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
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
						$zeile=explode("\n",$row[$i]);
						$anz  = count($zeile);
						echo "\t<td>\n";
						for ($ii=0; $ii<$anz; $ii++)
						{
							echo "\t$zeile[$ii]&nbsp;<br>\n";
						}
						echo "</td>\n";
					} else
					{
						echo "\t<td>$row[$i]&nbsp;</td>\n";
					}
				}
			};
		}
		if ($user_id == $row[11])
		{
			echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
			print_menu_icon ("_text","Anmeldung ansehen");
			echo "\t</a></td>\n";
		}
		echo "<tr>";
	}
	echo "</table>";
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
};

//-----------------------------------------------------------------------------
function info_liste($spieler,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where spieler_id=\"$spieler\" order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<table border=1 width=100% BGCOLOR=\"\">\n";

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
	echo "<hr>\n";
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
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";
		print_menu_icon ("_text");
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
};


//-----------------------------------------------------------------------------
function tage_liste($spieler,$ID,$TAG)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TABLE1;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where substring(von,1,4)>\"0000\" order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<table border=1 width=100% BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
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
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
};

function print_info($id,$user,$ID,$TAG)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
    global $PHP_SELF;
    
	//Anzeigen von Contage als einfache Maske
	//function view() {

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag=$TAG";
	$result1 = mysql_query($q) or die("Query $TABLE1");
	$row1 = mysql_fetch_array ($result1);

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler...".$q);

	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	mysql_close($db);

	//Daten bereich
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<TABLE WIDTH=\"435\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "    <TR HEIGHT=30>\n";
	echo "    <TD colspan=6> <CENTER><B>ANMELDUNG&nbsp;&nbsp;&nbsp;&nbsp;</TD>\n";
	echo "    </TR>\n";
	echo "    <TR>\n";
	echo "        <TD WIDTH=55><!-- Row:2, Col:1 -->\n";
	echo "        <B>Tag :\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:2, Col:2 -->\n";
	//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"\" SIZE=3 MAXLENGTH=3 VALUE=\"$TAG\" READONLY>\n";
	echo "        <B>$TAG\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=55><!-- Row:3, Col:1 -->\n";
	echo "        <P ALIGN=RIGHT>\n";
	echo "        <B>vom &nbsp;\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:4, Col:1 -->\n";
	//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"\" SIZE=10 MAXLENGTH=10 VALUE=\"$row1[2]\" READONLY>\n";
	echo "        <B>  ".print_datum($row1[2])."\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=55><!-- Row:5, Col:1 -->\n";
	echo "        <P ALIGN=RIGHT>\n";
	echo "        <B>bis&nbsp;\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:6, Col:1 -->\n";
	//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"\" SIZE=10 MAXLENGTH=10 VALUE=\"$row1[3]\" READONLY>\n";
	echo "        <B>".print_datum($row1[3])."\n";
	echo "        </TD>\n";
	echo "    </TR>\n";
	echo "    <TR HEIGHT=10>\n";
	echo "    <TD></TD>\n";
	echo "    </TR>\n";
	echo "    <TR>\n";
	echo "  <TD colspan=6>\n";
	echo "  <TEXTAREA NAME=\"text\" COLS=50 ROWS=12 READONLY>\n";
	echo "$row1[8]\n";
	echo "Anmeldeschluss $row1[6]\n";
	echo "\n";
	echo "Kosten : $row1[4] EUR\n";
	echo "  </TEXTAREA>\n";
	echo "  </TD>\n";
	echo "    </TR>\n";
	echo "</TABLE>\n";

	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name($result,$i);
		$type[$i]       =  mysql_field_type ($result, $i);
	}
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($type[$i]=="string") {
			$len[$i] = 60;
		}

		if ($type[$i]!="blob")
		{
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
			echo "<tr>";
		} else
		{
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=50 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
		}
	}
	echo "</table>";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	

};


function print_loeschen($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TABLE1;
	global $TAG;
	global $ID;

	$user_id = get_user_id($user);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	// Zugriff auf CON-TAGE
	$q = "select * from $TABLE1 where id=$TAG";
	$result1 = mysql_query($q) or die("Query $TABLE1");
	$row1 = mysql_fetch_array ($result1);

	// Zugriff auf CON-Anmeldung
	$q = "select * from $TABLE where tag=\"$TAG\"";
	$result = mysql_query($q)  or die("Query Fehler...");


	mysql_close($db);

	//  Datumasuwertung für Anmeldeschluss
	$datum = strftime("%Y-%m-%d");
	if ($datum <= $row1[6])  // row[6]  = bis-Datum jjjj-mm-tt
	{
		$err = 0;
	} else
	{
		$err = 1;
	}

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	

	echo "<table border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num-1; $i++)
	{
		switch ($i):
		case 0:
			echo "\t<td width=\"35px\"><b> </b></td>\n";
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
		case 9:
			echo "\t<td width=\"150px\"><b>Orga</b></td>\n";
			break;
			default:
			echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			break;
			endswitch;
	};
	//lfdnr,name,vorname,orga}
	echo "</tr>\n";
	echo "<hr>\n";
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
					echo "\t<td>\n "; ///$user / $err";
					if ($user !="gast")
					{
						if ($err == 1)    //#3
						{
							echo "\t<a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
						}
					}
					print_menu_icon ("_del", "Datensatz löschen, unwiederruflich");
					echo "\t</a></td>\n";
				} else
				{
					echo "\t<td></td>\n";
				}
			} elseif ($i == 10)
			{
			  echo "\t<td>\n";
			  print_textblock($row[$i]);
			  echo "\t</td>\n";
			}else
			{
			  echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Datensatz Ansehen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		//      echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	

};



function insert($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	for ($i=4; $i<=9; $i++)
	{
		$zw = $zw + (int)$row[$i];
	};
	if ($zw==0) {
		$row[6]=1;
	};

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="insert INTO  $TABLE  (";
	$q = $q."$field_name[1]";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]";
	};

	$q = $q.") VALUES (\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",\"$row[$i]\" ";
	};
	$q = $q.")";
	//  echo $q;

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	$result = mysql_query($q) or die("InsertFehler....$q.");

	mysql_close($db);

};


function update($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$zw = 0;
	for ($i=4; $i<=9; $i++)
	{
	  if (isset($row[$i])) 
	  {
	    $zw = $zw + (int)$row[$i];
	  }
	};
	if ($zw==0) {
		$row[6]=1;
	};

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
	}
	$q ="update $TABLE  SET ";
	$q = $q."$field_name[1]=\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
	  if (isset($row[$i])) 
	  {
	     $q = $q.",$field_name[$i]=\"$row[$i]\" ";
	  }
	};
	$q = $q."where id=\"$row[0]\" ";

	//  echo $q;
	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$result = mysql_query($q) or die("update Fehler....$q.");
	/**/
	mysql_close($db);

};


function loeschen($id,$user)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)     or die("Fehler beim verbinden!");

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$q = "delete from $TABLE where id=\"$id\" ";
	//  echo $q;
	$result = mysql_query($q) or die("Delete Fehler....$q.");
	/**/
	mysql_close($db);

};


function print_anmeld($id,$user,$next,$erf,$ID)
{
	//
	//  $id   beinhaltet den zu bearbeitenden Datensatz
	//  $user beinhaltet den User des Programms (authetifizierung)
	//  $next beinhaltet die nächste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//
	// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
	//
	//$TABLE = "con_anmeldung";
	//$TABLE1= "con_tage";

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
	global $TAG;
	global $ID;
	global $PHP_SELF;

	//Anzeigen von Contage als einfache Maske
	//function view() {
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	// Zugriff auf CON-TAGE
	$q = "select * from $TABLE1 where tag=$TAG";
	$result1 = mysql_query($q) or die("Query $TABLE1");
	$row1 = mysql_fetch_array ($result1);

	if ($erf == 0 )
	{
		// Zugriff aufCON_Anmeldung
		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");
		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
		$err = 0;

	} else
	{
		// Zugriff aufCON_Anmeldung
		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");
		//
		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);
		$datum = strftime("%Y-%m-%d");
		//echo "$TAG / $datum / $row1[6]\n";
		if ($datum <= $row1[6])
		{
			$err = 0;
		} else
		{
			$err = 1;
		}

	}

	mysql_close($db);
	//  echo count($row);
	/**/
	if (count($row)==1)
	{
		for ($i=0; $i<$field_num; $i++)
		{
			$row[$i] = "";
		};
		$row[11] = get_user_id($user);
		$row[2] = get_author($row[11]);
		$row[3] = get_mail($row[11]);
		$row[6] = 1;

	};
	/**/
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	if ($err != 0)
	{

	    echo "  <TABLE WIDTH=\"435\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR HEIGHT=30>\n";
		echo "    <TD > <CENTER><B>ANMELDUNGSCHLUSS !&nbsp;".print_datum($row1[6])."&nbsp;&nbsp;&nbsp;</TD>\n";
		echo "    </TR>\n";
		echo "  </TABLE>\n";
		
	}  else
	{
		echo "  <TD\n>";  //Daten bereich der Gesamttabelle

		echo "<FORM ACTION=\"$PHP_SELF?ID=$ID\" METHOD=POST  >\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[1]\"   VALUE=\"$TAG\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"row[11]\"   VALUE=\"$row[11]\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
		echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"  VALUE=\"$ID\">\n";

		echo "<TABLE WIDTH=\"560px\" BORDER=\"0px\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR HEIGHT=30>\n";
		echo "    <TD colspan=6> <CENTER><B>ANMELDUNG&nbsp;&nbsp;&nbsp;&nbsp;</TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=55><!-- Row:2, Col:1 -->\n";
		echo "        <B>Tag :\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:2, Col:2 -->\n";
		echo "        <B>$TAG\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=55><!-- Row:3, Col:1 -->\n";
		echo "        <P ALIGN=RIGHT>\n";
		echo "        <B>vom &nbsp;\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:4, Col:1 -->\n";
		echo "        <B>$row1[2]\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=55><!-- Row:5, Col:1 -->\n";
		echo "        <P ALIGN=RIGHT>\n";
		echo "        <B>bis&nbsp;\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:6, Col:1 -->\n";
		echo "        <B>$row1[3]\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "    <TR HEIGHT=10>\n";
		echo "    <TD></TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "  <TD colspan=6>\n";
		echo " <TEXTAREA NAME=\"text\" COLS=65 ROWS=20 READONLY>\n";
		echo "$row1[8]\n";
		echo "Anmeldeschluss $row1[6]\n";
		echo "Kosten : $row1[4] EUR\n";
		echo "  </TEXTAREA>\n";
		echo "  </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";

		echo "<TABLE WIDTH=\"560\" BORDER=\"0px\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "<TR>\n";
		echo "<TD>\n";
		echo "    <TABLE WIDTH=\"500\" BORDER=\"0px\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR HEIGHT=10>\n";
		echo "    <TD></TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=\"55\"><!-- Row:1, Col:1 -->\n";
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
		echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
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
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
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
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
		echo "        Taverne\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=50><!-- Row:2, Col:2 -->\n";
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
		echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR>\n";
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
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
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
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
		echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
		echo "        Orga\n";
		echo "        </TD>\n";
		echo "        <TD WIDTH=50><!-- Row:2, Col:2 -->\n";
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
		echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
		echo "    <TR>\n";
		//    echo "      <TD>\n";
		//    echo "        Bemerkung\n";
		//    echo "        </TD>\n";
		echo "        <TD colspan=3><!-- Row:5, Col:2 -->\n";
		//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[10]\" SIZE=50 MAXLENGTH=50 VALUE=\"$row[10]\">\n";
		echo "        <TEXTAREA NAME=\"row[10]\" COLS=64 ROWS=4>$row[10]</TEXTAREA>&nbsp;</td>\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
		echo "        <TD><!-- Row:5, Col:1 -->\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:5, Col:2 -->\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "    <TR>\n";
  		echo "        <TD><!-- Row:5, Col:1 -->\n";
  		echo "        </TD>\n";
		echo "        <TD colspan=2><!-- Row:5, Col:2 -->\n";
		echo "        <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">\n";
		echo "        &nbsp;&nbsp;&nbsp;&nbsp;\n";
		echo "        <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">\n";
		echo "        </TD>\n";
		echo "        <TD><!-- Row:5, Col:2 -->\n";
		echo "        </TD>\n";
		echo "    </TR>\n";
		echo "</TABLE>\n";
		echo "</TR>\n";
		echo "</TD>\n";
		echo "</TABLE>\n";
		echo "</FORM>\n";
	echo '</div>';
	
  }
  echo '</div>';
  echo "<!---  ENDE DATEN Spalte   --->\n";
};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$BEREICH = 'INTERN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$g_md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
$ID     = GET_SESSIONID("");
$g_id   = GET_id("0");

$p_md   = POST_md("md");
$p_row  = POST_row("0");

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

// 	// Prüfung des Zugriffsrecht über Lvl
// 	//
// 	if ($user_lvl <= $lvL_sl[14])
// 	{
// 		header ("Location: ../larp.html");  /* Umleitung des Browsers
// 		zur PHP-Web-Seite. */
// 		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
// 		Code ausgeführt wird. */
// 	};

$TAG   = get_akttag();
$TABLE = "con_anmeldung";
$TABLE1= "con_tage";

print_header("Con Anmeldung");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
print_kopf($logo_typ,$header_typ,"Con Anmeldung Dienste",$anrede,$menu_item);

//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";


switch ($p_md):
case 5: // Anlegen eines neuen des DAtensatzes
	//  Insert SQL
	insert($p_row);
$g_md= 0;
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	$g_md= 0;
	break;
default:  // MAIN-Menu
	endswitch;

	switch ($g_md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($g_id,$user);
	$g_md=3;
	break;

default:  // MAIN-Menu
	endswitch;


	switch ($g_md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
		);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 10:  // Meine Anmelde Liste
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 11:  // Meine Anmelde Liste
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
    break;
default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "99","caption" => "ANMELDUNG Tag $TAG","link" => ""),
	1=>array("icon" => "_add","caption" => "Neu","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG"),
	2=>array("icon" => "_folder","caption" => "Dienste","link" => "larp_anmelde_dienste.php?md=0&ID=$ID&TAG=$TAG"),
	3=>array("icon" => "_list","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&TAG=$TAG"),
	5=>array("icon" => "_list","caption" => "alle Anmeldungen","link" => "$PHP_SELF?md=10&ID=$ID&TAG=$TAG"),
	6=>array("icon" => "_list","caption" => "Con Liste","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG"),
//	98=>array ("icon" => "_list","caption" => "Reports ","link" => "larp_anmelde_rep.php?md=0&ID=$ID"),
	9=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID&TAG=$TAG")
	);
	endswitch;

	print_menu($menu);

	//echo $TAG;

	switch ($g_md):
case 1:
		//
		print_anmeld($g_id,$user,5,1,$ID);
	break;
case 2:
	Print_info($g_id, $user, $ID,$TAG);
	break;
case 3:
	//
	print_loeschen($user);
	break;
case 4:
	//
	print_anmeld($g_id,$user,6,0,$ID);
	break;
case 10:
	info_liste($spieler_id,$ID);
	break;
case 11:
	tage_liste($spieler_id,$ID,$TAG);
	break;
default:
	print_liste($user);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>