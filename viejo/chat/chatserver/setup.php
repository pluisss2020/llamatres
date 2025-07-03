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

mysql_query("drop table {$myconfig['tbl_info']}");
mysql_query(
"create table {$myconfig['tbl_info']} (
    id   integer unsigned not null auto_increment,

    user varchar(64)      not null,
    info text             not null,

    primary key (id))");
echo mysql_error(), '<br />';

mysql_query("drop table {$myconfig['tbl_pmsg']}");
mysql_query(
"create table {$myconfig['tbl_pmsg']} (
    id   integer unsigned not null auto_increment,

    name_from varchar(64) not null,
    name_to   varchar(64) not null,
    message   text        not null,

    index name_from (name_from(4)),
    index name_to   (name_to  (4)),
    primary key (id))");
echo mysql_error(), '<br />';

?>
