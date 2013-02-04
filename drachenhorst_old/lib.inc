<?php

/*
 Projekt :  INTERN

Datei   :  $RCSfile: lib.inc,v $

Datum   :  $Date: 2002/06/08 14:38:31 $  /

Rev.    :  $Revision: 1.7 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :
Enthält allgemiengültige Funktionen
Für alle Bereiche
Spieler
SL
ADMIN

function print_menu_icon ($typ)
function print_head_icon ($typ)
function print_background ($typ)

function get_spieler_id($user_id)
function get_user_id($user)
function get_author($user_id)
function get_mail($user_id)
function get_charname($user_id)
function get_spieler($user_id)
function get_akttag()
function get_sltag($user,$tag)
function get_hilfe($item)
function print_hilfe($ID,$item,$id)
function print_kalender()
function tumb_erzeugen($bild_url,$zieldir,$max_x,$max_y,$type)
function tumb_copy($bild_url,$zieldir,$max_x,$max_y,$type)



*/

function print_menu_icon ($typ,$info = " ")
/*
 Ausgabe eines Menu_icon anhand einer Indexnummer
*/
{
	switch ($typ) :
	case 99:
		echo "\t";
	break;
	case 1:
		if ($info == " ") {
			$info = "Seite aufrufen " ;
		}
		echo "\t<IMG SRC=\"button/_folder.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 2:
		if ($info == " ") {
			$info = "neuen Datensatz anlegen!" ;
		}
		echo "\t<IMG SRC=\"button/_add.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 3:
		echo "\t<IMG SRC=\"button/_edit.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 4:
		if ($info == " ") {
			$info = "Löschliste aufrufen" ;
		}
		echo "\t<IMG SRC=\"button/_del.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 5:
		if ($info == " ") {
			$info = "Liste anzeigen " ;
		}
		echo "\t<IMG SRC=\"button/_list.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 6:
		if ($info == " ") {
			$info = "Zurücjk zum vorigen Menü!" ;
		}
		echo "\t<IMG SRC=\"button/_stop.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 7:
		if ($info == " ") {
			$info = "Datensatz anzeigen ohne Bearbeitung" ;
		}
		echo "\t<IMG SRC=\"button/_page.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 8:
		if ($info == " ") {
			$info = "Druckliste aufrufen" ;
		}
		echo "\t<IMG SRC=\"button/_printer.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 9:
		if ($info == " ") {
			$info = "Datensatz bearbeiten!" ;
		}
		echo "\t<IMG SRC=\"button/_db.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 10:
		if ($info == " ") {
			$info = "Hilfe der Homepage aufrufen !" ;
		}
		echo "\t<IMG SRC=\"button/_help.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 11:
		if ($info == " ") {
			$info = "neuen Datensatz anlegen!" ;
		}
		echo "\t<IMG SRC=\"button/add.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 12:
		if ($info == " ") {
			$info = "Download starten !" ;
		}
		echo "\t<IMG SRC=\"button/_zip.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 13:
		echo "\t<IMG SRC=\"button/_key.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 14:
		echo "\t<IMG SRC=\"button/_tool.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 15:
		echo "\t<IMG SRC=\"button/nwn_eye.gif\" BORDER=\"0\" HEIGHT=\"24\" WIDTH=\"24\" ALT=\"$info\" TITLE=\"$info\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	default:
		echo "</A><HR>"; // Leerzeile
		endswitch;
};


function print_header_icon ($typ)
/*
 Ausgabe eines Menu_icon anhand einer Indexnummer
*/
{
	switch ($typ) :
	case 1:
		echo "\t<IMG SRC=\"images/drache.gif\" BORDER=\"0\" HEIGHT=\"84\" WIDTH=\"97\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=\"CENTER\">";
	break;
	case 2:
		echo "\t<IMG SRC=\"images/drachenhorst.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"360\"  ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 3:
		echo "\t<IMG SRC=\"images/buch.gif\" BORDER=\"0\" HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 4:
		echo "\t<IMG SRC=\"images/bibliothek.gif\" BORDER=\"0\"  ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 5:
		echo "\t<IMG SRC=\"images/feminist.gif\" BORDER=\"0\" HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 6:
		echo "\t<IMG SRC=\"images/DRAGON.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 7:
		echo "\t<IMG SRC=\"images/penta.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 8:
		echo "\t<IMG SRC=\"images/mag_drag_s.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 9:
		echo "\t<IMG SRC=\"images/sl_header.gif\" BORDER=\"0\"   HEIGHT=\"84\" WIDTH=\"392\"  ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 10:
		echo "\t<IMG SRC=\"images/cauldron.jpg\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 11:
		echo "\t<IMG SRC=\"images/_tool.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	case 12:
		echo "\t<IMG SRC=\"images/_div.gif\" BORDER=\"0\"  HEIGHT=\"84\" WIDTH=\"84\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>";
		break;
	default:
		break;
		endswitch;
};

