<?php
/*
 Projekt :  ADMIN

Datei   :  admin_down.php

Datum   :  2002/06/01

Rev.    :  2.0

Author  :  Olaf Duda

beschreibung : realisiert die Bearbeitungsfunktionen für die Tabelle <images>
- Liste der Datensätze
- Efassen neuer Datensätze und UPLOAD
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
	global $TAG;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE ";
	$result = mysql_query($q)  or die("Query Fehler...");

	mysql_close($db);


  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
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
				echo "\t<td><a href=\"$PHP_SELF?md=".mfd_edit_edit."&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
				print_menu_icon ("_tadd");
				echo "\t</a></td>\n";
			} elseif ($i==3)
			{
			  echo "\t<td>$row[$i]&nbsp;kb</td>\n";
			} else
			{
				echo "\t<td>$row[$i]&nbsp;</td>\n";
			};
		}
		echo "<tr>";
	}
	echo "</table>";
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

	$q = "select * from $TABLE ";
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
				echo "\t<td><a href=\"$PHP_SELF?md=7&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
				print_menu_icon (4);
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

/**
 * Insert des Datensatzes und Upload des Files
 * @param unknown $row
 * @param unknown $userfile
 * @param unknown $daten  enthaelt den Zielpfad
 */
function insert($row,$userfile,$daten )
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

	// Aufbereiten der Upload daten
	if ($daten == "")
	{
	  $path = "./images";
	} else 
	{
	  $path = $daten; 
	}

	$file_name = $_FILES['userfile']['name'];
	$row[1] = $_FILES['userfile']['name'];
	// berechnet size in Kb
	$row[3] = $_FILES['userfile']['size'];
	$row[3] = $row[3] / 1024;

	$downloadpath = realpath ($path)."/";

	if ( move_uploaded_file ($_FILES['userfile']['tmp_name'],$downloadpath.$file_name))
	{
		// Datensatz nur anlegen, wenn Upload erfolgreich !
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
	} else
	{
		echo"<br>" ;
		echo"Temp:".$_FILES['userfile']['tmp_name'] ;
		echo"<br>" ;
		echo"Move:.$downloadpath.$file_name" ;
		echo"<br>" ;
	}

};


/**
 * 
 * @param unknown $row
 */
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

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q) or die("Query BEARB.");

	$row = mysql_fetch_array ($result);

	$file_name = $row[4];

	$downloadpath = realpath ($path)."/";

	if (file_exists($downloadpath.$filename))
	{
		$q = "delete from $TABLE where id=\"$id\" ";
		$result = mysql_query($q) or die("Delete Fehler....$q.");
	} else
	{
		echo "No File:".$downloadpath.$filename;
	}

	mysql_close($db);

};

function print_maske($result, $id,$ID,$next,$isinfo=false, $daten, $iserf=false)
{

  global $PHP_SELF;
/**/
//	$style = $GLOBALS['style_datatab'];
  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	echo "<FORM ACTION=\"$PHP_SELF?md=0&daten=$daten&ID=$ID\" METHOD=POST enctype=\"multipart/form-data\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$id\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"daten\"  VALUE=\"$daten\">\n";
	echo "<TABLE WIDTH=\"300\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
	echo "\t<tr>\n";
	echo "\t<td width=100></td>\n";
	echo "\t</tr>\n";
	
	$row = mysql_fetch_array ($result);
	$field_num = mysql_num_fields($result);
	
	if($iserf == true)
	{
  	for ($i=0; $i<$field_num; $i++)
  	{
    	$row[$i] = "";
  	};
  	$row[4] = "images";
  	$row[5] = "public";
	}
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
		switch($i):
		case 0:
			echo "<tr>";
		echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
		echo "<td><input type=\"text\" name=\"\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
		echo "<tr>";
		break;
		case 1:
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\" readonly></td>\n";
			echo "<tr>";
			break;
		case 3:
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"> &nbsp;[kbyte]</td>\n";
			echo "<tr>";
			break;
		case 4:
			if ($iserf == true)  // NUR beim erfassen aktivieren
			{
				echo "<tr>";
				echo "<td>FILENAME\n";
				echo "</td>\n";
				echo "<td>\n";
				//          echo "<input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\">\n";
				echo "\t<input type=\"file\" name=\"userfile\" SIZE=65 accept=\"application/*\" >\n";
				echo "</td>\n";
				echo "</tr>";
			};
				echo "<tr>";
				echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
				echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
				echo "<tr>";
			break;
		case 2 :
			echo "<tr>";
			echo "\t<td><b></b></td>\n";
			echo "\t<td><TEXTAREA NAME=\"row[$i]\" COLS=50 ROWS=4>$row[$i]</TEXTAREA>&nbsp;</td>\n";
			echo "<tr>";
			break;
		default:
			echo "<tr>";
			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";
			echo "<td><input type=\"text\" name=\"row[$i]\" SIZE=$len[$i] MAXLENGTH=$len[$i] VALUE=\"$row[$i]\"></td>\n";
			echo "<tr>";
			break;
			endswitch;
	}

  if ($isinfo == false)
  {
  	echo "\t<tr>\n";
  	echo "\t<td></td>\n";
  	echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			<INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
  			</td>\n";
  	echo "\t</tr>\n";
  }
	echo "</table>";
	echo '</div>';
	
	$filename = $row[4]."/".$row[1];
	//style="width: 240px; height: 180px"
	echo "<img alt=\"\" src=\"$filename\"  title=\"Preview eines Bildes\" />";
	
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
	
};

