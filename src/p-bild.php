<?php
//Start PHP-Session
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Guckt, ob der Nutzer eingeloggt ist, wenn nein, wird er zur Startseite weitergeleitet.
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
if($_FILES['img']['size'] < 10000000)
    {
        if(array_key_exists('img',$_FILES)) {
            $userid = $_POST['id'];
            $idcheck = mysql_query("SELECT * FROM profile WHERE id = " . $userid);
            $idcheck1 = mysql_fetch_assoc($idcheck);
            if($idcheck1['administraedFrom'] == $_SESSION['userid']) {
                $name = $_FILES['img']['type'];
                $ext = substr($name, 6);
                move_uploaded_file($_FILES['img']['tmp_name'], "bilder/" . $userid . "." . $ext);
                $result = mysql_query("SELECT * FROM `profileimages` WHERE  userid = " . $userid);
            if(mysql_num_rows($result) == 0)
                {
                    $sq = mysql_query("INSERT INTO  `profileimages` (id,imgType,userid) VALUES ('','" . $ext . "','" . $userid . "')");
                }else{
                    $sq = mysql_query("UPDATE `profileimages` SET imgType = '" . $ext . "' WHERE userid = " . $userid );
                }
                //Weiterleitung
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri/profile.php?p=" . $userid);
                exit;
            }else{
                //Weiterleitung
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri/edit-profile.php?p=" . $userid);
                exit;
            }
        }else{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/edit-profile.php?p=" . $userid);
            exit;
        }
}else{
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/edit-profile.php?s=1&p=" . $_POST['id']);
    exit;
}
?>