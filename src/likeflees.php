<?php
//Diese Datei ersdtellte ein Like

//PHP Session starten
session_start();
//Mit Datenbank verbinden
require_once('config.php');

	//Parameter absichern vor SQL_Injection
	$f = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['f']);

	//Flees laden
	$selctFLData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  pinnwand WHERE id = '{$f}'");
	$FLData = mysqli_fetch_assoc($selctFLData);

	//Profil finden
	$userinfos = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = '" . $FLData['postOnUserID'] . "'");
	$userinfos = mysqli_fetch_assoc($userinfos);

	//Zeitzone festlegene
	date_default_timezone_set("Europe/Berlin");
	//Datum und Zeit abfragen
	$date = date("Y-m-d H:i:s");

	//User2 finden
	$user2infos = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = '" . $_SESSION['userid'] . "' AND type = '1'");
	$user2infos = mysqli_fetch_assoc($user2infos);

	//content
	$content = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], "mag diesen Flees auf der Seite <b>" . $userinfos['profileName'] . ":</b><br><br>" . $FLData['pwcontent']);


	//Like in die Datenbank schreiben
	$insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES ('','" . $content . "','" . $_SESSION['userid'] . "','" . $user2infos['id'] . "','" . $date . "')");

	//Weiterleitung
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/home.php");
	exit;
?>