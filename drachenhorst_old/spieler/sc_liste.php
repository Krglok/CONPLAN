<?
/*
 Projekt : CONPLAN

Datei   :  sc_liste.php3 (PUBLIC)

Datum   :  $date$  / 11.01.02

Rev.    :   $rev$   / 1.0

Author  :  $author$  / duda

beschreibung :  Liste der Spieler im PUBLIC Bereich

$LOG$
*/
include "../larp/config.inc";

echo "<html>\n";
echo "<head>\n";
echo"  <style><!--
		.header {background-color: #C0C0C0;}
		.th,td {vertical-align: top; font: 11pt \"ocr a extended\" \"Comic Sans MS\" color=\"yellow\"}
		//--></style>\n";
echo "</head>\n";
echo "<body TEXT=\"yellow\" LINK=\"yellow\" ALINK=\"red\" VLINK=\"yellow\" BORDER=\"1\"  BORDERCOLOR=\"orange\" BACKGROUND=\"../images/Backgreen.jpg\">\n";
echo "<table WIDTH=\"100%\">\n";

$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
mysql_select_db($DB_NAME) ;

$result = mysql_query("SELECT name,vorname,orga,charakter,email from spieler")
or die("Query Fehler...");


mysql_close($db);

$field_num = mysql_num_fields($result);
echo "<tr>\n";
echo "\t<td><b>Name</b></td>\n";
echo "\t<td><b>Vorname</b></td>\n";
echo "\t<td><b>Orga</b></td>\n";
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
echo "</body>\n";
echo "</html>\n";
?>