<?php

/*
 Projekt : ADMIN

Datei   :  admin_con.php,v $

Datum   :  2002/06/01

Rev.    :  3.0

Author  :  Olaf Duda

beschreibung :
Ueber das Script wird der Interne Teil der HP abgewickelt.
Es wird eine Session Verwaltung benutzt, die den User prueft.
Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
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


$Log: conadmin.php,v $
Revision 1.4  2002/06/01 10:40:00  windu
Erweiterung um bilder_admin

Revision 1.3  2002/05/30 07:22:21  windu
ADmin-Funktion für
Einbringen des Aktuellen Con-Tages
mit neuer Tabelle con_konst

Revision 1.2  2002/05/24 13:11:52  windu
neue icons im menü

Revision 1.1  2002/05/03 20:23:41  windu
Umstellung auf Session Managment.
PHP3 -File geloescht

Revision 1.4  2002/03/09 18:28:52  windu
Korrekturen und Aufteilung in LIB.INC

Revision 1.3  2002/02/26 18:42:40  windu
keyword aktiviert

Ver 3.0  / 06.02.2013
Es werden CSS-Dateien verwendert.
Es wird eine strikte Trennung von Content und Layout durchgefuehrt.
Es gibt die Moeglichkeit das Layout zu aendern durch setzen eins neues
Layoutpfades in der config.inc
Ansonsten bleibt der Inhalt der Seiten identisch.

$style = $GLOBALS['style_datalist'];
echo "<div $style >";
echo "<!--  DATEN Spalte   -->\n";

echo '</div>';
echo "<!--  ENDE DATEN Spalte   -->\n";

*/

include_once "_config.inc";
include_once "_lib.inc";
include_once "_head.inc";
include_once '_mfd_lib.inc';


//-----------------------------------------------------------------------------
function print_liste($mfd_list,$ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TAG;

//  $mfd_list['mfd'] = $mfd_name;
	$table =  $mfd_list['table'];
//  $mfd_list['titel'] = $table;
  $mfd_list['fields'] = $mfd_list['fields'].", con_tage.bemerkung,  spieler.name, spieler.vorname";
  $mfd_list['join'] =   
  " left outer join con_tage on con_tage.tag=$table.tag "
  ." left outer join user_liste on user_liste.id=$table.user_id "
  ." left outer join spieler on spieler.id=user_liste.spieler_id ";
  
  $mfd_list['where'] = "$table.id > 0 and $table.user_id >0";
  $mfd_list['order'] = " tag DESC , $table.user_id";
  
//   $q = "select $TABLE.* , con_tage.bemerkung,  spieler.name, spieler.vorname  from $TABLE "
//   ." left outer join con_tage on con_tage.tag=$TABLE.tag "
//   ." left outer join user_liste on user_liste.id=$TABLE.user_id "
//   ." left outer join spieler on spieler.id=user_liste.spieler_id "
//       ." order by tag DESC , user_id";

  $result = mfd_data_result($mfd_list);

  $akt_tag = get_akttag();

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "<table>\n";

  //Kopfzeile
  echo "<tr>";
  echo "<td colspan=3>";
  echo "Aktueller Con\n";
  echo "</td>";
  echo "<td>";
  echo "$akt_tag";
  echo "</td>";
  echo "</tr>";
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
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
        echo "\t<td><a href=\"$PHP_SELF?md=".mfd_edit."&ID=$ID&id=$row[$i]&TAG=$TAG\">\n";
        print_menu_icon ("_tcheck","Datensatz bearbeiten");
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td>$row[$i]&nbsp;</td>\n";
      };
    }
    echo "\t<td><a href=\"$PHP_SELF?md=".mfd_del."&ID=$ID&id=$row[0]&TAG=$TAG\">\n";
    print_menu_icon ("_tdelete","Datensatz löschen (Achtung! nicht reversibel!");
    echo "\t</a></td>\n";
    echo "<tr>";
  }
  echo "</table>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";


};

