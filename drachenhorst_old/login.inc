<?php
/*
 Projekt : CONPLAN

Datei   :

Datum   :  $date$  / 05.01.02

Rev.    :   $rev$   / 1.0

Author  :  $author$  / duda

beschreibung :

$LOG$
*/

//include "config.inc";

function getuser($user)
{
	/*
	 Die Funktion liest den User und sezt den Zugrifflevel
	$user_lvl
	Damit werden in den Menüs bestimmte Punkte freigeschaltet
	Die Paswortprüfung ist nicht notwendig,
	weil ein Sessionmanagment verwendt wird.
	*/
	global $DB_HOST,$DB_USER,$DB_PASS,$DB_INTERN,$TBL_USER;
	global $user_lvl;      // Globale Userstatus für Zugriff
	global $spieler_id;    // Globale Spieler_id zum Identifizieren

	if ($user!='')  // kein Zugriff ohne User
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die( "Fehler beim Verbinden".$DB_HOST."-".$DB_USER."-".$DB_PASS);

		mysql_select_db($DB_INTERN);
		$Q = "select username,pword,lvl,spieler_id from $TBL_USER where username=\"$user\"";
		$result = mysql_query($Q)
		or die( "Fehler ".$DB_NAME." query ".$Q);
		$row = mysql_fetch_row($result);


		if ($row[0] == $user)
		{
			return "TRUE";
		}
		else
		{
			//      echo "FALSE_PW";
			return "FALSE";
		}
	}
	else
	{
		//    echo "FALSE_L";
		return "FALSE";
	}
}

function checkuser($user, $pw)
{
	/*
	 Die Funktion prüft die übergebenen  Daten
	$user
	$pw
	gegen die Userdatennbank
	und gibt TRUE zurück
	*/
	global $DB_HOST,$DB_USER,$DB_PASS,$DB_INTERN,$TBL_USER;

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
			$q = "select old_password(\"$pw\");";
			$result = mysql_query($q) or die("PW: $q");
			$row = mysql_fetch_row($result) ;
			//     echo ">$row[0] / $check";
			if ($row[0] == $check)
			{
				session_start ($ID);

				$_SESSION[user]         = $user;
				$_SESSION[user_id]      = $user_id;
				$_SESSION[user_lvl]     = $user_lvl;     // Setzen globale Userstatus
				$_SESSION[spieler_id]   = $spieler_id;   // Setzen globale Spieler_ID
				return "TRUE";
			} else
			{
				return "FALSE";
			};
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


?>