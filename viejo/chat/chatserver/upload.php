<?php

$file = microtime(true);
move_uploaded_file($_FILES['file']['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']) . '/files/' . $file);
echo '<file file="' . $file . '">';

?>
