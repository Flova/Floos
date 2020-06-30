<?php
//Diese Datei zeigt das Profil an

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
//An Pinnwand posten
//Sind die Daten fuer die Pinnwand verwerndbar
if(isset($_GET['f']))
{
	//Mit Datenbank verbinden
	require('config.php');
	//Zeitzone festlegene
	date_default_timezone_set("Europe/Berlin");
	//Datum und Zeit abfragen
	$date = date("Y-m-d H:i:s");
	$fleesid = mysql_real_escape_string($_GET['f']);
	$selectflees = mysql_query("SELECT * FROM pinnwand WHERE id =" . $fleesid );
 $selectflees = mysql_fetch_assoc($selectflees);
 	$userinfos = mysql_query("SELECT * FROM user WHERE id = " . $selectflees['userid']);
	$userinfos = mysql_fetch_assoc($userinfos);
 $reflees = "<b>" . $userinfos['prename'] . " " . $userinfos['lastname'] . "</b><br><div style='padding-left:10px;'>" . 	$selectflees['pwcontent'] . "</div> ";
 $reflees = mysql_real_escape_string($reflees);
 	$homeid = mysql_query("SELECT * FROM  profile WHERE administraedFrom = " . $_SESSION['userid'] . " AND type = 1");
	$homeid1 = mysql_fetch_assoc($homeid);
 $upload = mysql_query("INSERT INTO pinnwand VALUES('','" . $reflees . "','" . $_SESSION['userid'] . "','" . $homeid1['id'] . "','" . $date . "')");
 //Weiterleitung
 $host = $_SERVER['HTTP_HOST'];
 $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 header("Location: http://$host$uri/home.php");
 exit;
}






