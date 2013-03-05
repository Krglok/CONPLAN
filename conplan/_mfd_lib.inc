<?php
/*
Projekt : LIBRARY

Datum    :  $date$  / 27.02.2013

Rev.    :  $rev$   / 1.0

Author  :  $author$  / krglok

beschreibung : MFD = Main Formular Data, 
beschreibt eine Tabelle und die Daten dieser Tabelle die in einer 
Datenliste angezeigt werden sollen.
Mit diesem Schema koennen einheitliche Anzeige- und
Bearbeitungsfunktionen benutzt werden, da die Funktionen nicht
an die Tabelleneigenschaften gebunden sind.

Enthält Funktionen fuer die Main Formular Definition (MFD)
- Datenliste
- Datenbank zugriff Insert, Update, Delete
- automatische Detailmaske
- Tools fuer Feldliste, etc.
- Default MFD fuer Tabelle
- Default MFD-COLS fuer Tabelle


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

$mfd_list = array("mfd"=>"", "table"=>"","tite"=>"","fields"=>"","join"=>"","where"=>"", "order"=>"");
$mfd_col = array("mfd_name"=>"", "mfd_titel"=>"", "mfd_pos"=>"", "mfd_field"=>"", "mfd_field_titel"=>"", "mfd_width"=>"", "mfd_field_typ"=>"");
$mfd_cols = array("0"=>$mfd_col);

define("mfd_list",10);
define("mfd_add", 11);
define("mfd_edit",12);
define("mfd_del", 13);
define("mfd_info", 14);
define("mfd_check", 15);

define("mfd_insert", 21);
define("mfd_update", 22);
define("mfd_delete", 23);


/**
 * Erzeugt ein Default mfd Columns fuer eine Tabelle in der Datenbank
 * Eine mfd COl Definition besteht aus mehreren Tabellenzeile.
 * Deshalb werden diese dynamisch erstellt und direkt aus der jeweiligen
 * Tabelle gelesen
 * @param  $table, name der Tabelle die gelesen wird
 * @param  $mfd_name , name der mfd-referenz die erzeugt wird
 */
function insert_mfd_cols($table,$mfd_name)
{
  // erzeuge mfd fuer Tabelle in die der insert gemacht werden soll
  $mfd_list = make_mfd_table("mfd_cols", "mfd_cols");

  $mfd_cols = make_mfd_cols_default($table, $mfd_name);

  $i =0;
  foreach ($mfd_cols as $mfd_col)
  {
    $row[0] = 0;  //ID
    $row[1] = $mfd_name;
    $row[2] = $mfd_col["mfd_pos"];
    $row[3] = $mfd_col["mfd_field"];
    $row[4] = $mfd_col["mfd_field_titel"];
    $row[5] = $mfd_col["mfd_width"];
    $row[6] = $mfd_col["mfd_field_typ"];

    mfd_insert($mfd_list, $row);
    $i++;
  }
}

$field_item = array
(
		"Field" => "",
		"Type" => "",
		"Null" => "",
		"Key" => "",
		"Default" => "",
		"Extra" => ""   //auto_increment
);

/**
 * erzeugt automatisch die col-definitionen fuer eine Tabelle
 * @param  $table  Tabellenname
 * @return $mfd_cols  column definition fuer mfd 
*/
function make_mfd_cols_default($table,$mfd_name)
{
	$result = get_fieldlist($table);

	$i=0;
	while ($row = mysql_fetch_row($result))
	{
		// 0 = Field, 1 = Type, 2 Null, 3 = Key, 4Defaault, 5=Extra
		$mfd_col["mfd_name"]	= $mfd_name;
		$mfd_col["mfd_pos"]		= $i;
		$mfd_col["mfd_field"]	= $row[0];
		$mfd_col["mfd_field_titel"] = $row[0];
		$mfd_col["mfd_width"]	= get_fieldtyp_width($row[1]);
		$mfd_col["mfd_field_typ"]	= $row[1];
		$mfd_cols[$i] = $mfd_col;
		$i++;
	}
	return $mfd_cols;
}

