// <script>

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

// ----- Popup Control ---------------------------------------------------------

function popup_display(x)
{
  win = window.open();
  for (var i in x) win.document.write(i+' = '+x[i]+'<br>');
}

// ----- Show Aux -----

function popup_show_aux(parent, child)
{
  var p = document.getElementById(parent);
  var c = document.getElementById(child);

  p.className = "active";

  var top  = (c["popup_position"] == "y") ? p.offsetHeight+2 : 0;
  var left = (c["popup_position"] == "x") ? p.offsetWidth +2 : 0;

  for (; p; p = p.offsetParent)
  {
    if (p.style.position != "absolute")
    {
      top  += p.offsetTop;
      left += p.offsetLeft;
    }
  }

  c.style.position   = "absolute";
  c.style.top        = top +'px';
  c.style.left       = left+'px';
  c.style.visibility = "visible";
}

// ----- Show -----

function popup_show()
{
  p = document.getElementById(this["popup_parent"]);
  c = document.getElementById(this["popup_child" ]);

  popup_show_aux(p.id, c.id);

  clearTimeout(c["popup_timeout"]);
}

// ----- Hide Aux -----

function popup_hide_aux(parent, child)
{
  document.getElementById(parent).className       = 'parent';
  document.getElementById(child).style.visibility = 'hidden';
}

// ----- Hide -----

function popup_hide()
{
  p = document.getElementById(this["popup_parent"]);
  c = document.getElementById(this["popup_child"]);

  c["popup_timeout"] = setTimeout("popup_hide_aux('"+p.id+"', '"+c.id+"');", 100);
}

// ----- Click -----

function popup_click()
{
  p = document.getElementById(this["popup_parent"]);
  c = document.getElementById(this["popup_child" ]);

  if (c.style.visibility != "visible") popup_show_aux(p.id, c.id);
  else c.style.visibility = "hidden";

  return false;
}

// ----- Attach -----

function popup_attach(parent, child, showtype, position, cursor)
{
  p = document.getElementById(parent);
  c = document.getElementById(child);

  p["popup_parent"]     = p.id;
  c["popup_parent"]     = p.id;
  p["popup_child"]      = c.id;
  c["popup_child"]      = c.id;
  p["popup_position"]   = position;
  c["popup_position"]   = position;

  c.style.position   = "absolute";
  c.style.visibility = "hidden";

  if (cursor != undefined) p.style.cursor = cursor;

  switch (showtype)
  {
    case "click":
      p.onclick     = popup_click;
      p.onmouseout  = popup_hide;
      c.onmouseover = popup_show;
      c.onmouseout  = popup_hide;
      break;
    case "hover":
      p.onmouseover = popup_show;
      p.onmouseout  = popup_hide;
      c.onmouseover = popup_show;
      c.onmouseout  = popup_hide;
      break;
  }
}


// ----- ChatClient Tabs -------------------------------------------------------

function ChatClientTab(tab)
{
  if (!ChatClientUsername && tab != 'tab_login') { alert('Please, login first!'); return; }

  document.getElementById('tab_login' ).style.display = 'none';
  document.getElementById('tab_chat'  ).style.display = 'none';
  document.getElementById('tab_select').style.display = 'none';
  document.getElementById('tab_rules' ).style.display = 'none';
  document.getElementById(tab         ).style.display = 'block';
}


// ----- ChatClient Auxiliary --------------------------------------------------

// ----- Variables -----

var ChatClientUsername = '';
var ChatClientPassword = '';

var ChatClientRoom  = '';
var ChatClientRooms = new Array();
var ChatClientUsers = new Array();
var ChatClientQueue = Array();

// ----- Send -----

function ChatClientSend()
{
  return (ChatClientQueue.length > 0) ? ChatClientQueue.shift() : "";
}

// ----- Encode -----

function ChatClientEncode(strings, prefix)
{
  var result = "";

  for (i = 0; i < strings.length; i++)
  {
    var length  = strings[i].length.toString();
    result += length;
    for (j = 0; j < prefix-length.length; j++) result += ' ';
    result += strings[i];
  }

  return result;
}

// ----- To Screen -----

function ChatClientToScreen(str)
{
  document.getElementById('ChatClientChat').innerHTML += '<div>'+str+'</div>';
  document.getElementById('ChatClientChat').scrollTop = 1000000;
}


// ----- ChatClient Confirm ----------------------------------------------------

// ----- Login -----

function ChatClientConfirmLogin(user)
{
  ChatClientUsername = user;
  ChatClientPassword = document.forms['ChatClientLogin']['password'].value;
  ChatClientTab('tab_chat');
  ChatClientToScreen('System: Login as <b>'+user+'</b>');
}

// ----- Enter -----

function ChatClientConfirmEnter(room)
{
  ChatClientRoom = room;
  ChatClientTab('tab_chat');
  ChatClientToScreen('System: Enter room <b>'+room+'</b><hr />');
}

// ----- Exit -----

function ChatClientConfirmExit()
{
  ChatClientRoom  = '';
  ChatClientUsers = new Array();
  ChatClientToScreen('<hr />System: Exit room');
  document.getElementById('ChatClientUsers').innerHTML = '';
}

