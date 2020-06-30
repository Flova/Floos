<?php
//PHP Session starten
session_start();
//Ist man eingellogt?
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
//Mit Datenbank verbinden
require('config.php');
//Flees loeschen
if(isset($_GET['f']))
{
	$f = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['f']);
	$post = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `pinnwand` WHERE `id` =" . $f);
	$post = mysqli_fetch_assoc($post);
	$proID = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = " . $post['postOnUserID']);
	$proID = mysqli_fetch_assoc($proID);
	if ($proID['administraedFrom'] == $_SESSION['userid']) {
 		$del = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM pinnwand WHERE id = '" . $f . "'");
 		//Weiterleitung
 		$host = $_SERVER['HTTP_HOST'];
 		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 		header("Location: http://$host$uri/profile.php?p=" . $post['postOnUserID']);
 		exit;
 	}
}
?>