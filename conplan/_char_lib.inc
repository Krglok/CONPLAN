<?php
/*
 Projekt : CONPLAN

Datei   :  $RCSfile: char_lib.inc,v $

Datum   :  $Date: 2002/06/01 10:31:54 $  /

Rev.    :  $Revision: 1.4 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :  Sammlung von Funktioen für die
Darstellung der Charakter daten


$Log: _doc.inc,v $
Revision 1.4  2002/06/01 10:31:54  windu
Erweterung im Funktions-Doku

Revision 1.3  2002/05/03 20:28:13  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.2  2002/02/26 18:41:39  windu
keyword aktiviert

*/

function print_char_kopf ()
{
	global $spieler_id;
	global $img_path;
	echo "<TABLE WIDTH=\"100%\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"1\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n\n";
	echo "  <TR>\n";
	echo "    <TD>\n";
	echo "      <TABLE WIDTH=\"800\" BORDER=\"1\" BGCOLOR=\"\" >\n";
	echo "        <TR >\n";
	echo "          <TD rowspan=4 WIDTH=\"120\"><!-- Row:1, Col:1   KOPF LOGO-->\n";
	echo "          <TABLE WIDTH=\"100%\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "          <TR>\n";
	echo "          <TD>\n";
	echo "            <IMG SRC=\"./images/feminist.gif\"  NOSAVE HEIGHT=80 WIDTH=80 ALIGN=LEFT BORDER=0 >\n";
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          </TABLE>\n";
	echo "          </TD>\n";
	echo "          <TD>\n";
	echo "          <TABLE WIDTH=\"640\" BORDER=\"0\" BGCOLOR=\"\" >\n";
	echo "          <TR>\n";
	echo "          <TD rowspan=2 width=450>\n";
	echo "          <IMG SRC=\"./images/drachenhorst_2.gif\" HSPACE=5 NOSAVE HEIGHT=73 WIDTH=350 ALIGN=ABSCENTER BORDER=0>\n";
	echo "          </TD>\n";
	echo "          <TD align=left >\n";
	echo "            &nbsp;<B>Charakter Verwaltung</b>\n";
	echo "          </TD>\n";
	/*
	 echo "          <TD align=left >\n";
	echo "          </TD>\n";
	*/
	echo "          </TR>\n";
	echo "          <TR>\n";
	echo "          <TD >\n";
	echo "            <b>".get_spieler($spieler_id); //Auserwählter\n";
	echo "          </TD>\n";
	echo "          </TR>\n";
	echo "          </TABLE>\n";
	echo "          </TD>\n";
	echo "        </TR>\n";
	echo "      </TABLE>\n";
	echo "    </TD>\n\n";
	echo "  </TR>\n\n";
	echo "</TABLE>\n";
	echo "\n\n";
};


function print_cbasis($id,$ID)
//==========================================================================
// Function     : print_basis
//--------------------------------------------------------------------------
// Beschreibun  :  erezugt eine Tabelle mit den DAten der Char_basis
//                 als Anzeige modul ohne Eingabe wie eine KOPf_Zeile
//
// Dateiname    : char_basis (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $nsc_char;

	$TABLE = 'char_basis';


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where id=\"$id\"";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	$row = mysql_fetch_row($result);
	//Liste der Datensätze
	if ($row[9]<=' ') {
		$row[9] = 'feminist.gif';
	};
	if ($row[8]<=' ') {
		$row[8] = 'default.gif';
	};

	if ($row[7]=='J')
	{
		$nsc_char='true';
		$row[9] = "ork2.gif";
	} else
	{
		$nsc_char='false';
	};

	echo "<table border=1 width=950 BGCOLOR=\"\">\n";
	echo "<tr>";
	echo "<td rowspan=2 width=90>";
	echo "\t<IMG SRC=\"chars/thumb/$row[9]\" BORDER=\"0\" HEIGHT=\"100\" ALT=\"Bild des Charakters\" title=\"Bild $row[9]\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	echo "</td>";
	echo "<td width=150 style=\"font-size:75%\"> ";
	echo "<b>Charakterame</b>";
	echo "</td>";
	echo "<td width=150 style=\"font-size:75%\">";
	echo "<b>Beruf</b>";
	echo "</td>";
	echo "<td width=150 style=\"font-size:75%\">";
	echo "<b>Rasse</b>";
	echo "</td>";
	echo "<td width=150 style=\"font-size:75%\">";
	echo "<b>Gilde</b>";
	echo "</td>";
	echo "<td rowspan=2 width=90>";
	echo "\t<IMG SRC=\"chars/thumb/$row[8]\" BORDER=\"0\" HEIGHT=\"100\" ALT=\"Wappen des Charakters\" title=\"Wappen $row[8]\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	echo "</td>";
	echo "<td >";
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td  style=\"font-size:105%\">";
	echo "$row[2]";
	echo "</td>";
	echo "<td style=\"font-size:105%\" >";
	echo "$row[3]";
	echo "</td>";
	echo "<td style=\"font-size:105%\" >";
	echo "$row[4]";
	echo "</td>";
	echo "<td style=\"font-size:105%\" >";
	echo "$row[5]<BR>";
	if ($row[7]=='J')
	{
		echo "<B>NSC";
	};
	echo "</td>";
	echo "</tr>";
	echo "</table>";

};

