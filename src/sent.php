<?php
//PHP Session starten
session_start();
require 'urlconv.php';
//Ist man eingellogt?
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Sind die Daten fuer die Pinnwand verwerndbar
if (isset($_POST['message']) && isset($_POST['secondID'])) {
    //Mit Datenbank verbinden
    require 'config.php';
    //Zeitzone festlegene
    date_default_timezone_set("Europe/Berlin");
    //Datum und Zeit abfragen
    $date = date("Y-m-d H:i:s");
    //Eingeben vor SQL-Injection sichern
    $pw = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['message']);
    $pw = make_clickable(htmlspecialchars($pw));
    $var = array(
        'ä' => '&auml;',
        'Ä' => '&Auml;',
        'ü' => '&uuml;',
        'Ü' => '&Uuml;',
        'ö' => '&ouml;',
        'Ö' => '&Ouml;',
        'ß' => '&szlig;');
    $pw1 = str_replace(array_keys($var), array_values($var), $pw);
    $uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
    $secID = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['secondID']);

    //Werte in Datenbank schreiben
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO Chat VALUES('','{$uid}','{$secID}','{$pw1}','{$date}','0')");
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/leiste.php?p=" . $secID);
    exit;
}
