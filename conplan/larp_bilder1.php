<?php
/*
 Projekt :  MAIN

Datei   :  main_bilder.php

Datum   :  2002/06/08

Rev.    :  3.0

Author  :  OlafDuda

beschreibung :
Dies ist eine Bildergalerie fuer den User Bereich
Es zeigt die Bilder ueber tag 100, da aufgrund von alten Daten definitionen
nur bis 99 angezeigt werden kann
Die Bilder sind in Kapitel oder Topics gegliedert.
Die Verwaltung der Topics geschieht in einem separaten Modul.

Realisiert die Bearbeitungsfunktionen f�r die Datei <bilder>
- �bersicht als HTML
- Liste der Datens�tze mit Bilder
- Anzeige der Details ohne Bearbeitung

Die Bilder werden in einen Standardpfad gespeichert.

/BILDER/           > f�r die aufgeladene Bilder
/BILDER/BASE/      > f�r spezielle Gruppenbilder
/BILDER/thumb/     > f�r thumbnails der Bilder

Es werden HTML Seiten angezeigt,
die folgenden Subdir  werden werden relativ benutzt
./pages  2)
Die images kommen ebenfalls aus dem Verzeichnis
./BILDER/BASE

Die HTML Seiten werden mit der Funktion
function print_data($html_file)
dargestellt.

Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.

REVISION
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


Ver 3.0 / 04.02.2013
Es werden CSS-Dateien verwendert. 
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues 
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

*/

include "_config.inc";
include "_lib.inc";
include "_head.inc";


/**
 *  Darstellung des Bilds als Verkleinerung
 *  Hinweis: die alte function des Thumbnail erstellen entfaellt 
 */
function make_tumb($row)
{
  //;
    echo "\t<img title=\"click hier zum anzeigen\" style=\" width: 50% height: 50%; \" alt=\"thumb\" src=\"BILDER/$row[0]$row[6]\">";
}



function print_liste($ID,$TAG,$LISTE)
//==========================================================================
// Function     : print_liste
//--------------------------------------------------------------------------
// Beschreibun  : Darstelen einer Bilder liste  mit
//                - Name des Bildes
//                - Bild_image
//                - Ref-Symbol mit LINK auf Detailansicht
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


  $style = "id=imgtable";
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
	
	//  echo "<table border=0 BGCOLOR=\"\">\n";
// 	echo "\t <TABLE  BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"1\" >\n";
	echo "\t <TABLE Border=\"1\"  >\n";
	
	// Kopfzeile
// 	echo "<hr>\n";
	//Liste der Datens�tze
	while ($row = mysql_fetch_row($result))
	{
		$row1 = mysql_fetch_row($result);
// 		$row2 = mysql_fetch_row($result);
    //---------------------------------------------------
		// Zeile 1
		echo "<tr>\n";
		// Spalte 1
		if ($row[0]!="")
		{
			echo "\t<td>$row[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "$row[0]/$row[2]/$row[3]";
			echo "\t</a></td>\n";
		}
		// Spalte 2  
		echo "\t<td>&nbsp;</td>\n";
		// Spalte 3
		if ($row1[0]!="")
		{
			echo "\t<td>$row1[4]&nbsp; </td>\n";
			echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			echo "$row1[0]/$row1[2]/$row1[3]";
			echo "\t</a></td>\n";
		}
		echo "</tr>";
		//---------------------------------------------------
		// Zeile 2
		echo "<tr>";
		// Spalte 1
		echo "\t<td> \n";
		if ($row[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			make_tumb($row);
// 			echo "\t<IMG SRC=\"BILDER/$row[0]$row[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			$zeile=explode("\n",$row[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
			  if (isset($zeile[$ii]))
			  {
				echo "\t$zeile[$ii]&nbsp;<br>\n";
			  }
			}
		}
		echo "\t</td>\n";
		// Spalte 2
		echo "\t<td>&nbsp;</td>\n";
		// Spalte 3
		echo "\t<td> \n";
		//daten nur zeigen wenn vorhanden
		if ($row1[0]!="")
		{
			echo "\t<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row1[0]&TAG=$TAG&LISTE=$LISTE\">\n";
			make_tumb($row1);
// 			echo "\t<IMG SRC=\"BILDER/thumb/$row1[0]$row1[6]\" BORDER=\"0\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			//        echo "\t<td>$row1[5]&nbsp;</td>\n";
			$zeile=explode("\n",$row1[5]);
			$anz  = count($zeile);
			echo "\t<td width=200>\n";
			for ($ii=0; $ii<2; $ii++)
			{
			  if (isset($zeile[$ii]))
			  {
			    echo "\t$zeile[$ii]&nbsp;<br>\n";
			  }
			}
		}
		echo "\t</td>\n";
		echo "</tr>";
	}
	echo "</table>";
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
	
};