// /**
//  * Ereugt einen defualt mfd-cols-defintion
//  * @param unknown $table
//  * @param unknown $mfd_name
//  * @return string
//  */
// function make_mfd_table_cols($table, $mfd_name)
// {
// 	$result = get_fieldlist($table);
// 	/*
// 	 0		"Field" => "",
// 	1		"Type" => "",
// 	2		"Null" => "",
// 	3		"Key" => "",
// 	4		"Default" => "",
// 	5		"Extra" => ""   //auto_increment
// 	*/
// 	$row = mysql_fetch_row($result);
// 	$i = 0;
// 	$list = $row[0];
// 	while ($row = mysql_fetch_row($result))
// 	{
// 		$list = $list.",".$row[0];
// 		$mfd_col['mfd_name'] = $mfd_list["mfd"];
// 		$mfd_col['mfd_titel'] = "MFD-LIST";
// 		$mfd_col['mfd_pos'] = $i;
// 		$mfd_col['mfd_field'] = $row[0];
// 		$mfd_col['mfd_field_titel'] = $row[0];
// 		$mfd_col['mfd_width'] = get_fieldtyp_width($row[1]);
// 		$mfd_cols[$i] = $mfd_col;
// 		$i++;
// 	}
// 	return $list;
// }


/**
 * Erstellt eine automatische Anzeige fuer tabelle als MFD
 * @param unknown $table
 * @param unknown $ID
 */
function show_mfd($table,$ID)
{
	global $PHP_SELF;
	$next = 5;
	//  $name = "";
	$sub  = "admin";
	print_table_list($ID);

	$mfd = make_mfd_table($table,$table);

	$style = $GLOBALS['style_datalist'];
	echo "<div $style > \n";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<TABLE > \n";
	echo "<TR> \n";
	echo "<TD>\n";
	echo "Breich";
	echo "</TD> \n";
	echo "<TD> \n";
	echo "<b>ADMIN</b>";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TBODY> \n";
	echo "<TR> \n";
	echo "<TD>\n";
	echo "Sub";
	echo "</TD> \n";
	echo "<TD> \n";
	echo "<b>main</b>";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD>\n";
	echo "Mfd";
	echo "</TD> \n";
	echo "<TD> \n";
	echo "<b>".$mfd['mfd']."</b>";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD> \n";
	echo "Table \n";
	echo "</TD> \n";
	echo "<TD> \n";
	echo $mfd['table']." \n";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD> \n";
	echo "Fields \n";
	echo "</TD> \n";
	echo "<TD> \n";
	echo $mfd['fields']." \n";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD> \n";
	echo "Join \n";
	echo "</TD> \n";
		
	echo "<TD> \n";
	echo $mfd['join']." \n";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "\n";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD> \n";
	echo "Where \n";
	echo "</TD> \n";
		
	echo "<TD> \n";
	echo $mfd['where']." \n";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD> \n";
	echo "Order \n";
	echo "</TD> \n";
	echo "<TD> \n";
	echo $mfd['order']." \n";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "</TBODY> \n";
	echo "</TABLE> \n";
	echo "</div> \n";
	echo "<!--  ENDE DATEN Spalte   -->\n";
  
	return $mfd;
}

/**
 * erstellt eine automatische Defition von mfd-cols 
 * mfd_name = "mfd_"+<table_name>
 * fuer eine Tabelle
 * @param unknown $table
 */
function show_mfd_cols($table,$ID)
{
	print_table_list($ID);
	$mfd_name = "mfd_".$table;
	$mfd_cols = make_mfd_cols_default($table, $mfd_name);

	$style = $GLOBALS['style_datalist'];
	echo "<div $style > \n";
	echo "<!--  DATEN Spalte   -->\n";
	echo "<TABLE > \n";
	echo "<TBODY> \n";
	echo "<TR> \n";
	echo "<TD>\n";
	echo "Tabelle";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "<b>$table</b>";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "";
	echo "</TD> \n";
	echo "</TR> \n";

	echo "<TR> \n";
	echo "<TD>\n";
	echo "<i>MFD-Referenz</i>";
	echo "</TD> \n";
	
	echo "<TD> \n";
	echo "<b>$mfd_name</b>";
	echo "</TD> \n";
	
	echo "<TD> \n";
	echo "";
	echo "</TD> \n";
	echo "</TR> \n";
	
	echo "<TR> \n";
	echo "<TD> \n";
	echo "<i>Fieldname</i> \n";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "<i>Titel</i> \n";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "<i>Width</i> \n";
	echo "</TD> \n";

	echo "<TD> \n";
	echo "<i>Typ</i> \n";
	echo "</TD> \n";
	echo "</TR> \n";
	
	foreach ($mfd_cols as $mfd_col)
	{
		echo "<TR> \n";
		echo "<TD> \n";
		echo $mfd_col["mfd_field"];
		echo "</TD> \n";

		echo "<TD> \n";
		echo $mfd_col["mfd_field_titel"];
		echo "</TD> \n";
			
		echo "<TD> \n";
		echo $mfd_col["mfd_width"];
		echo "</TD> \n";
		
		echo "<TD> \n";
		echo $mfd_col["mfd_field_typ"];
		echo "</TD> \n";
		echo "</TR> \n";
	}
	echo "</TBODY> \n";
	echo "</TABLE> \n";
	echo "</div> \n";
	echo "<!--  ENDE DATEN Spalte   -->\n";

	return $mfd_cols;
}

