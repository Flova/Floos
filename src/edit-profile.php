<?php
//Diese Datei editiert die Datenbankwerte des Nutzters

//Start PHP-Session
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Php Link
require 'urlconv.php';

//Guckt, ob der Nutzer eingeloggt ist, wenn nein, wird er zur Startseite weitergeleitet.
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Verarbeitung des Submitbuttons
if (isset($_POST['submit'])) {
    //Bereite die variable auf, um keinen Schaden in der Datenbank anzurichten
    $p = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
    //Holt sich Werte des Aktuellen Nutzers
    $selectIsUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND id = {$p}");
    //Guckt, ob es der Richtige Nutzer ist, der Daten abfragt
    //Wenn ja, darf er die Werte bearbeiten
    if (mysqli_num_rows($selectIsUserProfile) > 0) {
        $inf = mysqli_fetch_assoc($selectIsUserProfile);
        if ($inf['type'] == 1) {
            $pw = make_clickable(htmlspecialchars($_POST['pi']));
            $pI = nl2br($pw);
            $profilInfo = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $pI);
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE profile SET profilInfos =  '{$profilInfo}' WHERE  id ={$p}");
        } else {
            $pn = make_clickable(htmlspecialchars($_POST['profiname']));
            $profilname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $pn);
            $pw = htmlspecialchars($_POST['pi']);
            $pI = nl2br($pw);
            $profilInfo = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $pI);
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE profile SET profileName = '{$profilname}', profilInfos =  '{$profilInfo}' WHERE  id ={$p}");
        }
    }
    //Nach der Bearbeitung, Seite reseten
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/profile.php?p={$p}");
    exit;

}
//Werte aus Datenbank auslesen, um die Werte in die Formularfelder einzusetzten
$p = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
$selectIsUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND id = {$p}");
//Ist dass das Profil, auf welches zugegriffen werden soll
//Wenn ja, werte Auslesen
if (mysqli_num_rows($selectIsUserProfile) > 0) {
    $getUserMainProfil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND id = {$p}");
}
//Wenn nein, Nutzerprofil des angemeldeten Nutzters raussuchen
else {
    $getUserMainProfil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1}");
}
//Daten aus datenbank Auslesen
$data = mysqli_fetch_assoc($getUserMainProfil);
//Werte, die in die Felder kommen
//Trennzeichen des Profiles:     -_-_-_:-_:->|-#*##
$trenndata = str_replace("<br>", "", $data['profilInfos']);
$trenndata = preg_replace('/<[^>]+>/', '', $trenndata);
$userProfileInfos = explode("-_-_-_:-_:->|-#*##", $trenndata);
$tutorials = str_replace("<b>�ber mich:</b>", "", $userProfileInfos[2]);
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if ($open_friendship_request > 0) {
    $friendship_request = '<a href="requerst_anwser.php">' . $open_friendship_request . ' Kontaktanfrage(n)</a>';
}
//Gibt an ob der Name bearbeitet werden kann
if ($data['type'] == 1) {
    $dis1 = "disabled=''";
    $mu = "<b>&Uuml;ber mich</b>";
    $ps = "Profil ";
} else {
    $mu = "<b>&Uuml;ber die Seite</b>";
    $ps = "Seite ";
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link href="designImages/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="floos_logo.png">

    <script src="designImages/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="designImages/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="style.css" rel="Stylesheet">
    </link>

    <title><?php echo $ps; ?> - Profil Bearbeiten</title>
</head>

<body>
    <div class="container bs-docs-container" id="root">
        <div role="navigation" style="background-color:#02628a;" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <img style="height:47px; width:auto; float:left; margin-right:10px;" src="designImages/floos_logo.png">
                <div class="navbar-header">
                    <button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button"
                        class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand" style="color:#FFFFFF;">
                        <font size="5"><b>Floos</b></font>
                    </a>
                </div>
                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                    <ul class="nav navbar-nav">
                        <li>
                            <a>
                                <form action="serach.php" method="get">
                                    <input type="search" value="Suche" name="s"
                                        style="right:10px; float:left; width:162px;"
                                        onfocus="if(this.value == 'Suche') this.value = ''"
                                        onBlur="if(this.value == '') this.value = 'Suche'">
                                </form>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php echo $friendship_request; ?>
                        </li>
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="content" style="background-image:none;padding-left:0px; padding-top:50px;">
            <div class="col-md-2 hidden-xs hidden-sm">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Meine Kontakte</b>
                    </div>
                    <div class="panel-body">
                        <?php
$select1Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
while ($frinds1 = mysqli_fetch_assoc($select1Frinds)) {
    $nfrind = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds1['secondid']}");
    $nnfrind = mysqli_fetch_assoc($nfrind);
    $p3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$frinds1['secondid']} AND type = 1 ");
    $p4 = mysqli_fetch_assoc($p3);
    echo "<p><a href='profile.php?p=" . $p4['id'] . "'>" . $nnfrind['prename'] . " " . $nnfrind['lastname'] . "</a></p>";
}
$select2Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
while ($frinds2 = mysqli_fetch_assoc($select2Frinds)) {
    $nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds2['firstid']}");
    $nnfrind2 = mysqli_fetch_assoc($nfrind1);
    $p5 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$frinds2['firstid']} AND type = 1 ");
    $p6 = mysqli_fetch_assoc($p5);
    echo "<p><a href='profile.php?p=" . $p6['id'] . "'>" . $nnfrind2['prename'] . " " . $nnfrind2['lastname'] . "</a></p>";
}
?>
                    </div>
                    <div class="panel-heading">
                        <b>Mag ich</b>
                    </div>
                    <div class="panel-body">
                        <?php