function print_background ($typ)
/*
 Ausgabe eines Menu_icon anhand einer Indexnummer
*/
{
	switch ($typ) :
	case 1:
		echo "BACKGROUND=\"back/papermiddlecenter.jpg\"";
	break;
	case 2:
		echo "BACKGROUND=\"back/backmarble.jpg\"";
		break;
	case 3:
		echo "BACKGROUND=\"back/paper.jpg\"";
		break;
	case 4:
		echo "BACKGROUND=\"back/backbraun.jpg\"";
		break;
	case 5:
		echo "BACKGROUND=\"back/bground_karte.jpg\"";
		break;

	default:
		endswitch;
};


function get_spieler_id($user_id)
/*
 Gibt die Spieler_id zu einer User_id zurück
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select spieler_id from user_liste where id=\"$user_id\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	$user_id=$row1[0];
	return $user_id;

};

function get_user_id($user)
/*
 Gibt die Spieler_id zu einem UserNAme zurück
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select spieler_id,id,username from user_liste where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	$user_id=$row1[0];
	return $user_id;

};

function get_author($user_id)
/*
 Gibt den Realnamen (Vorname + Name zu einer spieler_id zurück
 		*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	$author = $row1[2]." ".$row1[1];
	return $author;
};

function get_mail($user_id)
/*
 Gibt die Mail-adresse zu einer Spieler_id zurück
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	return  $row[4];
};


function get_charname($user_id)
/*
 Gibt den Charakternamen zu einer Spieler_id zurück
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	return  $row[3];
};

function get_spieler($user_id)
/*
 Gibt den Namen des Spielers zu einer spieler_id zurück

*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;
	global $spieler_id;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	return  $row[2]." ".$row[1];
};



function get_akttag()
/*
 Gibt den aktuellen Contag zurück
*/
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select id,tag from con_konst where id=1 ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row = mysql_fetch_row($result);
	return  $row[1];
};


function get_sltag($user,$tag)
/*
 Prüft , ob der user auf den Tag Zugrifsberechtigt ist
Holt die User_id angand des User
Sucht die User_id in der
*/
{
	global $DB_HOST,$DB_USER,$DB_PASS,$DB_NAME,$TBL_USER;
	global $PHP_SELF;

	if ($user!='')
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die( "Fehler beim Verbinden".$DB_HOST."-".$DB_USER."-".$DB_PASS);

		mysql_select_db($DB_INTERN);
		// User_id ermitteln
		$Q = "select id,username,lvl from $TBL_USER where username=\"$user\"";
		$result = mysql_query($Q) or die( "Fehler bei User");
		$row = mysql_fetch_row($result);
		//    echo "user: $row[0] / $row[1] / $row[2] <BR>";
		// User_id in con_konst suchen mit user_id
		$q = "select id,tag,user_id from con_konst where user_id=\"$row[0]\" AND tag=\"$tag\"";
		$result = mysql_query($q) or die("select Fehler.con_konst.");
		$row = mysql_fetch_row($result);
		//    echo "konst: $row[1] / $tag <BR>";
		if ($row[1] == $tag)
		{
			return "TRUE";
		}
		else
		{
			return "FALSE";
		}
	}
	else
	{
		return "FALSE";
	}
};



function get_hilfe($item)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from hilfe where item=\"$item\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	return  $result;
}

function get_hilfe_item($item,$id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from hilfe where item=\"$item\" AND id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	return  $result;
}