/**
 * Holt die Mfd aus der Tabelle mfd_list
 * Die Felder sind vorgegeben !
 * @param  $name , name des mfd , der gelesen wird
 * @return mfd_list, array der mfd definition
 */
function get_mfd($name)
{
  global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

  mysql_select_db($DB_NAME);
  $table = "mfd_list";
  $fields = "ID, mfd_name, mfd_table, mfd_titel, mfd_fields, mfd_join, mfd_where, mfd_order ";
  $join = "";
  $where =" mfd_name = \"$name\" ";
  $order = "ID";

  $q = "SELECT $fields FROM $table  $join where $where  order by $order";

  $result = mysql_query($q) ;
  if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $q;
    die($message);

  } else
  {
    $i=0;
    $row = mysql_fetch_row($result);
    $mfd_list['mfd'] = $row[1];
    $mfd_list['table'] = $row[2];
    $mfd_list['titel'] = $row[3];
    $mfd_list['fields'] = $row[4];
    $mfd_list['join'] = $row[5];
    $mfd_list['where'] = $row[6];
    $mfd_list['order'] = $row[7];
    return $mfd_list;
  }

}


/**
 * Holt die Liste aller mfd Daten
 * @param unknown $name		// referenz des mfd
 * @return array mit mfd daten ($mfd_list)
 */
function get_mfd_list()
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$table = "mfd_list";
	$fields = "ID, mfd_name, mfd_table, mfd_titel, mfd_fields, mfd_join, mfd_where, mfd_order ";
	$join = "";
	$where =" id >0 ";
	$order = "ID";

	$q = "SELECT $fields FROM $table  $join where $where  order by $order";

	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		$i=0;
		while ($row = mysql_fetch_row($result))
		{
			// Reihenfolge der menu_item nach spalte item_sort
			//    $mfd_list['ID'] = $row[0];
			$mfd_list['mfd'] = $row[1];
			$mfd_list['table'] = $row[2];
			$mfd_list['titel'] = $row[3];
			$mfd_list['fields'] = $row[4];
			$mfd_list['join'] = $row[5];
			$mfd_list['where'] = $row[6];
			$mfd_list['order'] = $row[7];
			$mfd_lists[$i] = $mfd_list;
			$i++;
		}
		return $mfd_lists;
	}

}

/**
 * Holt den resultset zu einer mfd referenz ($name)
 * @param unknown $name		// referenz des mfd
 * @return $result , mysql Resultset;
 */
function get_mfd_result($name)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$table = "mfd_list";
	$fields = "ID, mfd_name, mfd_table, mfd_titel, mfd_fields, mfd_join, mfd_where, mfd_order ";
	$join = "";
	$where =" mfd_name = \"$name\" ";
	$order = "ID";

	$q = "SELECT $fields FROM $table  $join where $where  order by $order";

	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		$row = mysql_fetch_row($result);
		// Reihenfolge der menu_item nach spalte item_sort
		//    $mfd_list['ID'] = $row[0];
		$mfd_list['mfd'] = $row[1];
		$mfd_list['table'] = $row[2];
		$mfd_list['titel'] = $row[3];
		$mfd_list['fields'] = $row[4];
		$mfd_list['join'] = $row[5];
		$mfd_list['where'] = $row[6];
		$mfd_list['order'] = $row[7];
		return mfd_data_result($mfd_list);
	}

}

