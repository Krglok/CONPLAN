<?php
	
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
	
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
	
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
	echo "<div $style style=\" background:url(layout/back/paper.jpg)\">";
	echo "<!---  DATEN Spalte   --->\n";
	
	echo "\t<td > \n";
	echo "\t</td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	echo "\t<td width=50></td>\n";
	
	echo "<!---  ENDE DATEN Spalte   --->\n";
	
	
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
$anrede["name"] = $spieler_name;

