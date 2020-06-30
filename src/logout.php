<?php
/*********Diese Datei**********/
//Diese logt einen aus

//PHP Session starten
session_start();
//Beenden der PHP-Session
session_destroy();
setcookie("username","","0");
setcookie("pw","","0");
//Weiterleitung
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/index.php");
sleep(1);
exit;
?>