<?
/*
 Projekt :  CHARAKTER

Datei   :  waf_liste.php

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  $Author: windu $  / duda

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

#3  02.07.2008  Waffenfertigkeitenliste an neues Regelwerk angepasst
*/


include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";
include "char_lib.inc";


//-----------------------------------------------------------------------------
function print_liste($char,$ID)
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


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where char_id=\"$char\"";
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
				echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[$i]&char=$char\">\n";
				print_menu_icon (3);
				echo "\t</a></td>\n";
			} else
			{
				if ($i==2)
				{
					echo "\t<td width=\"200\" >$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td>$row[$i]&nbsp;</td>\n";
				}
			};
		}
		echo "<tr>";
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_loeschen($char,$ID)
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


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where char_id=\"$char\"";
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
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&char=$char\">\n";
				print_menu_icon (4);
				echo "\t</a></td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "\t<td>\n";
		echo "\t</td>\n";
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

function print_maske($id,$ID,$next,$erf,$ref)
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


		$q = "select * from regelwerk where id=\"$ref\"";
		$result1 = mysql_query($q) or die("Query REF...$q");

		$q = "select * from $TABLE where id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...$q");


		mysql_close($db);

		$row1= mysql_fetch_array ($result1);
		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);
		$muk =  get_char_klasse($id);
		$row[1] = $id;
		$row[2] = $row1[5];
		$row[3] = $row1[9];
		if ($muk=='MUK')
		{
			$row[4] = $row1[10];
		} else
		{
			$row[4] = $row1[11];
		}
		$row[5] = "N";
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
		if (($i!=0) AND ($i!=1) AND ($i!=5))
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
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
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

//==========================================================================
// Function     :  print_fert
//--------------------------------------------------------------------------
// Beschreibung : Zeigt eine Auswahlliste
//
// Argumente    : $ID = Session_ID
//                $char beinhaltet di Referenz auf den Charakter
//
// Returns      : --
//
//==========================================================================
function print_fert($ID,$char)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'regelwerk';


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$where = " where kapitel=\"2\" AND absatz=\"3\" AND item<>\"0\" ";

	$q = "select id,item,kurz,muk,mk from $TABLE $where order by item";
	$result = mysql_query($q)  or die("Query Fert...$q");

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
				echo "\t<td><a href=\"$PHP_SELF?md=1&id=$id&ID=$ID&ref=$row[0]&char=$char\">\n";
				//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Spieler auswählen\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				print_menu_icon (9);
				echo "\t</a></td>\n";
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


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
$c_md 	= $_COOKIE['md'];

$p_md 	= $_POST['md'];
$p_id 	= $_POST['id'];
$p_row 	= $_POST['row'];

$md = $_GET['md'];
$ID = $_GET['ID'];
$id = $_GET['id'];
$char = $_GET['char'];
$ref  = $_GET['ref'];


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



$TABLE = "char_waf";

switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row);
header ("Location: $PHP_SELF?md=0&ID=$ID&char=$char");  /* Auf sich Selbst*/
exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	header ("Location: $PHP_SELF?md=0&ID=$ID&char=$char");  /* Auf sich Selbst*/
	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	switch ($md):
case 7: // Delete eines bestehenden Datensatzes
		// SQL delete
		loeschen($id);
	header ("Location: $PHP_SELF?md=0&ID=$ID&char=$char");  /* Auf sich Selbst*/
	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	break;
default :
	break;
	endswitch;

	print_header("Charakterliste");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


	//  echo "POST : $p_md / GET : $md / id = $id / char = $char";

	print_cbasis($char,$ID);

	print_md();

	switch ($md):
case 0:  // MAIN-Menu
		$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
				2=>array("icon" => "2","caption" => "Erfassen","link" => "$PHP_SELF?md=8&ID=$ID&id=$id&char=$char"),
				3=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&id=$id&char=$char"),
				9=>array("icon" => "6","caption" => "Zurück","link" => "char_kopf_liste.php?md=0&ID=$ID&id=$char")
		);
		print_menu($menu);
		//      print_char_menu($menu);
		print_liste($char,$ID);
		break;
case 1: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
	1=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&char=$id")
	);
	print_menu($menu);
	//      print_char_menu($menu);
	print_maske($char,$ID,5,1,$ref);
	break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
	1=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&char=$char")
	);
	print_menu($menu);
	//      print_char_menu($menu);
	Print_info($id, $ID,$char);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
	1=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&char=$char")
	);
	print_menu($menu);
	//      print_char_menu($menu);
	print_loeschen($char,$ID);
	break;
case 4: // Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
	1=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&char=$char")
	);
	print_menu($menu);
	//      print_char_menu($menu);
	print_maske($id,$ID,6,0,$char);
	break;
case 8: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "WAFFEN","link" => ""),
	1=>array("icon" => "99","caption" => "AUSWAHL","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&char=$char")
	);
	print_menu($menu);
	//      print_char_menu($menu);
	print_fert($ID,$char);
	break;
default:  // die einzelnen Bildseiten 11-xx
	$menu = make_bild_menu();
	print_menu($menu);
	//      print_char_menu($menu);
	print_main($ID);
	break;
	endswitch;


	print_body_ende();

	?>