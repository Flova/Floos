<?php
//Bindet die Datnbankverbindung ein
require_once('config.php');
								//Werte in Datenbank schreiben
                                mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO  user (id ,prename ,lastname ,email ,password ) VALUES ('' ,  'eetr',  'xcvhj',  'fghj@fghj.de',  '123'");
								//Letzte Nutzerid auslesen, um Profil anzulegen
								$selctLastID = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM user ORDER BY id DESC LIMIT 1");
								$LastId = mysqli_fetch_assoc($selctLastID);
								$lID = $LastId['id'];
								//Profil anlegen
								$createProfile = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO  profile (id ,administraedFrom ,type ,profileName ) VALUES ('',  '{$lID}',  '1',  'dfgh dfgh')");

?>