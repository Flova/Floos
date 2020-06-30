<?php
//Start PHP-Session
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Guckt, ob der Nutzer eingeloggt ist, wenn nein, wird er zur Startseite weitergeleitet.
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
if ($_FILES['img']['size'] < 10000000) {
    if (array_key_exists('img', $_FILES)) {
        $userid = $_POST['id'];
        $idcheck = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = " . $userid);
        $idcheck1 = mysqli_fetch_assoc($idcheck);
        if ($idcheck1['administraedFrom'] == $_SESSION['userid']) {
            $name = $_FILES['img']['type'];
            $ext = substr($name, 6);
            move_uploaded_file($_FILES['img']['tmp_name'], "bilder/" . $userid . "." . $ext);
            $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profileimages` WHERE  userid = " . $userid);
            if (mysqli_num_rows($result) == 0) {
                $sq = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO  `profileimages` (id,imgType,userid) VALUES ('','" . $ext . "','" . $userid . "')");
            } else {
                $sq = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `profileimages` SET imgType = '" . $ext . "' WHERE userid = " . $userid);
            }
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/profile.php?p=" . $userid);
            exit;
        } else {
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/edit_profile.php?p=" . $userid);
            exit;
        }
    } else {
        //Weiterleitung
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/edit_profile.php?p=" . $userid);
        exit;
    }
} else {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/edit_profile.php?s=1&p=" . $_POST['id']);
    exit;
}
