<?php
/*
 Projekt : ADMIN

 Datei   :  _edit.php,v $

 Datum   :  2013/02/14

 Rev.    :  3.0

 Author  :  Olaf Duda

 beschreibung :
 Dies ist die libary zum einbinden des ckEdior, ein js library-
 Die library enthaelt alle relevanten configurationen und Tools , 
 die zum Betrieb des Editors notwendig sind. 

CKEditor - The text editor for Internet - http://ckeditor.com
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.

Licensed under the terms of any of the following licenses at your
choice:

 - GNU General Public License Version 2 or later (the "GPL")
   http://www.gnu.org/licenses/gpl.html
   (See Appendix A)

 - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
   http://www.gnu.org/licenses/lgpl.html
   (See Appendix B)

 - Mozilla Public License Version 1.1 or later (the "MPL")
   http://www.mozilla.org/MPL/MPL-1.1.html
   (See Appendix C)

You are not required to, but if you want to explicitly declare the
license you have chosen to be bound to when using, reproducing,
modifying and distributing this software, just include a text file
titled "legal.txt" in your version of this software, indicating your
license choice. In any case, your choice will not restrict any
recipient of your version of this software to use, reproduce, modify
and distribute this software under any of the above licenses.

  es ist ein spezieller header notwendig um den Editor einzubinden.
  
 */
include_once '_config.inc';
include_once '_lib.inc';
include_once '_head.inc';


/**
 * erstellt einne html Header mit css-Layout
 * @param unknown $NAME, enthält den Seitennamen
 */
function print_header_admin ($NAME)
{
  global $grp_name ;
  global $layout_path ;
  global $version ;

  echo "<HTML>\n";
  echo "<!-- PHP ".phpversion()." / Drachenhorst Framework $version / 2013-->\n";
  echo "<HEAD>\n";
  echo "<TITLE></TITLE>\n";
  echo "<META NAME=\"Description\" CONTENT=\"$grp_name \">\n";
  echo "<META NAME=\"Keywords\" CONTENT=\"LARP $NAME\">\n";
  echo "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
  echo"  <title>$grp_name $NAME </title> \n";
  echo"  <link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/konzept1.css\">  \n";
  echo"  <script src=\"js/test1.js\" type=\"text/javascript\"></script>  \n";
  echo"  <script src=\"/ckeditor/ckeditor.js\"></script> \n";
  echo "</HEAD>\n";
  echo "\n";
}

function POST_editor1($value = "")
{
  if (isset($_POST['editor1'])==true)
  {
    return $_POST['editor1'];
  }
  return false;
  }

/**
 * Liefert die Textzeilen fuer einen Pages Header
 * @return string
 */  
function get_template_header()
{
    global $version;
    global $grp_name;
    global $layout_path;
    
	$template[0] = "<HTML>\n";
	$template[1] = "<!-- PHP ".phpversion()." / Drachenhorst Framework $version / 2013-->\n";
    $template[2] = "<!-- PHP Template Pages Header -->\n";
	$template[3] = "<HEAD>\n";
	$template[5] = "<META NAME=\"Description\" CONTENT=\"$grp_name \">\n";
	$template[6] = "<META NAME=\"Keywords\" CONTENT=\"Pages Template\">\n";
	$template[7] = "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
	$template[8] = "<title>Pages Template</title> \n";
	$template[9] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/konzept1.css\">  \n";
	$template[10] = "</HEAD>\n";
	$template[11] = "\n";
	return $template;
}  

function get_template_bodystart()
{
  $template[0] = "<!-- PHP Template Pages Body-->\n";
  $template[1] =  "<body>\n  ";
  return $template;
}

function get_template_end()
{
  $template[0] = "<!-- PHP Template Pages Body Ende -->\n";
  $template[1] =  "</body>\n  ";
  $template[2] =  "</html>\n>\n  ";
  return $template;
}

function appendarray($a, $b)
{
  $i=0;
  $c = array_values ($a);
  $i = count($c);
  $d = array_values($b);
  for ($j=0; $j<count($d); $j++)
  {
    $c[$i+$j] = $d[$j];
  }
  return $c;
}

function make_html_page($data)
{
// 	$header = get_template_header();
// 	$body   = get_template_bodystart();
// 	$end	= get_template_end();
    $lines[0] = "<html>";
    $lines[0] = "<body>";
	$lines[1] = $data;
    $lines[2] = "</body>";
    $lines[0] = "</html>";
    $page = $lines;
	// 	$page = appendarray($header, $body);
// 	$page = appendarray($page, $lines);
// 	$page = appendarray($page, $end);	
	return $page;
}

/**
 * Liest die HTML page ein 
 * und gibt die als Array of lines zurück
 * @param $path  string mit dem dateipfad, relativ zur homepage   
 * @param $name  dateiname
 * @return array <string>
 */
function lese_html_lines ($path,$name)
{
	$html_file = $path."/".$name;
	$page = read_html_page($html_file);
	$lines = $page; //get_htmlbody($page);
	return $lines;
}

/**
 * Schreibt die Textzeilen ($page) in den file ($filename)
 * ACHTUNG, es wird gnadenlos ueberschrieben !!! 
 * @param unknown $filename
 * @param unknown $page
 */
function write_html_file($filename, $page)
{
		// In our example we're opening $filename in append mode.
		// The file pointer is at the bottom of the file hence
		// that's where $somecontent will go when we fwrite() it.
		if (!$handle = fopen($filename, 'w')) 
		{
			echo "Cannot open file ($filename)";
			return FALSE;
		}
//		echo count($page);
		for($i=0; $i<count($page); $i++)
		{	
		  $data = $page[$i];
			// Write $somecontent to our opened file.
			if (fwrite($handle, $data) === FALSE) 
			{
			echo "Cannot write to file ($filename)";
			exit;
			}
		}
		fclose($handle);
		return TRUE;
	
}

function schreibe_hmtl_lines($path,$name,$data)
{
	$html_file = $path."/".$name;
	$page =	make_html_page($data);
//	echo":".$page[(count($page)-2)]."<br>";
//	echo":".$page[(count($page)-1)]."<br>";
	write_html_file($html_file, $page);
}


?>