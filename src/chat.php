<?php
//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once 'config.php';
//Ist man eingellogt?
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
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

    <title>Floos - Chat</title>
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
        <div id="content" class="row" style="background-image:none;padding-left:0px; padding-top:50px;">
            <div class="col-md-2 hidden-xs hidden-sm">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Chatte mit:</b>
                    </div>
                    <div class="panel-body">
                        <?php
$select1Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
while ($frinds1 = mysqli_fetch_assoc($select1Frinds)) {
    $nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds1['secondid']}");
    $nnfrind = mysqli_fetch_assoc($nfrind1);
    echo "<p><a href='chat.php?p=" . $nnfrind['id'] . "'>" . $nnfrind['prename'] . " " . $nnfrind['lastname'] . "</a></p>";
}
$select2Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
while ($frinds2 = mysqli_fetch_assoc($select2Frinds)) {
    $nfrind2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds2['firstid']}");
    $nnfrind2 = mysqli_fetch_assoc($nfrind2);
    echo "<p><a href='chat.php?p=" . $nnfrind2['id'] . "'>" . $nnfrind2['prename'] . " " . $nnfrind2['lastname'] . "</a></p>";
}
?>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <?php
if (isset($_GET['p'])) {
    $selectsmFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$_GET['p']}");
    $smUserName = mysqli_fetch_assoc($selectsmFrom);
    echo "<b>Chatte mit " . $smUserName['prename'] . " " . $smUserName['lastname'] . "</b>";
} else {
    echo "<b>System</b>";
}
?>
                    </div>
                    <div class="panel-body">
                        <?php
if (isset($_GET['p'])) {
    echo '<iframe frameborder="0" style="width:100%; height:60px;" noresize="noresize" src="leiste.php?p=' . $_GET['p'] . '"></iframe>';
    echo '<div style="padding-left:10px" ><iframe frameborder="0" style="width:100%" noresize="noresize" src="chat_refresh.php?p=' . $_GET['p'] . '"></iframe><div style="padding-left:8px"><a href="c_chat.php?p=' . $_GET['p'] . '">Den gesammten Chatverlauf ansehen</a></div></div>';
} else {
    echo "W&auml;hle einen Kontakt zum Chatten aus";
}
?>
                    </div>
                </div>
            </div>
            <div class="col-md-2 hidden-lg hidden-md">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Chatte mit:</b>
                    </div>
                    <div class="panel-body">
                        <?php
$select1Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
while ($frinds1 = mysqli_fetch_assoc($select1Frinds)) {
    $nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds1['secondid']}");
    $nnfrind = mysqli_fetch_assoc($nfrind1);
    echo "<p><a href='chat.php?p=" . $nnfrind['id'] . "'>" . $nnfrind['prename'] . " " . $nnfrind['lastname'] . "</a></p>";
}
$select2Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
while ($frinds2 = mysqli_fetch_assoc($select2Frinds)) {
    $nfrind2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds2['firstid']}");
    $nnfrind2 = mysqli_fetch_assoc($nfrind2);
    echo "<p><a href='chat.php?p=" . $nnfrind2['id'] . "'>" . $nnfrind2['prename'] . " " . $nnfrind2['lastname'] . "</a></p>";
}
?>
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
                <a href="imrpessum.html">Impressum</a>
                <a style="padding-left:30px" href="about_us.html">&Uuml;ber uns</a>
            </p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="sonstiges/js/bootstrap.js"></script>
</body>

</html>
