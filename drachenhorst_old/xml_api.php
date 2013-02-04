<?php
/*
 Datenzugriff über XML auf Datenbank des Drachenhorst.
Der user und das Passwort werden jedesmal mit übertragen.

!!ACHTUNG test Api fuer Appletts


<xml>
<table>
<item>
<col1>data1</col1>
<col2>data2</col2>
</item>
</table>
</xml>

...where <col1> is

=====================================
KEINE Session Verwaltung !!


*/

include "config.inc";
//include "login.inc";
//include "head.inc";

function checkuser_xml($user, $pw)
{
	/*
	 Die Funktion prüft die übergebenen  Daten
	$user
	$pw
	gegen die Userdatennbank
	und gibt TRUE zurück
	*/
	global $DB_HOST,$DB_USER,$DB_PASS,$DB_INTERN,$TBL_USER;
	global $user_lvl   ;
	global $spieler_id ;
	global $user_id    ;

	if ($user!='')
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die( "Fehler beim Verbinden".$DB_HOST."-".$DB_USER."-".$DB_PASS);

		mysql_select_db($DB_INTERN);
		$Q = "select username,pword,lvl,spieler_id,id from $TBL_USER where username=\"$user\"";
		$result = mysql_query($Q)
		or die( "Fehler ".$DB_NAME." query ".$Q);
		$row = mysql_fetch_row($result);
		$check      = $row[1];
		$user_lvl   = $row[2];
		$spieler_id = $row[3];
		$user_id    = $row[4];

		if ($row[0] == $user)
		{
			//     $q = "select old_password(\"$pw\");";
			//     $result = mysql_query($q) or die("PW: $q");
			//     $row = mysql_fetch_row($result) ;
			//     echo ">$row[0] / $check";
			//     if ($row[0] == $check)
				//     {
				//        return "TRUE";
				//     } else
					//     {
					//       return "FALSE";
					//     };
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
}


function db2xml($query,$mode)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $user_lvl   ;


	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);

	$result = mysql_query($query)   or die("Fehler : Query db2xml..");
	$fields = mysql_num_fields($result);
	$rows   = mysql_num_rows($result);
	$table = mysql_field_table($result, $fields[0]);

	for ($i=0; $i<$fields; $i++)
	{
		$field_name[$i] =  mysql_field_name($result,$i);
		$field_type[$i] =  mysql_field_type ($result, $i);
	}

	$xmldata = "<xml><?xml version = \"1.0\"  encoding = \"ISO-8859-1\" ?> \r\n";   //
	/* */
	$xmldata .= "<!DOCTYPE db [";
	$xmldata .= "  <!ELEMENT db (create?,table?)>";
	$xmldata .= "  <!ELEMENT create (field)>";
	$xmldata .= "  <!ATTLIST create";
	$xmldata .= "		 name CDATA #REQUIRED";
	$xmldata .= "		 mode CDATA #REQUIRED";
	$xmldata .= "		 lvl CDATA #REQUIRED>";
	$xmldata .= "  <!ELEMENT field  (CDATA)>";
	$xmldata .= "  <!ATTLIST field";
	$xmldata .= "		 name CDATA #REQUIRED";
	$xmldata .= "		 typ CDATA #REQUIRED>";
	$xmldata .= "  <!ELEMENT table (record)>";
	$xmldata .= "  <!ATTLIST table";
	$xmldata .= "		 name CDATA #REQUIRED";
	$xmldata .= "		 mode CDATA #REQUIRED>";
	$xmldata .= "  <!ELEMENT record (column)+>";
	$xmldata .= "  <!ELEMENT column  (CDATA)>";
	$xmldata .= "  <!ATTLIST column";
	$xmldata .= "		 name CDATA #REQUIRED";
	$xmldata .= "		 typ CDATA #REQUIRED>";
	$xmldata .= "]>";
	/* */

	$xmldata .= "<db>\r\n";
	$xmldata .= "<create name=\"$table\" mode=\"$mode\"  lvl=\"$user_lvl\">\r\n";
	for ($i=0; $i<$fields; $i++)
	{
		$xmldata .= "<field  name=\"$field_name[$i]\" typ=\"$field_type[$i]\">";
		$xmldata .= "$i</field>\r\n";
	}
	$xmldata .= "</create>\r\n";

	$xmldata .= "<table name=\"$table\" mode=\"$mode\">\r\n";
	for ($i=0; $i<$rows; $i++)
	{
		$row = mysql_fetch_row($result);
		$xmldata .= "<record fieldnum=\"$fields\" >\r\n";
		for($j=0;$line=each($row);$j++)
		{
			$xmldata .= "<column  name=\"$field_name[$j]\" typ=\"$field_type[$j]\">";
			$xmldata .= "<![CDATA[$row[$j]]]></column>\r\n";
		}
		$xmldata .= "</record>\r\n";
	}

	$xmldata .= "</table>\r\n";
	$xmldata .= "</db>\r\n";
	mysql_free_result($result);
	mysql_close($db);

	return $xmldata;

}

