<?php

								//Werte in Datenbank schreiben
                                mysql_query("INSERT INTO  user (id ,prename ,lastname ,email ,password )VALUES ('' ,  '{$_POST['prename']}',  '{$_POST['lastname']}',  '{$_POST['mail']}',  '{md5($_POST['password']}'))");
								//Letzte Nutzerid auslesen, um Profil anzulegen
								$selctLastID = mysql_query("SELECT id FROM user ORDER BY id DESC LIMIT 1");
								$LastId = mysql_fetch_assoc($selctLastID);
								$lID = $LastId['id'];
								//Profil anlegen
								$createProfile = mysql_query("INSERT INTO  profile (id ,administraedFrom ,type ,profileName )VALUES ('',  '{$lID}',  '1',  '{$_POST['prename']} {$_POST['lastname']}')");

?>