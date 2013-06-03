<?php
/*
 Projekt :  CHARAKTER

Datei   :  char_kopf_liste.php

Datum   :  2002/06/01

Rev.    :   2.0

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


include "_config.inc";
include "_lib.inc";
include "_head.inc";
include "_char_lib.inc";


//-----------------------------------------------------------------------------
function print_liste($id,$ID)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Datenliste  mit
//                den selektierten Felder der Abfrage
//                spezieller Aufbau für Charkter verwaltung
//                CHAR_BASIS
//                CHAR_KOPF
//                CHAR_FERTIGKEITEN
//                CHAR_WAFFEN
//                CHAR_MAGIE
//                CHAR_ALCHINIE
//
// Argumente    : $ID = Charakter_id
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  
	echo "<TABLE width=750  border=0 BGCOLOR=\"\">\n";
	echo "<TR>";
	echo "<TD>";
	list_cvor($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "<TR>";
	echo "<TD>";
	list_cnach($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "</TABLE>";

	echo "<TABLE width=750  border=0 BGCOLOR=\"\">\n";
	echo "<TR>";
	echo "<TD>";
	list_cfert($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "<TR>";
	echo "<TD>";
	list_cwaf($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "</TABLE>";

	echo "<TABLE width=750  border=0 BGCOLOR=\"\">\n";
	echo "<TR>";
	echo "<TD>";
	list_cmag($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "<TR>";
	echo "<TD>";
	list_ctrank($id,$ID);
	echo "</TD>";
	echo "</TR>";
	echo "</TABLE>";

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

	
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
// 	echo "<TABLE width=750  border=0 BGCOLOR=\"\">\n";
// 	echo "<TR>";
// 	echo "<TD>";
	list_ctage($id,$ID);
// 	echo "</TD>";
// 	echo "</TR>";
// 	echo "<TR>";
// 	echo "<TD>";
// 	echo "</TD>";
// 	echo "</TR>";
// 	echo "</TABLE>";

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	

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

	if ($row[0] >= '1')
	{
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
	} else
	{
		insert($row);
	}
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
	global $PHP_SELF;;

	if ($erf == 0 )
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select * from $TABLE where char_id=$id";
		$result = mysql_query($q) or die("Query BEARB".$q);

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

		$q = "select * from $TABLE where char_id=\"0\"";
		$result = mysql_query($q) or die("Query ERF...".$q);


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
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
	
	echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$row[0]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[1]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";
	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t<td><center><b>Charakter Kopfdaten</b></td>\n";
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
		if (($i!=0) AND ($i!=1))
		{
			if ($type[$i]!="blob")
			{
				switch ($i) :
				case 2:
					echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=4 MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">";
				echo " Format 0.1, kein Komma !! ";
				echo "</td>\n";
				echo "<tr>";
				break;
				default :
					echo "<tr>";
					echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
					echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
					echo "<tr>";
					break;
					endswitch;
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
  
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
	
};

function get_menu_char_kopf($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home)
{
  switch ($md):
  case char_add: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
    				2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&id=$id")
    );
    break;
  case char_info: // ANSEHEN Form
    $menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&id=$id")
    );
    break;
  case char_del: // Delete eines bestehenden Datensatzes
    $menu = array (0=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
    9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&id=$id")
    );
    break;
  case char_edit: // Bearbeiten Form
    $menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&id=$id")
    );
    break;
  
  default:  // MAIN MENUE
		$menu = array (0=>array("icon" => "99","caption" => "ÜBERSICHT","link" => ""),
    2=>array("icon" => "_char","caption" => "Basiswerte","link" => "$PHP_SELF?md=".char_edit."&ID=$ID&id=$id"),
    3=>array("icon" => "_db","caption" => "Check","link" => "$PHP_SELF?md=".char_check."&ID=$ID&id=$id"),
    4=>array("icon" => "_folder","caption" => "Vorteile","link" => "char_vor_liste.php?md=0&ID=$ID&daten=$id"),
    5=>array("icon" => "_folder","caption" => "Nachteile","link" => "char_nach_liste.php?md=0&ID=$ID&daten=$id"),
    6=>array("icon" => "_folder","caption" => "Fertigkeiten","link" => "char_fert_liste.php?md=0&ID=$ID&daten=$id"),
    7=>array("icon" => "_folder","caption" => "Waffen","link" => "char_waf_liste.php?md=0&ID=$ID&daten=$id"),
    8=>array("icon" => "_folder","caption" => "Magie .","link" => "char_mag_liste.php?md=0&ID=$ID&daten=$id"),
    9=>array("icon" => "_folder","caption" => "Alchimie","link" => "char_alch_liste.php?md=0&ID=$ID&daten=$id"),
    10=>array("icon" => "_stop","caption" => "Zurück","link" => "$home?md=0&ID=$ID")
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
	
  $TABLE = "char_kopf";
  
  switch ($p_md):
  case char_insert:  // MAIN-Menu
  	insert($p_row);
  header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
  exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  break;
  case char_update: // Update eines bestehnden Datensatzes
  	// Update SQL
  	update($p_row);
  	header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  	break;
  default :
  	break;
  endswitch;
  
  	// automatische Rechenfunktion
  switch ($md):
  case char_check: // automatische Charakter prüfung
  	// SQL Select and Update
  	check_char($id,$ID);
  	header ("Location: $PHP_SELF?md=0&ID=$ID&id=$id");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  	break;
  case 7: // Delete eines bestehenden Datensatzes
  	// SQL delete
  	loeschen($p_id);
  	header ("Location: $PHP_SELF?md=3&ID=$ID&id=$id");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  	break;
  default :
  	break;
 	endswitch;

	print_header("Charakterliste");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

	$isnsc = print_kopf_liste($id,$ID);
	
	if($isnsc == true)
	{
	  $home = "con_nsc_liste.php";
	}else
	{
	  $home = "char_liste.php";
	}
  $titel = "Charakterdaten";
	
	$menu = get_menu_char_kopf($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);

  switch ($md):
  case char_add: // Erfassen eines neuen Datensatzes
		print_menu_status($menu);
		print_maske($id,$ID,5,1);
		break;
  case char_info: // ANSEHEN Form
  	print_menu_status($menu);
  	Print_info($id, $ID);
  	break;
  case char_del: // Delete eines bestehenden Datensatzes
  	print_menu_status($menu);
  	break;
  case char_edit: // Bearbeiten Form
  	print_menu_status($menu);
  	print_maske($id,$ID,6,0);
  	break;
  
  default:  // MAIN MENUE
  	print_menu($menu);
  	print_liste($id,$ID);
  	break;
 	endswitch;

	print_md_ende();

	print_body_ende();

	?>