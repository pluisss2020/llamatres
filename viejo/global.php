<?php


#####################################################################
# PLEASE EDIT THE FOLLOWING VARIABLES:
#####################################################################
require ("aut_config.inc.php");

//global $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
global $nro_mesa;
$username = $sql_usuario;
$password = $sql_pass;
$dir_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT']; # root of your FTP directory
  # you can also limit this to subdirectory, i.e.,
  # $dir_root = $DOCUMENT_ROOT."/www/articles";

$dir_web  = $HTTP_SERVER_VARS['DOCUMENT_ROOT']."/tmptxt"; # root of your WWW directory
$dir_temp = "/tmptxt";
$dir_img_cat = $HTTP_SERVER_VARS['DOCUMENT_ROOT']."/images/ofe";
$dir_img_rec = $HTTP_SERVER_VARS['DOCUMENT_ROOT']."/images/rec";
#####################################################################
# THERE'S NO NEED THE CHANGE THE FOLLOWING
#####################################################################

$header = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<html>
<head>
  <meta HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">
  <meta name=\"robots\" content=\"noindex,nofollow,noarchive\">
  <link rel=\"stylesheet\" type=\"text/css\" href=\"ie.css\">
</head>
";


if (isset($nmsg)) { $msg = base64_decode($nmsg); } else { $msg  = ""; }

if (isset($nfolder)) { # Setting the start directory
  $folder = str_replace("//","/",base64_decode($nfolder));
} else {
  $folder  = $dir_root;
  $nfolder = base64_encode($folder);
}



if (isset($nfile)) {
  $file    = str_replace("//","/",base64_decode($nfile));
  $folder  = dirname($file);
  $nfolder = base64_encode($folder);
}