function print_info($id,$ID,$TAG,$LISTE)
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
	global $PHP_SELF;
	

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

	echo "<FORM ACTION=\"$PHP_SELF?md=11&ID=$ID\" METHOD=POST>\n";
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
	echo "\t<td>\n";
	echo "\t<a href=\"$PHP_SELF?md=4&id=$id&ID=$ID&TAG=$TAG&LISTE=$LISTE\"> \n";
	print_menu_icon ("_edit","Bearbeiten");
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "\t<td>\n";
	echo "\t<a href=\"$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE\"> \n";
	print_menu_icon ("_stop", "Zur�ck");
	echo "\t</a>\n";
	echo "\t</td>\n";
	echo "</tr>";
	echo "</table>";
	echo "<TABLE WIDTH=\"\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "<tr>";
	echo "\t<td>\n";
	echo "\t<IMG SRC=\"BILDER/$row[0]$row[6]\" BORDER=\"0\"  TITLE=\"$row[4]\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
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
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $PHP_SELF;
  	
	
	//--- REFERENZ auf bilder_topic -------------------------------------------
// 	echo "tag:".$row[1]+":"+$_FILES['bild']['type']+":"+$_FILES['bild']['size'];
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
	elseif ($_FILES['bild']['type'] == 'image/png')
	{
		$fileendung = ".png";
	}
	$row[6] = $fileendung;
// 	echo "|ext:".$fileendung;
	
	//--- Felder von bilder ermitteln ------------------------------------------
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	$field_num = 7;
	$field_name[0] = "ID";
	$field_name[1] = "tag";
	$field_name[2] = "sort";
	$field_name[3] = "lfd";
	$field_name[4] = "Name";
	$field_name[5] = "beschreibung";
	$field_name[6] = "imgtype";
	
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
	$result = mysql_query($q,$db) or die("InsertFehler....$q.");

	$name = mysql_insert_id(); //ermittelt die ID des gespeicherten Record

	mysql_close($db);

// 	echo "id:".$name;
	$imagepath = realpath("./BILDER")."/";
	$file_name = $name.$fileendung;
// 	echo"<br>";
// 	echo "temp: ".$_FILES['bild']['tmp_name'];
// 	echo"<br>";
// 	echo "move: ".$imagepath.$file_name;
// 	echo"<br>";
// 	echo "type: ".$_FILES['bild']['type'];
	if(move_uploaded_file ($_FILES['bild']['tmp_name'],$imagepath.$file_name) == false )
	{
	  echo "Picture nicht gespeichert "+$file_name;
	}
};


