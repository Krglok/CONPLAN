<?php
/*
 Projekt :  ADMIN

Datei   :  admin_anmelde.php

Datum   :  2002/05/30

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Datensätze
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.

Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !


#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

$Log: anmelde_admin.php,v $
Revision 1.3  2002/05/30 07:21:50  windu
Einbringen des Aktuellen Con-Tages
mit neuer Tabelle con_konst

Revision 1.2  2002/05/24 13:05:14  windu
Tag 24 aktiviert

Revision 1.1  2002/05/03 20:23:40  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";


//-----------------------------------------------------------------------------
function print_liste($user,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where tag=\"$TAG\"";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
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
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]\">\n";
				print_menu_icon (9);
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function info_liste($spieler,$ID,$TAG)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TABLE1;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 order by tag DESC";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
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
				echo "\t<td width=\"20\"><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]\">\n";
			print_menu_icon (9);
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
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($user,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where tag=\"$TAG\"";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table width=\"100%\" border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	//lfdnr,name,vorname,orga}
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
				print_menu_icon (4,"Datensatz löschen, unwiederuflich !");
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
		echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Datensatz Ansehen\" HSPACE=\"0\" VSPACE=\"0\">\n";
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_info($id,$user,$ID,$TAG)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;

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
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

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
	echo "        <B>$row1[2]\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=55><!-- Row:5, Col:1 -->\n";
	echo "        <P ALIGN=RIGHT>\n";
	echo "        <B>bis&nbsp;\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:6, Col:1 -->\n";
	//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"\" SIZE=10 MAXLENGTH=10 VALUE=\"$row1[3]\" READONLY>\n";
	echo "        <B>$row1[3]\n";
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
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};


function insert($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

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
		$q = $q.",$field_name[$i]=\"$row[$i]\" ";
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


function loeschen($id)
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

function print_maske($id,$user,$next,$erf,$ID)
{
	//
	//  $id   beinhaltet den zu bearbeitenden Datensatz
	//  $next beinhaltet die nächste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//
	// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
	//
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TAG;

	//Anzeigen von Contage als einfache Maske
	//function view() {
	if ($erf == 0 )
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
	} else
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");


		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);

	}
	//  echo count($row);
	/**/
	if (count($row)==1)
	{
		for ($i=0; $i<$field_num; $i++)
		{
			$row[$i] = "";
		};
	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t<td><center><b>$TABLE</b></td>\n";
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);

	}
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($i!=0)
		{
			if ($type[$i]!="blob")
			{
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";

				echo "<tr>";
			} else
			{
				echo "<tr>";
				echo "\t<td><b></b></td>\n";
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "<tr>";
			}
		} else
		{
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
			echo "<tr>";
		}
	}


	echo "\t<tr>\n";
	echo "\t<td></td>\n";
	echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "\t</tr>\n";

	echo "</table>";
	echo "  </TD\n>"; //ENDE  Datenbereich der Gesamttabelle

};

function print_anmeld($id,$user,$next,$erf)
{
	//
	//  $id   beinhaltet den zu bearbeitenden Datensatz
	//  $user beinhaltet den User des Programms (authetifizierung)
	//  $next beinhaltet die nächste zu rufende Funktion
	//  $erf  steurt die Variablen initialisierung
	//
	// durch $next kann die Maske sowohl für Erfassen als auch Bearbeiten benutzt werden.
	//
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
	global $TAG;

	//Anzeigen von Contage als einfache Maske
	//function view() {
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag=\"$TAG\"";
	$result1 = mysql_query($q) or die("Query $TABLE1");
	$row1 = mysql_fetch_array ($result1);

	if ($erf == 0 )
	{

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");
		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
	} else
	{

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);


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
		$name = get_author($row[11]);
		$mail = get_mail($row[11]);

	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[1]\"   VALUE=\"$TAG\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[11]\"   VALUE=\"$row[11]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";

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
	echo "        <B>$row1[2]\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=55><!-- Row:5, Col:1 -->\n";
	echo "        <P ALIGN=RIGHT>\n";
	echo "        <B>bis&nbsp;\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:6, Col:1 -->\n";
	//    echo "        <INPUT TYPE=\"TEXT\" NAME=\"\" SIZE=10 MAXLENGTH=10 VALUE=\"$row1[3]\" READONLY>\n";
	echo "        <B>$row1[3]\n";
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

	echo "<TABLE WIDTH=\"435\" BORDER=\"1\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "<TR>\n";
	echo "<TD>\n";
	echo "    <TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "    <TR HEIGHT=10>\n";
	echo "    <TD></TD>\n";
	echo "    </TR>\n";
	echo "    <TR>\n";
	echo "        <TD WIDTH=\"55\"><!-- Row:1, Col:1 -->\n";
	echo "        Name\n";
	echo "        </TD>\n";
	echo "        <TD colspan=4><!-- Row:1, Col:2 -->\n";
	echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=30 MAXLENGTH=30 VALUE=\"$name\">\n";
	echo "        </TD>\n";
	echo "    </TR>\n";
	echo "    <TR>\n";
	echo "        <TD  ><!-- Row:4, Col:1 -->\n";
	echo "        email\n";
	echo "        </TD>\n";
	echo "        <TD colspan=4><!-- Row:4, Col:2 -->\n";
	echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=30 MAXLENGTH=30 VALUE=\"$mail\">\n";
	echo "        </TD>\n";
	echo "    </TR>\n";
	echo "</TABLE>\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "    <TR>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        WC\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[6]\" VALUE=\"1\" CHECKED>\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        Abwasch\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[4]\" VALUE=\"1\" >\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        Taverne\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[5]\" VALUE=\"1\" >\n";
	echo "        </TD>\n";
	echo "    </TR>\n";
	echo "</TABLE>\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "    <TR>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        NSC\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[7]\" VALUE=\"1\" >\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        Aufbau\n";
	echo "        </TD>\n";
	echo "        <TD><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[8]\" VALUE=\"1\" >\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:1 -->\n";
	echo "        Orga\n";
	echo "        </TD>\n";
	echo "        <TD WIDTH=50><!-- Row:2, Col:2 -->\n";
	echo "        <INPUT TYPE=\"checkbox\" NAME=\"row[9]\" VALUE=\"1\" >\n";
	echo "        </TD>\n";
	echo "    </TR>\n";
	echo "</TABLE>\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"0\" BGCOLOR=\"\" BORDERCOLOR=\"#C0C0C0\" BORDERCOLORDARK=\"#808080\" BORDERCOLORLIGHT=\"#C0C0C0\">\n";
	echo "    <TR>\n";
	echo "      <TD>\n";
	echo "        Bemerkung\n";
	echo "        </TD>\n";
	echo "        <TD colspan=4><!-- Row:5, Col:2 -->\n";
	echo "        <INPUT TYPE=\"TEXT\" NAME=\"row[10]\" SIZE=50 MAXLENGTH=50 VALUE=\"\">\n";
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
	echo "        <TD colspan=4><!-- Row:5, Col:2 -->\n";
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
	echo "  </TD\n>"; //ENDE  Datenbereich der Gesamttabelle

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];


