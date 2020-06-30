 <?php
//Diese Datei logt einen ein

//PHP Session starten
session_start();
//Datenbankverbindung
require_once 'config.php';
//Loginprozess
$email = $_POST['email'];
$password = $_POST['password'];
//Sind alle Felder ausgef�llt
if ($email != "" && $password != "") {
    //Absichern der Logineingaben, zum Schutz vor SQL-Injection
    $email = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $email);
    //Verschluesseln des Passwortes, um die Datenbankabfrage durchzufuehren
    $password = md5($password);
    //Daten aus Datenbanak holen
    $selectUserData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE email = '{$email}'");
    //Ist der Benutzer �berhaupt vorhanden?
    if (mysqli_num_rows($selectUserData) > 0) {
        //Aufarbeiten der Datenbankwerte
        $dbData = mysqli_fetch_assoc($selectUserData);
        //Ist das eingengeben Passwort gleich dem Datenbankpasswort
        if ($dbData['password'] == $password) {
            //Speichern der Logindaten im Log
            $userip = $_SERVER['REMOTE_ADDR'];
            $userid = $dbData['id'];
            //Zeitzone festlegene
            date_default_timezone_set("Europe/Berlin");
            //Datum und Zeit abfragen
            $date = date("Y-m-d H:i:s");

            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO loginlog VALUES ('','{$userid}','{$userip}','{$date}')");
            $_SESSION['userid'] = $userid;
            //Setzt die Zeitzone auf Berlin fest
            date_default_timezone_set("Europe/Berlin");
            //Bezieht sich die Serverzeit unter brücksichtigung der Zeitzone
            $date = date("Y-m-d H:i:s");
            $homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$userid} AND type = 1");
            $homeid1 = mysqli_fetch_assoc($homeid);
            $uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $homeid1['id']);
            $uid1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $userid);
            $nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$uid1}");
            $nnfrind2 = mysqli_fetch_assoc($nfrind1);
            $link1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['link']);
            $text = $nnfrind2['prename'] . " " . $nnfrind2['lastname'] . " hat folgenden Link geteielt:<br><a target='_blank' href='" . $_POST['link'] . "'>" . $_POST['link'] . "</a>";
            $text = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $text);
            //Schreibt die Werte in die Datenbank
            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','{$text}','{$uid1}','{$uid}','{$date}')");
            echo '<head>
<meta http-equiv="refresh" content="0; URL=http://floos.flova.de/home.php">
</head>';
        } else {
            echo "Fehler";
        }
    } else {
        echo "Fehler";
    }
} else {
    echo "Fehler";
}
?>
