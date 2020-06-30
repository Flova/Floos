<?php
//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Refresh
echo '<html><head><meta http-equiv="refresh" content="2;"><link href="designImages/css/bootstrap.min.css" rel="stylesheet"></head><body>';

//Ist der Nutzter eingeloggt, wenn nein auf die Anmeldeseite weiterlieten
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
//Chatausgabe
$myId = $_SESSION['userid'];
$secId = $_GET['p'];
$selctCHData = mysql_query("SELECT * FROM `Chat` WHERE ( `firstID` = " . $myId . " AND `secondID` = " . $secId . " ) OR ( `firstID` = " . $secId . " AND `secondID` = " . $myId . " ) ORDER BY time DESC LIMIT 0 , 50 ");
while($CHData = mysql_fetch_assoc($selctCHData))
{
	$selectsmFrom = mysql_query("SELECT * FROM user WHERE id = {$CHData['firstID']}");
	$smUserName = mysql_fetch_assoc($selectsmFrom);
	echo "<b>" . $smUserName['prename'] . " " . $smUserName['lastname']  . ":</b> " . $CHData['message'] . "<br>";
}
$sq = mysql_query("UPDATE `Chat` SET `read` = 1 WHERE `secondID` = " . $_SESSION['userid'] . " AND `firstID` = " . $secId );
echo '</body></html>';
?>




