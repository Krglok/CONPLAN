<?php/* Projekt : LARPDatei   :  _liste.phpDatum   :  2002/05/14Rev.    :   2.0Author  :  OlafDudabeschreibung : realisiert die Bearbeitungsfunktionen f�r die Datei <$TABLE>- Liste der Datens�tze- Efassen neuer Datens�tze- Bearbeiten vorhandener Datens�tze- Anzeige der Details ohne Bearbeitung- L�schen  eines DatensatzesEs wird eine Session Verwaltung benutzt, die den User prueft.Es werden Subseiten mit eigenen PHP-scripten aufgerufen.Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)Die Uebergabe Parameter werden aus den $_GET, $_POSTVariablen geholt.1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonsteine Wiederverwendung nicht moeglich ist.Die Include zeigen dann auf ein falsches Verzeichnis !#2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment undeinen veraenderte Konfiguration eingestellt- einheitliches Layout- funktionen fuer Bilder und Icon im Kopf- print_body(typ) mit dem Hintergrundbild der Seite- print_kopf  mit- LOGO links- LOGO Mitte- Text1, Text2  fuer rechte Seite$Log: mag_liste.php,v $Revision 1.2  2002/05/14 19:12:03  winduErweiterung um ReportfunktionVer 3.0  / 06.02.2013Es werden CSS-Dateien verwendert. Es wird eine strikte Trennung von Content und Layout durchgefuehrt.Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues Layoutpfades in der config.incAnsonsten bleibt der Inhalt der Seiten identisch.	$style = $GLOBALS['style_datatab'];	echo "<div $style >";	echo "<!---  DATEN Spalte   --->\n";	echo '</div>';	echo "<!---  ENDE DATEN Spalte   --->\n";*/include_once "_config.inc";include_once "_lib.inc";include_once "_head.inc";//include_once ''; "_login.inc";//-----------------------------------------------------------------------------function print_liste($ID,$grp){	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;	global $PHP_SELF;	global $TABLE;	global $PHP_SELF;
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");	mysql_select_db($DB_NAME);	if ($grp=='')	{		$grp="NT";	}	$q = "select id, grp,stufe,name,spruchdauer,MUK,RAR,GEIST from $TABLE where grp=\"$grp\" order by grp DESC, stufe";	$result = mysql_query($q)  or die("Query Fehler...");	mysql_close($db);	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
		echo "<table border=1 BGCOLOR=\"\">\n";	//Kopfzeile	echo "<tr>\n";	$field_num = mysql_num_fields($result);	for ($i=0; $i<$field_num; $i++)	{		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";	};	echo "</tr>\n";	//Liste der Datens�tze	while ($row = mysql_fetch_row($result))	{		echo "<tr>";		for ($i=0; $i<$field_num; $i++)		{			// aufruf der Deateildaten			if ($i==0)			{				echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";				print_menu_icon ("_text");				echo "\t</a></td>\n";			} else			{				echo "\t<td>$row[$i]&nbsp;</td>\n";			};		}		echo "<tr>";	}	echo "</table>";	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	};function print_liste_1($ID,$grp){	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;	global $PHP_SELF;	global $TABLE;	global $PHP_SELF;
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");	mysql_select_db($DB_NAME);	if ($grp=='')	{		$grp="WM";	}	$q = "select id, grp,stufe,name,spruchdauer from $TABLE where grp=\"$grp\" order by grp DESC, stufe";	$result = mysql_query($q)  or die("Query Fehler...");	mysql_close($db);	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
		echo "<table border=1 BGCOLOR=\"\">\n";	//Kopfzeile	echo "<tr>\n";	$field_num = mysql_num_fields($result);	for ($i=0; $i<$field_num; $i++)	{		echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";	};	echo "</tr>\n";	echo "<hr>\n";	//Liste der Datens�tze	while ($row = mysql_fetch_row($result))	{		echo "<tr>";		for ($i=0; $i<$field_num; $i++)		{			// aufruf der Deateildaten			if ($i==0)			{				echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";				echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";				echo "\t</a></td>\n";			} else			{				echo "\t<td>$row[$i]&nbsp;</td>\n";			};		}		//      echo "\t<td><a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]\">\n";		//      echo "\t<IMG SRC=\"../larp/images/xview.gif\" BORDER=\"0\" HEIGHT=\"15\" WIDTH=\"25\" ALT=\"Thema Lesen\" HSPACE=\"0\" VSPACE=\"0\">\n";		//      echo "\t</a></td>\n";		echo "<tr>";	}	echo "</table>";	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	};function print_info($id,$ID){	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;	global $TABLE;	global $PHP_SELF;
		//Anzeigen von Contage als einfache Maske	//function view() {	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)	or die("Fehler beim verbinden!");	mysql_select_db($DB_NAME);	$q = "select id,grp,stufe,name,spruchdauer,wirkdauer,wirkbereich,reichweite,wirkung,kosten,patzer,ausfuehrung,MUK,RAR,GEIST from $TABLE where id=$id";	$result = mysql_query($q)	or die("Query Fehler...");	$field_num = mysql_num_fields($result);	$row = mysql_fetch_row($result);	mysql_close($db);	//Daten bereich	$style = $GLOBALS['style_datatab'];	echo "<div $style >";	echo "<!---  DATEN Spalte   --->\n";		echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"0\">\n";	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\" VALUE=\"$ID\">\n";	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";	echo "<TABLE WIDTH=\"700\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	for ($i=0; $i<$field_num; $i++)	{		$field_name[$i] =  mysql_field_name($result,$i);		$type[$i]       =  mysql_field_type ($result, $i);	}	for ($i=0; $i<$field_num; $i++)	{		if ($type[$i]=="date") {			$len[$i] = 10;		}		if ($type[$i]=="int") {			$len[$i] = 5;		}		if ($type[$i]!="blob")		{			echo "<tr>";			echo "\t<td width=100>$field_name[$i]&nbsp;</td>\n";			echo "\t<td><input name=\"\" maxlength=$len[$i] size=$len[$i] readonly value=$row[$i]></td>\n";			//        echo "\t<td width=100>$type[$i]&nbsp;</td>\n";			echo "<tr>";		} else		{			echo "<tr>";			echo "\t<td><b></b></td>\n";			echo "\t<td><TEXTAREA NAME=\"$field_name[$i]\" COLS=50 ROWS=12 readonly>$row[$i]</TEXTAREA>&nbsp;</td>\n";			echo "<tr>";		}	}	echo "</table>";	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	};function print_blatt($id,$ID,$grp)/* Realisiert eine Einzelblatt des Datensatzes mit allen relevanten Details�hnlich der Info-funktion in den Datenmasken.Das Layout wird speziell angepasst um das DIN A$ format zu gew�hrleisten*/{	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;	global $TABLE;	global $TAG;    global $PHP_SELF;	//  Erstellen eines reports	//	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)	or die("Fehler beim verbinden!");	mysql_select_db($DB_NAME);	// Felder werden explizit angegeben,	// die Reihenfolge der Definition ist die Reihenfolge in der Ergebnisliste	//	$q = "select id,GRP,NR,STUFE,NAME,SPRUCHDAUER,KOSTEN,WIRKDAUER,WIRKBEREICH,REICHWEITE,WIRkUNG,PATZER,AUSFUEHRUNG,MUK,RAR,GEIST from $TABLE where id=$id";	$result = mysql_query($q)	or die("Query Fehler...");	//  anzahl zeile in Ergebnis -------------------------------------	$field_num = mysql_num_fields($result);	// Aufl�sung Datenzeilen in Ergebnis -----------------------------	$row = mysql_fetch_row($result);	// aufl�sen der Feldnamen und Type in einfache Tabellen ----------	for ($i=0; $i<$field_num; $i++)	{		$field_name[$i] =  ucfirst (mysql_field_name($result,$i));		$type[$i]       =  mysql_field_type ($result, $i);	};	mysql_close($db);	//	//Daten bereich	//	//      Datentypenerkennung f�r NICT Strings -----	//      if ($type[$i]=="date") { $len[$i] = 10; }	//      if ($type[$i]=="int") { $len[$i] = 5; }	//      if ($type[$i]!="blob")	$style = $GLOBALS['style_datatab'];
	echo "<div $style style=\" background:url(layout/back/paper.jpg)\">";
	echo "<!---  DATEN Spalte   --->\n";
		echo "<TABLE WIDTH=\"690\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";
	echo "\t<td > \n";
	echo "\t</td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";	echo "\t<td><a href=\"$PHP_SELF?md=0&ID=$ID&grp=$grp\">\n";	print_menu_icon ("_stop");	echo "\t</a></td>\n";		echo "</tr>";
		echo "<tr>";	echo "\t<td width=45 rowspan=2> \n";	echo "  <IMG SRC=\"images/penta.gif\" BORDER=\"0\" HEIGHT=\"65\" WIDTH=\"65\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\"> \n";	echo "\t</td>\n";	echo "\t<td width=50></td>\n";	echo "\t<td width=50><b>$field_name[1]&nbsp;</b></td>\n";	echo "\t<td width=50><b>$field_name[13]&nbsp;</b></td>\n";	echo "\t<td width=50><b>$field_name[14]&nbsp;</b></td>\n";	echo "\t<td width=50><b>$field_name[15]&nbsp;</b></td>\n";	echo "\t<td align=right> \n";	echo " SPRUCHBESCHREIBUNG &nbsp;&nbsp;&nbsp;\n";	echo "\t</td>\n";	echo "</tr>";	echo "<tr>";	//      echo "\t<td width=45></td>\n";	echo "\t<td width=50></td>\n";	echo "\t<td width=50>$row[1]</td>\n";	//      echo "\t<td width=50>$row[2] </td>\n";	echo "\t<td width=50>$row[13]</td>\n";	echo "\t<td width=50>$row[14] </td>\n";	echo "\t<td width=50>$row[15] </td>\n";	echo "\t<td width=50><b>&nbsp;</b></td>\n";	echo "</tr>";	echo "</table>\n";  // Ende der Tabllle	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";	echo "\t<td width=45> \n";	echo "\t</td>\n";	echo "\t<td width=65></td>\n";	echo "\t<td > </td>\n";	echo "</tr>";	echo "<tr height=20>";	echo "\t<td width=45> \n";	echo "\t</td>\n";	echo "\t</td>\n";	echo "</tr>";	echo "</table>\n";  // Ende der Tabllle	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";// Name	echo "\t<td width=100><b>$field_name[4]&nbsp;</b></td>\n";	echo "\t<td >$row[4]</td>\n";	echo "\t<td </b></td>\n";	echo "</tr>";	echo "</table>\n";  // Ende der Tabllle	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>"; // Stufe und Kosten	echo "\t<td width=100><b>$field_name[3]&nbsp;</b></td>\n";	echo "\t<td width=30>$row[3]&nbsp; </td>\n";	echo "\t<td width=50><b>$field_name[6]&nbsp;</b></td>\n";	echo "\t<td >$row[6] </td>\n";	echo "\t<td </b></td>\n";	echo "</tr>";	echo "</table>\n";  // Ende der Tabllle	echo "<TABLE WIDTH=\"690\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>"; // Spruchdauer	echo "\t<td width=100><b>$field_name[5]&nbsp;</b></td>\n";	echo "\t<td >$row[5] </td>\n";	echo "\t<td > </td>\n";	echo "<tr>";	echo "<tr>"; // Spruchname	echo "\t<td width=70><b>$field_name[7]&nbsp;</b></td>\n";	echo "\t<td >$row[7]</td>\n";	echo "\t<td></td>\n";	echo "</tr>";	echo "<tr>";	echo "\t<td width=50><b>$field_name[8]&nbsp;</b></td>\n";	echo "\t<td >$row[8] </td>\n";	echo "\t<td></td>\n";	echo "</tr>";	echo "<tr>";	echo "\t<td width=50><b>$field_name[9]&nbsp;</b></td>\n";	echo "\t<td >$row[9] </td>\n";	echo "\t<td > </td>\n";	echo "</tr>";	echo "</table>\n";  // Ende der Tabllle	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";	echo "\t<td width=100><b>Wirkung&nbsp;</b></td>\n";	//      echo "\t<td width=70><b></b>$field_name[10]&nbsp;</td>\n";	$zeile=explode("\n",$row[10]);	$anz  = count($zeile);	echo "\t<td>\n";	for ($ii=0; $ii<$anz; $ii++)	{		echo "\t$zeile[$ii]&nbsp;<br>\n";	}	echo "</td>\n";	echo "<tr>\n";	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";	echo "\t<td width=100><b>Patzer</b>&nbsp;</td>\n";	$zeile=explode("\n",$row[11]);	$anz  = count($zeile);	echo "\t<td>\n";	for ($ii=0; $ii<$anz; $ii++)	{		echo "\t$zeile[$ii]&nbsp;<br>\n";	}	echo "</td>\n";	echo "<tr>\n";	echo "<TABLE WIDTH=\"690\" HEIGHT=\"100\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\"			BORDERCOLOR=\"#EDDBCB\" BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";	echo "<tr>";	echo "\t<td width=100><b>Ausf�hrung</b>&nbsp;</td>\n";	$zeile=explode("\n",$row[12]);	$anz  = count($zeile);	echo "\t<td>\n";	for ($ii=0; $ii<$anz; $ii++)	{		echo "\t$zeile[$ii]&nbsp;<br>\n";	}	echo "</td>\n";	echo "<tr>\n";	echo "</table>\n";  // Ende der Tabllle	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
	};// ---------------------------------------------------------------// ---------    MAIN ---------------------------------------------//// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!// ----------------------------------------------------------------$BEREICH = 'INTERN';
