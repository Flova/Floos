 <?php
 $link = $_GET['l'];
 //PHP Session starten
  session_start();
 //Bindet die Datnbankverbindung ein
require_once('config.php');
 //Weiterleiten
 if(!isset($_SESSION['userid']))
{
            //Weiterleitung
           $host = $_SERVER['HTTP_HOST'];
           $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
           header("Location: http://$host$uri/loginbutton.php?l=" .$link);
           exit;
}
else
{
//Setzt die Zeitzone auf Berlin fest
	date_default_timezone_set("Europe/Berlin");
	//Bezieht sich die Serverzeit unter brücksichtigung der Zeitzone
	$date = date("Y-m-d H:i:s");
	$homeid = mysql_query("SELECT * FROM  profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
	$homeid1 = mysql_fetch_assoc($homeid);
	$uid = mysql_real_escape_string($homeid1['id']);
	$uid1 = mysql_real_escape_string($_SESSION['userid']);	
	//Schreibt die Werte in die Datenbank
	$insert = mysql_query("INSERT INTO pinnwand VALUES('','hat folgenden Link geteielt:<br><a href='{$link}'>{$link}</a>','{$uid1}','{$uid}','{$date}')");
    exit;
	}
 ?>