function  print_hilfe($ID,$item,$id)
{
	if ($id=='')
	{
		$result = get_hilfe($item);

		echo "  <TD\n>";
		echo "<table border=0 BGCOLOR="."  >\n";

		echo "<tr>\n";
		echo "<td>\n";
		print_menu_icon (10);
		echo "</td>\n";
		echo "<td>\n";
		echo "<b>Hilfeindex : $item\n";
		echo "</td>\n";
		echo "</tr>\n";
		//Daten
		$field_num = mysql_num_fields($result);
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			for ($i=0; $i<$field_num-1; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
					echo "\t<td><a href=\"$PHP_SELF?md=10&ID=$ID&id=$row[$i]&item=$item\">\n";
					print_menu_icon (7);
					echo "\t</a></td>\n";
				} else
				{
					echo "\t<td>".$row[$i]."&nbsp;</td>\n";
				}
			}
		}
		echo "</table>";
		echo "  </TD\n>";
	} else
	{
		$result = get_hilfe_item($item,$id);

		echo "  <TD\n>";
		echo "<table border=0 BGCOLOR=\"\"  >\n";

		//Daten
		$field_num = mysql_num_fields($result);
		while ($row = mysql_fetch_row($result))
		{
			echo "<tr>";
			echo "\t<td width=\"5\"><a href=\"$PHP_SELF?md=10&ID=$ID&item=$item\">\n";
			echo "\t<IMG SRC=\"../larp/images/back.gif\" BORDER=\"0\"  HEIGHT=\"25\" WIDTH=\"25\"  ALT=\"Vorige Seite\" HSPACE=\"0\" VSPACE=\"0\" ALIGN=ABSMIDDLE>\n";
			echo "\t</a></td>\n";
			echo "\t<td width=\"150\"><b>$row[3]&nbsp;</td>\n";
			echo "\t<td>&nbsp;</td>\n";

			//      echo "\t<td>".$row[4]."&nbsp;</td>\n";
			echo "</tr>";
			echo "<tr>";
			$zeile=explode("\n",$row[4]);
			$anz  = count($zeile);
			echo "\t<td colspan=3>\n";
			for ($ii=0; $ii<$anz; $ii++)
			{
				echo "\t$zeile[$ii]&nbsp;<br>\n";
			}
			echo "</td>\n";

			echo "</tr>";
		}
		echo "</table>";
		echo "  </TD\n>";

	}
}

function get_monat_name($m)
{
	switch($m):
	case 1:
		$str = "Jan.";
	break;
	case 2:
		$str = "Feb.";
		break;
	case 3:
		$str = "März";
		break;
	case 4:
		$str = "April";
		break;
	case 5:
		$str = "Mai";
		break;
	case 6:
		$str = "Juni";
		break;
	case 7:
		$str = "Juli";
		break;
	case 8:
		$str = "Aug.";
		break;
	case 9:
		$str = "Sep.";
		break;
	case 10:
		$str = "Okt.";
		break;
	case 11:
		$str = "Nov.";
		break;
	case 12:
		$str = "Dez.";
		break;
	default:
		$str="??";
		break;
		endswitch;

		return $str;
}


function get_typ_color($typ)
{
	switch($typ):
	case 'contag':
		$color="#00C600";
	break;
	case 'aufbau':
		$color="orange";
		break;
	case 'basteln':
		$color="orange";
		break;
	case 'vv':
		$color="fuchsia";
		break;
	default:
		$color = "silver";
		break;
		endswitch;

		return $color;
}