function update($row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $TABLE;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");
// 	$result = mysql_list_fields($DB_NAME,$TABLE)  or die("Query ERF...");
// 	$field_num = mysql_num_fields($result);
// 	for ($i=0; $i<$field_num; $i++)
// 	{
// 		$field_name[$i] =  mysql_field_name ($result, $i);
// 	}
	$field_num = 7;
	$field_name[0] = "ID";
	$field_name[1] = "tag";
	$field_name[2] = "sort";
	$field_name[3] = "lfd";
	$field_name[4] = "Name";
	$field_name[5] = "beschreibung";
	$field_name[6] = "imgtype";
	
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


function delete($id)
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


function print_bearb($id,$ID,$next,$TAG,$LISTE)
{
	//==========================================================================
	// Function     :  print_bearb
	//--------------------------------------------------------------------------
	// Beschreibung : Bearbeiten der Felder der Tabelle <bilder>
	//                Die Abfrage MUSS alle Felder beinhalten
	//                linke Spalte = Feldnamem
	//                rechte Spalte = Feld
	//                Button = SUBMIT und CANCEL
	//                Durch Switch auf die Feldnummer wird die Maske
	//                individuell gestaltet.
	//
	// Argumente    : $ID = Session_ID
	//                $id   beinhaltet den zu bearbeitenden Datensatz
	//                $next beinhaltet die n�chste zu rufende Funktion
	//                $TAG  referenziert die Kategorie
	//
	// Returns      : --
	//
	//==========================================================================
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
	global $PHP_SELF;
	
  // BEARBEITEN-Modus  selectierten Datensatz lesen
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
  

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  
	echo "<FORM ACTION=\"$PHP_SELF?md=$next&ID=$ID&TAG=$TAG\" METHOD=POST enctype=\"multipart/form-data\">\n";
// 	echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\" VALUE=\"".mfd_update."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"LISTE\"  VALUE=\"$LISTE\">\n";
	
	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	    // BEARBEITEN-Modus  selectierten Datensatz lesen
		echo "\t<td><center><b>BEARBEITEN BILDER</b></td>\n";
	echo "\t</tr>\n";
	for ($i=0; $i<$field_num; $i++)
	{
		$field_name[$i] =  mysql_field_name ($result, $i);
		$type[$i]       =  mysql_field_type ($result, $i);
		$len[$i]        =  mysql_field_len  ($result,$i);
	}
	//  Felder = ID,tag,sort,lfd,name,beschreibung,link
	for ($i=0; $i<$field_num; $i++)
	{
		if ($type[$i]=="date") {
			$len[$i] = 10;
		}
		if ($type[$i]=="int") {
			$len[$i] = 5;
		}

		switch($i):
		case 0 :   // Feld ersetzen durch auswahltabelle
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
      echo "<td>";
      echo "<INPUT TYPE=\"TEXT\" NAME=\"row[0]\" SIZE=$len[$i] MAXLENGTH=$len[$i] readonly VALUE=\"$row[$i]\">\n";
      echo "</td>";
// 			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH= readonly VALUE=\"$row[$i]\"></td>\n";
		  echo "</tr>\n";
		break;
		case 1 :   // Feld ersetzen durch auswahltabelle
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
		  echo "</tr>\n";
		break;
		case 6 :
				echo "<tr>";
				echo "<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i]  VALUE=\"$row[$i]\"></td>\n";
				echo "</tr>";
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
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
	
};


function print_erf($id,$ID,$next,$TAG,$LISTE)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
	global $TABLE1;
	global $PHP_SELF;

	     // ERFASSEN MODUS - Referenz auf Bildergruppe (Bilder_Topic)
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
	

		//Daten bereich
  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

	echo "<FORM ACTION=\"$PHP_SELF?md=$next&ID=$ID&TAG=$TAG\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"".mfd_insert."\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"TAG\"  VALUE=\"$TAG\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"LISTE\"  VALUE=\"$LISTE\">\n";

	echo "<TABLE WIDTH=\"400\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
  echo "\t<td><center><b>NEUE BILDER</b></td>\n";
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
    		$row1 = mysql_fetch_row($result1);
    		echo "\t<td width=100>Tag&nbsp;</td>\n";
    		echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$TAG\" READONLY> $row1[1]</td>\n";
    		echo "</tr>\n";
		break;
		case 6 :
				echo "<tr>";
				echo "<td>\n";
    		echo "<!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->";
    		echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"560000\" >";
				echo "<!-- Der Name des Input Felds bestimmt den Namen im $ _ FILES Array -->";
//    		echo "Diese Datei hochladen: <input name="userfile" type="file" />"
				echo "</td>\n";
				echo "<td>\n";
				echo "\t<input type=file name=bild accept=image/*>\n";
				echo "  <b>max 150kb Bildgr��e</b>";
				echo "</td>\n";
				echo "</tr>";
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
  
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
			
};

function make_bild_menu($ID)
//==========================================================================
// Function     :  make_bild_menu
//--------------------------------------------------------------------------
// Beschreibung : Erstellt das Bildgalerie Men� aus der Tabelle <bilder_topic>
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


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE1 where tag>99 order by tag desc,sort ";
	$result = mysql_query($q)  or die("Query Menu...$q");
	$anz = mysql_num_rows($result);
	mysql_close($db);

//	$row = mysql_fetch_row($result);

	$menu = array (0=>array("icon" => "9","caption" => "BILDER","link" => ""));
	$menu[1] = array("icon" => "_stop","caption" => "Zur�ck","link" => "larp.php?md=0&ID=$ID");
	for ($i=0; $i<$anz; $i++)
	{
		$row = mysql_fetch_row($result);
		//    $menu = array($i=>array("icon" => "1","caption" => "$row[1]","link" => "$PHP_SELF?md=11&TAG=$row[2]"));
		$menu[$i+2] = array("icon" => "_list","caption" => "$row[1]","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$row[2]&LISTE=$row[1]");
//		echo $row[1].",";
	}

	return  $menu;

};


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------


