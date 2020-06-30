<?php
//Mit Datenbank verbinden
require('config.php');
//Chatausgabe
$myId = $_SESSION['userid'];
if ($_GET['p'] == 321) {
$selctuserData = mysql_query("SELECT * FROM `loginlog` ORDER BY id DESC LIMIT 0 , 50 ");
	while($userData = mysql_fetch_assoc($selctuserData))
	{
		$selectsmFrom = mysql_query("SELECT * FROM user WHERE id = {$userData['userId']}");
		$smUserName = mysql_fetch_assoc($selectsmFrom);
		echo "<b>" . $smUserName['prename'] . " " . $smUserName['lastname']  . "</b><br> " . $userData['date'] . "<hr>";
	}
}
?>