$PHP_SELF = $_SERVER['PHP_SELF'];

$md     = GET_md(0);
$daten  = GET_daten("");
$id     = GET_id("");
$ID     = GET_SESSIONID("");
$grp    = GET_grp("");
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


print_header("Magieliste");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserw�hlter\n";

$menu_item = $menu_item_help;
print_kopf($logo_typ,$header_typ,"Spruchliste","Sei gegr�sst $spieler_name ",$menu_item);

$TABLE = "mag_list";switch ($md):case 1: // Ansehen / INFO eines Datensatzes	$menu = array (0=>array("icon" => "99","caption" => "MAGIE","link" => ""),			1=>array("icon" => "_list","caption" => "Neutral","link" => "$PHP_SELF?md=1&ID=$ID&grp=NT"),			2=>array("icon" => "_list","caption" => "Runen","link" => "$PHP_SELF?md=1&ID=$ID&grp=RU"),			3=>array("icon" => "_list","caption" => "Elementar","link" => "$PHP_SELF?md=1&ID=$ID&grp=EL"),			4=>array("icon" => "_list","caption" => "Druiden","link" => "$PHP_SELF?md=1&ID=$ID&grp=DU"),			20=>array("icon" => "0","caption" => "","link" => ""),			22=>array("icon" => "_list","caption" => "Weiss","link" => "$PHP_SELF?md=1&ID=$ID&grp=WM"),			24=>array("icon" => "_list","caption" => "Heilung","link" => "$PHP_SELF?md=1&ID=$ID&grp=HM"),			26=>array("icon" => "_list","caption" => "Priestermagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=PR"),			30=>array("icon" => "0","caption" => "","link" => ""),			32=>array("icon" => "_list","caption" => "Schwarze","link" => "$PHP_SELF?md=1&ID=$ID&grp=SM"),			34=>array("icon" => "_list","caption" => "Nekromantie","link" => "$PHP_SELF?md=1&ID=$ID&grp=NE"),			36=>array("icon" => "_list","caption" => "Daemonologie","link" => "$PHP_SELF?md=1&ID=$ID&grp=DM"),			40=>array("icon" => "_stop","caption" => "Zur�ck","link" => "larp.php?md=0&ID=$ID")	);	print_menu($menu);	print_liste($ID,$grp);	break;case 2: // Ansehen / INFO eines Datensatzes	print_blatt($id, $ID,$grp);	break;default:  // MAIN-Menu	$menu = array (0=>array("icon" => "99","caption" => "MAGIE","link" => ""),	1=>array("icon" => "_list","caption" => "Neutral","link" => "$PHP_SELF?md=1&ID=$ID&grp=NT"),	2=>array("icon" => "_list","caption" => "Runen","link" => "$PHP_SELF?md=1&ID=$ID&grp=RU"),	3=>array("icon" => "_list","caption" => "Elementar","link" => "$PHP_SELF?md=1&ID=$ID&grp=EL"),	4=>array("icon" => "_list","caption" => "Druiden","link" => "$PHP_SELF?md=1&ID=$ID&grp=DU"),	20=>array("icon" => "0","caption" => "","link" => ""),	22=>array("icon" => "_list","caption" => "Weiss","link" => "$PHP_SELF?md=1&ID=$ID&grp=WM"),	24=>array("icon" => "_List","caption" => "Heilung","link" => "$PHP_SELF?md=1&ID=$ID&grp=HM"),	26=>array("icon" => "_list","caption" => "Priestermagie","link" => "$PHP_SELF?md=9&ID=$ID&grp=PR"),	30=>array("icon" => "0","caption" => "","link" => ""),	32=>array("icon" => "_list","caption" => "Schwarze","link" => "$PHP_SELF?md=1&ID=$ID&grp=SM"),	34=>array("icon" => "_list","caption" => "Nekromantie","link" => "$PHP_SELF?md=1&ID=$ID&grp=NE"),	36=>array("icon" => "_list","caption" => "Daemonologie","link" => "$PHP_SELF?md=1&ID=$ID&grp=DM"),	40=>array("icon" => "_stop","caption" => "Zur�ck","link" => "larp.php?md=0&ID=$ID")	);	print_menu($menu);	print_liste($ID,$grp);	endswitch;	print_md_ende();	print_body_ende();	?>