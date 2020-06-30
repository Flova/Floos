<?php
//Diese Datei stellt eine Freundschaft her

//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Ist ein Parameter festgelegt
//Wenn ja, Freundschaft in die Datenbank
if (isset($_GET['p']) && isset($_GET['u'])) {
    //Variable aufbebreiten und in die Datenbank damit
    $u = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['u']);
    $p = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
    $user = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
    $lock = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `locked` WHERE `pageId` = {$p} AND `member` = {$user} AND ok = 1");
    if (mysqli_num_rows($lock) != 0) {
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `locked` SET `ok` = 1 WHERE `pageId` = {$p} AND `member` = {$u}");
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/profile.php?p=" . $p);
        exit;
    } else {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/home.php");
        exit;
    }
}
//Wenn nein, auf die Satrtseite weiterleiten
else {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/home.php");
    exit;
}
