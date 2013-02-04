<?php
/*
 Projekt :  LARP

Datei   :  larp_bild_liste.php

Datum   :  2002/06/12

Rev.    :  2.1

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Datei <bilder>
- Liste der Datensätze
- Efassen neuer Datensätze
- Bearbeiten vorhandener Datensätze
- Anzeige der Details ohne Bearbeitung
- Löschen  eines Datensatzes

Dies ist eine Bildergalerie mit Funktion zum Aufladen der Bilder
auf den Server.
Die Bilder sind in Kapitel odr Topics gegliedert.
Die Verwaltung der Topics geschieht in einem separaten Modul.

Die Bilder werden in einen Standardpfad gespeichert.

/BILDER/           > für die aufgeladene Bilder
/BILDER/BASE/      > für spezielle Gruppenbilder
/BILDER/thumb/     > für thumbnails der Bilder

Die Namen der Bilder werden automatisch erzeugt
als fortlaufende nummer (Feld ID = autoinc)

#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
einen veraenderte Konfiguration eingestellt
- einheitliches Layout
- funktionen fuer Bilder und Icon im Kopf
- print_body(typ) mit dem Hintergrundbild der Seite
- print_kopf  mit
- LOGO links
- LOGO Mitte
- Text1, Text2  fuer rechte Seite

#3  08.07.2008  Bilder Pfad absolute setzen auf /BILDER/

*/

include "config.inc";
include "login.inc";
include "lib.inc";
include "head.inc";




