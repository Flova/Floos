<?php
//Diese Datei beantwortet Freundschaftsanfragen

//PHP Session starten
session_start();
//Mit Datenbank verbinden
require_once 'config.php';
//Ist man eingelogt
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Freundschaft annehmen
if (isset($_GET['a'])) {
    //Parameter absichern
    $a = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['a']);
    //Datenbankabfrage, ob die Freundschaft bestaetigt werden kann
    $ismyrequest = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0 AND id = {$a}");
    //Kann sie bestaetigt werden
    if (mysqli_num_rows($ismyrequest) != 0) {
        //Freundschaft bestaetigen
        $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE friendship SET confired = 1 WHERE id = {$a}");
        //Weiterleitung, um Parameter zu entfernen
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/requerst_anwser.php");
        exit;
    } else {
        //Weiterleitung, um Parameter zu entfernen
        $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE friendship SET confired = 1 WHERE id = {$a}");
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/requerst_anwser.php");
        exit;
    }
}
//Freundschaft ablehnen
if (isset($_GET['d'])) {
    //Parameter absichern
    $d = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['d']);
    //Datenbankabfrage, ob die Freundschaft abgelehnt werden kann
    $ismyrequest = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0 AND id = {$d}");
    //Kann sie bestaetigt werden
    if (mysqli_num_rows($ismyrequest) != 0) {
        //Freundschaft ablehnen
        $update = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM friendship WHERE id = {$d}");
        //Weiterleitung, um Parameter zu entfernen
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/requerst_anwser.php");
        exit;
    } else {
        //Weiterleitung, um Parameter zu entfernen
        $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE friendship SET confired = 1 WHERE id = {$a}");
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/requerst_anwser.php");
        exit;
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link href="sonstiges/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="floos_logo.png">

    <script src="sonstiges/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="sonstiges/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="style.css" rel="Stylesheet">
    </link>

    <title>Floos - Deine Kontaktanfragen</title>
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
                                    <input id="se" type="search" value="Suche" name="s"
                                        style="right:10px; float:left; width:162px;"
                                        onfocus="if(this.value == 'Suche') this.value = ''"
                                        onBlur="if(this.value == '') this.value = 'Suche'">
                                </form>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
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
        <div id="content" class="row" style="background-image:none;padding-left:0px; padding-top:50px;">
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
                <h2>Kontaktanfragen</h2>
                <?php
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
while ($row = mysqli_fetch_assoc($select_friedship_requersts)) {
    $selct_user_info = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$row['firstid']}");
    $userdata = mysqli_fetch_assoc($selct_user_info);
    echo "<div class='panel panel-default'><div class='panel-heading'><b>" . $userdata['prename'] . " " . $userdata['lastname'] . "</b></div><div class='panel-body'>
										<button onclick=" . '"' . "window.location.href = '" . "requerst_anwser.php?a={$row['id']}" . "';" . '"' . " class='btn btn-primary' type='button'>Best&auml;tigen</button>
	        							<button onclick=" . '"' . "window.location.href = '" . "requerst_anwser.php?d={$row['id']}" . "';" . '"' . " class='btn btn-default' type='button'>L&ouml;schen</button>
									</div>
								</div>";
}
?>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <br>
            <p class="text-muted">
                &copy; Florian Vahl &amp; Tyll Peters
                <br><br>
                <a href="imrpessum.html">Impressum</a>
                <a style="padding-left:30px" href="about_us.html">&Uuml;ber uns</a>
            </p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="sonstiges/js/bootstrap.js"></script>
</body>

</html>