function print_kalender()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;


	echo "    <TD>\n";
	echo "<TABLE  WIDTH=\"600\" HEIGHT=\"40\" BORDER=\"1\" CELLPADDING=\"1\" BGCOLOR=\"silver\" BORDERCOLOR=\"#808080\" BORDERCOLORDARK=\"gray\" BORDERCOLORLIGHT=\"#C0C0C0\"\n";
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	// aktuelles Datum ermitteln fr STartwoche
	$t = date("j");
	$m = date("n");
	$j = date("Y");
	$W = date("W");
	$j1 = $j+1;

	$where = " where (jahr=".$j." OR jahr=".$j1." ) AND monat=".$m." AND (mo=".$t." OR di=".$t." OR mi=".$t." OR do=".$t." OR fr=".$t." OR sa=".$t." OR so=".$t.")" ;
	$result = mysql_query("SELECT kal_id from kalender ".$where)
	or die("Query Fehler...tag");
	$row = mysql_fetch_row($result);

	// Erste KW festlegen fr obertse Kalenderzeile
	$kw1 = $row[0];        // untere Grenze aktuelle Woche
	$kw2 = $row[0]+105;     // obere Grenze relativ

	//  $where = " where kal_id>=".$kw1." and kal_id<=".$kw2 ;
	$where = "where (jahr = extract(year from CurDate()) )  and (monat = extract(month from Curdate()) "
			." OR monat > extract(month from Curdate()) "
			." OR monat = extract(month from Curdate())-1) "
					."OR jahr > extract(year from CurDate())";

	$result = mysql_query("SELECT * from kalender ".$where." order by jahr,kw LIMIT 105 ")
	or die("Query Fehler...kw");

	// Kalender zeichnen
	$row = mysql_fetch_row($result);
	echo "<TR HEIGHT=\"40\" >";
	echo "\t<TD colspan=10  bgcolor=\"#A0A0C0\" ><FONT COLOR=\"black\">";
	echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"3\">\n";
	echo "<CENTER>Drachenhorst Kalender ".$j;
	echo "\t</TD>\n";
	echo "</TR>\n";
	echo "<TR  HEIGHT=\"30\" >";
	echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
	echo "\t<td width=\"15\" bgcolor=\"#A0A0C0\" ><FONT COLOR=\"black\">Monat&nbsp;<BR>";
	echo "</td>\n";
	echo "\t<td width=\"15\" bgcolor=\"#A0A0C0\" ><FONT COLOR=\"black\">KW </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Mo </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Di </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Mi </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Do </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Fr </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Sa </td>\n";
	echo "\t<td width=\"35\" bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">So </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color('0')."\" ><FONT COLOR=\"black\">Bemerkung </td>\n";
	echo "";
	echo "</TR>";
	echo "<TR  HEIGHT=\"40\" >";
	echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
	echo "\t<td width=\"15\" bgcolor=\"#A0A0C0\" ><FONT COLOR=\"black\">".get_monat_name($row[3])."</td>\n";
	echo "\t<td bgcolor=\"#A0A0C0\" > <FONT COLOR=\"black\">$row[2] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[11])."\" > <FONT COLOR=\"black\">$row[4] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[12])."\" > <FONT COLOR=\"black\">$row[5] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[13])."\" > <FONT COLOR=\"black\">$row[6] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[14])."\" > <FONT COLOR=\"black\">$row[7] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[15])."\" > <FONT COLOR=\"black\">$row[8] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[16])."\" > <FONT COLOR=\"black\">$row[9] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[17])."\" > <FONT COLOR=\"black\">$row[10] </td>\n";
	echo "\t<td bgcolor=\"".get_typ_color($row[16])."\" > <FONT COLOR=\"black\">&nbsp; $row[18] </td>\n";
	echo "";
	echo "</TR>";
	while ($row = mysql_fetch_row($result))
	{
		echo "<TR  HEIGHT=\"40\" >";
		echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
		echo "\t<td width=\"15\" bgcolor=\"#A0A0C0\" ><FONT COLOR=\"black\">".get_monat_name($row[3])."&nbsp;<BR>";
		echo "</td>\n";
		echo "\t<td bgcolor=\"#A0A0C0\" > <FONT COLOR=\"black\">$row[2] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[11])."\" > <FONT COLOR=\"black\">$row[4] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[12])."\" > <FONT COLOR=\"black\">$row[5] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[13])."\" > <FONT COLOR=\"black\">$row[6] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[14])."\" > <FONT COLOR=\"black\">$row[7] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[15])."\" > <FONT COLOR=\"black\">$row[8] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[16])."\" > <FONT COLOR=\"black\">$row[9] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[17])."\" > <FONT COLOR=\"black\">$row[10] </td>\n";
		echo "\t<td bgcolor=\"".get_typ_color($row[16])."\" > <FONT COLOR=\"black\">&nbsp; $row[18] </td>\n";
		echo "";
		echo '        </TR>';
	}

	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    .\n";
	echo "    </TD>\n";
	//=========== print_kalender_end ========================
};


function print_sc_liste()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	echo "    <TD ALIGN=\"CENTER\">\n";
	echo "<table border=0 WIDTH=\"600\">\n";

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME) ;

	$result = mysql_query("SELECT name,vorname,charakter,email from spieler  join user_liste on user_liste.spieler_id=spieler.ID")
	or die("Query Fehler...");


	mysql_close($db);

	$field_num = mysql_num_fields($result);
	echo "<tr>\n";
	echo "\t<td><b>Name</b></td>\n";
	echo "\t<td><b>Vorname</b></td>\n";
	echo "\t<td><b>Charakter</b></td>\n";
	echo "\t<td><b>email</b></td>\n";
	echo "</tr>\n";

	//Daten
	while ($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		for ($i=0; $i<$field_num; $i++)
		{
			if ($i==4)
			{
				echo "\t<td><a href=\"mailto:$row[$i]\"> $row[$i]</a></td>\n";
			} else
			{
				echo "\t<td>".$row[$i]."&nbsp;</td>\n";
			};
		}
		echo "<tr>\n";
	}
	echo "</table>\n";
	echo "    </TD>\n";

	echo "</table>\n";
	echo "    </TD>\n";
}

