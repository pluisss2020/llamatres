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


include 'init.php';

// ----- PHP Configuration -----

ignore_user_abort(true);
set_time_limit(0);

// ----- Auxiliary functions ---------------------------------------------------

// ----- HTMLEncode -----

function HTMLEncode($str)
{
  $trans = Array('"' => '&quot;', '<' => '&lt;', '>' => '&gt;', '&' => '&amp;');
  return strtr($str, $trans);
}

// ----- StringDecode -----

function StringDecode($str, $prefixlen = 3)
{
  $arr = Array();

  while (strlen($str))
  {
    $len   = (integer)substr($str, 0, $prefixlen);
    $arr[] = $len ? substr($str, $prefixlen, $len) : '';
    $str   = substr($str, $prefixlen+$len, strlen($str));
  }

  return $arr;
}

// ----- Array_LastIndex -----

function Array_LastIndex(&$arr)
{
  end($arr);
  list($i, $x) = each($arr);
  return $i;
}


// ----- TServer ---------------------------------------------------------------

define("TServer_ERReconnect", 1);
define("TServer_ERShutDown", -1);

define("TServer_CmdShutDown", "tell: {$myconfig['shut_down']}");
define("TServer_CmdNoop",     "noop");

define("TServer_MsgConfirmConnect",
       "<confirm action=\"connect\" " .
       "key=\"{$myconfig['auth_key']}\" " .
       "keyIM=\"{$myconfig['auth_keyIM']}\" " .
       "keyAds=\"{$myconfig['auth_keyAds']}\" " .
       "urlAds=\"{$myconfig['url_ads']}\" " .
       "freqAds=\"{$myconfig['ads_frequency']}\" " .
       "urlUpload=\"{$myconfig['url_upload']}\" " .
       "urlDownload=\"{$myconfig['url_download']}\" " .
       "noop1=\"{$myconfig['send_noop_interval']}\" " .
       "noop2=\"{$myconfig['conn_lost_interval']}\" />\r\n");
define("TServer_MsgConfirmRead", false);
define("TServer_MsgConfirmNoop", "<confirm action=\"noop\" />\r\n");

class TServer
{
  var $sock        = null;
  var $clientsocks = array();

  // ----- Logs -----

  function log($msg)
  {
    echo htmlentities($msg) . '<br />';
  }

  function errlog($location, $msg)
  {
    echo "Error in TServer::$location with message '$msg'.";
    if ($this->sock) echo ' ' . socket_last_error($this->sock) . '.';
    echo '<br />';
    return 0;
  }

  // ----- Connect -----