/**
 * Holt ein mySQL resultset fuer ein mfd_list
 * @param $mfd_list			// refenrenz des mfd
 * @return $result , array mit mySQL resultset
 */
function mfd_data_result($mfd_list)
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

function make_mfd_fieldlist($text)
{
	return explode(',', $text);
}


/**
 * Holt die Spaltendefinition fuer einen mfd_namen
 * die Felder von mfd_cols sind vorgegeben!
 * @param  $name			// Referenz auf mfd
 * @return Array mit Spaltendefinitionen ($mfd_cols)
 */
function get_mfd_cols($name)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
// 	global $mfd_col;
// 	global $mfd_cols;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$table = "mfd_list";
	$fields ="ref_mfd, mfd_pos, mfd_field, mfd_field_titel, mfd_width, mfd_field_typ ";
	$join = "join mfd_cols on mfd_cols.ref_mfm=mfd_list.ID";
	$where ="ref_mfd=\"$name\"";
	$order = "mfd_pos";

	$q = "SELECT $fields FROM $table  $join where $where order by $order";

	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		$i=0;
		while ($row = mysql_fetch_row($result))
		{
			$i++;
			// Reihenfolge der menu_item nach spalte item_sort
			$mfd_col['ref_mfd'] = $name;
			$mfd_col['mfd_pos'] = $row[2];
			$mfd_col['mfd_field'] = $row[3];
			$mfd_col['mfd_field_titel'] = $row[4];
			$mfd_col['mfd_width'] = $row[5];
			$mfd_col['mfd_field_typ'] = $row[5];
			$mfd_cols[$i] = $mfd_col;
		}
	}
	return $mfd_cols;
}

/**
 * Holt fuer eine mfd einen Datensatz mit dem PK $id
 * @param unknown $name   // mfd referenz
 * @param unknown $id			// pk des gesuchten Datensatz
 * @return resource				// Resultset des SQL
 */
function mfd_detail_result($mfd_list, $id)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
//	global $mfd_list;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");

	mysql_select_db($DB_NAME);
	$table = $mfd_list["table"];
	$fields =$mfd_list["fields"];
	$join = ""; //$mfd_list["join"];
	$where ="ID = $id";
	$order = "";

	$q = "SELECT $fields FROM $table $join where $where ";

	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);

	} else
	{
		return $result;
	}
}


/**
 * Loescht einen Datensatz anhand der mfd Definition
 * @param  $mfd_list , mfd Definition
 * @param  $id zu loeschender Datensatz
 */
function mfd_delete($mfd_list, $id)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $mfd_list;

	$table = $mfd_list["table"];
	$fields =""; //$mfd_list["fields"];
	$join = ""; //$mfd_list["join"];
	$where ="id = $id";
	$order = "";

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)     or die("Fehler beim verbinden!");

	if (mysql_select_db($DB_NAME) != TRUE) {
		echo "Fehler DB";
	};
	/**/
	$q = "delete from $table where $where ";
	//  echo $q;
	$result = mysql_query($q) ;
	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);
	}
	/**/
	mysql_close($db);
//echo "delete ".$id;
};



/**
 * Loescht einen Datensatz anhand des mfd_namen
 * @param unknown $name		// referenz auf mfd
 * @param unknown $id			// zu löschender PK (id)
 */
function mfd_delete_name($name, $id)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
//	global $mfd_list;

	$mfd_list = get_mfm_list($name);
	mfd_delete($mfd_list, $id);
};

/**
 * Macht einen Datenbank insert anhand der mfd Definition
 * @param unknown $mfd_list
 * @param unknown $row
 */
function mfd_insert($mfd_list, $row)
{
	global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$table = $mfd_list["table"];
	$fields =$mfd_list["fields"];
	$join = ""; //$mfd_list["join"];
	$where ="";
	$order = "";
	//  echo $fields;
	$field_name = make_mfd_fieldlist($fields);
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	$field_num = count($field_name);
	// der PK (ID) muss in der Fieldmenge enthalten sein, als erster!!
	$q ="insert INTO  $table  (";
	$q = $q."$field_name[1]";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",$field_name[$i]";
	};

	$q = $q.") VALUES (\"$row[1]\" ";
	for ($i=2; $i<$field_num; $i++)
	{
		$q = $q.",\"$row[$i]\" ";
	};
	$q = $q.")";
	if (mysql_select_db($DB_NAME) != TRUE)
	{
		echo "Fehler DB";
	}
	//  echo $q;
	$result = mysql_query($q) or die("InsertFehler..$table..$q.");
	mysql_close($db);

}

