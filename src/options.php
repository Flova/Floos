<?php
//Start PHP-Session
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Guckt, ob der Nutzer eingeloggt ist, wenn nein, wird er zur Startseite weitergeleitet.
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Passwort Ändern
if (isset($_POST['passwort'])) {
    $pw3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['passwort']);
    $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `user` SET `password` = MD5( '" . $pw3 . "' ) WHERE `id` = " . $_SESSION['userid']);
}
if (isset($_POST['website'])) {
    $codeinput = "<div class='panel panel-default'>
			           	<div class='panel-heading'>
			           		<b>Code zum einbinden eines FloosButtons auf der eigenen Website</b>
			           	</div>
			           	<div class='panel-body'>" .
    htmlspecialchars("<a target='_blank' href='http://flova.de/floos_debug/button.php?l=" . $_POST['website'] . "'>
							<img style='width:100px;' src='http://flova.de/floos_debug/flees_logo.png'>
							</a>") .
        "</div>
			      </div>";
} else {
    $codeinput = "<div class='panel panel-default'>
			           	<div class='panel-heading'>
			           		<b>Code zum einbinden eines FloosButtons auf der eigenen Website</b>
			           	</div>
			           	<div class='panel-body'>
			           		<div style='margin-bottom:10'><b>Achtung:</b><br>Vor dem Link muss http:// oder https:// stehen.</div>
			           		<form action='options.php' method='post' class='form-inline' role='form'>
								<div class='form-group' style='margin-right:10px;'>
									<input name='website' type='text' placeholder='Deine Website' class='form-control'>
								</div>
								<button type='submit' class='btn btn-default'>Code erstellen</button>
							</form>
			           	</div>
			        </div>";
}
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if ($open_friendship_request > 0) {
    $friendship_request = '<a href="requerst_anwser.php">' . $open_friendship_request . ' Kontaktanfrage(n)</a>';
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

    <title>Einstellungen - Floos</title>
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
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <h2>Einstellungen</h2>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <b>Passwort &auml;ndern</b>
                    </div>
                    <div class="panel-body">
                        <form action="options.php" method="post" class="form-inline" role="form">
                            <div class="form-group" style="margin-right:10px;">
                                <input name="passwort" type="password" placeholder="Password" id="exampleInputPassword2"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn btn-default">&Auml;ndern</button>
                        </form>
                    </div>
                </div>
                <?php echo $codeinput; ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <b>Melden, Account löschen usw.</b>
                    </div>
                    <div class="panel-body">
                        <p>Um eine Person oder einen Bug zu Melden, seinen Account zu Löschen oder &auml;hnliches,
                            kontaktieren Sie bitte den Admin:<br>E-Mail: flori@flova.de oder tyll@flova.de</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <br>
            <p class="text-muted">
                &copy; Florian Vahl &amp; Tyll Peters
                <br><br>
                <a href="impressum.html">Impressum</a>
                <a style="padding-left:30px" href="aboutus.html">&Uuml;ber uns</a>
            </p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="designImages/js/bootstrap.js"></script>
</body>

</html>
