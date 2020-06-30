<?php
//Mit Datenbank verbinden
require 'config.php';
$insert = mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE `profileimages` CHANGE `imageData` LONGBLOB BINARY NULL");
