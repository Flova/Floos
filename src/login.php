<?php
//Diese Datei logt einen ein

//PHP Session starten
session_start();
//Datenbankverbindung
require_once('config.php');
//Anmeldung mit der App?
if (isset($_COOKIE["userid"])) {
    $selectUserId = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = '". $_COOKIE["userid"] . "'");
    if (mysqli_num_rows($selectUserId) > 0) {
        $selectUserId = mysqli_fetch_assoc($selectUserId);
        if ($_COOKIE["pw"] == $selectUserId['password']) {
            $userip = $_SERVER['REMOTE_ADDR'];
            $userid = $_COOKIE["userid"];
            //Zeitzone festlegene
            date_default_timezone_set("Europe/Berlin");
            //Datum und Zeit abfragen
            $date = date("Y-m-d H:i:s");

            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO loginlog VALUES ('','{$userid}','{$userip}','{$date}')");
            $_SESSION['userid'] = $userid;
             //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/home.php");
            exit;
        }
    }
}
//Loginprozess
$email = $_POST['email'];
$password = $_POST['password'];
//Sind alle Felder ausgef�llt
if($email != "" && $password != "") {
	//Absichern der Logineingaben, zum Schutz vor SQL-Injection
    $email = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $email);
	//Verschluesseln des Passwortes, um die Datenbankabfrage durchzufuehren
    $password = md5($password);
    //Daten aus Datenbanak holen
    $selectUserData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE email = '". $email . "'");
    //Ist der Benutzer �berhaupt vorhanden?
    if(mysqli_num_rows($selectUserData) > 0){
        //Aufarbeiten der Datenbankwerte
        $dbData = mysqli_fetch_assoc($selectUserData);
		//Ist das eingengeben Passwort gleich dem Datenbankpasswort
        if($dbData['password'] == $password){
			//Speichern der Logindaten im Log
            $userip = $_SERVER['REMOTE_ADDR'];
            $userid = $dbData['id'];
            //Zeitzone festlegene
            date_default_timezone_set("Europe/Berlin");
            //Datum und Zeit abfragen
            $date = date("Y-m-d H:i:s");

            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO loginlog VALUES ('','{$userid}','{$userip}','{$date}')");
            $_SESSION['userid'] = $userid;
            //Wenn der user die App nutzt cookie loeschen
            if(isset($_GET['app'])){
                setcookie("userid", $userid, time()+(3600*24*364));
                setcookie("pw", $password, time()+(3600*24*364));

            }
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/home.php");
            exit;
        }
        else{
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php?f=1");
            exit;
        }
    }
    else{
     	$host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/index.php?f=1a");
        exit;
    }
}
else{
   $host = $_SERVER['HTTP_HOST'];
   $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
   echo("<script type='text/javascrip'>location.href = '$host$uri/index.php?f=1';</script>");
   exit;
}
?>