/**
 * Macht einen Datenbank insert anhand des mfd-namen
 * @param unknown $name  , name des mfd
 * @param unknown $row , Datensatz als array
 */
function mfd_insert_name($name,$row)
{
	//global $mfd_list;

	$mfd_list = get_mfd_list($name);
	mfdlist_insert($mfd_list, $row);
}

/**
 * Macht ein Tabellen update mit mfd
 * @param unknown $mfd_list 	// mfd defintion
 * @param unknown $row		// Datensatz Row mit Datenfelder
 */
function mfd_update($mfd_list, $row)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$id = $row[0];
	$table = $mfd_list["table"];
	$fields =$mfd_list["fields"];
	$join = ""; //$mfd_list["join"];
	$where ="id = $id";
	$order = "";
	$field_name = make_mfd_fieldlist($fields);
	$field_num = count($field_name);
	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	or die("Fehler beim verbinden!");

	// der PK (ID) muss in der Fieldmenge enthalten sein, als erster!!
	$q ="update  $table  set ";
	$q = $q.$field_name[1]."=\"".$row[1]."\"";
	for ($i=2; $i<$field_num; $i++)
	{
	$q = $q.",".$field_name[$i]."=\"".$row[$i]."\" ";
	};
	$q = $q." where $where";
	if (mysql_select_db($DB_NAME) != TRUE)
	{
	echo "Fehler DB";
	}
	//  echo $q;
	$result = mysql_query($q) or die("UpdateFehler..$table..$q.");
	mysql_close($db);
	
};

/**
 * Macht ein Tabellen update auf Tabelle von mfd $name
 * @param unknown $name 	// referenz auf mfd
 * @param unknown $row		// Datensatz Row mit Datenfelder
 */
function mfd_update_name($name, $row)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	//global $mfd_list;

	$mfd_list = get_mfd_list($name);

	mfd_update($mfd_list, $row);
};


/**
 * Fragt die Feldliste in der Datenabnk ab.
 * ACHTUNG ! die Datenbank connection muss vorhanden sein !
 * @param unknown $table
 * @return $result, MySQL resultarray
 */
function get_fieldlist($table)
{
	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)  or die("Fehler beim verbinden!");
	mysql_select_db($DB_NAME);
	$result = mysql_query("SHOW COLUMNS FROM $table");
	return $result;
}

/**
 * Ermittelt die Default Width anhand des Datentyp
 * @param unknown $typ
 * @return int, laenge des Datenfeldes
 */
function get_fieldtyp_width($typ)
{
  //echo $typ;
	if (stripos($typ,"int")!== false)
	{
		return 8;
	}
	if(stripos($typ,"varchar")!== false)
	{
		$s =  explode("(",$typ);
		$len = explode(")",$s[1]);
		//echo $len[0];
		return $len[0];
	}
	if(stripos($typ,"text")!== false)
	{
		return 35;
	}
	if(stripos($typ,"enum")!== false)
	{
		return 7;
	} else
	{
		return 12;
	}
}

/**
 * erzeugt eine komma separatet list der Feldnamen
 * @param unknown $table
 * @return string , comma separated Fieldnamen
 */
function get_fieldname_list($table)
{
	$result = get_fieldlist($table);


	$row = mysql_fetch_row($result);
	$list = $row[0];
	while ($row = mysql_fetch_row($result))
	{
		$list = $list.",".$row[0];
	}
	return $list;
}


/**
 * erzeugt eine mfd definition fuer eine tabelle als Liste
 * @param  $table	Tabellenname
 * @return array mfd definition
 */
function make_mfd_table($table, $mfd_name)
{
	$mfd_list['mfd'] = $mfd_name;
	$mfd_list['table'] = $table;
	$mfd_list['titel'] = $table;
	$mfd_list['fields'] = get_fieldname_list($table);
	$mfd_list['join'] = "";
	$mfd_list['where'] = "id > 0";
	$mfd_list['order'] = "id";
	return $mfd_list;
}

/**
 * Erzeugt eine Lnk-Spalte , der Link mus  uebergeben werden
 * oder alternativ eine Textspalte
 * @param unknown $link
 * @param unknown $ID
 * @param unknown $data
 */
