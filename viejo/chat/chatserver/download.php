<?php


$file = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/' . basename($_POST['file']);
echo file_get_contents($file);
unlink($file);

?>
