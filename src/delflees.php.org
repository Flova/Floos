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
	$f = mysql_real_escape_string($_GET['f']);
	$post = mysql_query("SELECT * FROM `pinnwand` WHERE `id` =" . $f);
	$post = mysql_fetch_assoc($post);
	$proID = mysql_query("SELECT * FROM profile WHERE id = " . $post['postOnUserID']);
	$proID = mysql_fetch_assoc($proID);
	if ($proID['administraedFrom'] == $_SESSION['userid']) {
 		$del = mysql_query("DELETE FROM pinnwand WHERE id = '" . $f . "'");
 		//Weiterleitung
 		$host = $_SERVER['HTTP_HOST'];
 		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 		header("Location: http://$host$uri/profile.php?p=" . $post['postOnUserID']);
 		exit;
 	}
}
?>