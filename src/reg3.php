<?php
//Diese Datei registriert jemanden

//Variablen deklarieren
$prename = $_POST['prename'];
$lastname = $_POST['lastname'];
$email = $_POST['mail'];
$password = $_POST['password'];
if($prename != "" && $lastname !="" && $email != "" && $password != "")
{
       if($password == $_POST['rpassword'])
            {
                //Checken ob Name korrekt
                $zeichen = "!&$%()/\?=1234567890{}[]<>|,;:._^^^^+*#'";
                $pospn = strpos($prename, $zeichen);
                $posln = strpos($lastname, $zeichen);
                if($pospn === false && $posln === false)
                {
                        //Checken ob E-Mail Korrekt
                        $posm1 = strpos($email, "@");
                        $posm2 = strpos($email, ".");
                        if($posm2 != "" && $posm1 != "")
                        {
                            //Sicherheit
                            $prename = htmlspecialchars($prename);
                            $prename = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $prename);
                            $prename = htmlentities($prename);
                            $lastname = htmlspecialchars($lastname);
                            $lastname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $lastname);
                            $lastname = htmlentities($lastname);
                            $email = htmlspecialchars($email);
                            $email = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $email);
                            $email = htmlentities($email);
                            $password = md5($password);
                            //Verbindung mit Datenbank
                            ($GLOBALS["___mysqli_ston"] = mysqli_connect("comixfuerjbs.co.ohostsql.de",  "mysql1110504",  "floos123")) or die("Fehler bei der Verbindung mit der Datenbank.");
                            mysqli_select_db($GLOBALS["___mysqli_ston"], mysql1110504);
                            //Checken, ob E-Mail schon vorhanden
                            $selectEMail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE email = '{$email}'");
                            if(mysqli_num_rows($selectEMail) == 0)
                            {
								//Werte in Datenbank schreiben
                                $insertDate = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO  user VALUES ('' ,  '{$prename}',  '{$lastname}',  '{$email}',  '{$password}')");
								//Letzte Nutzerid auslesen, um Profil anzulegen
								$selctLastID = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM user ORDER BY id DESC LIMIT 1");
								$LastId = mysqli_fetch_assoc($selctLastID);
								$lID = $LastId['id'];
								//Profil anlegen
								$createProfile = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO  profile (id ,administraedFrom ,type ,profileName )VALUES ('',  '{$lID}',  '1',  '{$prename} {$lastname}')");
                            }
                            else
                            {
                                    $output = "Diese E-Mail Adresse wurde bereits verwendet.";
                            }
                        }
                        else
                        {
                                $output = "E-Mail Adreese nicht korrekt";
                        }
                }
                else
                {
                        $output = "Ihr Name kann nicht korrekt sein. Bitte &auml;ndern sie diesen.";
                }
            }
            else
            {
                    $output = "Die E-Mail Adrssen stimmen nicht &uuml;berein.";
            }
}
else
{
        $output = "Bitte f&uuml;llen Sie alle Felder aus.";
}
echo $output;
?>