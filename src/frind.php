<?php
//Diese Datei stellt eine Freundschaft her

//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Ist ein Parameter festgelegt
//Wenn ja, Freundschaft in die Datenbank
if (isset($_GET['p'])) {
    //Variable aufbebreiten und in die Datenbank damit
    $p = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO friendship VALUES('','{$_SESSION['userid']}','{$p}',0)");
    //Anschliessend wieder zum Profil
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$p} AND type = 1");
    $homeid1 = mysqli_fetch_assoc($homeid);
    header("Location: http://$host$uri/profile.php?p=" . $homeid1['id']);
    exit;
}
//Wenn nein, auf die Satrtseite weiterleiten
else {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/home.php");
    exit;
}