function print_ckopf($id,$ID)
//==========================================================================
// Function     : print_ckopf
//--------------------------------------------------------------------------
// Beschreibun  :  erezugt eine Tabelle mit den DAten der Char_basis
//                 als Anzeige modul ohne Eingabe wie eine KOPf_Zeile
//
// Dateiname    : char_basis (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_kopf';
	$TABLE1 = 'char_basis';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from $TABLE where char_id=\"$id\"";
	$result = mysql_query($q)  or die("Query Fehler...");

	$q1 = "select * from $TABLE1 where id=\"$id\"";
	$result1 = mysql_query($q1)  or die("Query Fehler...");

	mysql_close($db);

	//Liste der Datensätze
	$row = mysql_fetch_row($result);
	$row1 = mysql_fetch_row($result1);


	echo "<table width=950  border=1 BGCOLOR=\"\">\n";
	echo "<tr>";
	echo "<td rowspan=2 Width=90>";
	if ($row[3]=="MUK")
	{
		echo "\t<IMG SRC=\"images/muk.gif\" BORDER=\"0\" HEIGHT=\"80\"  ALT=\"MUK Wappen\" TITLE=\"MUK Wappen\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	} else
	{
		echo "\t<IMG SRC=\"images/mk.gif\" BORDER=\"0\" HEIGHT=\"80\"  ALT=\"MK Wappen\" TITLE=\"MK Wappen\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
	};
	echo "</td>";
	echo "<td width=20>";
	echo " ";
	echo "</td>";
	echo "<td width=20>";
	echo "<B>Notority";
	echo "</td>";
	echo "<td width=20>";
	echo "<B>Klasse";
	echo "</td>";
	echo "<td width=50>";
	echo "<B>LP";
	echo "</td>";
	echo "<td width=50>";
	echo "<B>KS";
	echo "</td>";
	echo "<td width=50>";
	echo "<B>MP";
	echo "</td>";
	echo "<td width=50>";
	echo "<B>AP";
	echo "</td>";
	echo "<td width=50>";
	echo " ";
	echo "</td>";
	echo "<td width=50>";
	echo "EP Start";
	echo "</td>";
	echo "<td width=50>";
	echo "EP Con ";
	echo "</td>";
	echo "<td width=40>";
	echo "EP Vorteil";
	echo "</td>";
	echo "<td width=50>";
	echo "EP Nachteil";
	echo "</td>";
	echo "<td width=50>";
	echo "EP Fert";
	echo "</td>";
	echo "<td width=50>";
	echo "EP Waf";
	echo "</td>";
	echo "<td width=40>";
	echo "EP Mag";
	echo "</td>";
	echo "<td width=40>";
	echo "EP Alch";
	echo "</td>";
	echo "<td width=40>";
	echo "EP Rest";
	echo "</td>";
	echo "<td width=\"10%\" >";
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=20>";
	echo " ";
	echo "</td>";
	echo "<td >";
	echo "$row[2]";
	echo "</td>";
	echo "<td >";
	echo "<B>$row[3]";
	echo "</td>";
	echo "<td >";
	echo "$row[4]";
	echo "</td>";
	echo "<td >";
	echo "$row[8]";
	echo "</td>";
	echo "<td >";
	echo "$row[5]";
	echo " / $row[6]";
	echo "</td> ";
	echo "<td>";
	echo "$row[7]";
	echo "</td>";
	echo "<td> ";
	echo "</td>";
	echo "<td >";
	echo " $row[9]";
	echo "</td>";
	echo "<td>";
	echo " $row[10]";
	echo "</td>";
	echo "<td >";
	echo " $row[11]";
	echo "</td>";
	echo "<td >";
	echo " $row[12]";
	echo "</td> ";
	echo "<td > ";
	echo " $row[13]";
	echo "</td>";
	echo "<td >";
	echo " $row[14]";
	echo "</td>";
	echo "<td >";
	echo " $row[15]";
	echo "</td>";
	echo "<td >";
	echo " $row[16]";
	echo "</td>";
	echo "<td >";
	echo " $row[17]";
	echo "</td>";
	echo "</tr>";
	echo "<td >";
	echo "</td>";
	echo "</table>";

};


