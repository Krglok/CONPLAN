<?php
/*
 Projekt : ADMIN

 Datei   :  _edit.php,v $

 Datum   :  2013/02/14

 Rev.    :  1.0

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
 * @param unknown $NAME, enth�lt den Seitennamen
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
  echo"  <script src=\"/ckeditor/ckeditor.js\"></script> \n";
  echo"  <script src=\"js/test1.js\" type=\"text/javascript\"></script>  \n";
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
	$template[0] = "<HTML>\n";
	$template[1] = "<!-- PHP ".phpversion()." / Drachenhorst Framework $version / 2013-->\n";
	$template[2] = "<HEAD>\n";
	$template[3] = "<TITLE></TITLE>\n";
	$template[4] = "<META NAME=\"Description\" CONTENT=\"$grp_name \">\n";
	$template[5] = "<META NAME=\"Keywords\" CONTENT=\"Pages Template\">\n";
	$template[6] = "<META NAME=\"Author\" CONTENT=\"Dipl. Ing. Olaf Duda\">\n";
	$template[7] = "<title>Pages Template</title> \n";
	$template[8] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"$layout_path/konzept1.css\">  \n";
	$template[9] = "</HEAD>\n";
	$template[10] = "\n";
	return $template;
}  

function get_template_bodystart()
{
	$template[0] =  "<body>\n  ";
	return $template;
	
}

function get_template_end()
{
	$template[0] =  "</body>\n  ";
	$template[1] =  "</html>\n>\n  ";
	return $template;
	
}

function make_html_page($lines)
{
	$header = get_template_header();
	$body   = get_template_bodystart();
	$end		= get_template_end();
	$page = array_merge($header,$body,$lines,$end);
	return $page;
}

function lese_html_lines ($path,$name)
{
	$html_file = $path."/".$name;
	$page = read_html_page($html_file);
	$lines = get_htmlbody($page);
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
	if (is_writable($filename)) 
	{
		// In our example we're opening $filename in append mode.
		// The file pointer is at the bottom of the file hence
		// that's where $somecontent will go when we fwrite() it.
		if (!$handle = fopen($filename, 'w')) 
		{
			echo "Cannot open file ($filename)";
			return FALSE;
		}
		foreach ($page as $line)
		{	
			// Write $somecontent to our opened file.
			if (fwrite($handle, $line) === FALSE) 
			{
			echo "Cannot write to file ($filename)";
			exit;
			}
		}
		fclose($handle);
		return TRUE;
	} else 
	{
		echo "The file $filename is not writable";
		return FALSE;
	}
	
}

function schreibe_hmtl_lines($path,$name,$lines)
{
	$html_file = $path."/".$name;
	$page =	make_html_page($lines);
	write_html_file($html_file, $page);
}


?>