/**
 * Erstellt eine mfd Detailmaske zum erfassen eines Datensatzes (Insert)
 * HINWEIS : Im rufenden Modul muss post_md = 5 als insert ausgewertet werden
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $mfd_list
 * @param unknown $mfd_cols
 */
function print_maske_erf($id, $ID, $daten)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
//	global $TAG;
	
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=\"0\"";
	$result = mysql_query($q) or die("Query ERF...");


	mysql_close($db);


	$next = mfd_insert;	// Datenfunktion Insert

  print_maske($result, $id,$ID,$next, false, $daten, true);
}

/**
 * Erstellt eine mfd Detailmaske zum editieren des Datensatzes (Update)
 * HINWEIS : Im rufenden Modul muss post_md = 6 als update ausgewertet werden
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $mfd_list
 * @param unknown $mfd_cols
 */
function print_maske_edit($id, $ID, $daten)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TABLE;
//	global $TAG;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=$id";
	$result = mysql_query($q) or die("Query BEARB.");

	mysql_close($db);


	$next = mfd_update;	// Datenfunktion Update

  print_maske($result, $id,$ID,$next, false,$daten, false);

}


function print_maske_del($id, $ID, $daten)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $TABLE;
  //	global $TAG;
  
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  
  mysql_select_db($DB_NAME);
  
  $q = "select * from $TABLE where id=$id";
  $result = mysql_query($q) or die("Query BEARB.");
  
  mysql_close($db);
  
  $next = mfd_delete;	// Datenfunktion Delete

  print_maske($result, $id,$ID,$next, false,$daten, false);
  
}


function print_maske_info($id, $ID,  $daten)
{
  $next = 0;	// Datenfunktion Delete
  $result = mfd_detail_result($mfd_list, $id);
  $row = mysql_fetch_row($result);
  print_maske($row, $id,$ID,$next,true,$daten,false );

}

/**
 * 
 * @param unknown $md
 * @param unknown $PHP_SELF
 * @param unknown $ID
 * @param unknown $titel
 * @param unknown $id
 * @param unknown $daten
 * @param unknown $sub
 * @param unknown $home
 * @return multitype:multitype:string  multitype:string unknown
 */