function print_mfd_link_check($link,$ID,$data)
{
	if ($link != "")
	{
		echo "\t<td><a href=\"$link\">\n"; //
		print_menu_icon_mfd ("_tcheck","Datensatz bearbeiten");
		echo "\t</a></td>\n";
	}else
	{
		echo "\t<td>\n"; //
		echo "!".$data;
		echo "\t</td>\n";
	}
}

function print_mfd_link_del($link,$ID,$data)
{
  if ($link != "")
  {
    echo "\t<td><a href=\"$link\">\n"; //
    print_menu_icon_mfd ("_tdelete","Datensatz löschen, ACHTIUNG nicht reversibel!");
    echo "\t</a></td>\n";
}else
      {
        echo "\t<td>\n"; //
        echo "!".$data;
		echo "\t</td>\n";
	}
}

function print_mfd_link_info($link,$ID,$data)
{
  if ($link != "")
  {
    echo "\t<td><a href=\"$link\">\n"; //
    print_menu_icon_mfd ("_tinfo","Datensatz anzeigen ohne bearbeiten");
    echo "\t</a></td>\n";
  }else
  {
    echo "\t<td>\n"; //
    echo "!".$data;
    echo "\t</td>\n";
  }
}


/**
 * Ruft die Link bau funktion $link_call
 * oder alternativ ein Leerstring
 * @param unknown $ID	session ID
 * @param unknown $link_call  Funktionsname
 * @param unknown $data	Datenwert z.b. fuer 
 * @return Ambigous <string, mixed>
 */
function make_mfd_link($link_call,$ID,$data)
{
	if (function_exists ($link_call))
	{
	    // Call user function with 2 param
		$link = call_user_func($link_call,$ID,$data);
	} else
	{
		
	  $link = "";
	}
	return $link;
}

/**
 * Erstellt eine Datenliste fuer ein mfd entsprechend dem mfd_cols
 * Die Spaltenbreite wird eingestellt
 * Die Links werden mit einer Callback Funktion erzeugt
 * @param  $ID				SessionID
 * @param  $mfd_list	mfd Definition
 * @param  $mfd_cols	mfd Columns
 */
function print_mfd_listeRef( $ID, $mfd_list, $mfd_cols,$link_call_1, $link_call_2, $link_call_3)
{
	// 	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	echo "      <TABLE   BORDER=\"0\" BGCOLOR=\"\" >";
	// 	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	// 	or die("Fehler beim verbinden!");

	//	mysql_select_db($DB_NAME);

	$result = mfd_data_result($mfd_list)
	or die("Query Fehler...");

	echo "\t<TR>";
	//Print header
	echo "\t\t<TD width=\"5\">";
	echo "<p>";
	echo "</p>";
	echo "\t\t</TD>";
	for($i=0; $i<count($mfd_cols); $i++)
	{
		$mfd_col = $mfd_cols[$i];
		$width = $mfd_col["mfd_width"]*5;
		echo "\t\t<TD width=\"$width\">";
		echo "<p>";
		echo $mfd_col["mfd_field_titel"];
		echo "</p>";
		echo "\t\t</TD>";
		if($i > 32) exit;
	}
	echo "\t</TR>";
	// Printdata
	while ($row = mysql_fetch_row($result))
	{
	    //erzeuge den link_1 , im ersten Feld steht IMMER der PK
		$link_1 = make_mfd_link($link_call_1,$ID,$row[0]);
		// erzeuge link_2
		$link_2 = make_mfd_link($link_call_2,$ID,$row[0]);
		// erzeuge link_2
		$link_3 = make_mfd_link($link_call_3,$ID,$row[0]);
		echo "\t<TR>";
    	print_mfd_link_info($link_3,$ID,$row[0]);
		print_mfd_link_check($link_1,$ID,$row[0]);
		for ($i = 1; $i < count($mfd_cols); $i++)
		{
			echo "\t<td>".$row[$i]."\n";
			echo "</td>\n";
		}
		if ($link_2 != "")
		{
		  print_mfd_link_del($link_2,$ID,$row[0]);
		}
		echo "\t</TR>";
	}

	// 	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    \n";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

};

