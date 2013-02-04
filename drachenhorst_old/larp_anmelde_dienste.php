<?
/*
 Projekt : LARP

Datei   :  $RCSfile: _liste.php,v $

Datum   :  $Date: 2002/06/01 10:31:54 $  / 05.02.02

Rev.    :   $Rev$   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :
realisiert die Bearbeitungsfunktionen für die Datei <con_andiest>
- Liste der Datensätze
- Bearbeiten vorhandener Datensätze

Der Script verwaltet die Dienste fuer die Con Anmeldung.
Die Anzahl der Dienste fuer durch die Spieltage vorgegeben.
Ein belegter Datensatz kann nur durchden Admin freigeschaltet werden.
Ein belegter Dartensatz kann nicht neubelegt doder geaendert werden.

Es wird eine Session Verwaltung benutzt, die den User prueft.

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
include "head.inc";


function difdatum($d1,$d2)
//==========================================================================
// Function     : difdatum
//--------------------------------------------------------------------------
// Beschreibun  : Berechnet die differenz in tagen zwischen
//                zwischen datum_1 und dtaum_2
//
// Argumente    : $d1  = datum 1
//                $d2  = datum 2
//
// Returns      : anzahltage INTEGER
//==========================================================================
{
	$j1 = date("Y",$d1);
	$m1 = date("m",$d1);
	$t1 = date("j",$d1);

	$j2 = date("Y",$d2);
	$m2 = date("n",$d2);
	$t2 = date("j",$d2);

	if ($j1==$j2)
	{
		if ($m1==$m2)
		{
			return ($t2-$t1);
		}
		else
		{
			$dif = 0;
			$di  = $d1;
			$ti  = $t1;
			for ($i=$m1; $i==$m2-1; $i++)
			{
				$dif = $dif + date("t",$di) - $ti;
				$ti = 0;
				$di = strtotime("+1 month");
			}
			return $dif+$t2;
		}
	}
	else
	{
		return null;
	}

}

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
	global $TABLE1;
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag=\"$TAG\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	//Kopfzeile
	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	$d0 = strtotime($row[2]);
	$d1 = strtotime("+1 day",$d0);
	$d2 = strtotime($row[3]);
	$tage = difdatum($d1,$d2)+1;
	//  echo $tage.",".date("Y-m-d",$d0).",".date("Y-m-d",$d1).",".date("Y-m-d",$d2);

	// tage weise anzeige
	for ($t=1; $t<=$tage; $t++)
	{
		// select der diesnste des contages
		$q = "select * from $TABLE where tag=\"$TAG\" AND contag=\"$t\" order by typ";
		//    $q = "select * from $TABLE where tag=\"$TAG\" order by typ";
		$result = mysql_query($q)  or die("Dienst Fehler...");

		// ersten Contag berechnen aus Termin
		echo "<hr>\n";
		echo "<table border=1 BGCOLOR=\"\">\n";
		//Liste der Datensätze
		echo "<tr>";
		echo "\t<td>\n";
		echo "\tCONTAG ".$t."\n";
		echo "\t</td>\n";
		echo "\t<td> ".date("Y-m-d",$d1)." &nbsp;</td>\n";
		echo "\t<td>".date("l",$d1)."&nbsp;</td>\n";
		echo "<tr>";
		echo "</table>";

		echo "<table border=1 BGCOLOR=\"\">\n";
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
				// aufruf der Deateildaten
				if ($i==0)
				{
					if ($row[4]=="")
					{
						echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
						//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
						print_menu_icon (9);
						echo "\t</a></td>\n";
					}
					else
					{
						echo "\t<td>\n";
						echo "\t<IMG SRC=\"../larp/images/stop.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
						echo "\t</td>\n";
					}
				} else
				{
					echo "\t<td>$row[$i]&nbsp;</td>\n";
				};
			}
			echo "\t<td>";
			echo "\t</td>\n";
			echo "<tr>";
		}  // end  Liste der Datensaetze
		echo "</table>";
		// naechsten tag berechnen
		$d1 = strtotime("+1 day",$d1);

	} // end tage
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

	mysql_close($db);

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
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where S0=\"$TAG\"";
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
	global $TAG;
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
	};
	/**/

	echo "  <TD\n>";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[5]\"   VALUE=\"$spieler_id\">\n";
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
	for ($i=0; $i<$field_num-1; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}
		if ($i!=0)
		{
			if ($i==4)
			{
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";

				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"".get_spieler($spieler_id)."\"></td>\n";

				echo "<tr>";
			} else
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
			};
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

