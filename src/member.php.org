<?php
//Diese Datei stellt eine Freundschaft her

//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Ist ein Parameter festgelegt
//Wenn ja, Freundschaft in die Datenbank
if(isset($_GET['p']))
{
	//Variable aufbebreiten und in die Datenbank damit 
	$p = mysql_real_escape_string($_GET['p']);
	$user = mysql_real_escape_string($_SESSION['userid']);
	$lock = mysql_query("SELECT * FROM `locked` WHERE `pageId` = {$p} AND ok = 1");
	if(mysql_num_rows($lock) != 0) {
		$insert = mysql_query("INSERT INTO `locked` VALUES('','{$p}','{$user}','0')");
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/profile.php?p=" . $p);
		exit;
	}else{
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/home.php");
		exit;
	}
}
//Wenn nein, auf die Satrtseite weiterleiten
else
{
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/home.php");
	exit;
}
?>