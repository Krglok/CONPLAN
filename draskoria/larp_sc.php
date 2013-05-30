<?php

/*
 Projekt : LARP

Datei   :  $RCSfile: sc_liste.php,v $

Datum   :  $Date: 2002/02/26 18:42:41 $  /

Rev.    :  $Revision: 1.3 $   / 1.0

Author  :  $Author: windu $  / duda

beschreibung :
Ueber das Script wird der Interne Teil der SC liste abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.

Es werden HTML Seiten angezeigt.
Die HTML Seiten befinden sich im verzeichnis

./

Die images kommen aus dem Verzeichnis

./images

Die HTML Seiten werden mit der Funktion

function print_data($html_file)

dargestellt.

Die zugehoerigen HTML Seiten sollten in einem Subdir sein 2)
Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)

Die Uebergabe Parameter werden aus den $_GET, $_POST
Variablen geholt.

1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
eine Wiederverwendung nicht moeglich ist.
Die Include zeigen dann auf ein falsches Verzeichnis !

2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
notwendig.
Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
nicht wieder zusammen.



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

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";


/**
 * Erstellt eine Spielerliste
 * @param unknown $ID
 */
function print_sp_liste($id)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  //Macht aus einem Resultset eine HTML Tabelle


  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);

  $result = mysql_query("SELECT id,name,vorname,charakter,email,telefon from spieler where (name <> \"XX\" and  name <> \"??\")")
  or die("Query Fehler...");

  mysql_close($db);

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "<table >\n";

  //Header
  $field_num = mysql_num_fields($result);

  echo "<tr>\n";
  echo "\t<td><b>ID</b></td>\n";
  echo "\t<td><b>Name</b></td>\n";
  echo "\t<td><b>Vorname</b></td>\n";
  echo "\t<td><b>Charakter</b></td>\n";
  echo "\t<td><b>email</b></td>\n";
  echo "\t<td><b>Telefon</b></td>\n";
  echo "</tr>\n";

  //Daten
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    for ($i=0; $i<$field_num; $i++)
    {
      if ($i==0)
      {
        if($id==$row[0])
        {
          echo "<td>\n";
          print_menu_icon("_con_sc","Dein eigener Eintrag");
          echo "</td>\n";
        }else
        {
          echo "\t<td>&nbsp;</td>\n";
        }
      }elseif ($i==4)
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
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

};

/**
 * Erstellt eine Detailmaske fuer die Spieler daten
 * @param unknown $user
 * @param unknown $ID
 */
function print_spieler_edit($id,$ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  // DAtenbank zugriff
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

//   $q = "select spieler_id,id,username from user_liste where id=\"$id\"";
//   $result = mysql_query($q) or die("select Fehler....$q.");
//   $row = mysql_fetch_row($result);
//   $spieler_id=$row[0];
  //  echo "$user/$id/$result\n";

  $q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$id\" ";
  $result = mysql_query($q) or die("select Fehler....$q.");

  mysql_close($db);

  $row = mysql_fetch_row($result);
  
  //  Daten
  //
  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  //  FORMULAR
  echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

  echo "<table >\n";
  echo "Bearbeiten <b>deine</b> Spieler Daten\n";

  echo "<tr>\n";
  echo "\t<td WIDTH=\"75\"></td>\n"; //<b>ID</b>
  echo "<td> &nbsp; </td>\n"; //$user_id &nbsp;/ $id
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Name</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[1]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[1]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Vorname</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[2]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Charakter</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[3]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[3]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>email</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[4]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[4]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Telefon</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[5]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[5]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Geburtstag</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[6]\" SIZE=10 MAXLENGTH=10 VALUE=\"$row[6]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td><b>Bemerkung</b></td>\n";
  echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[7]\" SIZE=30 MAXLENGTH=30 VALUE=\"$row[7]\">&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td></td>\n";
  echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
      </td>\n";
  echo "</tr>\n";
  echo "</table>\n";
  echo "</FORM>\n";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
}

/**
 * macht datenbank Update fuer Spieler
 * @param unknown $id
 * @param unknown $ow  , datensatz als array
 */
function update_sc($id,$row)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);
  //	$q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";

  $q ="update spieler SET name=\"".$row[1]."\",vorname=\"".$row[2]."\",
      charakter=\"".$row[3]."\",email=\"".$row[4]."\",telefon=\"".$row[5]."\",
      geb=\"".$row[6]."\",bemerkung=\"".$row[7]."\" where id=$id";
  $result = mysql_query($q) or die("UPDATE Fehler....$q.");
  mysql_close($db);

}

/**
 * Erstellt eine Detailmaske fuer den UserUpdate , Passweort aendern
 * @param unknown $user
 * @param unknown $ID
 */
