<?php
/**
 Projekt : LIBRARY

 Datum    :  $date$  / 27.02.2013

 Rev.    :  $rev$   / 1.0

 Author  :  $author$  / krglok

 beschreibung : Libray fuer die Log funktionen
 Beschreibt eine Tabelle und die Daten der LOG-Tabelle
 Erzeugt eine Datenliste zur Anzeige.


 Ver 3.0  / 06.02.2013
 Es werden CSS-Dateien verwendert.
 Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
 Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
 Layoutpfades in der config.inc
 Ansonsten bleibt der Inhalt der Seiten identisch.


 $style = $GLOBALS['style_datalist'];
 echo "<div $style >";
 echo "<!---  DATEN Spalte   --->\n";

 echo '</div>';
 echo "<!---  ENDE DATEN Spalte   --->\n";
 */

include_once '_config.inc';
include_once '_mfd_lib.inc';

define("is_DEBUG", TRUE);


function log_write_info($text)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $user;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME,$db);
	$table = "sys_log";
	$fields ="id, stamp, message, typ,user ";
	$join = ""; //$mfd_list["join"];
	$where ="";
	$order = "";
    if ($user == "") { $user = "gast"; }
	$werte = "message=\"$text\", typ=\"INFO\", user=\"$user\" ";

	$q = "insert INTO $table SET $werte ";

	$result = mysql_query($q,$db) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);
	}
	mysql_close($db);
}


function log_write_error($text)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $user;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME,$db);
	$table = "sys_log";
	$fields ="id, stamp, message, typ,user ";
	$join = ""; //$mfd_list["join"];
	$where ="";
	$order = "";
	if ($user == "") { $user = "gast"; }
	
	$werte = "message=\"$text\", typ=\"ERROR\", user=\"$user\" ";

	$q = "insert INTO $table SET $werte ";

	$result = mysql_query($q,$db) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);
	}
	mysql_close($db);
}

function log_write_debug($text)
{
	if (is_DEBUG == TRUE)
	{
		global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
		global $user;
		$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

		mysql_select_db($DB_NAME,$db);
		$table = "sys_log";
		$fields ="id, stamp, message, typ,user ";
		$join = "";
		$where ="";
		$order = "";
		if ($user == "") { $user = "gast"; }
		
		$werte = "message=\"$text\", typ=\"DEBUG\", user=\"$user\" ";

		$q = "insert INTO $table SET $werte ";

		$result = mysql_query($q,$db) ;
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $q;
			die($message);
		}
		mysql_close($db);
	}
}

/**
 * Liest die log daten anhand der mfd Definition
 * @param unknown $mfd_list
 * @return resource
 */
function log_data_result_mfd($mfd_list)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	//	$mfd_list = get_mfd_list($name);

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$table = $mfd_list["table"];
	$fields = $mfd_list["fields"];
	$join =  $mfd_list["join"];
	$where = $mfd_list["where"];
	$order = $mfd_list["order"];

	$q = "SELECT $fields FROM $table $join where $where  order by $order";

	$result = mysql_query($q) ;
	if (!$result)
	{
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q."\n";
		die($message);
	} else
	{
		return $result;
	}

}

/**
 * Liest die letzten 100 Datensaetze aus der Log Datei
 * @return resource
 */
function log_data_result100($mfd_list)
{

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME,$db);

	$table = $mfd_list["table"];
	$fields = $mfd_list["fields"];
	$join =  $mfd_list["join"];
	$where = $mfd_list["where"];
	$order = $mfd_list["order"];

	$q = "SELECT $fields FROM $table $join where $where  order by $order LIMIT 100 ";

	$result = mysql_query($q,$db) ;
	if (!$result)
	{
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q."\n";
		die($message);
	} else
	{
		return $result;
	}

}

function print_log_filter_button()
{
	echo"<tr>\n";
	echo"<td >";
	echo"</td>\n";

	echo"<td >\n";
	echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"FILTERN\">\n";
	echo"</td>\n";

	echo"<td >\n";
	echo "<INPUT TYPE=\"RESET\" VALUE=\"RESET\">\n";
	echo"</td>\n";

	echo"<td >\n";
	echo"</td>\n";

	echo"<td >\n";
	echo"</td>\n";

	echo"</tr>\n";

}


/**
 * Erstellt eine Eingabe leiste fuer Spaltenfilter
 * @param unknown $mfd_cols
 */
function print_log_filter($mfd_cols)
{
	echo"<tr>\n";
	echo"<td >";
	$width = $mfd_cols[0]['mfd_width'];
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[0]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"\">\n";
	echo"</td>\n";

	echo"<td >\n";
	$width = $mfd_cols[1]['mfd_width'];
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[1]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"\">\n";
	echo"</td>\n";

	echo"<td >\n";
	$width = 100; // $mfd_cols[2]['mfd_width'];
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"\">\n";
	echo"</td>\n";

	echo"<td >\n";
	$width = $mfd_cols[3]['mfd_width'];
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"\">\n";
	echo"</td>\n";

	echo"<td >\n";
	$width = $mfd_cols[4]['mfd_width']/3;
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[4]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"\">\n";
	echo"</td>\n";

	echo"</tr>\n";

}

function 	print_log_data_header($mfd_cols)
{
	echo"<tr>";

	$width = $mfd_cols[0]['mfd_width'];
	echo"<td width=\"$width\">\n";
	echo "<i>".$mfd_cols[0]['mfd_field_titel']."</i>\n";
	echo"</td>\n";

	$width = $mfd_cols[1]['mfd_width'];
	echo"<td width=\"$width\">\n";
	echo "<i>".$mfd_cols[1]['mfd_field_titel']."</i>\n";
	echo"</td>\n";

	$width = 500; //$mfd_cols[2]['mfd_width'];
	echo"<td width=\"$width\">\n";
	echo "<i>".$mfd_cols[2]['mfd_field_titel']."</i>\n";
	echo"</td>\n";

	$width = $mfd_cols[3]['mfd_width'];
	echo"<td width=\"$width\">\n";
	echo "<i>".$mfd_cols[3]['mfd_field_titel']."</i>\n";
	echo"</td>\n";

	$width = $mfd_cols[4]['mfd_width'];
	echo"<td width=\"$width\">\n";
	echo "<i>".$mfd_cols[4]['mfd_field_titel']."</i>\n";
	echo"</td>\n";

	echo"</tr>\n";

}


/**
 * Erzeugt eine tabelle row (tr) fuer eine Log liste
 * @param unknown $row
 */
function print_log_zeile($row)
{
	echo"<tr>\n";
	echo"<td >";
	echo "".$row[0]."";
	echo"</td>\n";

	echo"<td >\n";
	echo "".$row[1]."";
	echo"</td>\n";

	echo"<td >\n";
	echo "".$row[2]."";
	echo"</td>\n";

	echo"<td >\n";
	echo "".$row[3]."";
	echo"</td>\n";

	echo"<td >\n";
	echo "".$row[4]."";
	echo"</td>\n";

	echo"</tr>\n";

}

function print_log_data($result,$ID)
{
	global $PHP_SELF;

	$next = 10;
	$table = "sys_log";
	$mfd_name = "Log-Liste";
	$mfd_cols = make_mfd_cols_default($table, $mfd_name);


	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";

	echo"<table>\n";
	echo"<tbody>\n";

	print_log_filter_button();

	print_log_data_header($mfd_cols);
	
	print_log_filter($mfd_cols);

	while ($row = mysql_fetch_row($result))
	{
	  print_log_zeile($row);
	}
	
	echo"</form>\n";
	
	echo"</tbody>\n";
	echo"</table>\n";

}


?>