<?php
/*
 * 
 * 
 */

include_once "_lib.inc";

function print_kopf_planung ($bereich,$anrede, $menu_item)
{

  $info = "Login aufrufen";
  $formel = $anrede["formel"];
  $name   = $anrede["name"];
  //  echo "<div id=\"div_1\">\n";
  $style = $GLOBALS["style_header_1"];
  echo "  <div $style >\n";
  $style = $GLOBALS["style_headerleft"];
  echo "    <div $style >\n";
  print_header_icon($GLOBALS["logo_typ"]);
  echo "    </div>\n";
  $style = $GLOBALS['style_headermain'];
  echo "    <div $style >\n";
  print_header_icon("sl_header.gif");
  echo "    </div>\n";
  $style = $GLOBALS['style_headerright'];
  echo "    <div $style >\n";
  echo "      <p>$bereich</p>\n";
  echo "      <p>$formel</p>\n";
  echo "      <p>$name</p>\n";
  if ($menu_item['icon'] != "0")
  {
    $style = "id=\"headermenuitem\""; //$GLOBALS['style_menu_item'];
    echo "      <div $style >\n";
    print_menu_item($menu_item);
    //           print_menu_icon($typ,$info);
    //           print_menu_ref("Login", $ref);
    echo "    	</div>\n";
  } else
  {
    $caption = $menu_item['caption'];
    echo "      <p>$caption</p>\n";
  }
  echo "    </div>\n";
  echo "  </div>\n";
  echo "\n\n";
};


?>