function print_liste($ID,$TAG,$LISTE)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Bilder liste  mit
//                - Name des Bildes
//                - Bild_image
//                - Ref-Symbol miz LINK auf Detailansicht
//
// Argumente    : $ID = Session_ID
//                $TAG = Refnummer des Topic
//                $LISTE = NAME des Tages
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where tag=\"$TAG\" order by tag,sort,lfd";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


	echo "  <TD\n>"; //Daten bereich der Gesamttabelle

	echo "<table border=1 BGCOLOR=\"\">\n";

	// Kopfzeile
	echo "<hr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		$row1 = mysql_fetch_row($result);
		//    $row2 = mysql_fetch_row($result);
		echo "<tr>\n";
		// Spalet 1
		if ($row[0]!="")
		{
			echo "\t<td>$row[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\">\n";
			print_menu_icon (9);
			echo "\t</a></td>\n";
		}
		// Spalet 2
		echo "\t<td>&nbsp;</td>\n";
		if ($row1[0]!="")
		{
			echo "\t<td>$row1[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			//echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\">\n";
			print_menu_icon (9);
			echo "\t</a></td>\n";
		}
		// Spalet 3
		/*
		 if ($row2[0]!="")
		 {
		echo "\t<td>$row2[4]&nbsp; </td>\n";
		echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row2[0]&TAG=$TAG&LISTE=$LISTE\">\n";
		echo "\t<IMG SRC=\"../larp/images/db.gif\" BORDER=\"0\" HEIGHT=\"25\" WIDTH=\"25\" ALT=\"Datensatz Bearbeiten\" HSPACE=\"0\" VSPACE=\"0\">\n";
		echo "\t</a></td>\n";
		}
		echo "</tr>\n";
		*/
		echo "<tr>";
		// Spalet 1
		echo "\t<td> \n";
		if ($row[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t<IMG SRC=\"/BILDER/thumb/$row[0]$row[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			//        echo "\t<td>$row[5]&nbsp;</td>\n";
			$zeile=explode("\n",$row[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
				echo "\t$zeile[$ii]&nbsp;<br>\n";
			}
			echo "\t</td>\n";
		}
		// Spalet 2
		echo "\t<td>&nbsp;</td>\n";
		echo "\t<td> \n";
		if ($row1[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "\t<IMG SRC=\"/BILDER/thumb/$row1[0]$row1[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			//        echo "\t<td>$row1[5]&nbsp;</td>\n";
			$zeile=explode("\n",$row1[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
				echo "\t$zeile[$ii]&nbsp;<br>\n";
			}
			echo "\t</td>\n";
		}
		// Spalet 3
		/*
		 echo "\t<td> \n";
		if ($row2[0]!="")
		{
		echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row2[0]&TAG=$TAG&LISTE=$LISTE\">\n";
		echo "\t<IMG SRC=\"/BILDER/thumb/$row2[0]$row2[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
		echo "\t</a></td>\n";
		echo "\t<td>$row2[$i]&nbsp;</td>\n";
		}
		echo "</tr>";
		*/
	}
	echo "</table>";
	echo " </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};

function print_info($id,$ID,$TAG)
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
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"  VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"  VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\" VALUE=\"$TAG\">\n";

	echo "<TABLE WIDTH=\"\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";

	echo "<tr>";
	echo "\t<td width=30>$row[1]</td>\n";
	echo "\t<td width=30>$row[2]</td>\n";
	echo "\t<td width=30>$row[3]</td>\n";
	echo "\t<td>$row[4]</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "<TABLE WIDTH=\"\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td><b></b></td>\n";
	echo "\t<IMG SRC=\"/BILDER/$row[0]$row[6]\" BORDER=\"0\"  ALT=\"$row[4]\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "<tr>";
	$zeile=explode("\n",$row[5]);
	$anz  = count($zeile);
	echo "\t<td>\n";
	for ($ii=0; $ii<$anz; $ii++)
	{
		echo "\t$zeile[$ii]&nbsp;<br>\n";
	}
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "  </TD\n>"; //ENDE Daten bereich der Gesamttabelle

};



function insert($row,$bild)
//==========================================================================
// Function     :  insert
//--------------------------------------------------------------------------
// Beschreibun  :  Fügt einen Datensatz in eine Tabelle ein
//                 Die Daten liegen als Array vor
//                 die Spalten sind identisch mit
//                 den Feldern der Tabelle.
//                 Ebenso die Reihemfolge der Felder !
//                 Ref_Tabelle >bilder_topic>
//                 Ref_ID = row[1] <tag>
//                          bestimmt path von img
//
// Argumente    :  $row = zu speichernde Daten
//                 $bild = image des Bildes
//
// Returns      :  --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;
	global $TABLE1;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");

	//--- REFERENZ auf bilder_topic -------------------------------------------
	$q = "select * from $TABLE1 where tag=\"$row[1]\"";
	$result1 = mysql_query($q) or die("Query TABLE_1/$row[1]");
	$row1 = mysql_fetch_row($result1);
	$row[1] = $row1[2];
	$fileendung = ".xxx";
	if ($_FILES['bild']['type'] == 'image/gif')
	{
		$fileendung = ".gif";
	}
	elseif ($_FILES['bild']['type'] == 'image/jpeg')
	{
		$fileendung = ".jpg";
	}
	elseif ($_FILES['bild']['type'] == 'image/pjpeg')
	{
		$fileendung = ".jpg";
	}
	$row[6] = $fileendung;

	//--- Felder von bilder ermitteln ------------------------------------------
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

	$name = mysql_insert_id(); //ermittelt die ID des gespeicherten Record

	mysql_close($db);

	$imagepath = realpath("./BILDER")."/";
	$file_name = $name.$fileendung;
	echo"<br>";
	echo "temp: ".$_FILES['bild']['tmp_name'];
	echo"<br>";
	echo "move: ".$imagepath.$file_name;
	echo"<br>";
	echo "type: ".$_FILES['bild']['type'];
	if(move_uploaded_file ($_FILES['bild']['tmp_name'],$imagepath.$file_name) )
	{
		tumb_erzeugen($file_name,$imagepath,100,50,$_FILES['bild']['type']);
	}
};


function update($row)
//==========================================================================
// Function     : update
//--------------------------------------------------------------------------
// Beschreibung : Update eines Datensatzes in einer Tabelle <bilder>
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

function print_maske($id,$ID,$next,$erf,$TAG,$LISTE)
{
	//==========================================================================
	// Function     :  print_maske
	//--------------------------------------------------------------------------
	// Beschreibung : Bearbeiten der Felder der Tabelle <bilder>
	//                Die Abfrage MUSS alle Felder beinhalten
	//                linke Spalte = Feldnamem
	//                rechte Spalte = Feld
	//
	//                Button = SUBMIT und CANCEL
	//                Durch Switch auf die Feldnummer wird die Maske
	//                individuell gestaltet.
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
	//                $TAG  referenziert die Kategorie
	//
	// Returns      : --
	//
	//==========================================================================
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;

	if ($erf == 0 )
	{    // BEARBEITEN-Modus  selectierten Datensatz lesen
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		//  Felder = ID,tag,sort,lfd,name,beschreibung,link

		$q = "select * from $TABLE where id=$id";
		$result = mysql_query($q) or die("Query BEARB.");

		mysql_close($db);

		$field_num = mysql_num_fields($result);
		//
		$row = mysql_fetch_array ($result);
		$len = mysql_fetch_row($result);

	} else
	{     // ERFASSEN MODUS - Referenz auf Bildergruppe (Bilder_Topic)
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME);

		$q = "select id,name,tag,sort from $TABLE1 where tag=\"$TAG\" order by tag,sort";
		$result1 = mysql_query($q) or die("Query ERF TABLE 1");

		//  Felder = ID,tag,sort,lfd,name,beschreibung,link
		$q = "select * from $TABLE where id=0";
		$result = mysql_query($q) or die("Query ERF TABLE");

		mysql_close($db);

		$row = mysql_fetch_array ($result);
		$field_num = mysql_num_fields($result);
	}

	echo "  <TD>\n";  //Daten bereich der Gesamttabelle

	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"LISTE\"  VALUE=\"$LISTE\">\n";

	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	if ($erf == 0 )
	{    // BEARBEITEN-Modus  selectierten Datensatz lesen
		echo "\t<td><center><b>BEARBEITEN BILDER</b></td>\n";
	}else
	{
		echo "\t<td><center><b>NEUE BILDER</b></td>\n";
	}
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);

	}

	//  Felder = ID,tag,sort,lfd,name,beschreibung,link
	for ($i=1; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}

		switch($i):
		case 1 :   // Feld ersetzen durch auswahltabelle
			echo "<tr>";
		if ($erf == 1)  // NUR beim erfassen aktivieren
		{
			$row1 = mysql_fetch_row($result1);
			echo "\t<td width=100>Tag&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$TAG\" READONLY> $row1[1]</td>\n";
		} else
		{
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
		}
		echo "</tr>\n";
		break;
		case 6 :
			if ($erf == 1)  // NUR beim erfassen aktivieren
			{
				echo "<tr>";
				echo "<td>\n";
				echo "</td>\n";
				echo "<td>\n";
				echo "\t<input type=file name=bild accept=image/*>\n";
				echo "  <b>max 150kb Bildgröße</b>";
				echo "</td>\n";
				echo "</tr>";
			} else
			{
				echo "<tr>";
				echo "<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i]  VALUE=\"$row[$i]\">";
				echo "  <b>max 150kb Bildgröße</b>";
				echo "</td>\n";
				echo "</tr>";
			}
			break;
		default:
			if ($type[$i]!="blob")
			{
				echo "<tr>";
				echo "<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
				echo "</tr>";
			} else
			{
				echo "<tr>";
				echo "<td><b></b></td>\n";
				echo "<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=12>$row[$i]</TEXTAREA>&nbsp;</td>\n";
				echo "</tr>";
			}
			break;
			endswitch;
	}

	echo "<tr>\n";
	echo "<td></td>\n";
	echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
			</td>\n";
	echo "</tr>\n";

	echo "</table>";
	echo "  </TD>\n"; //ENDE  Datenbereich der Gesamttabelle

};

