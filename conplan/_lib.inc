<?php

/*
 Projekt :  INTERN

Datum   :  $date$  / 03.02.2013

Rev.    :  $rev$   / 3.0

Author  :  $author$  / krglok

beschreibung :
Enthält allgemiengültige Funktionen
Für alle Bereiche
Spieler
SL
ADMIN

function print_menu_icon ($typ)
function print_menu_ref($caption, $ref)
function print_menu_item($item)
function print_menu ($menu)

function print_head_icon ($typ)

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

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";

	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";


*/

//include_once '_config.inc';


function print_textblock($text)
{
  
  $line = explode('\n', $text);
  foreach ($line as $s)
  {
    echo $s."\n"; 
  } 
}

/**
 * Macht einen normale Datumsanzeige
 * @param unknown $datum
 */
function print_datum($datum)
{
  $test = new DateTime($datum);
  return date_format($test, 'd-m-Y');
}

/**
 * Ausgabe eines Menu_icon anhand des default style
 * Fehlerbehandlung, [X] wird ausgegeben 
 * @param unknown $typ
 * @param string $info
 */
function print_menu_icon ($typ,$info = "xx")
{
  // convert int to string of icon type  
  //$typ = index2menutyp($typ);
  $icon = $GLOBALS['layoutButton_path'].$typ.".gif";
//  echo $icon;
  if ($typ != "") 
  {
  	echo "\t<IMG SRC=\"$icon\"  ALT=\"$info\" TITLE=\"$info\">";
  } else {
  	echo "\t[X]"; // Leerzeile
  }
};

/**
 * Erzeugt einen Linkentrag mit default style
 * @param unknown $caption  sichtbarer text
 * @param unknown $ref  linkdaten, voll qualifiziert
 */
function print_menu_ref($caption, $ref)
{
  echo "            <A HREF=\"$ref\" > ";
  echo "            $caption ";
  echo "            </A>\n";
};

function print_menu_item($item)
{
  global $PHP_SELF;
  
  $caption = $item["caption"];
  $link=$item["link"];
//  $ref = $link;
  // Reftyp zusammenbauen
  if (isset($item["itemtyp"])==false)
  {
    $item["itemtyp"] = "0";
  }
  $itemtyp = $item["itemtyp"];
  //echo "$itemtyp";
  if ($itemtyp == "0")
  {
    $ref = $link;
    
  } elseif ($itemtyp == "1")
  {
    $ref = "main_pages.php?md=0&daten=$link";
    
  } elseif ($itemtyp == "2")
  {
    $ref = "$PHP_SELF?md=2&daten=$link";
    
  }  elseif ($itemtyp = "100")
  {
    $ref = "$PHP_SELF?md=$itemtyp&daten=$link";
    
  } elseif ($itemtyp = "101")
  {
    $ref = "$PHP_SELF?md=$itemtyp&daten=$link";
    
  } else 
  {
    $ref="";
//    echo "$ref";
  }
  if ($item["icon"] != "0")
  {
    echo "          <p>  \n";
    echo "            <a HREF=\"$ref\" > ";
    print_menu_icon($item["icon"]);
    echo "            $caption ";
    echo "            </a>\n";
    echo "          </p>  \n";
  } else 
  {
    echo "          <p>  \n";
    echo "\t\t<hr> \n";
    echo "          </p>  \n";
  }

}

/**
 * Erzeugt ein Menu mit default style
 * @param unknown $menu  array mit menu daten
 */
