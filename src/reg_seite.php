<?php
session_start();
if (isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/home.php");
    exit;
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

    <title>FLOOS - Die Alternative</title>
</head>

<body>
    <div id="root">
        <div role="navigation" style="background-color:#02628a;" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <img style="height:47px; width:auto; float:left; margin-right:10px;" src="designImages/floos_logo.png">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand" style="color:#FFFFFF;">
                        <font size="5"><b>Floos</b></font>
                    </a>
                </div>
            </div>
        </div>
        <div class="container bs-docs-container" style="padding-top:49px;">
            <div class="jumbotron">
                <h1>Hier Registrieren</h1>
                <h3>Einfach in 2 Minuten auf Floos Registrieren.</h3>
                <?php
if (!isset($_GET['f'])) {} else {
    echo '<div class="alert alert-danger">Die Registrierung ist leider fehlgeschlagen<br>Dies kann z.B. an nicht ausgef&uuml;llten Feldern liegen.</div>';
}
?>
                <form action="reg.php" method="post">
                    <b>Vorname:</b></br>
                    <input class="form-control" type="text" name="prename" style="width:100%"></input>
                    <b>Nachname:</b></br>
                    <input class="form-control" type="text" name="lastname" style="width:100%"></input>
                    <b>E-Mail Adresse:</b></br>
                    <input class="form-control" type="mail" name="mail" style="width:100%"></input>
                    <b>E-Mail Adresse best&auml;tigen:</b></br>
                    <input class="form-control" type="mail" name="mailb" style="width:100%"></input>
                    <b>Passwort:</b></br>
                    <input class="form-control" type="password" name="password" style="width:100%"></input>
                    <b>Passwort best&auml;tigen:</b></br>
                    <input class="form-control" type="password" name="passwordb" style="width:100%"></input>
                    <b>Achtung:</b><br>Du wirst wenige Minuten nach dem Resistrieren eine Mail zur Verifizierung deines
                    Accounts bekommen diese könnte eventuell im Spam-Ordner landen.<br><br>
                    <input class="btn btn-primary btn-lg" type="submit" name="reg" value="   Registrieren   "></input>
                </form>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="sonstiges/js/bootstrap.min.js"></script>
</body>

</html>
