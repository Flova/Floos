<?php
//PHP Session starten
session_start();
//Ist man eingellogt?
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
echo '<html><head><link href="designImages/css/bootstrap.min.css" rel="stylesheet"></head><body><form action="sent.php" method="post"><input value="Deine Nachicht" style="width:100%;" onFocus="if(this.value == ' . "'" . 'Deine Nachicht' . "'" . ') this.value = ' . "''" . '"' . ' onBlur="if(this.value == ' . "''" . ') this.value = ' . "'Deine Nachicht'" . '" class="form-control" size="15" name="message" type="text"/><input type="hidden" name="secondID" value="' . $_GET['p'] . '"/></form></body></html>';
