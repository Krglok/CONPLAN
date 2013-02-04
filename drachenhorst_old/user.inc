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

include "config.inc";

function getuser($user, $pw)
{

	global $DB_HOST,$DB_USER,$DB_PASS,$DB_INTERN,$TBL_USER;
	global $user_lvl;

	if ($user!='')
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die( "Fehler beim Verbinden".$DB_HOST."-".$DB_USER."-".$DB_PASS);

		mysql_select_db($DB_INTERN);
		$Q = "select username,pword,lvl from $TBL_USER where username=\"$user\"";
		$result = mysql_query($Q)
		or die( "Fehler ".$DB_NAME." query ".$Q);
		$row = mysql_fetch_row($result);
		$check = $row[1];
		$user_lvl = $row[2];
		if ($row[0] == $user)
		{
			$q = "select password(\"$pw\");";
			$result = mysql_query($q) or die("PW: $q");
			$row = mysql_fetch_row($result) ;
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

function checkuser($user, $pw)
{

	global $DB_HOST,$DB_USER,$DB_PASS,$DB_INTERN,$TBL_USER;
	global $user_lvl;

	if ($user!='')
	{
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
		or die( "Fehler beim Verbinden".$DB_HOST."-".$DB_USER."-".$DB_PASS);

		mysql_select_db($DB_INTERN);
		$Q = "select username,pword,lvl from $TBL_USER where username=\"$user\"";
		$result = mysql_query($Q)
		or die( "Fehler ".$DB_NAME." query ".$Q);
		$row = mysql_fetch_row($result);
		$check = $row[1];
		$user_lvl = $row[2];
		if ($row[0] == $user)
		{
			$q = "select password(\"$pw\");";
			$result = mysql_query($q) or die("PW: $q");
			$row = mysql_fetch_row($result) ;
			//     echo ">$row[0] / $check";
			if ($row[0] == $check)
			{
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