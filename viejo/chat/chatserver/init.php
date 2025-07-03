<?php

// Copyright (C) 2005 Ilya S. Lyubinskiy. All rights reserved.
// Technical support: http://www.php-development.ru/
//
// YOU MAY NOT
// (1) Remove or modify this copyright notice.
// (2) Distribute this code, any part or any modified version of it.
//     Instead, you may link to the homepage of this code:
//     http://www.php-development.ru/products/java-chat/.
// (3) Use this code, any part or any modified version of it
//     as part of another product.
//
// YOU MAY
// (1) Use this code or its customized version on your website.
//
// NO WARRANTY
// This code is provided "as is" without warranty of any kind, either
// expressed or implied, including, but not limited to, the implied warranties
// of merchantability and fitness for a particular purpose. You expressly
// acknowledge and agree that use of this code is at your own risk.


// ----- Configuration Variables -----------------------------------------------

// ----- Authorization key -----

/*
FOR JAVA CHAT:
No authorization keys required.
FOR LIVE CHAT:
$myconfig['auth_key'] should be assigned to the authorization key for your domain.
For example, I keep php scripts here http://ilyalyu.letzebuerg.org/PHPChatServer/.
My domain is 'ilyalyu.letzebuerg.org' (not http://ilyalyu.letzebuerg.org and
not http://ilyalyu.letzebuerg.org/PHPChatServer/chat.php).
Authorization key for my domain is '6a256af5f76058d3abc6accc10d9cf4a'.
I could optionally use 'www.ilyalyu.letzebuerg.org' instead of 'ilyalyu.letzebuerg.org',
but in the authorization key would be different.
To receive authorization key for your domain visit http://www.php-development.ru/PHPChat/.
FOR INSTANT MESSENGER:
Use the same guidelines for $myconfig['auth_keyIM'] variable.
Authorization key for domain 'ilyalyu.letzebuerg.org' is '653a0e4b375baf92fbbce014b364a8e4'.
To receive authorization key for your domain visit http://www.php-development.ru/instant-messenger/.
ADS:
$myconfig['auth_keyAds'] contains the authorization key required for displaying ads.
Use the same guidelines as for $myconfig['auth_key'] variable.
*/

$myconfig['auth_key']    = '';
$myconfig['auth_keyIM']  = '653a0e4b375baf92fbbce014b364a8e4';
$myconfig['auth_keyAds'] = '';

// ----- URLs -----

$myconfig['url_ads']      = '';
$myconfig['url_upload']   = '';
$myconfig['url_download'] = '';

/*
Assign $myconfig['ads_frequency'] to ads rotation frequency in seconds.
*/

$myconfig['ads_frequency'] = 30;

// ----- MySQL -----

/*
FOR LIVE CHAT:
Set $myconfig['use_mysql'] to True if you want to use MySQL.
In this case you will need to execute setup.php script from your browser.
Set $myconfig['use_mysql'] to False if you don't want to use MySQL.
In this case some features will be unavailable.
I suggest that you act step by step and try it without MySQL first.
FOR INSTANT MESSENGER:
MySQL is required. Set $myconfig['use_mysql'] to True.
*/

$myconfig['use_mysql'] = true;

/*
The variables below should be assigned to your database host, username, password,
and database name.
*/

$myconfig['db_host'] = "localhost";
$myconfig['db_user'] = "root";
$myconfig['db_pass'] = "";
$myconfig['db_name'] = "llamatres";


/*
The variables below should be assigned to the table names that you wish to be
used for keeping ignore lists and friend lists.
*/

$myconfig['tbl_info'] = "messenger_info";
$myconfig['tbl_pmsg'] = "messenger_pmsg";


// ----- Port -----

/*
Port for socket connection.
*/

$myconfig['port'] = 9102;


// ----- Connection check -----

/*
Chat Client will check connection with the server from time to time.
Here you can control how often it will be done.
For example, if you set:
$myconfig['send_noop_interval'] =  5;
$myconfig['conn_lost_interval'] = 10;
then Chat Client will check connection after 5 seconds, and it will consider
that connection is lost after 10 seconds if there is no response from server.
*/

$myconfig['send_noop_interval'] =  5;
$myconfig['conn_lost_interval'] = 10;


// ----- Restart -----

/*
Some web hosting providers configure their servers to impose execution time
limits on the scripts. Here you can configure chat server to restart in case
it is terminated due to such limits. However, please check if such actions are
allowed by your hosting provider. If you want this feature on assign
$myconfig['restartonterminate'] to True, otherwise assign it to False.
If you have your own server then you probably do not need this feature.

IMPORTANT:
Please, check that the script runs smoothly with $myconfig['restartonterminate']
set to False first. You should do it because in theory self-restarting script can
act as a dead loop, or in other words it can cause infinite chain of terminations
and restarts which might consume your server resources.

If you are not sure assign $myconfig['restartonterminate'] to False.
*/

$myconfig['restartonterminate'] = False;

/*
Here you can set the delay before the script restarts. For example, if you set:
$myconfig['delayonrestart'] = 1;
then the script will not be restarted more often than once per 1 second.
To see why it should be done check previous comment.

If you are not sure assign $myconfig['delayonrestart'] to 1.
*/

$myconfig['delayonrestart']     = 1;

/*
Assign the variables below to the path to your chat server script.
For example, I keep chat server script here: http://ilyalyu.letzebuerg.org/PHPChatServer/chat.php.
My domain is 'ilyalyu.letzebuerg.org' and the path is '/PHPChatServer/chat.php'.
The variables should be set as follows:
$myconfig['restart_domain'] = 'ilyalyu.letzebuerg.org';
$myconfig['restart_path'  ] = '/PHPChatServer/chat.php';
*/

$myconfig['restart_domain']     = '/webmaster';
$myconfig['restart_path'  ]     = '/chatserver/messenger.php';

// ----- User info -----

/*
If you want your users to have their personal pages and these pages be opened
directly from the Chat Client then you should assign $myconfig['user_info_url']
to the url of such pages (usernames will be passed in the query string).
*/

$myconfig['user_info_url'] = 'http://localhost/chatserver/info.php';


// ----- Shut down command -----

/*
Set $myconfig['shut_down'] to the string will stop chat server execution.
You can use it if you need to make updates to the chat script.
*/

$myconfig['shut_down'] = 'shut down';


// ----- Check password function -----

/*
Use the function below to create custom password checking
*/

function check_password($user, $pass)
{
  return strlen($user) && ($pass === '');
}


// ----- Configuration Settings ------------------------------------------------

error_reporting(E_ALL);
ini_set("log_errors",     0);
ini_set("display_errors", 1);

if ($myconfig['use_mysql'])
{
  mysql_connect($myconfig['db_host'], $myconfig['db_user'], $myconfig['db_pass']);
  mysql_select_db($myconfig['db_name']);
}

?>
