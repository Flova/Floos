<?php
//Diese Datei zeigt das Profil an

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
//An Pinnwand posten
//Sind die Daten fuer die Pinnwand verwerndbar
if (isset($_GET['f'])) {
    //Mit Datenbank verbinden
    require 'config.php';
    //Zeitzone festlegene
    date_default_timezone_set("Europe/Berlin");
    //Datum und Zeit abfragen
    $date = date("Y-m-d H:i:s");
    $fleesid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['f']);
    $selectflees = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pinnwand WHERE id =" . $fleesid);
    $selectflees = mysqli_fetch_assoc($selectflees);
    $userinfos = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = " . $selectflees['userid']);
    $userinfos = mysqli_fetch_assoc($userinfos);
    $reflees = "<b>" . $userinfos['prename'] . " " . $userinfos['lastname'] . "</b><br><div style='padding-left:10px;'>" . $selectflees['pwcontent'] . "</div> ";
    $reflees = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $reflees);
    $homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = " . $_SESSION['userid'] . " AND type = 1");
    $homeid1 = mysqli_fetch_assoc($homeid);
    $upload = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','" . $reflees . "','" . $_SESSION['userid'] . "','" . $homeid1['id'] . "','" . $date . "')");
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/home.php");
    exit;
}
