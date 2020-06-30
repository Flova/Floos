<?php
//Mit Datenbank verbinden
require('config.php');
$insert = mysql_query("ALTER TABLE `profileimages` CHANGE `imageData` LONGBLOB BINARY NULL");
?>