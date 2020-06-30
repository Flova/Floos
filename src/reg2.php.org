<?php
//Bindet die Datnbankverbindung ein
require_once('config.php');
								//Werte in Datenbank schreiben
                                mysql_query("INSERT INTO  user VALUES ('' ,  'eetr',  'xcvhj',  'fghj@fghj.de',  '123'");
								//Letzte Nutzerid auslesen, um Profil anzulegen
								$selctLastID = mysql_query("SELECT id FROM user ORDER BY id DESC LIMIT 1");
								$LastId = mysql_fetch_assoc($selctLastID);
								$lID = $LastId['id'];
								//Profil anlegen
								$createProfile = mysql_query("INSERT INTO  profile (id ,administraedFrom ,type ,profileName )VALUES ('',  '{$lID}',  '1',  'dfgh dfgh')");

?>