function init_dienste($TAG)
//==========================================================================
// Function     :  init_dienste
//--------------------------------------------------------------------------
// Beschreibung : Initialisiert die Tabelle fuer die Dienste eines Con
//                Die Datensaetze werden automatisch erstellt.
//                Basis ist die eintragung in die tabelle < con_tage >
//                Fuer jeden Contag werden die folgenden Dienste erstellt
//
//                WC 1 (morgens)
//                WC 2 (mittags)
//                WC 3 (abends)
//
//                ABW 1 (morgens)
//                ABW 2 (mittags)
//                ABW 3 (abends)
//
// Argumente    : $TAG = nummerische ConNummer aus tabelle < con_tage >
//
// Returns      : --
//
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $TABLE1;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag=\"$TAG\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");

	//Kopfzeile
	$field_num = mysql_num_fields($result);
	$row = mysql_fetch_row($result);

	$d0 = strtotime($row[2]);
	$d1 = strtotime("+1 day",$d0);
	$d2 = strtotime($row[3]);
	$tage = difdatum($d1,$d2)+1;

	for ($t = 1; $t <= $tage; $t++)
	{
		// Dienst 1 WC
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";

		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"WC 1 (morgens)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

		// dienst 2 WC
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";
		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"WC 2 (mittags)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

		// Diesnt 3 WC
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";
		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"WC 3 (abends)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

		// Dienst 1 ABW
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";

		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"ABW 1 (morgens)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

		// Dienst 2 ABW
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";

		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"ABW 2 (mittags)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

		// Dienst 3 ABW
		$q ="insert INTO  $TABLE  (";
		$q = $q."tag,contag,typ";

		$q = $q.") VALUES (\"$TAG\" ";
		$q = $q.",\"$t\" ";
		$q = $q.",\"ABW 3 (abends)\" ";
		$q = $q.")";
		$result = mysql_query($q) or die("InsertFehler....$q.");

	} // end tageschleife
	mysql_close($db);
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
$g_md = $_GET['md'];
$g_id = $_GET['id'];

$p_md = $_POST['md'];
$p_row = $_POST['row'];

$ID = $_GET['ID'];


session_start ($ID);
$user       = $_SESSION[user];
$user_lvl   = $_SESSION[user_lvl];
$spieler_id = $_SESSION[spieler_id];

if ($ID == "")
{
	$session_id = 'FFFF';
	header ("Location: main.php");  // Umleitung des Browsers
	exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	// Code ausgeführt wird.
}

// Prüfung ob User  berechtigt ist
if (getuser($user,$pw) != "TRUE")
{
	$session_id = 'FFFF';
	//  echo "ID:$session_id ";
	chdir("..");
	//  Bei fehlendem oder falscher Rechten ins ROOT HTML
	header ("Location: ../larp.html");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
}
else
{
	// Prüfung des Zugriffsrecht über Lvl
	//
	if ($user_lvl <= $lvL_sl[14])
	{
		header ("Location: ../larp.html?$user_lvl&$lvl_sl[14]");  /* Umleitung des Browsers
		zur PHP-Web-Seite. */
		exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
		Code ausgeführt wird. */
	};
	$session_id = '01';
	//  echo "ID:$session_id  Remote $REMOTE_ADDR";
};

$TAG   = get_akttag();
$TABLE = "con_andienst";
$TABLE1 = "con_tage";

switch ($p_md):
case 5:  // MAIN-Menu
	//  SQL  insert
	insert($p_row,$bild,$userfile_name);
header ("Location: $PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE");  /* Umleitung des Browsers
zur PHP-Web-Seite. */
exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
Code ausgeführt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
case 7: // Delete eines bestehenden Datensatzes
	// SQL delete  enfaellt  , nur Admin funktion
	loeschen($g_id);
	header ("Location: $PHP_SELF?md=3&ID=$ID");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;
case 9:  // Init -> main
	init_dienste($TAG);
	header ("Location: $PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE");  /* Umleitung des Browsers
	zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */
	break;

default :
	break;
	endswitch;

	print_header("Con Anmeldung");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

	print_kopf(1,2,"Con Anmeldung Dienste","Sei gegrüsst $spieler_name ");


	echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";

	print_md();



	switch ($g_md):
case 1: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "99","caption" => "DIENSTE Tag $TAG","link" => ""),
				1=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
				2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		print_menu($menu);
		print_maske($g_id,$ID,5,1,$TAG);
		break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "DIENSTE Tag $TAG","link" => ""),
	1=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	print_info($g_id, $ID,$TAG);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "DIENSTE Tag $TAG","link" => ""),
	1=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
	);
	print_menu($menu);
	break;
case 4: // Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "DIENSTE Tag $TAG","link" => ""),
	1=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_maske($g_id,$ID,6,0,$TAG);
	break;
default:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "DIENSTE Tag $TAG","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "larp_anmelde_liste.php?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>