$BEREICH = 'INTERN';
print_header("Chronik");
print_body(1);


// Steuerparameter und steuerdaten
$md    = GET_md(0);
$daten = GET_daten("");
$item  = GET_item("main");
$sub   = GET_sub("");
$id    = GET_id(0);
$TAG   = GET_TAG("1");
$LISTE = GET_LISTE("");
$ID    = GET_SESSIONID("");

$p_md   = POST_md(0);
$p_id 	= POST_id(0);
$p_row 	= POST_row("");
$p_bild = POST_bild("");

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
  // Code ausgef�hrt wird.
}

$TABLE = "bilder";
$TABLE1 = "bilder_topic";


switch($p_md):
case mfd_insert: // Insert -> Erfassen
  if (array_key_exists ('bild' , $_FILES ))
  {
    echo "upload:"+":"+$_FILES['bild']['type']+":"+$_FILES['bild']['size'];
    insert($p_row,$p_bild);
  } else
  {
    echo "Kein Bild im Upload, wahrscheinlich zu gross!";
  }
  break;
case mfd_update: // Insert -> Erfassen
//   echo "Update";
	update($p_row);
	break;
case mfd_delete: // Delete => Loeschen
	delete($p_row[0]);
	break;
default: //
	break;
endswitch;

print_header("Interner Bereich");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;
print_kopf($logo_typ,$header_typ,"Intern",$anrede,$menu_item);


//print_md();

// echo "md:".$md;
switch ($md):
case 1: // Erfassen eines neuen Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "ERFASSEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	print_erf($id,$ID,11,$TAG,$LISTE);
	//print_maske($id,$ID,5,1,$TAG,$LISTE);
	break;
case 3: // Delete eines bestehenden Datensatzes
	$menu = array (0=>array("icon" => "99","caption" => "L�SCHEN","link" => ""),
	9=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	break;
case 4: // Bearbeiten Form
	$menu = array (0=>array("icon" => "99","caption" => "BEARBEITEN","link" => ""),
	2=>array("icon" => "6","caption" => "Zur�ck","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	print_bearb($id,$ID,11,$TAG,$LISTE);
	break;
case 2: // ANSEHEN Form
	$menu = array (0=>array("icon" => "99","caption" => "ANSEHEN","link" => ""),
	2=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=11&ID=$ID&TAG=$TAG&LISTE=$LISTE")
	);
	print_menu($menu);
	Print_info($id, $ID,$TAG,$LISTE);
	break;
case 11:  // die einzelnen Bildseiten 11-xx
	$menu = array (0=>array("icon" => "99","caption" => "$LISTE","link" => ""),
	2=>array("icon" => "_tadd","caption" => "Neu","link" => "$PHP_SELF?md=1&ID=$ID&TAG=$TAG&LISTE=$LISTE"),
	8=>array("icon" => "_stop","caption" => "Zur�ck","link" => "$PHP_SELF?md=0&ID=$ID&TAG=$TAG")
	);
	print_menu($menu);
	print_liste($ID,$TAG,$LISTE);
	break;
default:  // die einzelnen Bildseiten 11-xx
// 	case 0:  // MAIN-Menu
	$menu = make_bild_menu($ID);
   print_menu($menu);
   $daten='pages/main_bild_base.html';
   print_data($daten);
break;
	endswitch;

	//print_md_ende();

	print_body_ende();

	?>