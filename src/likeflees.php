<?php
//Diese Datei ersdtellte ein Like

//PHP Session starten
session_start();
//Mit Datenbank verbinden
require_once('config.php');

	//Parameter absichern vor SQL_Injection
	$f = mysql_real_escape_string($_GET['f']);

	//Flees laden
	$selctFLData = mysql_query("SELECT * FROM  pinnwand WHERE id = '{$f}'");
	$FLData = mysql_fetch_assoc($selctFLData);

	//Profil finden
	$userinfos = mysql_query("SELECT * FROM profile WHERE id = '" . $FLData['postOnUserID'] . "'");
	$userinfos = mysql_fetch_assoc($userinfos);

	//Zeitzone festlegene
	date_default_timezone_set("Europe/Berlin");
	//Datum und Zeit abfragen
	$date = date("Y-m-d H:i:s");

	//User2 finden
	$user2infos = mysql_query("SELECT * FROM profile WHERE administraedFrom = '" . $_SESSION['userid'] . "' AND type = '1'");
	$user2infos = mysql_fetch_assoc($user2infos);

	//content
	$content = mysql_real_escape_string("mag diesen Flees auf der Seite <b>" . $userinfos['profileName'] . ":</b><br><br>" . $FLData['pwcontent']);


	//Like in die Datenbank schreiben
	$insert = mysql_query("INSERT INTO pinnwand VALUES ('','" . $content . "','" . $_SESSION['userid'] . "','" . $user2infos['id'] . "','" . $date . "')");

	//Weiterleitung
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/home.php");
	exit;
?>