function print_menu ($menu)
{
  global $ID;
  $menu_item_subsl= array ("icon" => "_tool","caption" => "Planung","link" => "con_plan.php?md=0&ID=$ID","itemtyp"=>"0");
  $menu_item_sl 	= array ("icon" => "_tool","caption" => "SL","link" => "con_main.php?md=0&ID=$ID","itemtyp"=>"0");
  $menu_item_admin= array ("icon" => "_tool","caption" => "Admin","link" => "admin_main.php?md=0&ID=$ID","itemtyp"=>"0");
    
  //   menü spalte
  echo "<!---  Menu Spalte   --->\n";
  //  stellt die breite der Menüspalte ein !!!
  $style = $GLOBALS['style_menu_tab1'];
  echo "<div $style >\n";

  //  separate div pro Menu item
  //   $style = $GLOBALS['style_menu_head'];
  //   echo "\t<div  ><!-- Row:1, Col:1 -->\n";
  //   echo "\t</div >\n";
  $item = $menu[0];
  $is_sub = $item["icon"];
  $caption = $item["caption"];
  $style = $GLOBALS['style_menu_head'];
  echo "\t <div $style >\n";
  echo "$caption \n";
  echo "\t </div >\n";

  $style = $GLOBALS['style_menu_item'];
  echo "\t\t<div $style ><!-- Row:1, Col:1 -->\n";

  reset ($menu);
  $i = 0;
  foreach ($menu as $item)
  {
    // das erste Ellement ist der Header !!
    if ($i > 0)
    {
      //echo $i;
      print_menu_item($item);
    }
    $i++;
  }
  if ($is_sub == "0")
  {
    if (is_subsl()==TRUE)
    {
      print_menu_item($menu_item_subsl);
    }
    if (is_sl()==TRUE)
    {
      print_menu_item($menu_item_sl);
    }
    if (is_admin()==TRUE)
    {
      print_menu_item($menu_item_admin);
    }
  }
  echo "\t\t</div >\n";
  echo "\t</div >\n";
  echo "<!---  Menu Spalte ENDE   --->\n\n";
};

/**
 * Wird fuer die pages verwaltung benutzt
 * Zerlegt einen Pfad_Datei in Sub Item elemente
 * Bis zu 3 elemente werden ausgewertet.
 * Sind mehr elemente enthalten wird nichts zurueckgegeben 
 * @param unknown $daten
 * @return multitype:string unknown Ambigous <>
 */

function get_sub_item_name($daten)
{
	$sub_item_name = array("sub"=>"", "item"=>"", "name"=>"");
	$sub_item = explode("/", $daten);
	if (count($sub_item)==1)
	{
		$sub_item_name["name"] = $sub_item[0]; 
	}
	if (count($sub_item)==2)
	{
		$sub_item_name["sub"] = $sub_item[0];
		$sub_item_name["name"] = $sub_item[1];
	}
	if (count($sub_item)==3)
	{
		$sub_item_name["sub"] = $sub_item[0];
		$sub_item_name["item"] = $sub_item[1];
		$sub_item_name["name"] = $sub_item[2];
	}
	
	return  $sub_item_name;
}

/**
 * Wird fuer die pages verwaltung benutzt
 * Baut einen Pfad Datei aus den 3 elemente zusammen.
 * 
 * @param unknown $sub
 * @param unknown $item
 * @param unknown $name
 * @return string|unknown
 */
function set_sub_item_name($sub, $item, $name)
{
	if ($sub != "")
	{
		if ($item == "")
			{
				return $sub."/".$name;
			} else
			{
				return $sub."/".$item."/".$name;
			}
	} else
	{
		return $name;
	}
}

/**
 * Erstellt aus der Datenbank ein $menu
 * Es wird $itemtyp ausgewertet um den link zu erstellen
 * @param unknown $bereich
 * @param unknown $sub
 * @param unknown $item
 * @return Ambigous <unknown, multitype:multitype:string  , multitype:string >
 */
function get_menu_items($bereich, $sub,$item)
{
	if ($bereich == "")
	{
		$bereich = 'PUBLIC';
	}

	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $menu_item;
	global $menu_items;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$table = 'menu_item';

	//   $q = "SELECT item,item_titel,item_typ,item_icon,item_link,item_sort,sub FROM menu_bereich
	//   join menu_sub on menu_sub.ref_bereich = menu_bereich.ID
	//  join menu_item on menu_item.ref_sub=menu_sub.ID
	//  where bereich = \"$bereich\" and sub= \"$sub\"  and item=\"$item\" order by item_sort";
	$q="SELECT item,item_titel,item_typ,item_icon,item_link,item_sort FROM menu_bereich
	join menu_sub on menu_sub.ref_bereich = menu_bereich.ID
	join menu_item on menu_item.ref_sub=menu_sub.ID
	where bereich = \"$bereich\" and sub= \"$sub\" and item=\"$item\" order by item_sort";

	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid get_menu_items: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		$i=0;
		// Reihenfolge der menu_item nach spalte item_sort
		while ($row = mysql_fetch_row($result))
		{
			$menu_item['caption']=$row[1];
			$menu_item['icon']=$row[3];
			if ($row[2] == 1)
			{	// ergaenze pfad durch sub / item  als pfad
				$menu_item['link']= "&daten=".set_sub_item_name($sub, $item, $row[4]);
			} elseif ($row[2] == 2)
			{	// ergaenze pfad durch standard pages_pfad
				$menu_item['link']="&daten=pages/".$row[4];
			} else
			{
				$menu_item['link']=$row[4];
			}
			$menu_item['itemtyp']=$row[2];
			if ($row[5] == 0)
			{
				$menu_items[0]=$menu_item;
			} else
			{
				$menu_items[$i]=$menu_item;
			}
			$i++;
		}
	}
	return $menu_items;
}