session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];
$user_id 		= $_SESSION[user_id];

if ($ID == "")
{
	$session_id = 'FFFF';
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

if (getuser($user,$pw) != "TRUE")
{
	header ("Location: main.php");  // Umleitung des Browsers
	//       zur PHP-Web-Seite.
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}
else
{
	$l1 = (int) $user_lvl;
	$l2 = (int) $lvl_admin[14];
	if ($l1 >= $l2)
	{
		header ("Location: main.php?md=0");  /* Umleitung des Browsers
		zur HTML-StartSeite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
};
if ($md == 99)
{
	session_destroy();
	header ("Location: main.php?md=0");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
};

print_header("Admin Bereich");

print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Admin Bereich","Sei gegrüsst Meister ");


echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

print_md();

$TAG   = get_akttag();
$TABLE = "con_anmeldung";
$TABLE1= "con_tage";

switch ($p_md):
case 5:  // MAIN-Menu
	//  SQL  insert
	insert($p_row);
$md=0;
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	$md=0;
	break;
default :
	break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete  enfaellt  , nur Admin funktion
		loeschen($id);
	$md=3;
	break;
default :
	break;
	endswitch;


	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
		);
		break;
case 2: // Ansehen / INFO eines Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "7","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 4: // Anzigen Bearbeiten Form
	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	break;
case 10:  // MAIN-Menu
	$menu = array (0=>array("icon" => "7","caption" => "Anmeldung","link" => ""),
	1=>array("icon" => "99","caption" => "<b>für ConTag $TAG</b>","link" => ""),
	2=>array("icon" => "11","caption" => "Anmelden","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG"),
	3=>array("icon" => "5","caption" => "Dienste","link" => "admin_anmdienst.php?md=0&ID=$ID&TAG=$TAG"),
	4=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&TAG=$TAG"),
	5=>array("icon" => "5","caption" => "Akt. Liste","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG"),
	9=>array("icon" => "6","caption" => "Zurück","link" => "admin_con.php?md=0&ID=$ID&TAG=$TAG")
	);
	break;
default:  // MAIN-Menu
	$menu = array (0=>array("icon" => "7","caption" => "Anmeldung","link" => ""),
	1=>array("icon" => "99","caption" => "<b>für ConTag $TAG</b>","link" => ""),
	2=>array("icon" => "11","caption" => "Anmelden","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG"),
	3=>array("icon" => "5","caption" => "Dienste","link" => "admin_anmdienst.php?md=0&ID=$ID&TAG=$TAG"),
	4=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&TAG=$TAG"),
	5=>array("icon" => "5","caption" => "Con Liste","link" => "$PHP_SELF?md=10&ID=$ID&TAG=$TAG"),
	9=>array("icon" => "6","caption" => "Zurück","link" => "admin_con.php?md=0&ID=$ID&TAG=$TAG")
	);
	endswitch;

	print_menu($menu);


	switch ($md):
case 1:
		//
		print_anmeld($id,$user,5,1,$ID);
	break;
case 2:
	Print_info($id, $user,$ID,$TAG);
	break;
case 3:
	//
	print_loeschen($user,$ID);
	break;
case 4:
	//
	print_maske($id,$user,6,0,$ID);
	break;
case 10:
	info_liste($spieler_id,$ID,$TAG);
	break;
default:
	print_liste($user,$ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>