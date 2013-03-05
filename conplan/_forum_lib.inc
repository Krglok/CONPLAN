<?php
/**
 * 
 * 
 * 
 */


/**
 * Erstellt ein ckEditor Element  zu fuer $name mit dem default Text $text
 * Breite=50 und hoehe=34
 * @param unknown $name
 * @param unknown $text
 */
function print_thema_text($name,$text)
{
  echo "\t<td><b>Text</b></td>\n";
//  echo "\t<td><TEXTAREA NAME=\"$name\" COLS=50 ROWS=12></TEXTAREA>&nbsp;</td>\n";
  echo "<td>\n";
  echo "<textarea   name=\"$name\"  COLS=\"60\" ROWS=\"14\" >"; //class=\"ckeditor\"
  echo $text;
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


function print_thema_liste($ID,$foren_id,$user)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;

  if ($foren_id=='')
  {
    $foren_id = 1;
  }
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);

  $q = "SELECT  * from forum_post where foren_id=\"$foren_id\" AND post_id=\"0\" order by id DESC LIMIT 30";
  $result = mysql_query($q) or die("ForumList Fehler...");


  //Macht aus einem Resultset eine HTML Tabelle

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "\t <TABLE  >\n";

  //Header
  $field_num = mysql_num_fields($result);
  echo "\t<tr>\n";
  echo "\t<td width=\"25px\"><i> </i></td>\n";
  echo "\t<td width=\"300px\"><i>Thema</i></td>\n";
  echo "\t<td ><i>Author</i></td>\n";
  echo "\t<td width=\"85px\"><i>Datum</i></td>\n";
  echo "\t<td><b>Anwort<i></td>\n";
  echo "\n</tr>\n";

  //Daten
  while ($row = mysql_fetch_row($result))
  {
    // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
    $count = mysql_fetch_row(mysql_query("select count(*) from forum_post where post_id = \"$row[0]\""));
    echo "\t<tr>\n";
    echo "\t  <td>\n";
    echo "<a href=\"$PHP_SELF?md=2&ID=$ID&id=$row[0]&foren_id=$row[1]&post_id=$row[0]\"> \n";
    //echo "\t  <IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Zeige Thema und Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
    print_menu_icon ("_buble","Öffne Thema");
    echo "\t  </a>\n";
    echo "\t  </td>\n";
    echo "\t  <td>$row[6]&nbsp;</td>\n";
    echo "\t  <td>$row[4]&nbsp;</td>\n";
    echo "\t  <td>$row[5]&nbsp;</td>\n";

    echo "\t  <td>\n";
    echo "\t&nbsp;&nbsp;&nbsp;&nbsp;$count[0]";
    echo "\t  </td>\n";
    echo "\t</tr>\n";
  }
  echo "\t</table>\n";
  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";

  mysql_close($db);

};


function print_thema($ID,$foren_id,$id,$user)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;
  global $user_id;
  //Macht aus einem Resultset eine HTML Tabelle

  if ($foren_id=='')
  {
    $foren_id = 1;
  }
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS)
  or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME) ;

  $q = "SELECT * from forum_post where foren_id=\"$foren_id\" AND (post_id = \"$id\" OR id=\"$id\") order by id";
  $result = mysql_query($q)    or die("Query Fehler...");
  mysql_close($db);

  $style = $GLOBALS['style_datalist'];
  echo "<div $style >";
  echo "<!--  DATEN Spalte   -->\n";

  echo "\t <TABLE>\n";
  echo "\t <TBODY>\n";
  
  //Header
  $field_num = mysql_num_fields($result);
  echo "<tr>\n";
  // 	echo "\t<td width=\"30\"><b>Lesen</b></td>\n";
 	echo "\t<td ></td>\n";
 	echo "\t<td></td>\n";
 	echo "\t<td width=\"500\"><i>Thema</i></td>\n";
 	echo "\t<td width=\"150\"><i>Author</i></td>\n";
 	echo "\t<td width=\"100\"><i>Datum</i></td>\n";
 	echo "\t<td width=\"50\"><i>Anwort</i></td>\n";