function make_bild_menu($ID)
//==========================================================================
// Function     :  make_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Menü aus der Tabelle <bilder_topic>
//                Der erste Eintrag wird ignoriert
//
// Argumente    : $ID
//
// Returns      : $menu = array
//
//==========================================================================
//  2=>array("icon" => "1","caption" => "Tag 1","link" => "$PHP_SELF?md=11&ID=$ID"),
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE1;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag <=100 order by tag DESC,sort DESC";
	$result = mysql_query($q)  or die("Query Menu...");
	$anz = mysql_num_rows($result);
	mysql_close($db);

	$row = mysql_fetch_row($result);

	$menu = array (0=>array("icon" => "99","caption" => "BILDERLISTE","link" => ""),
			1=>array("icon" => "6","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID"));
	echo $anz;
	for ($i=1; $i<$anz; $i++)
	{
		$row = mysql_fetch_row($result);
		$menu[$i+2] = array("icon" => "1","caption" => "$row[1]","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$row[2]&LISTE=$row[1]");
	}

	return  $menu;

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
$c_md = $_COOKIE['md'];

$p_md  = $_POST['md'];
$p_row = $_POST['row'];
$p_bild = $_POST['bild'];


$md = $_GET['md'];
$ID = $_GET['ID'];
$id = $_GET['id'];				// Record ID
$TAG = $_GET['TAG'];			// Tage Nr fuer SQL
$LISTE = $_GET['LISTE'];	// Ueberschrift


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

print_header("Bilder Liste");


print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

print_kopf(1,2,"Interner Bereich","Sei gegrüsst $spieler_name ");

//echo "POST : $p_md / GET : $md / ID :$ID / Spieler = $spieler_id";
//echo "<br> FILES : ".$_FILES['bild']['tmp_name']."/ typ:".$_FILES['bild']['type'];
//echo "<br>";

$TABLE = "bilder";
$TABLE1 = "bilder_topic";

switch ($p_md):
case 5:  // MAIN-Menu
	insert($p_row,$p_bild);
$md = 11;
break;
case 6: // Update eines bestehnden Datensatzes
	// Update SQL
	update($p_row);
	$md = 11;
	break;
case 7: // Delete eines bestehenden Datensatzes
	// SQL delete
	loeschen($id);
	$md = 11;
	break;
default :
	break;
	endswitch;


	print_md();

	switch ($md):
case 0:  // MAIN-Menu
		$menu = make_bild_menu($ID);
	print_menu($menu);
	$daten='main_bild_base.html';
	print_data($daten);
	break;
case 1: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	print_maske($id,$ID,5,1,$TAG,$LISTE);
	break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	Print_info($id, $ID,$TAG);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "LÖSCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	break;
case 4: // Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	print_maske($id,$ID,6,0,$TAG,$LISTE);
	break;
case 11:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "$LISTE","link" => ""),
	2=>array("icon" => "11","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG&LISTE=$LISTE"),
	8=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID,$TAG,$LISTE);
	break;
default:  // die einzelnen Bildseiten 11-xx
	$menu = make_bild_menu($ID);
	print_menu($menu);
	print_main($ID);
	break;
	endswitch;

	print_md_ende();

	print_body_ende();

	?>