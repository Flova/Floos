<?php
//Diese Datei ist die Suche


//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Ist der Nutzter eingeloggt, wenn nein auf die Anmeldeseite weiterlieten
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if($open_friendship_request > 0)
{
	$friendship_request = '<a href="requerst_anwser.php">'. $open_friendship_request.' Freundschaftsanfrage(n)</a> | ';	
}
?>
<html>
<head>
    
	<link href="style.css" rel="Stylesheet" type="text/css" media="screen"></link>
	<title> Dein Floos</title>
</head>
<body>
    <div id="root">
        <div id="logo"></div>
        <div id="sub-navi"><form action="serach.php" method="get"><input type="search" value="Suche" name="s" style="right:10px; float:left; width:162px;" onfocus="if(this.value == 'Suche') this.value = ''" onBlur="if(this.value == '') this.value = 'Suche'">	  	<?php echo $friendship_request; ?><a href="home.php">Home</a><a>  </a><a href="logout.php">Logout </a></form></div>
            <div id="content">
            <div id="navi"></div>
            <div id="main-content">
				<?php
if(isset($_GET['s']))
				 {
				     $s = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['s']);
$selectProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `id`, `profileName` FROM `profile` WHERE `profileName` LIKE '%{$s}%'");
					 $a = mysqli_fetch_assoc($selectProfile);
					echo $a['profileName'];
				  }
				 ?> </div>
        </div>
    </div>
</body>    
</html>