<?php
/*
 Projekt : CHARAKTERE

Datei   :  char_liste.php

Datum   :  2002/06/01

Rev.    :   2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <$TABLE>
- Liste der Charaktere
- Efassen neuer Charaktere
- Bearbeiten vorhandener Charaktere
- Aktivieren eines Charakters
- Sub Liste Contag
- Sub liste Fertigkeiten

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

include "_config.inc";
include "_lib.inc";
include "_head.inc";

//-----------------------------------------------------------------------------
function print_liste($ID)
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
	global $spieler_id;  // wird bei login gesetzt

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,beruf,rasse,gilde,nsc,aktiv,wappen_path,bild_path from $TABLE where spieler_id=\"$spieler_id\" AND nsc=\"N\"";
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
	//  echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]\">\n";
				//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Charakter Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				print_menu_icon ("_db","Charakter Basis bearbeiten");
				echo "\t</a></td>\n";
			} else
			{
				if (($i==6) OR ($i==5))
				{
					if ($i==6)
					{
						if ($row[$i]=='J')
						{
							echo "\t<td width=30 bgcolor=gray>$row[$i]&nbsp;</td>\n";
						} else
							echo "\t<td width=30 >$row[$i]&nbsp;</td>\n";
						{
						};
					} else
					{
						echo "\t<td width=30>$row[$i]&nbsp;</td>\n";
					};
				} else
				{
					echo "\t<td width=130>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "\t<td><a href=\"char_kopf_liste.php?md=0&ID=$ID&id=$row[0]\">\n";
		print_menu_icon ("_edit","Charakter Fertigkeiten bearbeiten");
		echo "\t</a></td>\n";
		echo "</tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($ID)
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
	global $PHP_SELF;
	global $TABLE;
	global $spieler_id;  // wird bei login gesetzt


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	//  $q = "select * from $TABLE where S0=\"$TAG\"";
	$q = "select id,name,beruf,rasse,gilde,nsc,aktiv from $TABLE where spieler_id=\"$spieler_id\" ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

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

function print_info($id,$ID)
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
	global $TAG;


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
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

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
		if ($type[$i]!="blob")
		{
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";
			//        echo "\t<td width=100>$type[$i]&nbsp;</td>\n";
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

	$imagepath = realpath("./chars")."/";
	$file_name = $_FILES['logo']['name'];
	if ($file_name != '' )
	{
		if (move_uploaded_file ($_FILES['logo']['tmp_name'],$imagepath.$file_name));
		{
			$row[8] = $file_name; // Dateiname auf Datenfeld setzen
			tumb_copy($file_name,$imagepath,100,100,$_FILES['logo']['type']);
		};
	};
	$file_name = $_FILES['bild']['name'];
	if ($file_name != '' )
	{
		if (move_uploaded_file ($_FILES['bild']['tmp_name'],$imagepath.$file_name));
		{
			$row[9] = $file_name; // Dateiname auf Datenfeld setzen
			tumb_copy($file_name,$imagepath,100,100,$_FILES['bild']['type']);
		};
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
	//  $q ="insert INTO con_tage (tag,von,bis,bemerkung,kosten,leg_id,text) VALUES ( \"$tag\",\"$von\",\"$bis\",\"$bemerkung\",\"$kosten\",\"$leg_id\",\"$text\"";
	$result = mysql_query($q) or die("InsertFehler....$q.");

	mysql_close($db);

};


function update_sql($row)
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

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	$result = mysql_query($q) or die("update Fehler....$q.");
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

	$imagepath = realpath("./chars")."/";
	$file_name = $_FILES['logo']['name'];
	if ($file_name != '' )
	{
		if (move_uploaded_file ($_FILES['logo']['tmp_name'],$imagepath.$file_name));
		{
			$row[8] = $file_name; // Dateiname auf Datenfeld setzen
			tumb_copy($file_name,$imagepath,100,100,$_FILES['logo']['type']);
		};
	};
	$file_name = $_FILES['bild']['name'];
	if ($file_name != '' )
	{
		if (move_uploaded_file ($_FILES['bild']['tmp_name'],$imagepath.$file_name));
		{
			$row[9] = $file_name; // Dateiname auf Datenfeld setzen
			tumb_copy($file_name,$imagepath,100,100,$_FILES['bild']['type']);
		};
	};
	update_sql($row);
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

function print_maske($id,$ID,$next,$erf)
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
	global $spieler_id;

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
	if (count($row)==1)
	{
		for ($i=0; $i<$field_num; $i++)
		{
			$row[$i] = "";
		};
		$row[1] = $spieler_id;
	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";

	echo "<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t<td><center><b>Charakter Basisdaten</b></td>\n";
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
		if (($i!=0) AND ($i!=1) AND ($i!=13) AND ($i!=12) AND ($i!=11) AND ($i!=7) AND ($i!=8) AND ($i!=9))
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
				echo "\t<td><b>$field_name[$i]&nbsp;</b></td>\n";
				echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=70 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "<tr>";
			}
		} else
		{
			switch ($i):
			case 7:  // NSC Schalter
				echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td> "; // <input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"N\"></td>\n";
			if ($row[7] =="J")
			{
				echo "  <p>";
				echo "    <input type=\"radio\" name=\"row[$i]\" value=\"J\" checked> NSC <br>";
				echo "    <input type=\"radio\" name=\"row[$i]\" value=\"N\"> SC <br>";
				echo "  </p>";
				echo "<tr>";
			} else
			{
				echo "  <p>";
				echo "    <input type=\"radio\" name=\"row[$i]\" value=\"J\"> NSC <br>";
				echo "    <input type=\"radio\" name=\"row[$i]\" value=\"N\" checked > SC <br>";
				echo "  </p>";
				echo "<tr>";
			}
			break;
			case 8:
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td>\n";
				echo "<input type=\"text\" name=\"row[$i]\" SIZE=25 MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" >";
				echo "\t<input type=file name=logo accept=image/*>\n";
				echo " max 100 x 100 ! ";
				echo "</td>\n";
				echo "</tr>";
				break;
			case 9:
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td>\n";
				echo "\t<input type=\"text\" name=\"row[$i]\" SIZE=25 MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" >\n";
				echo "\t<input type=file name=bild accept=image/*>\n";
				echo " max 100 x 100 ! ";
				echo "</td>\n";
				echo "</tr>";
				break;
			case 11:
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td>\n";
				echo "\t<input type=\"text\" name=\"row[$i]\" SIZE=1 MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" >\n";
				echo " Ziel der Notority (H= Hell / N= Neutral / D= Dunkel)";
				echo "</td>\n";
				echo "</tr>";
				break;
			default:  // die geschuetzten Felder
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "\t<td>\n";
				echo "\t<input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly>\n";
				echo "\t</td>\n";
				echo "<tr>";
				break;
				endswitch;
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

function aktiv($id)
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
	global $spieler_id;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where spieler_id=\"$spieler_id\" AND nsc=\"N\"";
	$result = mysql_query($q) or die("update Reset.$q.");

	// Alle auf Nein setzen
	while ($row = mysql_fetch_row($result))
	{
		$q ="update $TABLE  SET aktiv=\"N\" ";
		$q = $q."where id=\"$row[0]\" ";

		if (mysql_select_db($DB_NAME) != TRUE) {
			echo "Fehler DB";
		};
		$upd = mysql_query($q) or die("update Fehler....$q.");
	};

	// Aktuellen Datensatz auf Ja setzen
	$row = mysql_fetch_row($result);
	$q ="update $TABLE  SET aktiv=\"J\" ";
	$q = $q."where id=\"$id\" ";

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	$result = mysql_query($q) or die("update Fehler....$q.");
	mysql_close($db);
};

function print_aktiv($ID)
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
	global $PHP_SELF;
	global $TABLE;
	global $spieler_id;  // wird bei login gesetzt


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);


	$q = "select id,name,beruf,rasse,gilde,nsc,aktiv from $TABLE where spieler_id=\"$spieler_id\"   AND nsc=\"N\" ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

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
				echo "\t<td>";
				echo "\t</td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=9&ID=$ID&id=$row[0]\">\n";
		print_menu_icon ("_point","Charakter aktivieren");
		echo "\t</a></td>\n";
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function get_menu_char_list($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home)
{
  
  switch ($md):
  case 1: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "0","caption" => "NEUER CHARAKTER","link" => ""),
    1=>array("icon" => "0","caption" => "ERFASSEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case 2: // ANSEHEN Form
    $menu = array (0=>array("icon" => "0","caption" => "ANSEHEN","link" => ""),
    1=>array("icon" => "0","caption" => "ANSEHEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG&LISTE=$LISTE")
    );
    break;
  case 3: // Delete eines bestehenden Datensatzes
    $menu = array (0=>array("icon" => "0","caption" => "LÖSCHEN","link" => ""),
    1=>array("icon" => "0","caption" => "LÖSCHEN","link" => ""),
    9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  case 4: // Bearbeiten Form
    $menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
    1=>array("icon" => "0","caption" => "BEARBEITEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
    );
    break;
  case 8: // Aktivieren des aktuellen Char
    $menu = array (0=>array("icon" => "99","caption" => "AKTIVIEREN","link" => ""),
    1=>array("icon" => "0","caption" => "AKTIVIEREN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
    );
    break;
  default:  //
      $menu = array (0=>array("icon" => "99","caption" => "CHARAKTER","link" => ""),
          2=>array("icon" => "_tadd","caption" => "Neuer Charakter","link" => "$PHP_SELF?md=1&ID=$ID","itemtyp"=>"0"),
          3=>array("icon" => "_tcheck","caption" => "CON-Tage","link" => "char_tage_liste.php?md=0&ID=$ID","itemtyp"=>"0"),
          4=>array("icon" => "_db","caption" => "Aktivieren","link" => "$PHP_SELF?md=8&ID=$ID","itemtyp"=>"0"),
          9=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID","itemtyp"=>"0")
      );
        break;
    endswitch;
  return $menu;
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
	$BEREICH = 'INTERN';
	
	$md     = GET_md(0);
	$daten  = GET_daten("");
	$sub    = GET_sub("");
	$id     = GET_id(0);
	
	$p_md   = POST_md(0);
	$p_id 	= POST_id(0);
	$p_row 	= POST_row("");
	//$p_editor1 = POST_editor1("");
	
	
	$ID     = GET_SESSIONID("");
	session_id ($ID);
	session_start();
	$user       = $_SESSION["user"];
	$user_lvl   = $_SESSION["user_lvl"];
	$spieler_id = $_SESSION["spieler_id"];
	$user_id 	= $_SESSION["user_id"];
	$SID        = $_SESSION["ID"];
	
	if ($ID != $SID)
	{
		header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
		exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
		// Code ausgeführt wird.
	}
	
	if (is_user()==FALSE)
	{
	//  echo "no lvl";	
	  header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
	    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	  // Code ausgeführt wird.
	}
	


  $TABLE = "char_basis";


  switch ($p_md):
  case 5:  // MAIN-Menu
  	insert($p_row);
    header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
    exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  break;
  case 6: // Update eines bestehnden Datensatzes
	// Update SQL
  	update($p_row);
  	header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	break;
  default :
  break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($id);
	header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	break;
case 9: // Update eines bestehenden Datensatzes
	// SQL update
	aktiv($id);
	header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	print_header("Charakterliste");
	print_body(2);
	
	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";
	
	$menu_item = $menu_item_help;
	$anrede["name"] = $spieler_name;
	print_kopf($char_typ,$header_typ,"INTERN",$anrede,$menu_item);
//	print_kopf(5,2,"Charakter Verwaltung","Sei gegrüsst $spieler_name ");
	
	$titel = "CHARAKTER";
	$home = "larp.php";
	
	$menu = get_menu_char_list($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);
	print_menu($menu);
	
	switch ($md):
  case 0:  // MAIN-Menu
		print_liste($ID);
		break;
case 1: // Erfassen eines neuen Datensatzes
	print_maske($id,$ID,5,1);
	break;
case 2: // ANSEHEN Form
	Print_info($id, $ID,$TAG);
	break;
case 3: // Delete eines bestehenden Datensatzes
	print_loeschen($ID);
	break;
case 4: // Bearbeiten Form
	print_maske($id,$ID,6,0);
	break;
case 8: // Aktivieren des aktuellen Char
	print_aktiv($ID);
	break;
default:  //
	print_main($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>