function print_user_edit($id,$ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);

  $q = "select spieler_id,id,username from user_liste where id=\"$id\"";
  $result = mysql_query($q) or die("select Fehler....$q.");
  $row = mysql_fetch_row($result);
  $user_id=$row[0];
  $user = $row[2];

  $q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$user_id\" ";
  $result_1 = mysql_query($q) or die("select Fehler....$q.");

  mysql_close($db);
  //  Daten
  //
  $sp_row = mysql_fetch_row($result_1);

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  //  FORMULAR
  echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"5\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">\n";

  //	echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

  echo "<table  >\n";
  echo "<CAPTION>Bearbeiten <b>deine</b> User Daten</CAPTION>\n";
  echo "<tr>";
  echo "  \t<td><b>Username</b></td>\n";
  echo "  <td><INPUT TYPE=\"TEXT\" NAME=\"row[2]\" SIZE=30 MAXLENGTH=30 VALUE=\"$user\">&nbsp;</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "  \t<td><b>Paswort alt</b></td>\n";
  echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"row[3]\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "  \t<td><b>Passwort neu</b></td>\n";
  echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"row[4]\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "  \t<td><b>Kontrolle</b></td>\n";
  echo "  <td><INPUT TYPE=\"PASSWORD\" NAME=\"row[5]\" SIZE=30 MAXLENGTH=30 VALUE=\"\">&nbsp;</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "\t<td></td>\n";
  echo "<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
      </td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "</tr>";
  echo "<tr>";
  echo "</tr>";
  echo "<tr>";
  echo "\t<td><b>Spielername</b></td>\n";
  echo "<td>&nbsp;$sp_row[1]</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "\t<td><b>Vorname</b></td>\n";
  echo "<td>&nbsp;$sp_row[2]</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "\t<td><b>Charakter</b></td>\n";
  echo "<td>&nbsp;$sp_row[3]</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "\t<td><b>email</b></td>\n";
  echo "<td>&nbsp;$sp_row[4]</td>\n";
  echo "</tr>";
  echo "<tr>";
  echo "</tr>";
  echo "</table>";
  echo "</FORM>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

}

/**
 * Erstellt Datenbank Update fuer user
 * @param unknown $user
 * @param unknown $id
 * @param unknown $username
 * @param unknown $alt_pw
 * @param unknown $pw_1
 * @param unknown $pw_2
 * @return string
 */
function update_user($id,$row)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME) ;

  $username = $row[2];
  $alt_pw   = $row[3];
  $pw_1     = $row[4];
  $pw_2     = $row[5];

  $q = "select pword from user_liste where username=\"$user\"";
  $result = mysql_query($q) or die("select Fehler....$q.");
  $row = mysql_fetch_row($result);
  $check = $row[0];

  // passwort codieren
  $q = "select old_password(\"$alt_pw\");";
  $result = mysql_query($q) or die($q);
  $row = mysql_fetch_row($result) ;
  //  echo "$row[0] / $check";  // nur zum testen !!

  if ($check==$row[0])
  {
    if ($pw_1==$pw_2)
    {
      $q ="update user_liste SET username=\"$username\",pword=old_Password(\"$pw_1\") where id=\"$id\"";
      $result = mysql_query($q) or die("Update Fehler....$q.");
      $err = "Daten gespeichert";
    } else
    {
      $err = "Passwort ungleich  Kontrolle / Datensatz nicht gespeichert";
    };
  } else
  {
    $err = "Passwort falsch Datensatz nicht gespeichert";
  };
  mysql_close($db);
  return $err;
}


// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
$BEREICH = 'INTERN';


$p_md    = POST_md(0);
$p_row   = POST_row("");
$p_id    = POST_id(0);

// $p_id					= $_POST['id'];
// $p_name				= $_POST['name'];
// $p_vorname		= $_POST['vorname'];
// $p_charakter	= $_POST['charakter'];
// $p_email			= $_POST['email'];
// $p_telefon		= $_POST['telefon'];
// $p_geb				= $_POST['geb'];
// $p_bemerkung	= $_POST['bemerkung'];

// $p_username		= $_POST['username'];
// $p_alt_pw			= $_POST['alt_pw'];
// $p_pw_1				= $_POST['pw_1'];
// $p_pw_2				= $_POST['pw_2'];


$md     = GET_md(0);
$daten  = GET_daten("");
$sub    = GET_sub("main");
$item   = GET_item("");
$ID     = GET_SESSIONID("");

session_id ($ID);
session_start();
$user       = $_SESSION["user"];
$user_lvl   = $_SESSION["user_lvl"];
$spieler_id = $_SESSION["spieler_id"];
$user_id 	= $_SESSION["user_id"];
$SID        = $_SESSION["ID"];

if ($ID != $SID)
{
  header ("Location: main.php?md=0&ID=$ID");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

if (is_user()==FALSE)
{
  header ("Location: larp.php");  // Umleitung des Browsers
  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
  // Code ausgeführt wird.
}

/// Datenbank Funktion  mit reload , um F5 (refresh) zu unterdruecken
switch ($p_md):
case 3:
  update_sc($p_id,$p_row);
  $md = 0;
  break;
case 5:
  update_user($p_id,$p_row);
  $md = 0;
  break;
default:
  break;
  endswitch;

print_header("Interner Bereich");
print_body(2);

$spieler_name = get_spieler($spieler_id); //Auserwählter\n";

$menu_item = $menu_item_help;
$anrede["name"] = $spieler_name;

print_kopf($logo_typ,$header_typ,"Intern",$anrede,$menu_item);

if ($user=="gast")
{
  $md=1;
  $p_md=0;
};


  switch ($md):
case 2:
  $menu = array (0=>array("icon" => "1","caption" => "BEARBEITEN","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
  );
  break;
case 4:
  $menu = array (0=>array("icon" => "1","caption" => "USER","link" => ""),
  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=1&ID=$ID")
  );
  break;
default:
    $menu = array (0=>array("icon" => "1","caption" => "SPIELER","link" => ""),
        1=>array("icon" => "_tcheck","caption" => "Spieler","link" => "$PHP_SELF?md=2&ID=$ID"),
        2=>array("icon" => "_tcheck","caption" => "User","link" => "$PHP_SELF?md=4&ID=$ID"),
        3=>array("icon" => "_stop","caption" => "Zurück","link" => "larp.php?md=0&ID=$ID")
    );
    break;
  endswitch;

  print_menu_status($menu);

  switch ($md):
case 2:
    // es werden die Id aus der Session verwendet
    print_spieler_edit($spieler_id,$ID);
  break;
case 4:
  // es werden die Id aus der Session verwendet
  print_user_edit($user_id,$ID);
  break;
default:
  print_sp_liste($spieler_id);
  break;
  endswitch;

  print_md_ende();


  ?>