$select1Profile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `likes` WHERE `userID` = '{$_SESSION['userid']}' AND `Type` = '0'");
while ($frinds8 = mysqli_fetch_assoc($select1Profile)) {
    $nfrind9 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = {$frinds8['pageID']}");
    $nnfrind9 = mysqli_fetch_assoc($nfrind9);
    echo "<p><a href='profile.php?p=" . $nnfrind9['id'] . "'>" . $nnfrind9['profileName'] . "</a></p>";
}
?>
                    </div>
                    <div class="panel-heading">
                        <b>Optionen</b>
                    </div>
                    <div class="panel-body">
                        <p>
                            Neue
                            <a href="creat_page.php">
                                Seite
                            </a>
                        </p>
                        <p>
                            <a href="options.php">
                                Einstellungen
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <b><?php echo $ps; ?> bearbeiten</b>
                        <span style="padding-left:5px;" class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <div class="panel-body">
                        <form action="edit-profile.php" method="post">
                            <b>Name:</b><br>
                            <input class="form-control" <?php echo $dis1; ?> type="text" name="profiname"
                                style="width:100%" value="<?php echo $data['profileName']; ?>"><br>
                            <?php echo $mu; ?><br>
                            <textarea class="form-control" name="pi" style="resize:none; width:100%"><?php $selectbox = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profile` WHERE id = {$p}");
$selectbox1 = mysqli_fetch_assoc($selectbox);
$info = $selectbox1['profilInfos'];
$breaks = "<br />";
$text1 = str_ireplace($breaks, "", $info);
echo $text1;
?></textarea><br>
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <input type="submit" class="btn btn-default" value="   &Auml;ndern   " name="submit" />
                        </form>
                    </div>
                </div>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <b>Profilbild &auml;ndern</b>
                        <span class="glyphicon glyphicon-camera" style="padding-left:5px;"></span>
                    </div>
                    <div class="panel-body">
                        <?php
if (!isset($_GET['s'])) {} else {
    echo '<div class="alert alert-danger">Bild ist zu gro&szlig;<br>Um den Server zu schonen d&uuml;rfen nur Bilder bis maximal 10 MB hochgeladen werden</div>';
}
?>
                        <form class="form-horizontal" role="form" method="post" action="p-bild.php"
                            enctype="multipart/form-data">
                            <div style="margin-bottom:10px;">
                                <input type="file" name="img" size="40">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                            <input type="submit" class="btn btn-default" name="submit" value="Abschicken">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="designImages/js/bootstrap.js"></script>
    <div id="footer">
        <div class="container">
            <br>
            <p class="text-muted">
                &copy; Florian Vahl &amp; Tyll Peters
                <br><br>
                <a href="imrpessum.html">Impressum</a>
                <a style="padding-left:30px" href="aboutus.html">&Uuml;ber uns</a>
            </p>
        </div>
    </div>
</body>

</html>
