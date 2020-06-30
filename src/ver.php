<?php
//Mit Datenbank verbinden
require('config.php');
//Flees loeschen
if(isset($_GET['code']))
{
		$code = mysql_real_escape_string($_GET['code']);
		$insert = mysql_query("UPDATE ver SET ver = 1 WHERE code =" . $code);
}
//Weiterleitung
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/index.php");
exit;
?>