function list_cfert($id,$ID)
//==========================================================================
// Function     : list_cfert
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_fert';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,stufe,ep from $TABLE where char_id=\"$id\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if ($i==1)
		{
			echo "\t<td width=200><b>FERTIGKEIT</b></td>\n";
		} else
		{
			echo "\t<td width=25><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"char_fert_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
				print_menu_icon (3);
				echo "\t</a></td>\n";
			} else
			{
				if ($i==1)
				{
					echo "\t<td width=220>$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td width=30>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "</tr>";
	}
	echo "</table>";

};

function list_cnach($id,$ID)
//==========================================================================
// Function     : list_cnach
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_nach';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,stufe,ep from $TABLE where char_id=\"$id\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if ($i==1)
		{
			echo "\t<td width=220><b>NACHTEIL</b></td>\n";
		} else
		{
			echo "\t<td width=25><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"char_nach_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
				print_menu_icon (3);
				echo "\t</a></td>\n";
			} else
			{
				if ($i==1)
				{
					echo "\t<td width=200>$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td width=30>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "</tr>";
	}
	echo "</table>";

};

function list_cvor($id,$ID)
//==========================================================================
// Function     : list_cvor
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_vor';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,stufe,ep from $TABLE where char_id=\"$id\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if ($i==1)
		{
			echo "\t<td width=200><b>VORTEIL</b></td>\n";
		} else
		{
			echo "\t<td width=25><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"char_vor_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
				print_menu_icon (3);
				echo "\t</a></td>\n";
			} else
			{
				if ($i==1)
				{
					echo "\t<td width=220>$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td width=25>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "</tr>";
	}
	echo "</table>";

};

function list_cwaf($id,$ID)
//==========================================================================
// Function     : list_cwaf
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_waf';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,ks,ep from $TABLE where char_id=\"$id\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	//Kopfzeile
	echo "<tr>\n";
	$field_num = mysql_num_fields($result);
	for ($i=0; $i<$field_num; $i++)
	{
		if ($i==1)
		{
			echo "\t<td width=200><b>WAFFEN</b></td>\n";
		} else
		{
			echo "\t<td width=25><b>".mysql_field_name($result,$i)."</b></td>\n";
		};
	};
	echo "</tr>\n";
	//Liste der Datensätze
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			// aufruf der Deateildaten
			if ($i==0)
			{
				echo "\t<td><a href=\"char_waf_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
				print_menu_icon (3);
				echo "\t</a></td>\n";
			} else
			{
				if ($i==1)
				{
					echo "\t<td width=220>$row[$i]&nbsp;</td>\n";
				} else
				{
					echo "\t<td width=32>$row[$i]&nbsp;</td>\n";
				};
			};
		}
		echo "<tr>";
	}
	echo "</table>";

};

function list_cmag($id,$ID)
//==========================================================================
// Function     : list_cmag
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_mag';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,stufe,ep from $TABLE where char_id=\"$id\" order by stufe,id ";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	//Kopfzeile
	$row_num = mysql_num_rows($result);
	$field_num = mysql_num_fields($result);
	if ($row_num > 0)
	{
		echo "<tr>\n";
		for ($i=0; $i<$field_num; $i++)
		{
			if ($i==1)
			{
				echo "\t<td width=0 ><b>SPRUCH</b></td>\n";
			} else
			{
				echo "\t<td width=25 ><b>".mysql_field_name($result,$i)."</b></td>\n";
			};
		};
		echo "</tr>\n";
		//Liste der Datensätze
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
					echo "\t<td><a href=\"char_mag_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
					print_menu_icon (3);
					echo "\t</a></td>\n";
				} else
				{
					if ($i==1)
					{
						echo "\t<td width=220>&nbsp;$row[$i]&nbsp;</td>\n";
					} else
					{
						echo "\t<td width=30>$row[$i]&nbsp;</td>\n";
					};
				};
			}
			echo "</tr>";
		}
	}
	echo "</table>";

};

function list_ctrank($id,$ID)
//==========================================================================
// Function     : list_ctrank
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_trank';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,stufe,ep from $TABLE where char_id=\"$id\" order by id";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	//Kopfzeile
	$row_num = mysql_num_rows($result);
	$field_num = mysql_num_fields($result);
	if ($row_num > 0)
	{
		echo "<tr>\n";
		for ($i=0; $i<$field_num; $i++)
		{
			if ($i==1)
			{
				echo "\t<td><b>TRANK</b></td>\n";
			} else
			{
				echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			};
		};
		echo "</tr>\n";
		//Liste der Datensätze
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
					echo "\t<td><a href=\"char_alch_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
					print_menu_icon (3);
					echo "\t</a></td>\n";
				} else
				{
					if ($i==1)
					{
						echo "\t<td width=220>&nbsp;$row[$i]&nbsp;</td>\n";
					} else
					{
						echo "\t<td width=30>$row[$i]&nbsp;</td>\n";
					};
				};
			}
			echo "</tr>";
		}
	}
	echo "</table>";

};

