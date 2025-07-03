<?php

function StringEncode($arr, $prefixlen = 3)
{
  $str = '';

  foreach ($arr as $i => $x)
    $str .= str_pad(strlen($x), $prefixlen, ' ') . $x;

  return $str;
}

$NN     = mt_rand(1, 4);
//$target = 'http://localhost/messenger/target.php?id=0' . $NN;
$target = 'http://ilyalyu.letzebuerg.org/messenger/target.php?id=0' . $NN;
$image  = dirname($_SERVER['SCRIPT_FILENAME']) . '/ads/0' . $NN . '.gif';

echo StringEncode(Array($target, file_get_contents($image)), 5);

?>
