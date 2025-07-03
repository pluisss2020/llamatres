<?php

$fp = fsockopen("accessliberty.com", 9113, $errno, $errstr, 5);
var_dump($fp);

?>