function list_ctage($id,$ID)
//==========================================================================
// Function     : list_ctage
//--------------------------------------------------------------------------
// Beschreibun  :  erzeugt eine Tabelle mit den Daten der Char_fertiglkeiten
//                 als Anzeige modul ohne Eingabe wie eine Liste
//
// Dateiname    : char_fert (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================

{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$TABLE = 'char_tage';

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$q = "select id,name,conname,con,tage,con_ep,sonder_ep,notority from $TABLE where char_id=\"$id\" order by con DESC";
	$result = mysql_query($q)  or die("Query Fehler...");
	mysql_close($db);

	echo "<table border=1 BGCOLOR=\"\">\n";
	//Kopfzeile
	$row_num = mysql_num_rows($result);
	$field_num = mysql_num_fields($result);
	if ($row_num > 0)
	{
		echo "<tr>\n";
		for ($i=0; $i<$field_num; $i++)
		{
			if ($i==1)
			{
				echo "\t<td><b>CON-TAG</b></td>\n";
			} else
			{
				echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
			};
		};
		echo "</tr>\n";
		//Liste der Datensätze
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
					echo "\t<td><a href=\"char_tage_liste.php?md=4&ID=$ID&id=$row[$i]&char=$id\">\n";
					print_menu_icon (3);
					echo "\t</a></td>\n";
				} else
				{
					if ($i==1)
					{
						echo "\t<td width=220>&nbsp;$row[$i]&nbsp;</td>\n";
					} else
					{
						echo "\t<td width=30>$row[$i]</td>\n";
					};
				};
			}
			echo "<tr>";
		}
	}
	echo "</table>";

};

function get_char_klasse($id)
//==========================================================================
// Function     : get_char_klasse
//--------------------------------------------------------------------------
// Beschreibun  :  ermittelt die CharakterKlasse eines Chars
//
// Dateiname    : char_basis (local)
//
//
// Argumente    : $ID = charakter_id
//
// Returns      : --
//==========================================================================
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select klasse from char_kopf where char_id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	return  $row[0];

}

function check_char($char,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$TABLE = 'char_kopf';
	$q = "select * from $TABLE where char_id=\"$char\"";
	$result = mysql_query($q)  or die("KOPF Fehler...");

	$kopf = mysql_fetch_row($result);

	// Auswertung tage
	$TABLE = 'char_tage';
	$q = "select sum(sonder_ep),sum(con_ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[10] =  $sum[0] + $sum[1];;

	// Auswertung Vorteile
	$TABLE = 'char_vor';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[11] =  $sum[0];;

	// Auswertung Nachteile
	$TABLE = 'char_nach';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[12] =  $sum[0];;


	// Auswertung fertigkeiten
	$TABLE = 'char_fert';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[13] = -1 * $sum[0];

	// Auswertung Waffen
	$TABLE = 'char_waf';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[14] = -1 * $sum[0];

	// Auswertung Magie
	$TABLE = 'char_mag';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[15] = -1 * $sum[0];

	// Auswertung Alchimie
	$TABLE = 'char_trank';
	$q = "select sum(ep) from $TABLE where char_id=\"$char\" group by char_id";
	$result = mysql_query($q)  or die("KOPF Fehler...");
	$sum = mysql_fetch_row($result);

	$kopf[16] = -1 * $sum[0];

	// Summe aller EP
	$kopf[17] = $kopf[9]+$kopf[10]+$kopf[11]+$kopf[12]+$kopf[13]+$kopf[14]+$kopf[15]+$kopf[16];

	mysql_close($db);

	// Update der kopfdaten
	update($kopf);


};

function get_char_aktiv()
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $spieler_id;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id from char_basis where spieler_id=\"$spieler_id\" AND aktiv=\"J\"";
	$result = mysql_query($q)  or die("Char_Basis Fehler...");
	$row = mysql_fetch_row($result);

	mysql_close($db);
	return $row[0];

};

function get_char_name()
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $TABLE;
	global $spieler_id;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select name from char_basis where spieler_id=\"$spieler_id\" AND aktiv=\"J\"";
	$result = mysql_query($q)  or die("Char_Basis Fehler...");
	$row = mysql_fetch_row($result);

	mysql_close($db);
	return $row[0];

};

?>