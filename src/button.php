 <?php
 //PHP Session starten
  session_start();

   $link = $_GET['l'];
 //Bindet die Datnbankverbindung ein
require_once('config.php');
 //Weiterleiten
if(!isset($_SESSION['userid']))
{
   echo '<html>
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
    <link href="style.css" rel="Stylesheet"></link>

    <title>FLOOS - Die Alternative</title>
</head>
<body>
       <div id="root">
             <div role="navigation" style="background-color:#02628a;" class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                		   <img style="height:47px; width:auto; float:left; margin-right:10px;" src="designImages/floos_logo.png">
                        <div class="navbar-header">
                            <a href="#" class="navbar-brand" style="color:#FFFFFF;" ><font size="5"><b>Floos</b></font></a>
                        </div>
                </div>
             </div>
             <div class="container bs-docs-container" style="padding-top:49px;">
                 <div class="jumbotron">
                        <h1>Floos</h1>
                        <h3>Du musst dich erst anmelden, um den Link zu teilen</h3>
                        <p>Anmelden</p>
                        <p>
                            <form style="width:200px;" action="outlogin.php" method="post">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="email" value="E-Mail" onfocus="if(this.value == ' . "'" . "E-Mail" . "'" . ') this.value = ' . "''" . '" onblur="if(this.value == ' . "''" . ') this.value = ' . "'" . "E-Mail" . "'" .'"></input>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" value="*******" onfocus="if(this.value == ' . "'" . "*******" . "'" . ') this.value = ' . "''" . '" onblur="if(this.value == ' . "''" . ') this.value = ' . "'" . "*******" . "'" . '"></input>
                                </div>
                                <input type="hidden" name="link" value="' . $link . '">
                                        <input class="btn btn-primary btn-lg" type="submit" value="Login" name="submit"></input>
                            </form>
                        </p>
                        <p>Noch nicht dabei?</p>
                        <p><a class="btn btn-primary btn-lg" role="button">Registrieren</a></p>
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
        <a style="padding-left:30px" href="aboutus.html">&Uuml;ber uns</a>
      </p>
        </div>
      </div>
         <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
         <script type="text/javascript" src="sonstiges/js/bootstrap.min.js"></script>
 </body>    
</html>' ;
}else{
   //Setzt die Zeitzone auf Berlin fest
	date_default_timezone_set("Europe/Berlin");
	//Bezieht sich die Serverzeit unter brücksichtigung der Zeitzone
	$date = date("Y-m-d H:i:s");
	$homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
	$homeid1 = mysqli_fetch_assoc($homeid);
	$uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $homeid1['id']);
	$uid1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
	$nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$uid1}");
	$nnfrind2 = mysqli_fetch_assoc($nfrind1);
	$link1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['link']);
	$text = $nnfrind2['prename'] . " " . $nnfrind2['lastname'] . " hat folgenden Link geteielt:<br><a href='" . $link . "'>" . $link . "</a>";
	$text = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $text);
	//Schreibt die Werte in die Datenbank
	$insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','{$text}','{$uid1}','{$uid}','{$date}')");
	//Weiterleitung
  $host = $_SERVER['HTTP_HOST'];
  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  header("Location: http://$host$uri/home.php");
  exit;
	}
 ?>