//-----------------------------------------------------------------------------
function tage_liste($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TABLE1;

  $TAG   = get_akttag();

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $q = "select * from con_tage where substring(von,1,4)>\"0000\" order by tag DESC";
  $result = mysql_query($q)  or die("Query Fehler...");

  mysql_close($db);

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "<table>\n";

  //Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result)-1;
  for ($i=1; $i<$field_num-1; $i++)
  {
    echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
  };
  echo "</tr>\n";
  //Liste der Datensätze
  while ($row = mysql_fetch_row($result))
  {
    echo "<tr>";
    for ($i=1; $i<$field_num-1; $i++)
    {
      if ($row[1]==$TAG)
      {
        $bgcolor="silver";
      } else
      {
        $bgcolor="";
      }

      // aufruf der Deateildaten
      switch ($i):
      case 0 :
        echo "\t<td width=\"30\"> \n";
      //print_menu_icon (9);
      echo "\t</a></td>\n";
      break;
      case 1:
        echo "\t<td width=\"20\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 2:
        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 3:
        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 4:
        echo "\t<td width=\"30\" align=RIGHT  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 5:
        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 6:
        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      case 7:
        if ($row[1]==$TAG)
        {
          echo "\t<td width=\"250\" bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        } else
        {
          echo "\t<td width=\"250\" bgcolor=\"$bgcolor\" >$row[$i]&nbsp;</td>\n";
        }
        break;
      case 8:
        //        echo "\t<td width=\"80\"  bgcolor=\"$bgcolor\">$row[$i]&nbsp;</td>\n";
        break;
      default :
        endswitch;
    };
    	
    echo "<tr>";
  }
  echo "</table>";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

};


function print_con_erf($ID,$user_id)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $TAG;
  global $PHP_SELF;
  
  $id = 0;
  $next = mfd_insert;
	$table = "con_konst";
	$mfd_list = make_mfd_table($table, $table);
	$mfd_list["where"]	= "id = $id ";
	
	$result = mfd_data_result($mfd_list);
  
  $row = mysql_fetch_array ($result);
  $field_num = mysql_num_fields($result);
  	//  echo count($row);
  	/**/
  	if (count($row)==1)  // ergebnis ist leer = ERFASSEN
  	{
  		for ($i=0; $i<$field_num; $i++)
  		{
  		$row[$i] = "";
  		};
  		$row[2] = $user_id;
  	};
//
  	$style = $GLOBALS['style_datatab'];
  	echo "<div $style >";
  	echo "<!--  DATEN Spalte   -->\n";
  	
	$id=0;
 	$next = mfd_insert;
 	$daten = "";
 	$mfd_cols = make_mfd_cols_default($mfd_list["table"], $mfd_list["table"]);
 	print_mfd_maske($mfd_list, $row, $id, $next, $ID, $mfd_cols, false, $daten);
 	
 	echo '</div>';
 	echo "<!--  ENDE DATEN Spalte   -->\n";
 	
}

function print_con_edit($id,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TAG;
	global $PHP_SELF;
	
	$next = mfd_update;
	$table = "con_konst";
	$mfd_list = make_mfd_table($table, $table);
	$mfd_list["where"]	= "id = $id ";
	
	$result = mfd_data_result($mfd_list);
	//
	$row = mysql_fetch_array ($result);
	
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
	$next = mfd_update;
	$daten = "";
	$mfd_cols = make_mfd_cols_default($mfd_list["table"], $mfd_list["table"]);
	print_mfd_maske($mfd_list, $row, $id, $next, $ID, $mfd_cols, false, $daten);

	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
}


function print_con_del($id,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TAG;
	global $PHP_SELF;

	$next = mfd_delete;
	$table = "con_konst";
	$mfd_list = make_mfd_table($table, $table);
	$mfd_list["where"]	= "id = $id ";

	$result = mfd_data_result($mfd_list);
	//
	$row = mysql_fetch_array ($result);
	
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";
	
	$next = mfd_delete;
  $daten = "";
	$mfd_cols = make_mfd_cols_default($mfd_list["table"], $mfd_list["table"]);
	print_mfd_maske($mfd_list, $row, $id, $next, $ID, $mfd_cols, false, $daten);
	
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
}


function print_con_info($id,$ID)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $TAG;
	global $PHP_SELF;

	$next = 0;
	$table = "con_konst";
	$mfd_list = make_mfd_table($table, $table);
	$mfd_list["where"]	= "id = $id ";

	$result = mfd_data_result($mfd_list);
	//
	$row = mysql_fetch_array ($result);

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	$next = 0;
  $daten = "";
	$mfd_cols = make_mfd_cols_default($mfd_list["table"], $mfd_list["table"]);
	print_mfd_maske($mfd_list, $row, $id, $next, $ID, $mfd_cols, true, $daten);
	
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";
	
}


function print_auswahl($ID)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
  global $PHP_SELF;
  global $TABLE;
  global $TAG;


  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $q = "select s.id,s.name,s.vorname,u.username,u.id from spieler as s, user_liste as u where s.id=u.spieler_id order by s.name, s.vorname";
  $result = mysql_query($q)  or die("Query Fehler...");

  mysql_close($db);

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";
  
  echo "<table >\n";

  //Kopfzeile
  echo "<tr>\n";
  $field_num = mysql_num_fields($result);
  for ($i=0; $i<$field_num; $i++)
  {
    echo "\t<td><b>".mysql_field_name($result,$i)."</b></td>\n";
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
        echo "\t<td><a href=\"$PHP_SELF?md=".mfd_add."&ID=$ID&daten=$row[4]\">\n";
        print_menu_icon ("_db","Auswahl des Datensatzes !");
        echo "\t</a></td>\n";
      } else
      {
        echo "\t<td>$row[$i]&nbsp;</td>\n";
      };
    }
    echo "<tr>";
  }
  echo "</table>";
  
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
  
};