function decodeSQLPost($sql)
{

}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
//
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist
$cmd  = $_GET['cmd'];
$user = $_GET['user'];
$pw   = $_GET['pw'];
$mode = $_GET['mode'];
$name = $_GET['name'];
$TAG = $_GET['TAG'];

$sql  = $_POST['sql'];
$data  = $_POST['data'];


global $user_lvl   ;
global $spieler_id ;
global $user_id    ;

echo "<HTML>";
echo "<HEAD>";

if (checkuser_xml($user,$pw) == "TRUE")
{

	echo "cmd: $cmd\r\n";

	switch ($cmd):
	case 1:  // eigene Spieler Daten wird
		// automatisch bei CheckUser ermittelt
		$sql = " select * from spieler where id=$spieler_id";
	echo $sql;
	echo db2xml($sql,$mode);
	break;
	case 10:  //  Alle Spieler Daten
		if (user_lv <= $lvl_sl[14] )
		{
			echo "lvl:$user_lvl";
			$sql = " select * from spieler";
			echo db2xml($sql,$mode);
			break;
		};
	case 11:  // alle News holen
		$sql = " select * from news ";
		echo db2xml($sql,$mode);
		break;
	case 12:  //  alle con_konst = Zugriff auf Con planung
		$sql = " select * from con_konst ";
		echo db2xml($sql,$mode);
		break;
	case 13:  // alle user
		$sql = " select * from user_liste ";
		echo db2xml($sql,$mode);
		break;
	case 14:  // alle Anmeldungen
		$sql = " select * from con_anmeldung ";
		echo db2xml($sql,$mode);
		break;
	case 15:  // alle Bilder Topic
		$sql = " select * from bilder_topic ";
		echo db2xml($sql,$mode);
		break;
	case 16:  // alle Download
		$sql = " select * from download ";
		echo db2xml($sql,$mode);
		break;
	case 17:  // alle Kalenderdaten
		$sql = " select * from kalender ";
		echo db2xml($sql,$mode);
		break;
	case 18:  // alle Regelwerk
		$sql = " select * from regelwerk order by kapitel, absatz, item ";
		echo db2xml($sql,$mode);
		break;
	case 20:  // Trankliste
		$sql = " select * from trank_list ";
		echo db2xml($sql,$mode);
		break;
	case 21:  // Trank Gruppe
		$sql = " select * from trank_grp ";
		echo db2xml($sql,$mode);
		break;
	case 22:  // Pflanznliste
		$sql = " select * from trank_pflanz_list ";
		echo db2xml($sql,$mode);
		break;
	case 23:  //
		$sql = " select * from mag_list ";
		echo db2xml($sql,$mode);
		break;
	case 28: // hole Contage bis aktuellem Contag
		$sql = "SELECT con_tage.* FROM con_tage left outer join con_konst on con_konst.ID=1 where con_tage.tag <= con_konst.tag AND con_tage.Tag > 0 order by con_tage.tag DESC";
		echo db2xml($sql,$mode);
		break;
	case 29:  //
		$sql = " select con_konst.* from con_konst  where con_konst.user_id=$user_id  order by tag DESC ";
		echo db2xml($sql,$mode);
		break;
	case 30:  //
		//      $sql = " select con_tage.* from con_tage join con_konst on con_konst.tag=con_tage.tag where con_konst.user_id=$user_id order by tag DESC ";
		$sql = " select con_tage.* from con_tage  order by tag DESC ";
		echo db2xml($sql,$mode);
		break;
	case 31:  //
		$sql = "SELECT * FROM con_ablauf where S0 = $TAG order by S0,S1,S2";
		echo db2xml($sql,$mode);
		break;
	case 32:  //
		$sql = "SELECT * FROM con_orte where S0 = $TAG order by S0,S1,S2";
		echo db2xml($sql,$mode);
		break;

	case 33:  //
		$sql = "SELECT * FROM con_nsc where S0 = $TAG order by S0,S1,S2";
		echo db2xml($sql,$mode);
		break;
	case 34:  //
		$sql = "SELECT * FROM con_geruecht where S0 = $TAG order by S0,S1,S2";
		echo db2xml($sql,$mode);
		break;
	case 35:  //
		$sql = "SELECT * FROM con_buch where S0 = $TAG order by S0,S1,S2";
		echo db2xml($sql,$mode);
		break;
	case 36:  //
		$sql = "SELECT * FROM artefakte where S0 = $TAG order by S0,name";
		echo db2xml($sql,$mode);
		break;
	case 37:  //
		$sql = "SELECT * FROM con_sc where S0 = $TAG order by S0,r_grp,name";
		echo db2xml($sql,$mode);
		break;
	case 38:  //
		$sql = "SELECT * FROM con_anmeldung where tag = $TAG order by id";
		echo db2xml($sql,$mode);
		break;
	case 40:  //
		$sql = "SELECT * FROM mag_list order by grp,stufe,nr";
		echo db2xml($sql,$mode);
		break;
	case 41:  //
		$sql = "SELECT * FROM trank_list order by grp,stufe,nr";
		echo db2xml($sql,$mode);
		break;
	case 42:  //
		$sql = "SELECT * FROM artefakte order by s0, name";
		echo db2xml($sql,$mode);
		break;
	case 43:  //
		$sql = "SELECT * FROM legende order by s0 DESC ,s1,s2";
		echo db2xml($sql,$mode);
		break;
	case 44:  //
		$sql = "SELECT * FROM bib_titel order by bereich,thema,sort,item";
		echo db2xml($sql,$mode);
		break;

	case 50:  // CHAR BASIS
		$sql = "SELECT * FROM char_basis where spieler_id = $spieler_id AND nsc = 'N' order by ID";
		echo db2xml($sql,$mode);
		break;
	case 51:  //  CHAR KOPF
		$sql = "SELECT * FROM char_kopf where char_id = $TAG ";
		echo db2xml($sql,$mode);
		break;
	case 52:  //  CHAR VORTEILE
		$sql = "SELECT * FROM char_vor where char_id = $TAG order by stufe,name";
		echo db2xml($sql,$mode);
		break;
	case 53:  //  CHAR NACHTEILE
		$sql = "SELECT * FROM char_nach where char_id = $TAG order by stufe,name";
		echo db2xml($sql,$mode);
		break;
	case 54:  //  CHAR FERTIGKEITEN
		$sql = "SELECT * FROM char_fert where char_id = $TAG order by stufe,name";
		echo db2xml($sql,$mode);
		break;
	case 55:  //  CHAR WAFFEN
		$sql = "SELECT * FROM char_waf where char_id = $TAG order by KS,name";
		echo db2xml($sql,$mode);
		break;
	case 56:  //  CHAR MAFIE
		$sql = "SELECT * FROM char_mag where char_id = $TAG order by stufe,name";
		echo db2xml($sql,$mode);
		break;
	case 57:  //  CHAR ALCHIMIE / TRAENKE
		$sql = "SELECT * FROM char_trank where char_id = $TAG order by stufe,name";
		echo db2xml($sql,$mode);
		break;
	case 58:  //  CHAR RASSE
		$sql = "SELECT * FROM char_rasse  order by name";
		echo db2xml($sql,$mode);
		break;
	case 59:  //  CHAR TAGE
		$sql = "SELECT * FROM char_tage where char_id = $TAG order by con,name";
		echo db2xml($sql,$mode);
		break;
	case 60:  // NSC BASIS
		$sql = "SELECT * FROM char_basis where  nsc = 'J' order by ID";
		echo db2xml($sql,$mode);
		break;
	case 61:  // CHAR BASIS ALLE
		$sql = "SELECT char_basis.*, concat(spieler.name,',',spieler.vorname ) as spieler_name FROM char_basis left outer join spieler on spieler.id=char_basis.spieler_id where nsc = 'N' order by ID";
		echo db2xml($sql,$mode);
		break;
	case 62:  //  Trankzutaten
		$sql = "SELECT * FROM trank_pflanz_list  order by grp,nr";
		echo db2xml($sql,$mode);
		break;
	case 63:  //
		$sql = "SELECT * FROM mag_list where (grp='NT' OR grp='WM' OR grp='SM' OR grp='DM' or grp='HM' OR grp='PR' OR grp='EL' OR grp='NE'  ) order by grp,stufe,nr";
		echo db2xml($sql,$mode);
		break;
	case 64:  //
		$sql = "SELECT * FROM trank_list order by grp,stufe,nr";
		echo db2xml($sql,$mode);
		break;
	case 99:  // Select mit Parametern
		//      echo "lvl:$user_lvl";
		if ($user_lvl <= 128 )
		{
			if ($name =='user_liste') {
				$name='spieler';
			}
			$data = stripslashes($data);
			$sql = " select * from  $name $data";
			//      echo "SQL = $sql";
			echo db2xml($sql,$mode);
		}
		break;
	default:  //
		//      echo "default cmd: $cmd mode:$mode\r\n";
		$sql = stripslashes($sql);
		//      echo $sql;
		echo db2xml($sql,$mode);
		break;
		endswitch;
		//  include"larp.html";
		exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
		// Code ausgeführt wird. */
}
else
{
	echo "IGNORED cmd: $cmd\r\n";
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
	Code ausgeführt wird. */

}



?>