/**
 * Erstellt eine Datenliste fuer ein mfd entsprechend dem mfd_cols
 * ohne Links, die Spaltenbreite wird NICHT eingestellt
 * @param  $ID				SessionID
 * @param  $mfd_list	mfd Definition
 * @param  $mfd_cols	mfd Columns
 */
function print_mfd_liste( $ID, $mfd_list, $mfd_cols)
{
	// 	global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
	global $PHP_SELF;

	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	$result = mfd_data_result($mfd_list)
	or die("Query Fehler...");
	
//	echo $mfd_list["table"].":".count($mfd_cols);
	
	echo "<TABLE >";
	// 	$db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
	// 	or die("Fehler beim verbinden!");

	//	mysql_select_db($DB_NAME);

	echo "\t<TR>";
	//Print header
	$fieldnum = count($mfd_cols);
	for($i=0; $i<$fieldnum; $i++)
	{
		$mfd_col = $mfd_cols[$i];
		$width = $mfd_col["mfd_width"]*5;
		echo "\t\t<TD width=\"$width\">";
		echo "<p>";
		echo $mfd_col["mfd_field_titel"];
		echo "</p>";
		echo "\t\t</TD>";
	}
	echo "\t</TR>";
	// Printdata
	while ($row = mysql_fetch_row($result))
	{
		echo "\t<TR>";
		for ($i = 0; $i < $fieldnum; $i++)
		{
			echo "\t<td>".$row[$i]."\n";
			echo "</td>\n";
		}
		echo "\t</TR>";
	}

	// 	mysql_close($db);
	echo '      </TABLE>';
	echo "    </TD>\n";
	echo "    <TD>\n";
	echo "    \n";
	echo '</div>';
	echo "<!--  ENDE DATEN Spalte   -->\n";

};


/**
 * Erstellt ein Inputfeld mit der Textlaenge
 * die Size wird auf max 75 Zeichen begrenzt
 *
 * @param unknown $titel
 * @param unknown $pos
 * @param unknown $data
 * @param unknown $width
 * @param unknown $readonly
 */
function print_mfd_edit_spalte($titel,$pos, $data, $width, $is_readonly)
{
	if($is_readonly)
	{
		$readonly = "readonly";
	} else
	{
		$readonly = "";
	}

	if($width >75)
	{
		$size = 75;
	} else
	{
		$size = $width;
	}
	$titel = ucwords(strtolower($titel));
	echo "<td width=75 ><i>$titel</i></td>\n";
	echo "<td width=50>\n";
	echo "<INPUT TYPE=\"TEXT\" NAME=\"row[$pos]\" SIZE=$size MAXLENGTH=$width $readonly VALUE=\"$data\"\n";
	echo "</td>\n";
}

	/**
	* Erstellt eine Textarea als Input. Die Textarea wird durch ckEditor ersetz
	* bei readonly=true wird nur der Text angezeigt
	* @param unknown $titel  des Feldes
	* @param unknown $pos    index des $row
	* @param unknown $data		vorhandene Daten
	* @param unknown $is_readonly true = als Text / false = als Eingabe feld
	*/
	function print_mfd_edit_text($titel,$pos, $data, $is_readonly)
	{
	$name = "row[$pos]";  // dies ist der Name des Elementres das ersetzt werden soll
	$titel = ucwords(strtolower($titel));
	echo "  <td width=75px ><i>$titel</i></td>\n";
	echo "<td >\n";
			if ($is_readonly)
			{
			$anz  = count(explode("\n",$data));
			if ($anz < 5) {
			$anz=5;
			}
			$len = strlen($data) / 60;
			if($len>$anz) {
			$anz=$len+$anz;
			}

			echo "<textarea   name=\"$name\" readonly COLS=\"60\" ROWS=\"$anz\" >"; //class=\"ckeditor\"
			echo $data;
			echo "</textarea>";
			} else
  {
			echo "\t<td><i>$titel</i></td>\n";
			//  echo "\t<td><TEXTAREA NAME=\"$name\" COLS=50 ROWS=12></TEXTAREA>&nbsp;</td>\n";
			echo "<td>\n";
			echo "<textarea   name=\"$name\"  COLS=\"60\" ROWS=\"14\" >"; //class=\"ckeditor\"
			echo $data;
			echo "</textarea>";

			echo "<!--  Text editor Konfiguration-->";
    echo "  <script type=\"text/javascript\">";
    echo " CKEDITOR.replace('$name',{
    toolbar: 'ForumToolbar',
    removeButtons : 'Table',
    uiColor : '#9AB8F3',
    height : '250px'
			} );";
			echo "  </script>";
			echo "</td>\n";
			}
			echo "\t&nbsp;<br>\n";
			echo "</td>\n";

}