/**
 * Ausgabe des Logo image anhand des default style 
 * @param unknown $typ
 */
function print_header_icon ($typ)
{
	global $home;
	$typ = $GLOBALS['layoutImages_path'].$typ;
	if($typ != "") 
	{
		echo "\t<a href=\"$home\">  <IMG SRC=\"$typ\" title=\"Zur Startseite\"> </a>  ";
	} else{
		echo "<p><a href=\"$home\"> HIER FEHLT EIN BILD </a>  </p>";
	}
};

/**
 * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
 * @return boolean
 */
function is_admin()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  $user_lvl   = $_SESSION["user_lvl"];
  if ($user_lvl < 1) return FALSE;
  if ($user_lvl < 4)
  {
    return TRUE;
  }
  return FALSE;
}

/**
 * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
 * 
 * @return boolean
 */
function is_sl()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  
  $user_lvl   = $_SESSION["user_lvl"];
  if ($user_lvl < 1) return FALSE;
    if ($user_lvl < 16)
  {
    return TRUE;
  }
  return FALSE;
}

/**
 * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
 * 
 * @return boolean
 */
function is_subsl()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  $user_lvl   = $_SESSION["user_lvl"];
  if ($user_lvl < 1) return FALSE;
  if ($user_lvl < 64)
  {
    return TRUE;
  }
  return FALSE;
}

/**
 * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
 * 
 * @return boolean
 */
function is_author()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  $user_lvl   = $_SESSION["user_lvl"];
  if ($user_lvl < 1) return FALSE;
  if ($user_lvl < 256)
  {
    return TRUE;
  }
  return FALSE;
}

/**
  * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
* 
 * @return boolean
 */
function is_user()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  $user_lvl   = $_SESSION["user_lvl"];
  if ($user_lvl < 1) return FALSE;
  if ($user_lvl < 512)
  {
    return TRUE;
  }
  return FALSE;
}

/**
 * prueft ob user Lvl den entsprechenden Wert hat
 * 1-3    = admin
 * 4-15   = sl
 * 16-63  = sub_sl
 * 64-255 = author
 * 256-511  = user
 * 512....  = public  
 * 
 * @return boolean
 */
function is_public()
{
  global $user_lvl;
  if (!isset($_SESSION["user_lvl"])) { return FALSE; }
  if ($user_lvl < 1) return FALSE;
  
  if ($user_lvl > 511)
  {
    return TRUE;
  }
  return FALSE;
}


/**
 * DB funktion, gibt die Spieler_id zu einer User_id zurück
 * gibt es mehrere relationen, wird die erste genommen
 * @param unknown $user_id
 * @return int
 */
function get_spieler_id($user_id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
    $table = $GLOBALS['TBL_USER'];
	$q = 'select spieler_id from $table where id=\"$user_id\"';
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	$user_id=$row1[0];
	return $user_id;

};

/**
 * DB-Funktion, Gibt die Spieler_id zu einem UserNAme zurück 
 * @param unknown $user
 * @return unknown
 */
function get_user_id($user)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
    $table = $GLOBALS['TBL_USER'];
	$q = "select spieler_id,id,username from $table where username=\"$user\"";
	$result = mysql_query($q) or die("select Fehler....$q.");
	$row1 = mysql_fetch_row($result);
	$user_id=$row1[0];
	return $user_id;

};

/**
 * DB Funktion
 * Gibt den Realnamen (Vorname + Name zu einer spieler_id zurück 
 * @param unknown $user_id
 * @return string
 */
function get_author($user_id)
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

