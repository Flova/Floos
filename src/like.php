<?php
//Diese Datei ersdtellte ein Like

//PHP Session starten
session_start();
//Mit Datenbank verbinden
require_once('config.php');
//Ist der Parameter gesetzt
if(isset($_GET['p']))
{
	//Parameter absichern vor SQL_Injection
	$p = mysql_real_escape_string($_GET['p']);
	//Like in die Datenbank schreiben
	$insert = mysql_query("INSERT INTO likes VALUES('','{$p}','{$_SESSION['userid']}','')");
	//Weiterleitung zum Profil
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/profile.php?p={$p}");
	exit;
}
else
{
	//Bei Fehler, weiterleiten auf die Startseite
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/home.php");
	exit;
}
?>