// 	echo "\t<td> </td>\n";
 	echo "</tr>\n";

 	//Daten
 	$row = mysql_fetch_row($result);
 	// (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
 	//  HauptBeitrag
 	echo "<tr>";
 	echo "\t<td>\n";
 	if ($user_id==$row[8])
 	{
 	  echo "\t<a href=\"$PHP_SELF?md=5&ID=$ID&id=$row[0]&foren_id=$row[1]&post_id=$row[0]&betreff=Re:$row[6]&next=2\">\n";
 	  print_menu_icon ("_editor","Thema");
 	  echo "\t</a>\n";
 	} else
 	{
 	  print_menu_icon ("_buble","Thema");
 	} 
 	echo "\t</td>\n";
 	echo "\t<td></td>\n";
 	echo "\t<td><b>$row[6]</b></td>\n";
 	echo "\t<td>$row[4]&nbsp;</td>\n";
 	echo "\t<td>$row[5]&nbsp;</td>\n";
 	echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&post_id=$row[0]&betreff=Re:$row[6]&next=2\">\n";
 	print_menu_icon ("_edit","Erstelle eine Anwort zu dem Thema");
 	echo "\t</td>\n";
 	//    	echo "\t<td> </td>\n";
 	echo "</tr>";

 	echo "<tr>";
 	echo "\t<td></td>\n";
 	//	echo "\t<td></td>\n";
 	echo "\t<td ></td>\n";
 	$delimiter="\n";
 	$lines = explode($delimiter, $row[7]);
 	print_textblock_td($lines);
 	echo "\t</tr>\n";
 	//     echo "</table>";
 	// 	echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
 	// 			BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
 	while ($row = mysql_fetch_row($result))
 	{
 	  // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
 	  echo "<tr>";
 	  echo "\t<td></td>\n";
 	  echo "\t<td>\n";
 	 	if ($user_id==$row[8])
     	{
     	  echo "\t<a href=\"$PHP_SELF?md=5&ID=$ID&id=$row[0]&foren_id=$row[1]&post_id=$row[0]&betreff=Re:$row[6]&next=2\">\n";
     	  print_menu_icon ("_editor","Thema");
     	  echo "\t</a>\n";
     	} else
     	{
     	  print_menu_icon ("_buble","Thema");
     	} 
 	  echo "\t</td>\n";
 	  // 		echo "\t<td><a href=\"$PHP_SELF?md=3&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]\">\n";
 	  // 		//echo "\t<IMG SRC=\"images/xview.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
 	  // 		print_menu_icon ("_page");
 	  // 		echo "\t</a></td>\n";
 	  echo "\t<td><b>$row[6]</b></td>\n";
 	  echo "\t<td>$row[4]&nbsp;</td>\n";
 	  echo "\t<td>$row[5]&nbsp;</td>\n";
 	  echo "\t<td><a href=\"$PHP_SELF?md=4&ID=$ID&id=$row[0]&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]&betreff=Re:$row[6]&next=2\">\n";
 	  //echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"\" HSPACE=\"0\" VSPACE=\"0\">\n";
 	  print_menu_icon ("_edit","Erstelle eine Anwort zu dem Thema");
 	  echo "\t</td>\n";
 	  echo "\t</tr>\n";
 	  echo "<tr>";
 	  echo "\t<td></td>\n";
 	  echo "\t</a></td>\n";
 	  echo "\t<td></td>\n";
 	  // 		echo "\t<td></td>\n";
 	  $lines = explode($delimiter, $row[7]);
 	  print_textblock_td($lines);
 	  echo "\t<tr>\n";
 	}
  echo "\t </TBODY>\n";
 	echo "</table>\n";

 	echo '</div>';
 	echo "<!--  ENDE DATEN Spalte   -->\n";

};

