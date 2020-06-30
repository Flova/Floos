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
$id = $_GET['id'];

$result = mysql_query("SELECT * FROM `profileimages` WHERE 	userid = " . $id);

$row=mysql_fetch_assoc($result);

header("Content-type: {$row['imgType']}");

$im = ImageCreateFromJPEG($row['imageData']);

imagejpeg($im,"",10);

echo $im;


?>