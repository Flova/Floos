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
if(isset($_POST['f']) && isset($_POST['a']))
{
	//Mit Datenbank verbinden
	require('config.php');
	//Zeitzone festlegene
	date_default_timezone_set("Europe/Berlin");
	//Datum und Zeit abfragen
      //Php Link
      require('urlconv.php');
      $aw = make_clickable(htmlspecialchars($_POST['a']));
	$date = date("Y-m-d H:i:s");
	$var = array(
                  'ä' => '&auml;',
                  'Ä' => '&Auml;',
                  'ü' => '&uuml;',
                  'Ü' => '&Uuml;',
                  'ö' => '&ouml;',
                  'Ö' => '&Ouml;',
                  'ß' => '&szlig;' );
    $aw = str_replace(array_keys($var), array_values($var),$aw); 
	$fleesid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['f']);
	$upload = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO answer VALUES('','" . $_POST['f'] . "','" . $_SESSION['userid'] . "','" . $aw . "','" . $date . "')");
	//Weiterleitung
 	$host = $_SERVER['HTTP_HOST'];
 	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 	header("Location: http://$host$uri/home.php");
 	exit;
}