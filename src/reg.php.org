<?php
require('config.php');
if( $_POST['passwordb'] != "" ){
	if( $_POST['password'] != "" ){
		if( $_POST['mailb'] != "" ){
			if( $_POST['mail'] != "" ){
				if( $_POST['lastname'] != "" ){
					if( $_POST['prename'] != "" ){
						if($_POST['mail'] == $_POST['mailb']) {
							if($_POST['password'] == $_POST['passwordb']) {
													//Werte in Datenbank schreiben
					        						$p = mysql_query("INSERT INTO  user (id ,prename ,lastname ,email ,password )VALUES ('' ,  '" . $_POST['prename'] . "',  '" . $_POST['lastname'] . "',  '" . $_POST['mail'] . "',  md5('" . $_POST['password'] . "'))");
													//Letzte Nutzerid auslesen, um Profil anzulegen
													$selctLastID = mysql_query("SELECT id FROM user ORDER BY id DESC LIMIT 1");
													$LastId = mysql_fetch_assoc($selctLastID);
													$lID = $LastId['id'];
													//Profil anlegen
													$createProfile = mysql_query("INSERT INTO  profile (id ,administraedFrom ,type ,profileName )VALUES ('',  '" . $lID . "',  '1',  '" . $_POST['prename'] . " " . $_POST['lastname'] . "')");

													//Sicherheitsmail
													$zufall = rand(1,1000000000000);
													mail( $_POST['mail'] , "Verifizierung deines Floos Accounts" , "Bitte klick folgenden Link zur Verifizierung deines Accounts an.<br><a href='http://floos.flova.de/ver.php?code=" . $zufall . "'>floos.flova.de/ver.php?code=" . $zufall . "</a>" , "From: Floos <keineantwort@flova.de>\nContent-Type: text/html");
													//Sicherheitsdatenbank beschreiben
													$createProfile = mysql_query("INSERT INTO  ver (id ,userId ,code , ver)VALUES ('','" . $lID . "','" . $zufall . "','0')");
											        //Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/index.php");
											        exit;
							} else {
													//Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/reg_seite.php?f=1");
											        exit;
							}
						} else {
													//Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/reg_seite.php?f=1");
											        exit;
						}
					} else {
													//Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/reg_seite.php?f=1");
											        exit;
					}
				} else {
													//Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/reg_seite.php?f=1");
											        exit;
				}
			} else {
													//Weiterleitung
											        $host = $_SERVER['HTTP_HOST'];
											        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
											        header("Location: http://$host$uri/reg_seite.php?f=1");
											        exit;
			}
		} else {
												//Weiterleitung
										        $host = $_SERVER['HTTP_HOST'];
										        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
										        header("Location: http://$host$uri/reg_seite.php?f=1");
										        exit;
		}
	} else {
												//Weiterleitung
										        $host = $_SERVER['HTTP_HOST'];
										        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
										        header("Location: http://$host$uri/reg_seite.php?f=1");
										        exit;
	}
} else {
												//Weiterleitung
										        $host = $_SERVER['HTTP_HOST'];
										        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
										        header("Location: http://$host$uri/reg_seite.php?f=1");
										        exit;
}
?>