function get_menu_con_tage($md, $PHP_SELF, $ID, $titel, $id, $daten, $sub, $home)
{
	switch ($md):
	case mfd_add: // Erfassen eines neuen Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "CON SL","link" => ""),
		  1=>array("icon" => "1","caption" => "NEU","link" => ""),
		  2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
	case mfd_info: // Ansehen / INFO eines Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "CON SL","link" => ""),
		1=>array("icon" => "1","caption" => "ANSEHEN","link" => ""),
		8=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
	case mfd_del: // Delete eines bestehenden Datensatzes
		$menu = array (0=>array("icon" => "7","caption" => "CON SL","link" => ""),
		1=>array("icon" => "1","caption" => "LÖSCHEN","link" => ""),
		9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID&")
		);
		break;
	case mfd_edit: // Anzigen Bearbeiten Form
		$menu = array (0=>array("icon" => "7","caption" => "CON SL","link" => ""),
		1=>array("icon" => "1","caption" => "BEAREBEITEN","link" => ""),
		2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
	case 8: // Anzigen Bearbeiten Form
		$menu = array (0=>array("icon" => "7","caption" => "CON-TAG","link" => ""),
		1=>array("icon" => "1","caption" => "SETZEN","link" => ""),
		2=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
	case mfd_auswahl:  // MAIN-Menu
		$menu = array (0=>array("icon" => "7","caption" => "USER","link" => ""),
		1=>array("icon" => "0","caption" => "AUSWAHL","link" => ""),
		9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
	
		break;
	case mfd_list:  // MAIN-Menu
		$menu = array (0=>array("icon" => "99","caption" => "CON-SL","link" => ""),
		9=>array("icon" => "_stop","caption" => "Zurück","link" => "$PHP_SELF?md=0&ID=$ID")
		);
		break;
	default:  // MAIN-Menu
		$menu = array (0=>array("icon" => "99","caption" => "CON-SL","link" => ""),
		1=>array("icon" => "_add","caption" => "Erfassen","link" => "$PHP_SELF?md=".mfd_add."&ID=$ID"),
		3=>array("icon" => "_db","caption" => "CON-Tag setzen ","link" => "$PHP_SELF?md=8&ID=$ID&id=1"),
		4=>array("icon" => "_list","caption" => "CON-Liste","link" => "$PHP_SELF?md=".mfd_list."&ID=$ID&id=0"),
		9=>array("icon" => "_stop","caption" => "Zurück","link" => "admin_main.php?md=0&ID=$ID")
		);
		break;
		endswitch;
		
	return $menu;	
}

// ---------------------------------------------------------------
// ---------    MAIN ---------------------------------------------
// ----------------------------------------------------------------
// keinerlei Ausgabe vor  der header() Zeile !!!!!!!!!!!!!!!!!!!!!
// ----------------------------------------------------------------
// Prüfung ob User  berechtigt ist

	$BEREICH = 'ADMIN';
	
	$md     = GET_md(0);
	$id     = GET_id(0);
	$sub    = GET_sub("");
	$daten  = GET_daten("");
	
	$ID     = GET_SESSIONID("");
	$p_md   = POST_md(0);
	$p_id 	= POST_id(0);
	$p_row 	= POST_row("");
	
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
	  // Code ausgeführt wird.
	}
	
	if (is_admin()==FALSE)
	{
	  $session_id = 'FFFF';
	  header ("Location: main.php");  // Umleitung des Browsers
	  exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
	  // Code ausgeführt wird.
	}
	
	
	print_header("Admin Bereich");
	
	print_body(2);
	
	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";
	
	
	$spieler_name = get_spieler($spieler_id); //Auserwählter\n";
	
	$menu_item = $menu_item_help;
	$anrede["name"] = $spieler_name;
	$anrede["formel"] = "Sei gegrüsst Meister ";
	
	print_kopf($admin_typ,$header_typ,"Admin Bereich",$anrede,$menu_item);

	$ref_mfd = "con_konst";
	$mfd_list = make_mfd_table($ref_mfd, $ref_mfd);
	
	switch ($p_md):
	case mfd_insert: // Anlegen eines neuen des DAtensatzes
	  mfd_insert($mfd_list, $p_row);
		$md=0;
		break;
	case mfd_update: // Update eines bestehnden Datensatzes
	 	mfd_update($mfd_list, $p_row);
	  $md=0;
	  break;
	case mfd_delete:
		mfd_delete($mfd_list, $id);
		$md=0;
		break;
	default:  // MAIN-Menu
	endswitch;
		
	$home = "admin_main.php";
	
	$menu = get_menu_con_tage($md, $PHP_SELF, $ID, "", $id, $daten, $sub, $home);

	switch ($md):
	case mfd_add:
		print_menu_status($menu);
		print_con_erf($ID, $daten);
		break;
	case mfd_del:
	  //
		print_menu_status($menu);
		print_con_del($id, $ID);
	  break;
	case mfd_edit:
	  //
		print_menu_status($menu);
		print_con_edit($id,$ID);
	  break;
	case 8:
	  //
		print_menu_status($menu);
		print_con_edit($id,$ID);
	  break;
	  case mfd_auswahl:
	  // Neue CON SL
		print_menu_status($menu);
	  print_auswahl($ID);
	  break;
	case mfd_list:
	  //
		print_menu_status($menu);
		tage_liste($ID);
	  break;
	default:
	  print_menu($menu);
		print_liste($mfd_list,$ID);
	break;
	endswitch;
	
	print_body_ende();

?>