/**
 * DB-Funktion, Gibt die Mail-adresse zu einer Spieler_id zurück
 * @param unknown $user_id
 * @return Ambigous <>
 */
function get_mail($user_id)
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

/**
 * DB-Funktion, Gibt den Charakternamen zu einer Spieler_id zurück 
 * @param unknown $user_id
 * @return Ambigous <>
 */
function get_charname($user_id)
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

/**
 * DB-Funktion, Gibt den Namen des Spielers zu einer spieler_id zurück 
 * @param unknown $user_id
 * @return string
 */
function get_spieler($user_id)
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


/**
 * Gibt den aktuellen Contag zurück 
 * @return int
 */
function get_akttag()
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

/**
 * DB-Funktion
 * Prüft , ob der user auf den Tag Zugrifsberechtigt ist
 * Holt die User_id angand des User
 * Sucht die User_id in der
 * @param String $user
 * @param int $tag
 * @return Boolean (TRUE/FALSE)
 */
function get_sltag($user,$tag)
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


/**
 * Sucht einen Referenz in der Help Tabelle
 * @param unknown $item
 * @return resource (MySQL resultset)
 */
function get_hilfe($item)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from hilfe where item=\"$item\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	return  $result;
}

/**
 * Sucht eine Referenz (item) und im BEreich (id)
 * @param unknown $item
 * @param unknown $id
 * @return resource  (MySQL resultset)
 */
function get_hilfe_item($item,$id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);

	$q = "select * from hilfe where item=\"$item\" AND id=\"$id\" ";
	$result = mysql_query($q) or die("select Fehler....$q.");
	return  $result;
}

/**
 * Sucht ein Hilfe Referenz (item) 
 * Zeigt eine Hilfeseite an im default style fuer html
 * @param unknown $ID
 * @param unknown $item
 * @param unknown $id
 */
function  print_hilfe($ID,$item,$id)
{
	if ($id=='')
	{
		$result = get_hilfe($item);
        $style = $GLOBALS['style_datatab'];
		echo "<div $style \n>";
		print_menu_icon (10);
		echo "\t<p> <b>Hilfeindex : $item </b> </p>\n";
		//Daten
		$field_num = mysql_num_fields($result);
		echo "\t<div>";
		while ($row = mysql_fetch_row($result))
		{
			for ($i=0; $i<$field_num-1; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
//					echo "\t<td><a href=\"$PHP_SELF?md=10&ID=$ID&id=$row[$i]&item=$item\">\n";
                    $style = $GLOBALS['style_balken_menu_r'];
                    echo "\t\t<div $style > \n";
					print_menu_icon ($GLOBALS['menu_stop']);
					echo "\t\t</div> \n";
				} else
				{
					echo "\t".$row[$i]."&nbsp; \n";
				}
			}
		}
		echo "\t</div>";
		echo "</div\n>";
	} else
	{
		$result = get_hilfe_item($item,$id);
        $style = $GLOBALS['style_datatab'];
		echo "<div $style \n>";
		print_menu_icon (10);
		echo "\t<p> <b>Hilfeindex : $item </b> </p>\n";
		//Daten
		$field_num = mysql_num_fields($result);
		echo "\t<div>";
		while ($row = mysql_fetch_row($result))
		{
			for ($i=0; $i<$field_num-1; $i++)
			{
				// aufruf der Deateildaten
				if ($i==0)
				{
//					echo "\t<td><a href=\"$PHP_SELF?md=10&ID=$ID&id=$row[$i]&item=$item\">\n";
                    $style = $GLOBALS['style_balken_menu_r'];
                    echo "\t\t<div $style > \n";
                    $img = $GLOBALS['menu_stop']; 
					print_menu_icon ($img);
					echo "\t\t</div> \n";
				} else
				{
					echo "\t".$row[$i]."&nbsp; \n";
				}
			}
		}
		echo "\t</div>";
		echo "</div\n>";
	}
}

/**
 * Gibt den Kurznamen des Montas zurück
 * Wird im Kalender verwendet
 * @param int $m  Monat (1..12)
 * @return string
 */
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

/**
 * Gibt die Hintergrundfarbe zurück anhand eines Eintragstyp
 * im Kalender
 * 	['contag','aufbau',"orange",'basteln',"orange", 'vv',default]
 * @param unknown $typ
 * @return string colorName or colorHex 
 */
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