// ----- Tell -----

function ChatClientConfirmTell()
{
  document.forms['ChatClientTell'   ]['Tell'].value = '';
  document.forms['ChatClientPrivate']['Tell'].value = '';
}

// ----- ChatClient Action -----------------------------------------------------

// ----- Login -----

function ChatClientDoLogin()
{
  data = new Array(document.forms['ChatClientLogin']['username'].value,
                   document.forms['ChatClientLogin']['password'].value);
  ChatClientQueue[ChatClientQueue.length] = 'login: '+ChatClientEncode(data, 3);
}

// ----- Enter -----

function ChatClientDoEnter(room)
{
  ChatClientTab('tab_chat');
  ChatClientQueue[ChatClientQueue.length] = 'enter: '+ChatClientRooms[room];
}

// ----- Tell -----

function ChatClientDoTell()
{
  ChatClientQueue[ChatClientQueue.length] =
    'tell: '+document.forms['ChatClientTell']['Tell'].value;
}

// ----- New Room -----

function ChatClientDoNewRoom()
{
  if (!ChatClientUsername) { alert('Please, login first!'); return; }
  ChatClientQueue[ChatClientQueue.length] =
    'enter: '+document.forms['ChatClientNewRoom']['Room'].value;
  popup_hide_aux("menu_rooms_new", "menu_rooms_new_child");
}

// ----- Private -----

function ChatClientDoPrivate()
{
  if (!ChatClientUsername) { alert('Please, login first!'); return; }
  data = new Array(document.forms['ChatClientPrivate']['User'].value,
                   document.forms['ChatClientPrivate']['Tell'].value);
  ChatClientQueue[ChatClientQueue.length] = 'tell1: '+ChatClientEncode(data, 3);
  popup_hide_aux("menu_users_private", "menu_users_private_child");
}

// ----- Find -----

function ChatClientDoFind()
{
  if (!ChatClientUsername) { alert('Please, login first!'); return; }
  ChatClientQueue[ChatClientQueue.length] =
    'find: '+document.forms['ChatClientFind']['User'].value;
  popup_hide_aux("menu_users_find", "menu_users_find_child");
}

// ----- Ignore -----

function ChatClientDoIgnore()
{
  if (!ChatClientUsername) { alert('Please, login first!'); return; }
  ChatClientQueue[ChatClientQueue.length] =
    'ignore: '+document.forms['ChatClientIgnore']['User'].value;
  popup_hide_aux("menu_users_ignore", "menu_users_ignore_child");
}

// ----- Info -----

function ChatClientDoInfo()
{
  if (!ChatClientUsername) { alert('Please, login first!'); return; }
  ChatClientQueue[ChatClientQueue.length] =
    'info: '+document.forms['ChatClientInfo']['User'].value;
  popup_hide_aux("menu_users_info", "menu_users_info_child");
}

// ----- ChatClient Command ----------------------------------------------------

// ----- Login -----

function ChatClientLogin()
{
  if (ChatClientUsername || ChatClientPassword)
  {
    data = new Array(ChatClientUsername, ChatClientPassword);
    ChatClientQueue[ChatClientQueue.length] = 'login: '+ChatClientEncode(data, 3);
  }
  else ChatClientTab('tab_login');
}

// ----- Invalid Login -----

function ChatClientInvalidLogin()
{
  ChatClientUsername = '';
  ChatClientPassword = '';
  ChatClientTab('tab_login');
}

// ----- New Room -----

function ChatClientNewRoom(rooms)
{
  for (var i = 0; i < rooms.length; i++)
  {
    var exists = false;
    for (var j = 0; j < ChatClientRooms.length; j++)
      if (ChatClientRooms[j] == rooms[i]) exists = true;
    if (exists) continue;

    document.getElementById('ChatClientRooms').innerHTML +=
      '<a href="javascript: ChatClientDoEnter('+ChatClientRooms.length+');">'+rooms[i]+'</a><br />';
    ChatClientRooms[ChatClientRooms.length] = rooms[i];
  }
}

// ----- Enter -----

function ChatClientEnter(users)
{
  for (var i = 0; i < users.length; i++)
  {
    var exists = false;
    for (var j = 0; j < ChatClientUsers.length; j++)
      if (ChatClientUsers[j] == users[i]) exists = true;
    if (exists) continue;

    document.getElementById('ChatClientUsers').innerHTML +=
      '<a id="ChatClientUser_'+ChatClientUsers.length+'">'+users[i]+'</a>';
    ChatClientUsers[ChatClientUsers.length] = users[i];
  }
}

// ----- Exit -----

function ChatClientExit(user)
{
  for (i = 0; i < ChatClientUsers.length; i++)
    if (user == ChatClientUsers[i])
    {
      ChatClientUsers[i] = undefined;
      element = document.getElementById('ChatClientUser_'+i);
      element.parentNode.removeChild(element);
    }
}

// ----- Tell -----

function ChatClientTell(type, color, user, msg)
{
  ChatClientToScreen('<font color="#'+color+'">'+'<b>'+user+':</b> '+msg+'</font>');
}


// ----- URL -----

function ChatClientURL(url)
{
  window.open(url);
}



