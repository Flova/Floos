<?php
//Diese Datei editiert die Datenbankwerte des Nutzters

//Start PHP-Session
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Php Link
require('urlconv.php');

//Guckt, ob der Nutzer eingeloggt ist, wenn nein, wird er zur Startseite weitergeleitet.
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
//Verarbeitung des Submitbuttons
if(isset($_POST['submit']))
{
  $select1Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
  while($frinds1 = mysql_fetch_assoc($select1Frinds))
  {
    if(isset($_POST[$frinds1['secondid']]))
      {

       }
  }
  $select2Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
  while($frinds2 = mysql_fetch_assoc($select2Frinds))
  {
 
 }
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
    <link href="style.css" rel="Stylesheet"></link>

  <title>Floos - Neue Fleesgruppe</title>
</head>
<body>
    <div class="container bs-docs-container" id="root"> 
      <div role="navigation" style="background-color:#02628a;" class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                       <img style="height:47px; width:auto; float:left; margin-right:10px;" src="designImages/floos_logo.png">
                        <div class="navbar-header">
                          <button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                            <a href="#" class="navbar-brand" style="color:#FFFFFF;" ><font size="5"><b>Floos</b></font></a>
                        </div>
                        <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                          <ul class="nav navbar-nav">
                            <li>
                            <a>
                             <form action="serach.php" method="get">
                      <input type="search" value="Suche" name="s" style="right:10px; float:left; width:162px;" onfocus="if(this.value == 'Suche') this.value = ''" onBlur="if(this.value == '') this.value = 'Suche'">
                            </form> </a>
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
          <div class="col-md-2 hidden-xs hidden-sm" >
            <div class="panel panel-default">
          <div class="panel-heading">
                    <b>Meine Kontakte</b>
          </div>
          <div class="panel-body">
                <?php 
            $select1Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
            while($frinds1 = mysql_fetch_assoc($select1Frinds))
            {
            $nfrind = mysql_query("SELECT * FROM user WHERE id = {$frinds1['secondid']}");
            $nnfrind = mysql_fetch_assoc($nfrind);
            $p3 = mysql_query("SELECT * FROM profile WHERE administraedFrom = {$frinds1['secondid']} AND type = 1 ");
            $p4 = mysql_fetch_assoc($p3);
            echo "<p><a href='profile.php?p=" .$p4['id'] ."'>" .$nnfrind['prename'] ." " .$nnfrind['lastname'] ."</a></p>";
            }
            $select2Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
            while($frinds2 = mysql_fetch_assoc($select2Frinds))
            {
            $nfrind1 = mysql_query("SELECT * FROM user WHERE id = {$frinds2['firstid']}");
            $nnfrind2 = mysql_fetch_assoc($nfrind1);
            $p5 = mysql_query("SELECT * FROM profile WHERE administraedFrom = {$frinds2['firstid']} AND type = 1 ");
            $p6 = mysql_fetch_assoc($p5);
            echo "<p><a href='profile.php?p=" .$p6['id'] ."'>" .$nnfrind2['prename'] ." " .$nnfrind2['lastname'] ."</a></p>";
            }
            ?>
                  </div>
            <div class="panel-heading">
              <b>Mag ich</b>
            </div>
            <div class="panel-body">
            <?php
            $select1Profile = mysql_query("SELECT * FROM `likes` WHERE `userID` = '{$_SESSION['userid']}' AND `Type` = '0'");
            while($frinds8 = mysql_fetch_assoc($select1Profile))
            {
            $nfrind9 = mysql_query("SELECT * FROM profile WHERE id = {$frinds8['pageID']}");
            $nnfrind9 = mysql_fetch_assoc($nfrind9);
            echo "<p><a href='profile.php?p=" .$nnfrind9['id'] ."'>" .$nnfrind9['profileName'] ."</a></p>";
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
                    <b>Neue Fleesgruppe</b>
                  </div>
                  <div class="panel-body">
                    <div class="panel-body">
                    <form action="flees_group.php" method="post">
                    <b>Name der Fleesgruppe</b><br>
                    <input type="text" class="form-control" name="profiname" style="width:100%" value="Florian Vahl"><br>
                    <?php 

                      $select1Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
                      while($frinds1 = mysql_fetch_assoc($select1Frinds))
                      {
                      $nfrind = mysql_query("SELECT * FROM user WHERE id = {$frinds1['secondid']}");
                      $nnfrind = mysql_fetch_assoc($nfrind);
                      echo  '<label class="checkbox"><input type="checkbox" name="' . $nnfrind['id'] .'"  value="1">' .$nnfrind['prename'] ." " .$nnfrind['lastname'] ."</label>";
                      }
                      $select2Frinds = mysql_query("SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
                      while($frinds2 = mysql_fetch_assoc($select2Frinds))
                      {
                      $nfrind1 = mysql_query("SELECT * FROM user WHERE id = {$frinds2['firstid']}");
                      $nnfrind2 = mysql_fetch_assoc($nfrind1);
                      echo  '<label class="checkbox"><input type="checkbox" name="' . $nnfrind2['id'] .'"  value="1">' .$nnfrind2['prename'] ." " .$nnfrind2['lastname'] ."</label>";
                      }

                    ?>
                    <input type="submit" class="btn btn-default" value="   Erstellen   " name="submit">
                    </form>
                  </div>
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