function print_thema_lesen($ID,$foren_id,$id,$user)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;

  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME) ;

  // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
  $q = "select * from forum_post where id=\"$id\"";
  $result = mysql_query($q) or die("select Fehler....$q.");

  mysql_close($db);

  //  Daten
  //
  echo "<TD>\n";/// Spalte für Datenbereich

  //  FORMULAR
  echo "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"3\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"$user\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"id\"   VALUE=\"$id\">\n";

  echo "\t <TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
      BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
  //    echo "<CAPTION>Beitrag Lesen</CAPTION>\n";

  $row = mysql_fetch_row($result);
  if ($row[3] == 0)
  {
    $row[3] = $row[0];
  }

  // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)
  echo "<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"$row[1]\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"top_id\" VALUE=\"$row[2]\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$row[2]\">\n";
  echo "<INPUT TYPE=\"hidden\" NAME=\"betreff\" VALUE=\"Re:$row[6]\">\n";

  echo "<tr>\n";
  echo "<td>\n";
  echo "\t <TABLE WIDTH=\"100%\" BORDER=\"0\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
      BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
  echo "\t<tr>\n";
  echo "\t<td WIDTH=\"100\"> </td>\n";
  echo "\t<td><B>Beitrag Lesen</b></td>\n";
  echo "\t<td ></td>\n";
  echo "\t<td>\n";
  echo "\t<td WIDTH=\"35\" ><a href=\"$PHP_SELF?md=4&ID=$ID&foren_id=$row[1]&top_id=$row[2]&post_id=$row[3]&betreff=re:$row[6]\"&next=2>\n";
  //echo "\t<IMG SRC=\"images/feder1.gif\" BORDER=\"0\" HEIGHT=\"20\" WIDTH=\"30\" ALT=\"Antworten\" HSPACE=\"0\" VSPACE=\"0\">\n";
  print_menu_icon ("_edit");
  echo "\t</td>\n";
  echo "\t</table>\n";
  echo "  </td>\n";
  echo "  </tr>\n";
  echo "  <tr>\n";
  echo "  <td>\n";
  echo "\t<table border=0 BGCOLOR=\"\"  >\n";
  echo "\t<tr>\n";
  echo "\t<td WIDTH=\"75\"><B>Datum</B></td>\n";
  echo "\t<td WIDTH=\"100\">$row[5]</td>\n";
  echo "\t<td ><B>Author</B></td>\n";
  echo "\t<td>$row[4]</td>\n";
  echo "\t</table>\n";
  echo "</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td>";
  echo "\t<table border=0 BGCOLOR=\"\"  >\n";
  echo "\t<tr>\n";
  echo "\t<td WIDTH=\"75\"><b>Betreff:</b></td>\n";
  echo "\t<td BGCOLOR=\"#E2D7CF\">$row[6]</td>\n";
  echo "\t</table>\n";
  echo "</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  //C
  //#E9E0DA
  echo "<td  WIDTH=\"400\" HEIGHT=\"200\" BGCOLOR=\"#E9E0DA\">$row[7]</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "\t<td></td>\n";
  echo "</tr>\n";
  echo "</table>\n";
  echo "</FORM>\n";
  echo "</TD>\n"; //  ENDE Spalte Datenbereich
}