function tumb_erzeugen($bild_url,$zieldir,$max_x,$max_y,$type)
//==========================================================================
// Function     :  insert
//--------------------------------------------------------------------------
// Beschreibun  :  Verkleinert ein Bild zu einem thumbnail
//                 für GIF, JPG, PNG
//                 die Höhe wird fest vorgegeben.
//                 hoehe = 80
//                 die Breite wird berechnet
//                 das thumbnail wird in einem vorgegeben Unterverzeichnis
//                 gespeichert
//                 ./thumb
//
//> Kann mir jemand sagen wie ich dennoch die Bilder ohne Farbverlust
//> verkleinern kann
//> oder hat evtl. einen Codeschnippsel dafür parat...
//Ich hatte das Problem auch mal und in einem Forum diese Funktion
//Gefunden:
//
// Argumente    :  $bild_url = Name des Bildes
//                 $zieldir = Verzeichnis des Bildes
//
// Returns      :  --
//==========================================================================

{

	$PicPathIn=$zieldir; // Dein Verzeichnis des Original Bildes z.B.bilder/
	$PicPathOut=realpath($zieldir."thumb")."/"; // Dein Tumb Ziel Verzeichnis

	if ($max_x == 0) {
		$max_x = 100;
	}
	if ($max_y == 0) {
		$max_x = 50;
	}

	// Festellen ob Bild vorhanden
	//  echo "<br>";
	//  echo "OUT: ".$PicPathOut.$bild_url;
	//  echo "<br>";
	//  echo " IN: ".$PicPathIn.$bild_url;
	//  echo "<br>";
	//  echo " TYPE: $type";

	if(!file_exists($PicPathIn . $bild_url))
	{
		/* Erzeugen eines leeren Bildes */
		$im = ImageCreate ($max_x, $max_y);
		$bgc = ImageColorAllocate ($im, 255, 255, 255);
		$tc = ImageColorAllocate ($im, 0, 0, 0);
		ImageFilledRectangle ($im, 0, 0, $max_x, $max_y, $bgc);

		/* Ausgabe einer Fehlermeldung */
		ImageString($im, 1, 5, 5, "Kein Bild", $tc);
		ImageJPEG($im,$PicPathOut.$bild_url);
		imagedestroy ($im);
		echo "<br>$type";
		//    echo "KEIN BILD";
	} else
	{
		// Bilddaten feststellen
		$size=getimagesize($PicPathIn.$bild_url);
		$breite=$size[0];
		$hoehe=$size[1];
		$neueHoehe=$max_x; // Hier gibs du die neue Grösse an - Höhe wird  automatisch berechnet.
		$neueBreite=intval($breite*$neueHoehe/$hoehe);

		if ($type == 'image/gif')
		{ // GIF
			$altesBild=ImageCreateFromGIF("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,
			$neueHoehe,$breite,$hoehe);
			ImageGIF($neuesBild,"$PicPathOut" . "$bild_url");
			//    echo "<br>";
			//    echo "GIF BILD";
		}
		if ($type == 'image/jpeg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "JPEG BILD";
		}
		if ($type == 'image/jpg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "JPG BILD";
		}
		if ($type == 'image/pjpeg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "PJPG BILD";
		}
		if ($type == 'image/jpeg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "JPEG BILD";
		}
	};

}

function bild_speichern($bild,$name,$imagepath)
{
	$info = getimagesize($bild);
	switch($info[2])
	{
		case "1":
			$fileendung = ".gif";
			break;

		case "2":
			$fileendung = ".jpg";
			break;

		case "3":
			$fileendung = ".png";
			break;

		case "4":
			$fileendung = ".swf";
			break;

		case "":
			$fileendung = ".bmp";
			break;
	}
	$row[6] = $fileendung;
	$imagepath = realpath ($imagepath)."/";

	$file_name = $name.$fileendung;
	if(is_uploaded_file ($bild) )
	{
		move_uploaded_file ($bild,$imagepath.$file_name);
		chmod ($imagepath.$file_name, 0755);  // oktal; richtiger Wert von mode
		tumb_erzeugen($file_name,$imagepath,100,50);
	} else
	{
		echo "<BR>$imagepath$file_name<BR>\n";
		echo "<BR>$imagepath$bild<BR>\n";
	}


}