/**
 * Erstellt eine Eingabe Detailmaske als FORM
 * $next beinhaltet die nächste zu rufende Funktion
 * @param $mfd_list	mfd definition
 * @param $row	Datensatz mit felder als array
 * @param $id   Datensatz PK
 * @param $next aufzurufende Funktion im POST zur Weiterverarbeitung
 * @param $erf	Flag fuer Erfassen Modus
 * @param $ID		SessionID
 */
function print_mfd_maske($mfd_list, $row, $id,$next,$ID, $mfd_cols )
{
	//  Fielddefs holen  bzw. defaultwerte erzeugen
	global $PHP_SELF;

	$style = $GLOBALS['style_datalist'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

	//  FORMULAR
	echo "<FORM ACTION=\"$PHP_SELF?md=0&ID=$ID\" METHOD=POST>\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"row[0]\"   VALUE=\"$row[0]\">\n";
	echo "<INPUT TYPE=\"hidden\" NAME=\"ID\"   VALUE=\"$ID\">\n";

	echo "\t <TABLE>\n";
	echo "<tr>\n";
	echo "\t<td><b><i>".$mfd_list["mfd"]."</i></b></td>\n";
	echo "\t<td></td>\n";
	echo "</tr>\n";
	
	echo "<tr>\n";
	echo "\t<td WIDTH=\"175\"><i>".$mfd_cols[0]["mfd_field_titel"]."</i></td>\n";
	echo "<td>\"$row[0]\"&nbsp;</td>\n";
	echo "</tr>\n";

	for ($i = 1; $i < count($mfd_cols); $i++)
	{
	    $mfd_col = $mfd_cols[$i];
	    echo "<tr>\n";
		echo "\t<td><i>".$mfd_col["mfd_field_titel"]."</i></td>\n";
		$width = $mfd_col["mfd_width"];
		echo "<td><INPUT TYPE=\"TEXT\" NAME=\"row[$i]\" SIZE=\"$width\" MAXLENGTH=\"$width\" VALUE=\"".$row[$i]."\">&nbsp;</td>\n";
		echo "</tr>\n";
	}

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
};

/**
 * Erstellt eine mfd Detailmaske zum erfassen eines Datensatzes (Insert)
 * HINWEIS : Im rufenden Modul muss post_md = 5 als insert ausgewertet werden
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $mfd_list
 * @param unknown $mfd_cols
 */
function print_mfd_erf($id, $ID, $mfd_list, $mfd_cols)
//
// $id   beinhaltet den zu bearbeitenden Datensatz
//
{
	for ($i=1; $i<count($mfd_cols); $i++)
	{
		$row[$i] = "";
	}
	$row[0] = 0;
	$next = mfd_insert;	// Datenfunktion Insert

	print_mfd_maske($mfd_list,$row, $id,$next,$ID, $mfd_cols );
}

/**
 * Erstellt eine mfd Detailmaske zum editieren des Datensatzes (Update)
 * HINWEIS : Im rufenden Modul muss post_md = 6 als update ausgewertet werden
 * @param unknown $id
 * @param unknown $ID
 * @param unknown $mfd_list
 * @param unknown $mfd_cols
 */
function print_mfd_edit($id, $ID, $mfd_list, $mfd_cols)
//
//  $id   beinhaltet den zu bearbeitenden Datensatz
//
{
	//  Daten
	//
	$next = mfd_update;	// Datenfunktion Update
	$result = mfd_detail_result($mfd_list, $id);
	$row = mysql_fetch_row($result);


	print_mfd_maske($mfd_list,$row, $id,$next,$ID, $mfd_cols );

}


function print_mfd_del($id, $ID, $mfd_list, $mfd_cols)
{
  $next = mfd_delete;	// Datenfunktion Delete
  $result = mfd_detail_result($mfd_list, $id);
  $row = mysql_fetch_row($result);
  print_mfd_maske($mfd_list,$row, $id,$next,$ID, $mfd_cols );

}


?>