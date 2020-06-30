<?php
//Diese Datei ist die Startseite fuer eingeloggte Benutzter

//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Ist der Nutzter eingeloggt, wenn nein auf die Anmeldeseite weiterlieten
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Pinnwand eingabe verarbeiten
if (isset($_POST['pinnwand']) && $_POST['pinnwand'] != "" && $_POST['pinnwand'] != "Dein Status") {
    //Setzt die Zeitzone auf Berlin fest
    date_default_timezone_set("Europe/Berlin");
    //Bezieht sich die Serverzeit unter brücksichtigung der Zeitzone
    $date = date("Y-m-d H:i:s");
    //Bereitet die Variablen für die Datenbank auf
    $pw = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pinnwand']);
    $uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
    //Schreibt die Werte in die Datenbank
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','{$pw}','{$uid}','{$uid}','{$date}')");
}
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if ($open_friendship_request > 0) {
    $friendship_request = '<a href="requerst_anwser.php">' . $open_friendship_request . ' Freundschaftsanfragen</a> | ';
}
//Liest die ID des Profiles aus
$selectUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
$userProfile = mysqli_fetch_assoc($selectUserProfile);
?>
<html>

<head>

    <link href="style.css" rel="Stylesheet" type="text/css" media="screen">
    </link>
    <title> Dein Floos</title>
</head>

<body>
    <div id="root">
        <div id="logo"></div>
        <div id="sub-navi">
            <form action="serach.php" method="get">
                <input type="search" value="Suche" name="s" style="right:10px; float:left; width:162px;"
                    onfocus="if(this.value == 'Suche') this.value = ''"
                    onBlur="if(this.value == '') this.value = 'Suche'"> <?php echo $friendship_request; ?><a
                    href="profile.php?p=<?php echo $userProfile['id']; ?>">Mein Profil</a><a> </a><a
                    href="logout.php">Logout </a> </form>
        </div>
        <div id="content">
            <div id="navi">
                <div style="padding-left:15;color:#FFF; width:140;">
                    <b>Meine Freunde</b>
                    <div style="padding-top:10;">
                        <?php
$selectAllFrinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `firstid`, `secondid` FROM `friendship` WHERE `confired` = 1 AND (`firstid` = '{$_SESSION['userid']}' OR `secondid` = '{$_SESSION['userid']}')");
$frinds = array();
while ($frindsselekted = mysqli_fetch_assoc($selectAllFrinds)) {
    if ($frindsselekted['firstid'] == $_SESSION['userid']) {
        $frinds[] = $frindsselekted['secondid'];
    } elseif ($frindsselekted['secondid'] == $_SESSION['userid']) {
        $frinds[] = $frindsselekted['firstid'];
    }
}
$idsToSelect = implode(",", $frinds);
$frindsselekted2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `id`, `profileName` FROM `profile` WHERE `type` = 1 AND `id` IN '{$idsToSelect}'");
while ($frinds = mysqli_fetch_assoc($frindsselekted2)) {
    echo $frinds['profileName'];
}
?>
                    </div>
                </div>
            </div>
        </div>
        <div id="main-content">
            <form action="home.php" method="post">
                <input type="text" value="Dein Status" name="pinnwand" style="width:100%;"
                    onFocus="if(this.value == 'Dein Status') this.value = ''"
                    onBlur="if(this.value == '') this.value = 'Dein Status'" />
            </form>
            <div class="floatarea" style="width:500px">
                <a>Fleeses</a>
                <?php
//Pinwandausgabe
$selctPWData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  pinnwand WHERE postOnUserID = '{$_SESSION['userid']}' ORDER BY poston DESC  ");
while ($pwData = mysqli_fetch_assoc($selctPWData)) {
    $selectPostFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$pwData['userid']}");
    $PostUserName = mysqli_fetch_assoc($selectPostFrom);
    echo "<a href='profile.php?p=" . $PostUserName['id'] . "'>" . $PostUserName['prename'] . " " . $PostUserName['lastname'] . "</a><br>";
    echo $pwData['pwcontent'] . "<hr>";
}
?>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