function tumb_copy($bild_url,$zieldir,$max_x,$max_y,$type)
//==========================================================================
// Function     :  insert
//--------------------------------------------------------------------------
// Beschreibun  :  Verkleinert ein Bild zu einem thumbnail
//                 für GIF, JPG, PNG
//                 die Höhe wird fest vorgegeben.
//                 hoehe = 80
//                 die Breite wird auf max_y gesetzt
//                 das thumbnail wird in einem vorgegeben Unterverzeichnis
//                 gespeichert
//                 ./thumb
//
//> Kann mir jemand sagen wie ich dennoch die Bilder ohne Farbverlust
//> verkleinern kann
//> oder hat evtl. einen Codeschnippsel dafür parat...
//Ich hatte das Problem auch mal und in einem Forum diese Funktion
//Gefunden:
//
// Argumente    :  $bild_url = Name des Bildes
//                 $zieldir = Verzeichnis des Bildes
//
// Returns      :  --
//==========================================================================

{

	$PicPathIn=$zieldir; // Dein Verzeichnis des Original Bildes z.B.bilder/
	$PicPathOut=realpath($zieldir."thumb")."/"; // Dein Tumb Ziel Verzeichnis

	if ($max_x == 0) {
		$max_x = 100;
	}
	if ($max_y == 0) {
		$max_y = 100;
	}

	// Festellen ob Bild vorhanden
	//  echo "<br>";
	//  echo "OUT: ".$PicPathOut.$bild_url;
	//  echo "<br>";
	//  echo " IN: ".$PicPathIn.$bild_url;
	//  echo "<br>";
	//  echo " TYPE: $type";

	if(!file_exists($PicPathIn . $bild_url))
	{
		/* Erzeugen eines leeren Bildes */
		$im = ImageCreate ($max_x, $max_y);
		$bgc = ImageColorAllocate ($im, 255, 255, 255);
		$tc = ImageColorAllocate ($im, 0, 0, 0);
		ImageFilledRectangle ($im, 0, 0, $max_x, $max_y, $bgc);

		/* Ausgabe einer Fehlermeldung */
		ImageString($im, 1, 5, 5, "Kein Bild", $tc);
		ImageJPEG($im,$PicPathOut.$bild_url);
		imagedestroy ($im);
		//    echo "<br>";
		//    echo "KEIN BILD";
	} else
	{
		// Bilddaten feststellen
		$size=getimagesize($PicPathIn.$bild_url);
		$breite=$size[0];
		$hoehe=$size[1];
		$neueHoehe=$max_x; // Hier gibs du die neue Grösse an - Höhe wird  automatisch berechnet.
		$neueBreite=$max_y; //intval($breite*$neueHoehe/$hoehe);
		echo "<br> $type";
		//echo "x = $neueHoehe  y = $neueBreite";

		if ($type == 'image/gif')
		{ // GIF
			$altesBild=ImageCreateFromGIF("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopy($neuesBild,$altesBild,0,0,0,0,$neueBreite, $neueHoehe);

			//    ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite, $neueHoehe,$breite,$hoehe);

			ImageGIF($neuesBild,"$PicPathOut" . "$bild_url");
			//    echo "<br>";
			//    echo "GIF BILD";
		}
		if ($type == 'image/jpeg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopy($neuesBild,$altesBild,0,0,0,0,$neueBreite, $neueHoehe);

			//      ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "JPEG BILD";
		}
		if ($type == 'image/jpg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopy($neuesBild,$altesBild,0,0,0,0,$neueBreite, $neueHoehe);

			//      ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "JPG BILD";
		}
		if ($type == 'image/pjpeg')
		{ // JPG
			$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild_url");
			$neuesBild=ImageCreate($neueBreite,$neueHoehe);
			ImageCopy($neuesBild,$altesBild,0,0,0,0,$neueBreite, $neueHoehe);

			//      ImageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
			ImageJPEG($neuesBild,"$PicPathOut"."$bild_url");
			//    echo "<br>";
			//    echo "PJPG BILD";
		}
	};

}


?>