function print_thema_erf($ID,$id, $foren_id, $post_id, $author, $datum, $betreff, $text, $user_id,$next, $md)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;
  // DAtenbank zugriff =============================================================
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME) ;

  /*
   $q = "select spieler_id,id,username from user_liste where username=\"$user\"";
  $result = mysql_query($q) or die("select Fehler....$q.");
  $row = mysql_fetch_row($result);
  $spieler_id=$row[0];
  $q = "select id,name,vorname,charakter,email,telefon,geb,bemerkung from spieler where id=\"$spieler_id\" ";
  $result = mysql_query($q) or die("select Fehler....$q.");
  $row = mysql_fetch_row($result);
  $author = $row[2]." ".$row[1];
  */
  $author = get_spieler($_SESSION["spieler_id"]);
  $user_id = $_SESSION["user_id"];
  //	echo "Author : $_SESSION[spieler_id] / $author user_id : $user_id";
  mysql_close($db);
  // Datenbank Ende ================================================================

  //  Daten
  //
  if ($next==2)
  {
    $id = $post_id;
  };
  $d = getdate();
  $datum = $d["year"]."-".$d["mon"]."-".$d["mday"];
  echo "<!--  Daten Spalte    -->\n";

  //  FORMULAR
  echo "\n";
  echo "\t<FORM ACTION=\"$PHP_SELF?md=$md&ID=$ID&post_id=$post_id\" METHOD=POST>\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"5\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"$foren_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$post_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"user_id\" VALUE=\"$user_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"next\" VALUE=\"$next\">\n";

  echo "\t<TABLE WIDTH=\"100%\" BORDER=\"1\"  CELLPADDING=\"1\" CELLSPACING=\"2\" BGCOLOR=\"\" BORDERCOLOR=\"#EDDBCB\"
      BORDERCOLORDARK=\"silver\" BORDERCOLORLIGHT=\"#ECD8C6\">\n";
  echo "\t<P Align=LEFT><B>Lass deine Ideen sprühen\n";

  // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)

  echo "\t<td><b>Author</b></td>\n";
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"author\" SIZE=30 MAXLENGTH=30 VALUE=\"$author \">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td><b>Datum</b></td>\n";
  //    $datum = getdate();
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"datum\" SIZE=30 MAXLENGTH=30 VALUE=\"$datum\">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td><b>Betreff</b></td>\n";
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"betreff\" SIZE=50 MAXLENGTH=50 VALUE=\"$betreff\">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  print_thema_text("text",$text);
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td></td>\n";
  echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
      </td>\n";
  echo "\t</tr>\n";
  echo "\t</table>\n";
  echo "\t</FORM>\n";

  echo "<!--  Daten Spalte ENDE   -->\n\n";
}

/**
 * erzeugt einen EIntrag in der Forentabelle
 * sowohl neue themen als auch antworten auf themen
 * @param unknown $ID
 * @param unknown $foren_id
 * @param unknown $top_id
 * @param unknown $post_id
 * @param unknown $author
 * @param unknown $datum
 * @param unknown $betreff
 * @param unknown $text
 * @param unknown $user_id
 * @return string
 */
function erf_thema($ID, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;

  // Datenbankzugriff =====================
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);
  
//  $author = sql_textcheck($author);
//  $datum  = sql_textcheck($datum);
//  $betreff = sql_textcheck($betreff);
  $text    = sql_textcheck($text);
  
  $q ="INSERT INTO forum_post (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id) VALUES (NULL,\"$foren_id\", \"$top_id\", \"$post_id\", \"$author\", \"$datum\", \"$betreff\", \"$text\", \"$user_id\")";
  $result = mysql_query($q) or die("Forum Insert Fehler....$q");
  $err = "Daten gespeichert ";
  mysql_close($db);
  // Datenbank Ende =======================
  // 	if ($post_id == 0)
    // 	{
    // 		header ("Location: $PHP_SELF?md=1&ID=$ID");  /* Umleitung des Browsers zur PHP-Web-Seite. */
    // 	} else
      // 	{
      // 		header ("Location: $PHP_SELFE?md=2&ID=$ID&id=$id&post_id=$post_id");
      // 	};
      // 	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
      // 	Code ausgeführt wird. */
  return $err;
}

/**
 * Erstellt eine Detailmakse fuer Edit
 * @param unknown $ID
 * @param unknown $id
 * @param unknown $next
 * @param unknown $md
 */