function get_menu_images($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home)
{
  switch ($md):
  case mfd_edit_add: // erfassen
    
    $menu = array (0=>array("icon" => "7","caption" => "Images","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "NEU","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_edit_edit:  //Bearbeiten
// 	$menu = array (0=>array("icon" => "7","caption" => "ANSEHEN","link" => ""),
// 	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID")
// 	);
    $menu = array (0=>array("icon" => "7","caption" => "Images","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => " EDIT ","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_edit_del: //
    $menu = array (0=>array("icon" => "7","caption" => "images","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "DELETE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_edit_info: //
// 	$menu = array (0=>array("icon" => "7","caption" => "BEARBEITEN","link" => ""),
// 	2=>array("icon" => "6","caption" => "Zurück","link" => "$PHP_SELF?md=11&ID=$ID")
// 	);
    $menu = array (0=>array("icon" => "7","caption" => "Images","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "MASKE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  case mfd_edit_list: //
    $menu = array (0=>array("icon" => "7","caption" => "Images","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array("icon" => "1","caption" => "LISTE","link" => ""),
    9=>array ("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&amp;daten=$daten&amp;ID=$ID".get_parentlink()."")
    );
    break;
  default: // main
//     $menu = array (0=>array("icon" => "7","caption" => "DOWNLOAD","link" => ""),
//         1=>array ("icon" => "3","caption" => "Erfassen","link" => "$PHP_SELF?md=1&ID=$ID"),
//         2=>array ("icon" => "1","caption" => "Löschen","link" => "$PHP_SELF?md=3&ID=$ID"),
//         5=>array ("icon" => "6","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
//     );
    
    $menu = array (0=>array("icon" => "7","caption" => "Images","link" => ""),
    1=>array("icon" => "1","caption" =>$titel, "link" => ""),
    2=>array ("icon" => "_tadd","caption" => "Neu","link" => "$PHP_SELF?md=".mfd_edit_add."&amp;daten=$daten&amp;ID=$ID".get_parentlink().""),
    5=>array ("icon" => "_stop","caption" => "Zurück","link" => get_home($home)."?md=0&amp;daten=$daten&amp;ID=$ID")
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

  $BEREICH = 'ADMIN';
  
  $md     = GET_md(0);
  $id     = GET_id(0);
  $daten  = GET_daten("");
  $sub    = GET_sub("");
  
  $ID     = GET_SESSIONID("");
  $p_md   = POST_md(0);
  $p_id 	= POST_id(0);
  $p_row 	= POST_row("");
  $p_userfile = POST_userfile("");
  
  session_start($ID);
  $user       = $_SESSION["user"];
  $user_lvl   = $_SESSION["user_lvl"];
  $spieler_id = $_SESSION["spieler_id"];
  $user_id 	= $_SESSION["user_id"];
  
  if ($ID == "")
  {
    $session_id = 'FFFF';
    echo "session";
    //  header ("Location: main.php");  // Umleitung des Browsers
    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
    // Code ausgeführt wird.
  }
  
  if (is_admin()==FALSE)
  {
    $session_id = 'FFFF';
    echo "Admin";
    //  header ("Location: main.php");  // Umleitung des Browsers
    exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
    // Code ausgeführt wird.
  }
  
  
  print_header_admin("Admin Bereich");
  
  print_body(2);
  
  $spieler_name = get_spieler($spieler_id); //Auserwählter\n";
  
  
  $spieler_name = get_spieler($spieler_id); //Auserwählter\n";
  
  $menu_item = $menu_item_help;
  $anrede["name"] = $spieler_name;
  $anrede["formel"] = "Sei gegrüsst Meister ";

  print_kopf($admin_typ,$header_typ,"Download",$anrede,$menu_item);
  

  $TABLE = "images";
  
  switch ($p_md):
  case mfd_insert: //5:  // MAIN-Menu
  	insert($p_row,$p_userfile,$daten); //$datei);
    $md=0;
    break;
  case mfd_update: // 6: // Update eines bestehnden Datensatzes
  	// Update SQL
  	update($p_row);
  	$md=0;
  	break;
  case mfd_del: //7: // Delete eines bestehenden Datensatzes
  	// SQL delete
  	loeschen($id);
  	$md=0;
  	break;
  default :
    break;
  endswitch;

  $titel = "";
  $home  = "admin_main.php";
  
	$menu = get_menu_images($md,$PHP_SELF, $ID,$titel,$id,$daten,$sub,$home);
	
	print_menu_status($menu);
	
	switch ($md):
  case mfd_edit_add: // Erfassen eines neuen Datensatzes
  		print_maske_erf($id,$ID,$daten);
  		break;
  case mfd_edit_info: // ANSEHEN Form
  	Print_maske_info($id, $ID, $daten);
  	break;
  case mfd_edit_delete: // ANSEHEN Form
  	Print_maske_del($id, $ID,$daten);
  	break;
  case mfd_edit_edit: // Bearbeiten Form
  	print_maske_edit($id,$ID,$daten);
  	break;
  default:  // die einzelnen Bildseiten 11-xx
  	print_liste($ID);
  	break;
 	endswitch;

	print_body_ende();

	?>