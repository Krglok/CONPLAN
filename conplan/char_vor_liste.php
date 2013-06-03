<?php
/*
 Projekt :  CCHARRAKTER

Datei   :  vor_liste.php

Datum   :  2002/06/01

Rev.    :   2.0

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
		if($i != 1)
		{
			if ($i==2)
			{
				echo "\t<td width=\"220px\"><b>".mysql_field_name($result,$i)."</b></td>\n";
			} else
			{
				echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			}
		}
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
				echo "\t<td><a href=\"$PHP_SELF?md=".char_edit."&ID=$ID&id=$row[$i]&char=$char\">\n";
				//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
				print_menu_icon ("_point_g");
				echo "\t</a></td>\n";
			} else
			{
				if($i != 1)
				{
					echo "\t<td>$row[$i]&nbsp;</td>\n";
				}
			};
		}
		echo "\t<td><a href=\"$PHP_SELF?md=".char_delete."&ID=$ID&id=$row[0]&daten=$char\">\n";
		print_menu_icon ("_del");
		echo "\t</a></td>\n";
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

function print_maske($id,$ID,$next,$iserf,$ref,$daten)
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
	global $PHP_SELF;
	
	if ($iserf == false )
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
		$row[0] = 0;
		$row[1] = $daten;
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

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
	
	echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID&daten=$daten\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
//	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
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
		// Welche Felder sollen NICHT angezeigt werden !!!
		if (($i!=3)  AND ($i!=5))
		{
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

	$where = ' where kapitel="1" AND absatz="4" AND item<>"0" ';

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
				echo "\t<td><a href=\"$PHP_SELF?md=".char_add."&ID=$ID&auswahl=$row[0]&daten=$char\">\n";
				print_menu_icon ("_point");
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

function get_menu_char_vor($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home)
{
  switch ($md):
  case char_add: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "99","caption" => "VORTEILE","link" => ""),
    1=>array("icon" => "1","caption" => "ERFASSEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&daten=$daten")
    );
    break;
  case char_edit: // Bearbeiten Form
    $menu = array (0=>array("icon" => "99","caption" => "VORTEILE","link" => ""),
    1=>array("icon" => "1","caption" => "BEARBEITEN","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&daten=$daten")
    );
    break;
  case char_auswahl: // Erfassen eines neuen Datensatzes
    $menu = array (0=>array("icon" => "99","caption" => "VORTEILE","link" => ""),
    1=>array("icon" => "1","caption" => "AUSWAHL","link" => ""),
    2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&daten=$daten")
    );
    break;
  default:  // die einzelnen Bildseiten 11-xx
    $menu = array (0=>array("icon" => "99","caption" => "VORTEILE","link" => ""),
    				2=>array("icon" => "_tadd","caption" => "Erfassen","link" => "$PHP_SELF?md=".char_auswahl."&ID=$ID&daten=$daten"),
//    				3=>array("icon" => "4","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID&id=$id"),
    				9=>array("icon" => "_stop","caption" => "Zurück","link" => "char_kopf_liste.php?md=0&ID=$ID&id=$daten")
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
	$auswahl= GET_auswahl(0);
	
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

  $TABLE = "char_vor";

  switch ($p_md):
  case char_insert:  // MAIN-Menu
  	//SQL Insert
  	insert($p_row);
	  header ("Location: $PHP_SELF?md=0&ID=$ID&daten=$daten");  /* Auf sich Selbst*/
	  exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
	  break;
  case char_update: // Update eines bestehnden Datensatzes
  	// Update SQL
  	update($p_row);
  	header ("Location: $PHP_SELF?md=0&ID=$ID&daten=$daten");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  	break;
  default :
  	break;
 	endswitch;
  
 	switch ($md):
  case char_delete: // Delete eines bestehenden Datensatzes
  		// SQL delete
 		loeschen($id);
  	header ("Location: $PHP_SELF?md=0&ID=$ID&daten=$daten");  /* Auf sich Selbst*/
  	exit;  /* Sicher stellen, das nicht nachfolgender Code ausgeführt wird. */
  	break;
  default :
  	break;
	endswitch;

	print_header("Charakterliste");

	print_body(2);

	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";


	$isnsc = print_kopf_liste($daten,$ID);
	
	if($isnsc == true)
	{
	  $home = "con_nsc_liste.php";
	}else
	{
	  $home = "char_kopf_liste.php";
	}
  $titel = "Charakterdaten";
	
	$menu = get_menu_char_vor($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home);
	
	switch ($md):
  case char_add: // Erfassen eines neuen Datensatzes
  	print_menu_status($menu);
  	print_maske($id,$ID,char_insert,true,$auswahl,$daten);
  	break;
  case char_edit: // Bearbeiten Form
  	print_menu_status($menu);
  	//      print_char_menu($menu);
  	print_maske($id,$ID,char_update,false,0,$daten);
  	break;
   case char_auswahl: // Erfassen eines neuen Datensatzes
   	print_menu_status($menu);
   	print_fert($ID,$daten);
   	break;
  default:  // die einzelnen Bildseiten 11-xx
  	print_menu($menu);
  	print_liste($daten,$ID);
    break;
	endswitch;


	print_body_ende();

	?>