function print_thema_upd($ID,$id, $md)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;
  $next = 6;
  // DAtenbank zugriff =============================================================
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");

  $author = get_spieler($_SESSION["spieler_id"]);
  $user_id = $_SESSION["user_id"];
  
  mysql_select_db($DB_NAME);
  $table = "forum_post"; //$mfd_list["table"];
  $fields = "foren_id, post_id, author, datum, betreff, text, user_id ";  //$fields =$mfd_list["fields"];
  $join = ""; //$mfd_list["join"];
  $where ="id=$id";
  $order = "";
  
  $q = "SELECT $fields FROM $table $join where $where ";
  
  $result = mysql_query($q) ;
  if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $q;
    die($message);
  
  } else
  {
    $row = mysql_fetch_row($result);
    $foren_id = $row[0]; 
    $post_id  = $row[1];
    $author   = $row[2];
    $datum    = $row[3]; 
    $betreff  = $row[4]; 
    $text     = $row[5];    
  }
  if ($post_id==0)
  {
    $post_id=$id;
  }

  mysql_close($db);
  // Datenbank Ende ================================================================

  //  Daten
  //
	$style = $GLOBALS['style_datatab'];
	echo "<div $style >";
	echo "<!--  DATEN Spalte   -->\n";

  //  FORMULAR
  echo "\n";
  echo "\t<FORM ACTION=\"$PHP_SELF?md=$md&ID=$ID&post_id=$post_id\" METHOD=POST>\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"md\"   VALUE=\"$next\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"foren_id\" VALUE=\"$foren_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"post_id\" VALUE=\"$post_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"user_id\" VALUE=\"$user_id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">\n";
  echo "\t<INPUT TYPE=\"hidden\" NAME=\"next\" VALUE=\"$next\">\n";

  echo "\t<P Align=LEFT><B>Lass deine Ideen sprühen\n";
  echo "\t<TABLE>\n";

  // (ID, foren_id, top_id, post_id, author, datum, betreff, text, user_id)

  echo "\t<td><b>Author</b></td>\n";
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"author\" SIZE=30 MAXLENGTH=30 readonly VALUE=\"$author \">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td><b>Datum</b></td>\n";
  //    $datum = getdate();
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"datum\" SIZE=30 MAXLENGTH=30 readonly VALUE=\"$datum\">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td><b>Betreff</b></td>\n";
  echo "\t<td><INPUT TYPE=\"TEXT\" NAME=\"betreff\" SIZE=50 MAXLENGTH=50 VALUE=\"$betreff\">&nbsp;</td>\n";
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  print_thema_text("text",$text);
  echo "\t</tr>\n";
  echo "\t<tr>\n";
  echo "\t<td></td>\n";
  echo "\t<td> <INPUT TYPE=\"SUBMIT\" VALUE=\"SPEICHERN\">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <INPUT TYPE=\"RESET\" VALUE=\"ABBRECHEN\">
      </td>\n";
  echo "\t</tr>\n";
  echo "\t</table>\n";
  echo "\t</FORM>\n";

  echo '</div>';
  echo "<!--  ENDE DATEN Spalte   -->\n";
}


function upd_thema($id, $foren_id, $top_id, $post_id, $author, $datum, $betreff, $text, $user_id)
{
  global $DB_HOST, $DB_USER, $DB_PASS,$DB_NAME;
  global $PHP_SELF;

  // Datenbankzugriff =====================
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("Fehler beim verbinden!");
  mysql_select_db($DB_NAME);

  //  $author = sql_textcheck($author);
  //  $datum  = sql_textcheck($datum);
  //  $betreff = sql_textcheck($betreff);
  $text    = sql_textcheck($text)."\n<i>edit am ".date('Y-m-d/H:i:s',time())."</i>";
  
  $fields = "foren_id=\"$foren_id\", top_id=\"$top_id\", post_id=\"$post_id\", author=\"$author\", datum=\"$datum\", betreff=\"$betreff\", text=\"$text\", user_id=\"$user_id\" ";
  $q ="UPDATE forum_post SET $fields  where id=$id ";
  $result = mysql_query($q) or die("Forum Fehler....$q");
  $err = "Daten gespeichert ";
  mysql_close($db);
  return $err;
}


?>