/**
 * erzeugt eine Liste der news im Datenbereich
 */
function print_news()
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

  $style = $GLOBALS['style_datatab'];
  echo "<div $style >";
  echo "<!---  DATEN Spalte   --->\n";
  echo "<CENTER>";
  
  echo "      <TABLE WIDTH=\"500\"  BORDER=\"0\" BGCOLOR=\"\" >";
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);

  $result = mysql_query("SELECT datum,text_1,text_2,Text_3 from news order by id DESC LIMIT 10")
  or die("Query Fehler...");

  while ($row = mysql_fetch_row($result))
  {
    echo "        <TR>";
    echo "        <FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
    echo "\t<td width=\"95\">".$row[0]."<br><br><br><br>";
    echo "</td>\n";
    echo "\t<td>$row[1]<BR>$row[2]<BR>$row[3]<BR>";
          echo "<HR>";
    echo "</td>\n";
    echo '        </TR>';
}

mysql_close($db);
echo '      </TABLE>';
echo "    </TD>\n";
echo "    <TD>\n";
echo "    .\n";
echo "</CENTER>";
echo '</div>';
echo "<!---  ENDE DATEN Spalte   --->\n";

};

/**
 *  erstellt einen Kalender als Tabelle
 *  kann direkt in die Datentab geschrieben werden
 */
function print_kalender()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
    echo "<CENTER>";
	
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
//	echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"3\">\n";
	echo "<CENTER>Drachenhorst Kalender ".$j;
	echo "\t</TD>\n";
	echo "</TR>\n";
	echo "<TR  HEIGHT=\"25\" >";
//	echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
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
	echo "<TR  HEIGHT=\"25\" >";
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
		echo "<TR  HEIGHT=\"25\" >";
		//echo "<FONT FACE=\"Comic Sans MS\" SIZE=\"2\">\n";
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
    echo "</CENTER>";
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
	//=========== print_kalender_end ========================
};


/**
 *  erstellt eine Spielerliste als Tabelle
 *  kann direkt in das Datatab geschrieben werden 
 */
function print_sc_liste()
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;

	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!---  DATEN Spalte   --->\n";
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
	echo '</div>';
	echo "<!---  ENDE DATEN Spalte   --->\n";
}

/**
 * 
 * @param unknown $bild_url
 * @param unknown $zieldir
 * @param unknown $max_x
 * @param unknown $max_y
 * @param unknown $type
 */
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
// Kann mir jemand sagen wie ich dennoch die Bilder ohne Farbverlust
// verkleinern kann
// oder hat evtl. einen Codeschnippsel dafür parat...
// Ich hatte das Problem auch mal und in einem Forum diese Funktion
// Gefunden:
//
//==========================================================================

{

	$PicPathIn=$zieldir; // Dein Verzeichnis des Original Bildes z.B.bilder/
//	$PicPathOut=realpath($zieldir."thumb")."/"; // Dein Tumb Ziel Verzeichnis
	$PicPathOut=realpath($GLOBALS['path_thumbnail']); // Dein Tumb Ziel Verzeichnis
	
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

/**
 * Speichert ein hochgeladenes Bild in der Gallerie (Verzeichnis)
 * Der Bildtyp wird anhand der fileendung erkannt, gif, jpg, png, swf, bmp 
 * (hmm... unbefriedigende Loesung)
 * Es wird ein thunmbnail erzeugt
 * @param unknown $bild   Bildaten
 * @param unknown $name   Bildname wurde automatisch erzeugt
 * @param unknown $imagepath  Bildpfad
 */
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

/**
 * Erzeugt ein Thumbnail
 * 
 * @param unknown $bild_url
 * @param unknown $zieldir
 * @param unknown $max_x
 * @param unknown $max_y
 * @param unknown $type
 */
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
// Kann mir jemand sagen wie ich dennoch die Bilder ohne Farbverlust
// verkleinern kann
// oder hat evtl. einen Codeschnippsel dafür parat...
// Ich hatte das Problem auch mal und in einem Forum diese Funktion
// Gefunden
//
//==========================================================================

{

	$PicPathIn=$zieldir; // Dein Verzeichnis des Original Bildes z.B.bilder/
	$PicPathOut=realpath($GLOBALS['path_thumbnail']); // Dein Tumb Ziel Verzeichnis

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