  function connect($port)
  {
    if (false === ($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
      return $this->errlog("connect()", "Couldn't create socket");

    socket_setopt($this->sock, SOL_SOCKET, SO_REUSEADDR, 1);

    if (!socket_bind($this->sock, $_SERVER["SERVER_ADDR"], $port))
      return $this->errlog("connect()", "Couldn't bind socket");

    if (!socket_listen($this->sock, 10))
      return $this->errlog("connect()", "Couldn't listen on socket");

    $this->log("");
    $this->log("Server started");

    return 1;
  }

  // ----- Disconnect -----

  function disconnect()
  {
    reset($this->clientsocks);
    while (list($i, $x) = each($this->clientsocks))
    {
      socket_shutdown($this->clientsocks[$i], 2);
      socket_close($this->clientsocks[$i]);
      unset($this->clientsocks[$i]);
    }

    if ($this->sock)
    {
      socket_shutdown($this->sock, 2);
      socket_close($this->sock);
      $this->sock = null;
    }

    $this->log("");
    $this->log("Server shut down");
    $this->log("");
  }

  // ----- Execute -----

  function execute()
  {
    $ExecutionTime = 0;
    $StartTime     = microtime(true);

    while(true)
    {
      $read   = $this->clientsocks;
      $read[] = $this->sock;

      $ExecutionTime += microtime(true)-$StartTime;

      if (false === socket_select($read, $write = null, $except = null, 10))
        return $this->errlog("execute", "Couldn't select socket");

      $StartTime = microtime(true);

      $this->log("");
      $this->log("Time elapsed: " . number_format(round(1000*$ExecutionTime)/1000, 3, '.', '') . ' sec');
      $this->log(count($read) . " socket(s) selected");

      // Accept connection

      if (in_array($this->sock, $read))
      {
        $i = count($this->clientsocks) ? Array_LastIndex($this->clientsocks)+1 : 0;

        if (false === ($this->clientsocks[$i] = socket_accept($this->sock)))
          return $this->errlog("execute", "Couldn't accept connection");
        socket_setopt($this->clientsocks[$i], SOL_SOCKET, SO_REUSEADDR, 1);

        $this->log("Connection accepted from id $i");
        if (is_string(TServer_MsgConfirmConnect))
          $this->write($i, TServer_MsgConfirmConnect);
        $this->on_connect($i);
      }

      reset($this->clientsocks);
      while (list($i, $x) = each($this->clientsocks))
        if (in_array($this->clientsocks[$i], $read))
        {
          $msg = socket_read($this->clientsocks[$i], 4096, PHP_BINARY_READ);

          if (($msg === false) || ($msg === ''))
          {
            // Close connection

            socket_shutdown($this->clientsocks[$i], 2);
            socket_close($this->clientsocks[$i]);
            unset($this->clientsocks[$i]);

            $this->log("Connection closed by id $i");
            $this->on_disconnect($i);
          }
          else
          {
            // Process message

            $msg = substr($msg, 0, strlen($msg)-2);

            if (is_string(TServer_CmdShutDown))
              if ($msg == TServer_CmdShutDown) return TServer_ERShutDown;

            $this->log("Receive from id $i: $msg");

            if (is_string(TServer_MsgConfirmRead))
              $this->write($i, TServer_MsgConfirmRead);

            if (is_string(TServer_CmdNoop) && is_string(TServer_MsgConfirmNoop))
              if ($msg == TServer_CmdNoop)
                $this->write($i, TServer_MsgConfirmNoop);

            $this->on_read($i, $msg);
          }
        }
    }

    return TServer_ERReconnect;
  }

  // ----- Write -----

  function write($id, $msg)
  {
    if (isset($this->clientsocks[$id]))
    {
      socket_write($this->clientsocks[$id], $msg, strlen($msg));
      $this->log("Send to id $id: $msg");
    }
  }

  // ----- Events -----

  function on_connect($id)    {}
  function on_disconnect($id) {}
  function on_read($id, $msg) {}
}

// ----- TServerRooms ----------------------------------------------------------

define("TServerRooms_CmdLogin",  "login: ");
define("TServerRooms_CmdEnter",  "enter: ");
define("TServerRooms_CmdTell",   "tell: ");
define("TServerRooms_CmdTell1",  "tell1: ");
define("TServerRooms_CmdFind",   "find: ");
define("TServerRooms_CmdIgnore", "ignore: ");
define("TServerRooms_CmdInfo",   "info: ");

define("TServerRooms_MsgRequestLogin",     "<login type=\"userpass\" />\r\n");
define("TServerRooms_MsgRerequestLogin",   "<login type=\"userpass+\" />\r\n");

define("TServerRooms_MsgConfirmLogin",     "<confirm action=\"login\" user=\"%user%\" />\r\n");
define("TServerRooms_MsgConfirmRoomEnter", "<confirm action=\"enter\" room=\"%room%\" />\r\n");
define("TServerRooms_MsgConfirmRoomExit",  "<confirm action=\"exit\" />\r\n");
define("TServerRooms_MsgConfirmTell",      "<confirm action=\"tell\" />\r\n");
define("TServerRooms_MsgConfirmTell1",     "<confirm action=\"tell\" />\r\n");

define("TServerRooms_MsgNotifyNewRoom",    "<newroom %roomlist% />\r\n");
define("TServerRooms_MsgNotifyEnter",      "<enter %userlist% />\r\n");
define("TServerRooms_MsgNotifyExit",       "<exit %userlist% />\r\n");

define("TServerRooms_MsgUserInfo",         "<url url=\"%url%\" />\r\n");

define("TServerRooms_Tell",  "<tell user=\"%user%\" color=\"%color%\" msg=\"%msg%\" />\r\n");
define("TServerRooms_Tell1", "<tell type=\"private\" user=\"%user%\" to=\"%to%\" color=\"%color%\" msg=\"%msg%\" />\r\n");

class TServerRooms extends TServer
{
  var $clientcolors = array('C00000', '707000', '00C000', '007070', '0000C0', '700070');
  var $clientnames  = array();
  var $clientrooms  = array();
  var $roomlist     = array();
  var $userlist     = array();

  // ----- chat_write -----

  function chat_write($msg)
  {
    reset($this->clientsocks);
    while (list($i, $x) = each($this->clientsocks)) $this->write($i, $msg);
  }

  // ----- room_write -----

  function room_write($room, $msg)
  {
    $this->roomlist[$room]['time'] = time();

    reset($this->roomlist[$room]['users']);
    while (list($i, $x) = each($this->roomlist[$room]['users'])) $this->write($i, $msg);
  }

  // ----- room_enter -----

  function room_enter($id, $room)
  {
    if (!isset($this->clientnames[$id])) return;
    if ( isset($this->clientrooms[$id])) $this->room_exit($id);

    $room_encode = HTMLEncode($room);
    $name_encode = HTMLEncode($this->clientnames[$id]);

    // New room notifications

    if (!isset($this->roomlist[$room]))
      $this->chat_write(str_replace('%roomlist%', "n0=\"$room_encode\"", TServerRooms_MsgNotifyNewRoom));

    // Enter room and send confirmations

    $this->clientrooms[$id] = $room;
    $this->roomlist[$room]['users'][$id] = $id;
    if (is_string(TServerRooms_MsgConfirmRoomEnter))
      $this->write($id, str_replace('%room%', $room_encode, TServerRooms_MsgConfirmRoomEnter));
    $this->room_write($room, str_replace('%userlist%', "n0=\"$name_encode\"", TServerRooms_MsgNotifyEnter));

    $this->room_getusers($id, $room);
    $this->on_enter($id);
  }

  // ----- room_exit -----

  function room_exit($id)
  {
    if (!isset($this->clientnames[$id])) return;
    if (!isset($this->clientrooms[$id])) return;

    $room        = $this->clientrooms[$id];
    $name_encode = HTMLEncode($this->clientnames[$id]);

    $this->on_exit($id);

    // Exit room and send confirmation

    if (is_string(TServerRooms_MsgConfirmRoomExit))
      $this->write($id, TServerRooms_MsgConfirmRoomExit);
    $this->room_write($room, str_replace('%userlist%', "n0=\"$name_encode\"", TServerRooms_MsgNotifyExit));
    unset($this->clientrooms[$id]);
    unset($this->roomlist[$room]['users'][$id]);
  }

  // ----- room_getusers -----

  function room_getusers($id)
  {
    if (!isset($this->clientnames[$id])) return;
    if (!isset($this->clientrooms[$id])) return;

    $room  = $this->clientrooms[$id];

    $users = array();
    reset($this->roomlist[$room]['users']);
    while (list($i, $x) = each($this->roomlist[$room]['users']))
      $users[] = HTMLEncode($this->clientnames[$i]);
    reset($users);
    while (list($i, $x) = each($users)) $users[$i] = 'n' . $i . '="' . $x . '"';
    $users = implode(' ', $users);

    $this->write($id, str_replace('%userlist%', $users, TServerRooms_MsgNotifyEnter));
  }

  // ----- on_connect -----

  function on_connect($id)
  {
    parent::on_connect($id);
    $this->write($id, TServerRooms_MsgRequestLogin);
  }

  // ----- on_login -----

  function on_login($id)
  {
    $rooms = array();
    reset($this->roomlist);
    while (list($i, $x) = each($this->roomlist)) $rooms[] = HTMLEncode($i);
    reset($rooms);
    while (list($i, $x) = each($rooms)) $rooms[$i] = 'n' . $i . '="' . $x . '"';
    $rooms = implode(' ', $rooms);

    $this->write($id, str_replace('%roomlist%', $rooms, TServerRooms_MsgNotifyNewRoom));
  }

  // ----- on_disconnect -----

  function on_disconnect($id)
  {
    $this->room_exit($id);
    unset($this->userlist[$this->clientnames[$id]]);
    unset($this->clientnames[$id]);

    parent::on_disconnect($id);
  }

  // ----- on_read -----

  function on_read($id, $msg)
  {
    // Login

    if (strpos($msg, TServerRooms_CmdLogin) === 0)
    {
      $msg  = substr($msg, strlen(TServerRooms_CmdLogin));
      list($user, $pass) = StringDecode($msg);

      if ($this->on_checkpass($user, $pass))
      {
        $this->clientnames[$id] = $user;
        $this->userlist[ $user] = $id;

        if (is_string(TServerRooms_MsgConfirmLogin))
          $this->write($id, str_replace('%user%', HTMLEncode($user), TServerRooms_MsgConfirmLogin));

        $this->on_login($id);
      }
      else $this->write($id, TServerRooms_MsgRerequestLogin);

      return;
    }

    if (!isset($this->clientnames[$id])) return;

    // Enter room

    if (strpos($msg, TServerRooms_CmdEnter) === 0)
    {
      $msg = substr($msg, strlen(TServerRooms_CmdEnter));
      $this->room_enter($id, $msg);
      return;
    }

    // Tell

    if (strpos($msg, TServerRooms_CmdTell) === 0)
    {
      if (is_string(TServerRooms_MsgConfirmTell))
        $this->write($id, TServerRooms_MsgConfirmTell);

      $msg   = substr($msg, strlen(TServerRooms_CmdTell));
      $trans = Array('%user%'  => HTMLEncode($this->clientnames[$id]),
                     '%color%' => $this->clientcolors[$id % count($this->clientcolors)],
                     '%msg%'   => HTMLEncode($msg));
      $msg   = strtr(TServerRooms_Tell, $trans);

      if (isset($this->clientrooms[$id])) $this->room_write($this->clientrooms[$id], $msg);
      return;
    }

    // Tell private

    if (strpos($msg, TServerRooms_CmdTell1) === 0)
    {
      if (is_string(TServerRooms_MsgConfirmTell1))
        $this->write($id, TServerRooms_MsgConfirmTell1);

      $msg = substr($msg, strlen(TServerRooms_CmdTell1));
      list($user, $msg) = StringDecode($msg);
      $trans = Array('%user%'  => HTMLEncode($this->clientnames[$id]),
                     '%to%'    => HTMLEncode($user),
                     '%color%' => $this->clientcolors[$id % count($this->clientcolors)],
                     '%msg%'   => HTMLEncode($msg));
      $msg   = strtr(TServerRooms_Tell1, $trans);

      if (isset($this->userlist[$user]))
      {
        $this->write($id, $msg);
        if ($this->on_accept_private($this->userlist[$user], $id))
          $this->write($this->userlist[$user], $msg);
      }
      else $this->on_private_offline($id, $user, $msg);

      return;
    }

    // Find user

    if (strpos($msg, TServerRooms_CmdFind) === 0)
    {
      $msg   = $this->on_find($id, substr($msg, strlen(TServerRooms_CmdFind)));
      $trans = Array('%user%'  => 'System',
                     '%to%'    => HTMLEncode($this->clientnames[$id]),
                     '%color%' => '000000',
                     '%msg%'   => HTMLEncode($msg));
      if ($msg !== false) $this->write($id, strtr(TServerRooms_Tell, $trans));
    }

    // Ignore/unignore

    if (strpos($msg, TServerRooms_CmdIgnore) === 0)
    {
      $msg   = $this->on_ignore($id, substr($msg, strlen(TServerRooms_CmdIgnore)));
      $trans = Array('%user%'  => 'System',
                     '%to%'    => HTMLEncode($this->clientnames[$id]),
                     '%color%' => '000000',
                     '%msg%'   => HTMLEncode($msg));
      if ($msg !== false) $this->write($id, strtr(TServerRooms_Tell, $trans));
    }

    // User details

    if (strpos($msg, TServerRooms_CmdInfo) === 0)
    {
      $msg   = $this->on_info($id, substr($msg, strlen(TServerRooms_CmdInfo)));
      $trans = Array('%user%'  => 'System',
                     '%to%'    => HTMLEncode($this->clientnames[$id]),
                     '%color%' => '000000',
                     '%msg%'   => HTMLEncode($msg));
      if ($msg !== false) $this->write($id, strtr(TServerRooms_Tell, $trans));
    }

    parent::on_read($id, $msg);
  }

  // ----- Events -----

  function on_checkpass($user, $pass)
  {
    return check_password($user, $pass);
  }

  function on_enter($id) {}
  function on_exit ($id) {}

  function on_find($id, $msg)
  {
    if (isset($this->userlist[$msg]) && isset($this->clientrooms[$this->userlist[$msg]]))
      return "$msg is currently in the room \"{$this->clientrooms[$this->userlist[$msg]]}\"!";
    return "$msg is not online!";
  }

  function on_info($id, $msg)
  {
    $this->write($id, str_replace('%url%',
                                  HTMLEncode($GLOBALS['myconfig']['user_info_url'] . '?user=' . URLEncode($msg)),
                                  TServerRooms_MsgUserInfo));
    return false;
  }

  function on_ignore($id, $msg) { return 'Ignore list is not implemented on this server!'; }

  function on_accept_private($id, $id_from) { return true; }

  function on_private_offline($id, $name, $msg)
  {
    $trans = Array('%user%'  => 'System',
                   '%to%'    => HTMLEncode($this->clientnames[$id]),
                   '%color%' => '000000',
                   '%msg%'   => HTMLEncode("The message can't be sent! The user is offline!"));
    $this->write($id, strtr(TServerRooms_Tell, $trans));
  }
}

// ----- TServerRoomsSQL -------------------------------------------------------

define("TServerRoomsSQL_MsgGroup",     "<group name=\"%name%\" %userlist% />\r\n");
define("TServerRoomsSQL_MsgDelGroup",  "<delgr name=\"%name%\" />\r\n");
define("TServerRoomsSQL_MsgDelFriend", "<delfr name=\"%name%\" fname=\"%fname%\" />\r\n");

define("TServerRoomsSQL_MsgOnline",    "<online name=\"%name%\" />\r\n");
define("TServerRoomsSQL_MsgOffline",   "<offline name=\"%name%\" />\r\n");

define("TServerRoomsSQL_MsgTransferFile", "<file user=\"%user%\" file=\"%file%\" tmp=\"%tmp%\" />\r\n");


define("TServerRoomsSQL_CmdAddGroup",  "add_group: " );
define("TServerRoomsSQL_CmdDelGroup",  "del_group: " );
define("TServerRoomsSQL_CmdAddFriend", "add_friend: ");
define("TServerRoomsSQL_CmdDelFriend", "del_friend: ");
define("TServerRoomsSQL_CmdTransferFile",  "file: ");


class TServerRoomsSQL extends TServerRooms
{
  var $info = Array();

  var $info_default = Array("ignorelist" => Array(),
                            "friendlist" => Array("General" => Array()),
                            "notifylist" => Array());

  // ----- load_info -----

  function load_info($user)
  {
    $user   = mysql_real_escape_string($user);
    $result = mysql_query("select info from {$GLOBALS['myconfig']['tbl_info']}
                           where user = '$user'");
    if ($row = mysql_fetch_assoc($result)) return unserialize($row['info']);

    mysql_query("insert into {$GLOBALS['myconfig']['tbl_info']} (user, info)
                 values ('$user', '" . serialize($this->info_default) . "')");
    return $this->info_default;
  }

  // ----- save_info -----

  function save_info($user, $info)
  {
    $user = mysql_real_escape_string($user);
    $info = mysql_real_escape_string(serialize($info));

    mysql_query("update {$GLOBALS['myconfig']['tbl_info']} set
                 info = '$info' where user = '$user'");
  }

  // ----- notifylist_add -----

  function notifylist_add($user, $friend)
  {
    if (isset($this->userlist[$user]))
      $this->info[$this->userlist[$user]]['notifylist'][$friend] = $friend;

    $user = mysql_real_escape_string($user);
    $info = $this->load_info($user);
    $info['notifylist'][$friend] = $friend;
    $this->save_info($user, $info);
  }

  // ----- notifylist_del -----

  function notifylist_del($user, $friend)
  {
    if (isset($this->userlist[$user]))
      unset($this->info[$this->userlist[$user]]['notifylist'][$friend]);

    $user = mysql_real_escape_string($user);
    $info = $this->load_info($user);
    unset($info['notifylist'][$friend]);
    $this->save_info($user, $info);
  }

  // ----- del_friend -----

  function del_friend($id, $group, $friend)
  {
    unset($this->info[$id]['friendlist'][$group][$friend]);
    $this->save_info($this->clientnames[$id], $this->info[$id]);

    $del = True;
    reset($this->info[$id]['friendlist']);
    while (list($i, $x) = each($this->info[$id]['friendlist']))
      if (isset($x[$friend])) $del = False;
    if ($del) $this->notifylist_del($friend, $this->clientnames[$id]);

    $trans = Array('%name%' => HTMLEncode($group), '%fname%' => HTMLEncode($friend));
    $this->write($id, strtr(TServerRoomsSQL_MsgDelFriend, $trans));
  }

  // ----- on_login -----

  function on_login($id)
  {
    parent::on_login($id);
    $this->info[$id] = $this->load_info($this->clientnames[$id]);

    // Notify Friends

    $msg = str_replace('%name%', HTMLEncode($this->clientnames[$id]), TServerRoomsSQL_MsgOnline);

    reset($this->info[$id]['notifylist']);
    while (list($i, $x) = each($this->info[$id]['notifylist']))
      if (isset($this->userlist[$i])) $this->write($this->userlist[$i], $msg);

    // Send Friend List

    reset($this->info[$id]['friendlist']);
    while (list($i, $group) = each($this->info[$id]['friendlist']))
    {
      $userlist = Array();

      reset($group);
      while (list($j, $friend) = each($group))
        if (isset($this->userlist[$friend]))
             $userlist[]   = '+' . HTMLEncode($friend);
        else $userlist[]   = '-' . HTMLEncode($friend);
      reset($userlist);
      while (list($j, $friend) = each($userlist)) $userlist[$j] = "n$j=\"$friend\"";

      $trans = Array('%name%'     => HTMLEncode($i),
                     '%userlist%' => implode(' ', $userlist));

      $this->write($id, strtr(TServerRoomsSQL_MsgGroup, $trans));
    }
  }

  // ----- on_disconnect -----

  function on_disconnect($id)
  {
    if (isset($this->clientnames[$id]) && isset($this->info[$id]))
    {
      $msg = str_replace('%name%', HTMLEncode($this->clientnames[$id]), TServerRoomsSQL_MsgOffline);

      reset($this->info[$id]['notifylist']);
      while (list($i, $x) = each($this->info[$id]['notifylist']))
        if (isset($this->userlist[$i])) $this->write($this->userlist[$i], $msg);
    }

    parent::on_disconnect($id);
  }

  // ----- on_ignore -----

  function on_ignore($id, $msg)
  {
    if ($msg == $this->clientnames[$id])
      return "You can't add yourself to ignore list!";

    if (isset($this->info[$id]['ignorelist'][$msg]))
    {
      unset($this->info[$id]['ignorelist'][$msg]);
      $this->save_info($this->clientnames[$id], $this->info[$id]);
      return 'The user is removed from ignore list!';
    }
    else
    {
      reset($this->info[$id]['friendlist']);
      while (list($i, $x) = each($this->info[$id]['friendlist']))
        if (isset($this->info[$id]['friendlist'][$i][$msg]))
          $this->del_friend($id, $i, $msg);

      $this->info[$id]['ignorelist'][$msg] = $msg;
      $this->save_info($this->clientnames[$id], $this->info[$id]);
      return 'The user is added to ignore list!';
    }
  }

  // ----- on_accept_private -----

  function on_accept_private($id, $id_from)
  {
    return !isset($this->info[$id]['ignorelist'][$this->clientnames[$id_from]]);
  }

  // ----- on_read -----

  function on_read($id, $msg)
  {
    // Add Group

    if (strpos($msg, TServerRoomsSQL_CmdAddGroup) === 0)
    {
      $msg = substr($msg, strlen(TServerRoomsSQL_CmdAddGroup));

      if (!isset($this->info[$id]['friendlist'][$msg]))
        $this->info[$id]['friendlist'][$msg] = Array();
      $this->save_info($this->clientnames[$id], $this->info[$id]);

      $trans = Array('%name%' => HTMLEncode($msg), '%userlist%' => '');
      $this->write($id, strtr(TServerRoomsSQL_MsgGroup, $trans));

      return;
    }

    // Del Group

    if (strpos($msg, TServerRoomsSQL_CmdDelGroup) === 0)
    {
      $msg = substr($msg, strlen(TServerRoomsSQL_CmdDelGroup));
      unset($this->info[$id]['friendlist'][$msg]);
      $this->save_info($this->clientnames[$id], $this->info[$id]);

      $trans = Array('%name%' => HTMLEncode($msg));
      $this->write($id, str_replace('%name%', HTMLEncode($msg), TServerRoomsSQL_MsgDelGroup));

      return;
    }

    // Add Friend

    if (strpos($msg, TServerRoomsSQL_CmdAddFriend) === 0)
    {
      $msg = substr($msg, strlen(TServerRoomsSQL_CmdAddFriend));

      list($group, $friend) = StringDecode($msg);
      unset($this->info[$id]['ignorelist'][$friend]);
      $this->info[$id]['friendlist'][$group][$friend] = $friend;
      $this->save_info($this->clientnames[$id], $this->info[$id]);

      $this->notifylist_add($friend, $this->clientnames[$id]);

      if (isset($this->userlist[$friend]))
           $trans = Array('%name%' => HTMLEncode($group), '%userlist%' => 'n0="+' . HTMLEncode($friend) . '"');
      else $trans = Array('%name%' => HTMLEncode($group), '%userlist%' => 'n0="-' . HTMLEncode($friend) . '"');
      $this->write($id, strtr(TServerRoomsSQL_MsgGroup, $trans));

      return;
    }

    // Del Friend

    if (strpos($msg, TServerRoomsSQL_CmdDelFriend) === 0)
    {
      $msg = substr($msg, strlen(TServerRoomsSQL_CmdDelFriend));
      list($group, $friend) = StringDecode($msg);
      $this->del_friend($id, $group, $friend);

      return;
    }

    // Transfer File

    if (strpos($msg, TServerRoomsSQL_CmdTransferFile) === 0)
    {
      $msg = substr($msg, strlen(TServerRoomsSQL_CmdTransferFile));
      list($user, $file, $tmp) = StringDecode($msg);

      if (isset($this->userlist[$user]))
      {
        $trans = Array('%user%' => HTMLEncode($this->clientnames[$id]),
                       '%file%' => HTMLEncode($file),
                       '%tmp%'  => HTMLEncode($tmp));
        $this->write($this->userlist[$user], strtr(TServerRoomsSQL_MsgTransferFile, $trans));
      }
    }

    parent::on_read($id, $msg);
  }
}

// ----- Main ------------------------------------------------------------------

session_name('ChatClient');
session_id  (mt_rand());
session_start();

// ----- Shut Down -----

function restart()
{
  $_SESSION['server']->write(0, "<tell user=\"System\" color=\"000000\" msg=\"Restart\" />\r\n");
  $_SESSION['server']->write(0, "<restart />\r\n");
  $_SESSION['server']->disconnect();

  if (!$GLOBALS['myconfig']['restartonterminate']) return;

  $fp = fsockopen("{$GLOBALS['myconfig']['restart_domain']}", 80, $errno, $errstr, 30);
  if ($fp)
  {
    $out  = "GET {$GLOBALS['myconfig']['restart_path']} HTTP/1.1\r\n";
    $out .= "Host: {$GLOBALS['myconfig']['restart_domain']}\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
    fclose($fp);
  }
}

// ----- Server Execute -----

if ($myconfig['use_mysql'])
     $_SESSION['server'] = new TServerRoomsSQL();
else $_SESSION['server'] = new TServerRooms();

if ($_SESSION['server']->connect($myconfig['port']))
{
  sleep($myconfig['delayonrestart']);
  register_shutdown_function('restart');
  $_SESSION['server']->execute();
}

?>
