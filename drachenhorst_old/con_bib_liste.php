<?
/*
 Projekt : 	CONPLAN

Datei   :   con_bib_liste.php

Datum   :   2006-06-04

Rev.    :   2.0

Author  :   Olaf Duda

beschreibung :
realisiert die Bearbeitungsfunktionen für die BIBLIOTHEK
Dies entspricht dem Status Bibliothekar
- Liste der Bereiche mit Zugriff
- Liste der Themen (alle)
- Liste der Titel nach Zugriff (public OR privat OR protect)
- Erfassen neuer Datensätze, Recht (write)
- Bearbeiten vorhandener Datensätze Recht (write)
- Anzeige der Details ohne Bearbeitung Recht (read/write)
- Löschen  eines Datensatzes (nicht installiert)

Die Abwicklung basiert auf den Variablen
bib_id = PK des Bereiches
THEMEN = Klartext des Themas

Die  Zugriffsverwaltung stuetzt sich auf die user_id des Benutzers.
Es werden nur Datensaetze aus den Bereichen gewaehlten Bereich
bib_id
und mit dem in der Zugriffsverwaltung hinterlegten Zugriff
(public, privat,protect)
angezeigt
und mit dem in der Zugriffsverwaltung hinterlegten Rechten
(read, write)
bearbeitet.

Die Zugriffsrechte werden bei jeder Funktion gelesen und ausgewertet.

Die Bereichnamen werden bei jeder Funktion gelesen.

ALLGEMEIN===
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
 


*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "bib_lib.inc";
include "head.inc";



//-----------------------------------------------------------------------------
function print_liste($ID, $THEMEN,$bib_id)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_info>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TAG;

	$BIB = get_bib_bereich($bib_id);
	$recht = get_bib_recht($bib_id);
	$zugriff = get_bib_zugriff($bib_id);

	echo $BIB."/".$THEMEN."/".$recht."/".$zugriff;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	if ($zugriff=="public")
	{
		$where_and = "AND zugriff = \"public\" ";
	}
	if ($zugriff=="privat")
	{
		$where_and = "AND (zugriff = \"public\" OR zugriff = \"privat\") ";
	}
	if ($zugriff=="protect")
	{
		$where_and = "AND (zugriff = \"public\" OR zugriff = \"privat\" OR zugriff = \"protect\") ";
	}

	$where = "where bereich=\"$BIB\" AND thema like \"$THEMEN\" $where_and ";
	$order = " order by thema, item,jahr DESC ,sort DESC,titel ";

	$q = "select ID,thema,titel,kurz,item,zugriff from $TABLE $where $order ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
	echo "</tr>\n";
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Detaildaten
			if ($i==0)
			{
				if ($recht=="write")
				{
					echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&THEMEN=$THEMEN&bib_id=$bib_id\">\n";
					print_menu_icon (3);
					echo "\t</a></td>\n";
				} else
				{
					echo "\t<td>&nbsp;</td>\n";
				}
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&THEMEN=$THEMEN&bib_id=$bib_id\">\n";
		print_menu_icon (7);
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

//-----------------------------------------------------------------------------
function print_bereiche($ID, $THEMEN,$BIB)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Detailansicht <print_info>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE3;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$where = "";
	$order = " order by bereich ";
	$q = "select * from $TABLE3 $where $order ";
	$result = mysql_query($q)  or die("Query Fehler.".$q);

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<table border=1 BGCOLOR=\"\">\n";

	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
	};
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
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID,$THEMEN,$BIB)
//==========================================================================
// Function     : print_loeschen
//--------------------------------------------------------------------------
// Beschreibun  : Darstellen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                Kopfzeile   = Feldnamem
//                Datenzeilen = selektierte Felder
//                LINK auf Loeschfunktion <loeschen>
//
// Argumente    : $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where BIB=\"$BIB\" thema=\"$THEMEN\"";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle
	echo "<INPUT TYPE=\"hidden\" NAME=\"THEMEN\" VALUE=\"$THEMEN\">\n";

	echo "<table border=1 BGCOLOR=\"\">\n";

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
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
				echo "\t<IMG SRC=\"../larp/images/stop.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"20\" ALT=\"Datensatz Löschen\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
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

function print_info($id,$THEMEN,$ID,$bib_id)
//==========================================================================
// Function     : print_info
//--------------------------------------------------------------------------
// Beschreibun  : Anzeige der Detail der Bildergalerie  mit
//                - Tag = Topid_id
//                - Sortiernummer
//                - Lfdnummer des Bildes
//                - Name des Bildes
//                - Image des Bildes
//                - Beschreibung als Langtext
//                Anzeige als Tabelle
//
// Argumente    : $id = recordnummer des Bildes
//                $ID = Session_ID
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q)
	or die("Query Fehler...");

	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	mysql_close($db);

	//Daten bereich
	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"THEMEN\" VALUE=\"$THEMEN\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"bib_id\"   VALUE=\"$bib_id\">\n";
	echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name($result,$i);
		$type[$i]       =  mysql_field_type ($result, $i);
	}

	echo "<TABLE WIDTH=100% BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\" BACKGROUND=\" back/paper.jpg\">\n";
	echo "<tr>";
	echo "\t<td width=10 > \n";
	echo "\t&nbsp;</td>\n";
	echo "\t<td width=100% > \n";
	echo "\t<DIV ALIGN=\"RIGHT\">\n";
	echo "\t<FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;Thema : \n";
	echo "\t<FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">";
	echo "\t $row[2]\n";
	echo "</DIV>";
	echo "\t<FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;Titel : \n";
	echo "\t<FONT  COLOR=#000000 SIZE=4 FACE=\"Comic Sans MS\">";
	echo "\t$row[4] \n";
	echo "\t</td>\n";
	echo "\t<td > \n";
	echo "\t<a href=\"$PHP_SELF?md=9&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id\" > \n";
	//    echo "\t<IMG SRC=\"../bib_logo/G.gif\" BORDER=\"0\" HEIGHT=\"50\" WIDTH=\"50\" ALT=\"Zurück\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	print_menu_icon (6);
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td  ><FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td  ><FONT  COLOR=#000000 SIZE=2> Kurz <FONT  COLOR=#000000 SIZE=3> $row[5] </td>\n";
	echo "\t<td ><br>&nbsp;</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td ><FONT  COLOR=#000000  SIZE=4 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td  >\n";
	echo "\t<FONT  COLOR=#000000 SIZE=2> Author : <FONT  COLOR=#000000 SIZE=3> $row[7] \n";
	echo "\t<b> &nbsp; &nbsp;&nbsp;&nbsp;</b>\n";
	echo "\t<FONT  COLOR=#000000 SIZE=2> Jahr :  <FONT  COLOR=#000000 SIZE=3> $row[9] \n";
	echo "\t <FONT  COLOR=#000000 SIZE=3>  $row[8]\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	echo "\t<td><FONT  COLOR=#000000  SIZE=2 FACE=\"Comic Sans MS\">&nbsp;</td>\n";
	echo "\t<td >\n";
	$zeile=explode("\n",$row[6]);
	$anz  = count($zeile);
	for ($ii=0; $ii<$anz; $ii++)
	{
		$zeile[$ii] = rtrim($zeile[$ii]);
		$zeile[$ii] = str_replace("  ", "&nbsp;&nbsp;", $zeile[$ii]);
		echo "\t<FONT  COLOR=#000000  SIZE=3 FACE=\"Comic Sans MS\">$zeile[$ii]<BR>\n";
	}
	echo "\t</td>\n";
	echo "\t<td ><br>&nbsp;</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "</table>";
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};


function insert($row)
//==========================================================================
// Function     :  insert
//--------------------------------------------------------------------------
// Beschreibun  :  Fügt einen Datensatz in eine Tabelle ein
//                 Die Daten liegen als Array vor
//                 die Spalten sind identisch mit
//                 den Feldern der Tabelle.
//                 Ebenso die Reihemfolge der Felder !
//
// Argumente    :  $row = zu speichernde Daten
//
// Returns      :  --
//==========================================================================
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
	//  echo $q;

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	//  $q ="insert INTO con_tage (tag,von,bis,bemerkung,kosten,leg_id,text) VALUES ( \"$tag\",\"$von\",\"$bis\",\"$bemerkung\",\"$kosten\",\"$leg_id\",\"$text\"";
	$result = mysql_query($q) or die("InsertFehler....$q.");

	mysql_close($db);

};


function update($row)
//==========================================================================
// Function     : update
//--------------------------------------------------------------------------
// Beschreibung : Update eines Datensatzes in einer Tabelle
//                 Die Daten liegen als Array vor
//                 die Spalten sind identisch mit
//                 den Feldern der Tabelle.
//                 Ebenso die Reihemfolge der Felder !
//                 Die Recordnummer liegt in $row[0]
//
// Argumente    : $row = die zu speichernde Daten
//
// Returns      : --
//==========================================================================
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
//==========================================================================
// Function     :  loeschen
//--------------------------------------------------------------------------
// Beschreibun  :  Loescht einen Datensatz aus einer Tabelle
//
// Argumente    :  $id = Recordnummer (PRIMARY)
//                 $ID = Sessionmanagnet
//
// Returns      : --
//==========================================================================
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

function print_maske($id,$THEMEN,$next,$erf,$ID,$bib_id,$BIB)
{
	//==========================================================================
	// Function     :  print_maske
	//--------------------------------------------------------------------------
	// Beschreibung : Bearbeiten der Felder der Tabelle
	//                Die Abfrage MUSS alle Felder beinhalten
	//                linke Spalte = Feldnamem
	//                rechte Spalte = Feld
	//
	//                Button = SUBMIT und CANCEL
	//
	//                durch $next kann die Maske sowohl für Erfassen als auch
	//                Bearbeiten benutzt werden.
	//
	// Argumente    : $ID = Session_ID
	//                $id   beinhaltet den zu bearbeitenden Datensatz
	//                $next beinhaltet die nächste zu rufende Funktion
	//                $erf  steurt die Variablen initialisierung
	//                      0 = Bearbeiten der Daten
	//                      1 = Erfassen neuer Daten
	//
	// Returns      : --
	//
	//==========================================================================
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
	global $TABLE2;

	if ($erf == 0 ) //  BEarbeiten Modus / Update
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		$q1 = "select thema from $TABLE1 where ID>0";
		$result1 = mysql_query($q1) or die("Query THEMA");

		$q2 = "select item from $TABLE2 where ID>0";
		$result2 = mysql_query($q2) or die("Query ITEM");

		mysql_close($db);

		$thema_anz =  mysql_num_rows($result1);

		$item_anz =  mysql_num_rows($result2);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);
	} else
	{				// ERFASSEN Modus  ( Insert)
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");
			
		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...");

		$q1 = "select thema from $TABLE1 where ID>0";
		$result1 = mysql_query($q1) or die("Query THEMA");

		$q2 = "select item from $TABLE2 where ID>0";
		$result2 = mysql_query($q2) or die("Query ITEM");

		mysql_close($db);

		$thema_anz =  mysql_num_rows($result1);

		$item_anz =  mysql_num_rows($result2);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);

	}
	if (count($row)==1)
	{
		for ($i=0; $i<$field_num; $i++)
		{
			$row[$i] = "";
		};
		$row[1] = $BIB;		//Vorbelegter Wert gewaehlte Bibliothek
		$row[2] = $THEMEN;	//Vorbelegter Wert gewaehltes Thema
	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"THEMEN\" VALUE=\"$THEMEN\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"bib_id\" VALUE=\"$bib_id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"  VALUE=\"$ID\">\n";
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
				switch($i)
				{
					case 2 :
						echo "<tr>";
						echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
						echo "\t<td>\n";
						echo "\t<select name=\"row[$i]\" MAXLENGTH=25 >\n";
						echo "\t<option selected> $row[$i]\n";
						for ($j=0; $j<$thema_anz; $j++)
						{
							$thema = mysql_fetch_array ($result1);
							echo "\t<option value=\"$thema[0]\">  $thema[0]\n";
						}
						echo "\t</select> \n";
						echo "\t</td>";
						echo "</tr>";
						break;
					case 3 :
						echo "<tr>";
						echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
						echo "\t<td>\n";
						echo "<input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">\n";
						echo "\t<select name=\"1\" MAXLENGTH=25 >\n";
						echo "\t<option selected> $row[$i]\n";
						for ($j=0; $j<$item_anz; $j++)
						{
							$item = mysql_fetch_array ($result2);
							echo "\t<option value=\"$item[0]\">  $item[0]\n";
						}
						echo "\t</select> \n";
						echo "\t</td>";
						echo "</tr>";
						break;
					case 13 :
						echo "<tr>";
						echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
						echo "\t<td>\n";
						echo "\t<select name=\"row[$i]\" MAXLENGTH=25 >\n";
						echo "\t<option selected> $row[$i]\n";
						echo "\t<option value=\"PUBLIC\">  PUBLIC\n";
						echo "\t<option value=\"PRIVAT\">  PRIVAT\n";
						echo "\t<option value=\"PROTECT\">  PROTECT\n";
						echo "\t</select> \n";
						echo "\t</td>";
						echo "</tr>";
						break;
					default:
						echo "<tr>";
						echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

						echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";

						echo "</tr>";
				} // switch
			} else
			{
				echo "<tr>";
				echo "\t<td><b></b></td>\n";
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=70 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
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


function make_thema_menu($THEMEN,$ID,$bib_id)
//==========================================================================
// Function     :  make_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Menü aus der Tabelle <bilder_topic>
//                Der erste Eintrag wird ignoriert
//
// Argumente    :
//
// Returns      : $menu = array
//
//==========================================================================
//  2=>array("icon" => "1","caption" => "Tag 1","link" => "$PHP_SELF?md=11&ID=$ID"),
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE1;

	$BIB = get_bib_bereich($bib_id);
	$recht = get_bib_recht($bib_id);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$table = $TABLE1;
	$fields= "$TABLE1.id,$TABLE1.thema ";
	$join  = " ";
	$where = "  ";
	$order = "order by thema";

	$q = "select $fields from $table $join $where $order ";
	$result = mysql_query($q)  or die("Query Thema : ".$q);
	$anz = mysql_num_rows($result);
	mysql_close($db);

	$row = mysql_fetch_row($result);

	$menu = array (0=>array("icon" => "99","caption" => "$BIB","link" => ""));

	if ($recht == "write")
	{
		$menu[1] = array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id");
	}
	$menu[2] = array("icon" => "0","caption" => "","link" => "$PHP_SELF?md=0&ID=$ID&THEMEN=%&bib_id=$bib_id");
	$menu[3] = array("icon" => "1","caption" => "ALLE","link" => "$PHP_SELF?md=9&ID=$ID&THEMEN=%&bib_id=$bib_id");

	for ($i=4; $i<$anz+3; $i++)
	{
		$row = mysql_fetch_row($result);
		$menu[$i] = array("icon" => "1","caption" => "$row[1]","link" => "$PHP_SELF?md=9&ID=$ID&THEMEN=$row[1]&bib_id=$bib_id");
	}
	$menu[50] = array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&bib_id=$bib_id");

	return  $menu;

};

function make_bereich_menu($THEMEN,$ID)
//==========================================================================
// Function     :  make_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Menü aus der Tabelle <bilder_topic>
//                Der erste Eintrag wird ignoriert
//
// Argumente    :
//
// Returns      : $menu = array
//
//==========================================================================
/*
 CREATE TABLE  `bib_zugriff` (
 		`ID` int(10) unsigned NOT NULL auto_increment,
 		`bereich_id` int(10) unsigned NOT NULL default '0',
 		`user_id` int(10) unsigned NOT NULL default '0',
 		`bib_zugriff` enum('public','protect','privat') NOT NULL default 'public',
 		`bib_recht` enum('read','write') NOT NULL default 'read',
 		PRIMARY KEY  (`ID`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Zugriff auf Bibliotheks bereiche';
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE3;
	global $user_id;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$table = "bib_zugriff";
	$fields= "$TABLE3.bereich, $table.bib_recht, $table.bereich_id";
	$join  = "left outer join $TABLE3 on $TABLE3.id= $table.bereich_id ";
	$where = " where $table.user_id=$user_id";
	$order = ""; //"order by bereich";


	$q = "select $fields from $table $join $where  $order";
	$result = mysql_query($q)  or die("Query Bereich: ".$q);
	$anz = mysql_num_rows($result);
	mysql_close($db);


	$menu = array (0=>array("icon" => "99","caption" => "Bund der Schreiber","link" => ""),
	//                 1=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&THEMEN=$THEMEN"),
	//                 2=>array("icon" => "0","caption" => "THEMEN","link" => "$PHP_SELF?md=9&ID=$ID&THEMEN=%"),
			3=>array("icon" => "99","caption" => "BEREICHE","link" => "$PHP_SELF?md=0&ID=$ID&THEMEN=%")
	);
	for ($i=0; $i<$anz; $i++)
	{
		$row = mysql_fetch_row($result);
		$menu[$i+4] = array("icon" => "1","caption" => "$row[0]/$row[1]","link" => "$PHP_SELF?md=9&ID=$ID&bib_id=$row[2]");
	}
	$menu[50] = array("icon" => "6","caption" => "Zurück","link" => "conmain.php?md=0&ID=$ID&bib_id=$row[2]");

	return  $menu;

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// Prüfung ob User  berechtigt ist

$c_md = $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$id = $_GET['id'];
$ID = $_GET['ID'];
$THEMEN = $_GET['THEMEN'];
$bib_id = $_GET['bib_id'];

$BIB = get_bib_bereich($bib_id);

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
	$l2 = (int) $lvl_sl[14];
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

$TABLE  = "bib_titel";
$TABLE1 = "bib_thema";
$TABLE2 = "bib_item";
$TABLE3 = "bib_bereich";
$TABLE4 = "bib_zugriff";


switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row);
header ("Location: $PHP_SELF?md=9&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id");  /* Umleitung des Browsers
zur PHP-Web-Seite. */
exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
Code ausgeführt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=9&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($id);
	header ("Location: $PHP_SELF?md=3&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	print_header("SL Bereich");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

	print_kopf(1,9,"SL Bereich","Sei gegrüsst Meister ");


	//  echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();



	switch ($md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "99","caption" => "$BIB","link" => ""),
				1=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id")
		);
		print_menu($menu);
		print_maske($id,$THEMEN,5,1,$ID,$bib_id,$BIB);
		break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "$BIB","link" => ""),
	1=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id")
	);
	//      print_menu($menu);
	Print_info($id, $THEMEN,$ID,$bib_id);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "$BIB","link" => ""),
	1=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id")
	);
	print_menu($menu);
	break;
case 4: // Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "$BIB","link" => ""),
	1=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=9&ID=$ID&THEMEN=$THEMEN&bib_id=$bib_id")
	);
	print_menu($menu);
	print_maske($id, $THEMEN,6,0,$ID,$bib_id);
	break;
case 9:  // Das Basis Menü mit den THEMEN
	$menu = make_thema_menu($THEMEN,$ID,$bib_id);
	print_menu($menu);
	print_liste($ID, $THEMEN,$bib_id);
	break;
default:  // Das Basis Menü mit den THEMEN
	$menu = make_bereich_menu($THEMEN,$ID);
	print_menu($menu);
	print_bereiche($ID, $THEMEN,$bib_id);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>