<?php
//Diese Datei ist die Startseite fuer eingeloggte Benutzter


//PHP Session starten
session_start();
//Bindet die Datnbankverbindung ein
require_once('config.php');
//Php Link
require('urlconv.php');
//Ist der Nutzter eingeloggt, wenn nein auf die Anmeldeseite weiterlieten
if(!isset($_SESSION['userid']))
{			
	            //Weiterleitung
	            $host = $_SERVER['HTTP_HOST'];
	            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	            header("Location: http://$host$uri/");
	            exit;
}
//Pinnwand eingabe verarbeiten
if(isset($_POST['pinnwand']) && $_POST['pinnwand'] != "" && $_POST['pinnwand'] !="Dein Status")
{
	//Setzt die Zeitzone auf Berlin fest
	date_default_timezone_set("Europe/Berlin");
	//Bezieht sich die Serverzeit unter br�cksichtigung der Zeitzone
	$date = date("Y-m-d H:i:s");
	//Bereitet die Variablen f�r die Datenbank auf
                 $pw = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pinnwand']);
                 $pw = make_clickable(htmlspecialchars($pw));
                 $var = array(
                  'ä' => '&auml;',
                  'Ä' => '&Auml;',
                  'ü' => '&uuml;',
                  'Ü' => '&Uuml;',
                  'ö' => '&ouml;',
                  'Ö' => '&Ouml;',
                  'ß' => '&szlig;' );
                  $pw1 = str_replace(array_keys($var), array_values($var), $pw);
	$homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
	$homeid1 = mysqli_fetch_assoc($homeid);
	$uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $homeid1['id']);
	$uid1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);	
	//Schreibt die Werte in die Datenbank
	$insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','{$pw1}','{$uid1}','{$uid}','{$date}')");
}
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if($open_friendship_request > 0)
{
	$friendship_request = '<a href="requerst_anwser.php">'. $open_friendship_request.' Kontaktanfrage(n)</a>';	
	$friendship_request1 = '<div class="panel-heading hidden-lg hidden-sm hidden-md"><b>Anfragen</b></div><div class="panel-body hidden-lg hidden-sm hidden-md"><p>' . $friendship_request . '</p></div>';
}
//Liest die ID des Profiles aus
$selectUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
$userProfile = mysqli_fetch_assoc($selectUserProfile);

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
function onOffline() {
    alert("Du bist offline");
}</script>

	<title> Dein Floos</title>
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
                        		</form>	</a>
                            </li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                            <li>
                              <?php echo $friendship_request; ?>
                            </li>
                            <li>
                            	 <a href="profile.php?p=<?php $homeid2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1"); $homeid12 = mysqli_fetch_assoc($homeid2); echo $homeid12['id']; ?>">Mein Profil</a>
                            </li>
                            <li>
                              <a href="chat.php">Chat</a> 
                            </li>
                            <li>
                              <a href="logout.php">Logout</a> 
                            </li>
                          </ul>
                       </nav>
                </div>
             </div>
        <div id="content" style="background-image:none;padding-left:0px; padding-top:50px;">
        	<div class="col-md-12 hidden-md hidden-lg">
						<h2>Home</h2>
		            		<form action="home.php" method="post">
					      		<div class="input-group">
					      			<input class="form-control" type="text" value="Dein Status" name="pinnwand" style="width:100%;" onFocus="if(this.value == 'Dein Status') this.value = ''" onBlur="if(this.value == '') this.value = 'Dein Status'"/>
		           					<div class="input-group-btn">
										 <button class="btn btn-default" type="submit">Senden</button><!--
										 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Einschränken <span class="caret"></span></button>
										 <ul style="right: 0; left: auto;" role="menu" class="dropdown-menu dropdown-menu-right">
										    <div style="margin:5px;margin-left:10px;" class="radio">
										 		<label>
										 		  <input type="radio" name="groups" value="1" checked="">
										 		  Alle
										 		</label>
											</div>
										
											<li class="divider"></li>
  											<li><a href="flees_group.php">Neue Fleesgruppe</a></li>
     								    </ul>
-->
     								   
     								</div>
<!-- /btn-group -->
     							</div>
		           			</form>	
					</div>
	        <div class="col-md-2" >
	        	<div class="panel panel-default">
	      			<?php echo $friendship_request1;?>
					<div class="panel-heading">
			            	<b>Meine Kontakte</b>
					</div>
					<div class="panel-body">
			       		<?php 
						$select1Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
						while($frinds1 = mysqli_fetch_assoc($select1Frinds))
						{
						$nfrind = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds1['secondid']}");
						$nnfrind = mysqli_fetch_assoc($nfrind);
						$p3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$frinds1['secondid']} AND type = 1 ");
						$p4 = mysqli_fetch_assoc($p3);
						echo "<p><a href='profile.php?p=" .$p4['id'] ."'>" .$nnfrind['prename'] ." " .$nnfrind['lastname'] ."</a></p>";
						}
						$select2Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");
						while($frinds2 = mysqli_fetch_assoc($select2Frinds))
						{
						$nfrind1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$frinds2['firstid']}");
						$nnfrind2 = mysqli_fetch_assoc($nfrind1);
						$p5 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$frinds2['firstid']} AND type = 1 ");
						$p6 = mysqli_fetch_assoc($p5);
						echo "<p><a href='profile.php?p=" .$p6['id'] ."'>" .$nnfrind2['prename'] ." " .$nnfrind2['lastname'] ."</a></p>";
						}
						?>
			            </div>
						<div class="panel-heading">
							<b>Mag ich</b>
						</div>
						<div class="panel-body">
						<?php
						$select1Profile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `likes` WHERE `userID` = '{$_SESSION['userid']}' AND `Type` = '0'");
						while($frinds8 = mysqli_fetch_assoc($select1Profile))
						{
						$nfrind9 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = {$frinds8['pageID']}");
						$nnfrind9 = mysqli_fetch_assoc($nfrind9);
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
	            <div class="col-md-10" style="padding-left:5; background-color:#e9e9e9;">
					<div class="col-md-12 hidden-xs hidden-sm">
						<h2>Home</h2>
		            		<form action="home.php" method="post">
					      		<div class="input-group">
					      			<input class="form-control" type="text" value="Dein Status" name="pinnwand" style="width:100%;" onFocus="if(this.value == 'Dein Status') this.value = ''" onBlur="if(this.value == '') this.value = 'Dein Status'"/>
		           					<div class="input-group-btn">
										 <button class="btn btn-default" type="submit">Senden</button>
										 <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Einschränken <span class="caret"></span></button>
										 <ul style="right: 0; left: auto;" role="menu" class="dropdown-menu dropdown-menu-right">
										    <div style="margin:5px;margin-left:10px;" class="radio">
										 		<label>
										 		  <input type="radio" name="groups" value="1" checked="">
										 		  Alle
										 		</label>
											</div>
											<li class="divider"></li>
  											<li><a href="flees_group.php">Neue Fleesgruppe</a></li>
     								    </ul>-->

     								   
     								</div>
<!-- /btn-group -->
     							</div>
		           			</form>	
					</div>
					<div  class="col-md-6 hidden-md hidden-lg" >
						<?php
						 //Sind neue Nachichten vorhanden?
						 $myId = $_SESSION['userid'];
        $selctCHData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `Chat` WHERE `secondID` = " . $myId . " AND `read` = 0 ORDER BY time DESC");
        if(mysqli_num_rows($selctCHData) > 0){
           echo "<div class='panel panel-default'><div class='panel-heading'><b> Du hast " . mysqli_num_rows($selctCHData) . " neue Chatnachicht(en)</b></div><div class='panel-body'>";
           while($newchatdata = mysqli_fetch_assoc($selctCHData))
           {
              	$selectsmFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$newchatdata['firstID']}");
	             $smUserName = mysqli_fetch_assoc($selectsmFrom);
              	echo "<a href='chat.php?p=" . $newchatdata['firstID'] . "'>" . $smUserName['prename'] . " " . $smUserName['lastname']  . "</a><br>";

           }
           echo "</div></div>"; 
        }
						 //Profilbild ausgabe
							$p33 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1 ");
							$p43 = mysqli_fetch_assoc($p33);
							$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profileimages` WHERE 	userid = " . $p43['id']);
							if(mysqli_num_rows($result) > 0){
								$result = mysqli_fetch_assoc($result);
								echo "<div class='panel panel-default'><div class='panel-body'><img src='bilder/" . $p43['id'] . "." . $result['imgType'] . "' style='width:100%; height:auto;'></div></div>";
							}

							?>
		            	<?php 
						// Profil anzeigen
						$p3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1 ");
						$p4 = mysqli_fetch_assoc($p3);
						echo "<div class='panel panel-default'><div class='panel-heading'><b>Mein Profil</b><a> [</a><a  href='edit-profile.php?p=".$p4['id']."'>Bearbeiten</a><a>]</a></div><div class='panel-body'>";
						$my_profil_info = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = {$p4['id']}");
						$my_data = mysqli_fetch_assoc($my_profil_info);
						echo $my_data['profilInfos']."</div></div>";
			            ?>	
		            </div>
					<div class="col-md-6" >
						<?php
    						$ms = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM message WHERE userId = {$_SESSION['userid']} AND activ = 1 ORDER BY id DESC");
							if(mysqli_num_rows($ms) > 0){
								$ms = mysqli_fetch_assoc($ms);
								echo '<div class="alert alert-' . $ms['prio'] . ' fade in" role="alert">
      										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      										<h4>Meldung des Admins</h4>
      										<p>' . $ms['content'] . '</p>
    									</div>';
							}
    					?>
						<div class="panel panel-default hidden-lg hidden-md">
							<div class="panel-heading">
								<b>Die neusten Fleeses deiner Kontakte</b>
							</div>
						</div>
					<?php
					//neusten fleeses
					$select11Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `firstid` = '{$_SESSION['userid']}'");
					$np = "( " .$_SESSION['userid'] ;
					while($frinds11 = mysqli_fetch_assoc($select11Frinds))
					{
						$np = $np . " , " . $frinds11['secondid'] ;                                                                
					}
					$select21Frinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE `confired` = 1 AND `secondid` = '{$_SESSION['userid']}'");		
		            while($frinds21 = mysqli_fetch_assoc($select21Frinds))
					{
						$np = $np . " , " . $frinds21['firstid'] ;
					}
					$np = $np ." )";
		                                                      	$selctPWData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  pinnwand WHERE userid IN {$np} ORDER BY poston DESC LIMIT 0 , 30 ");
						while($pwData = mysqli_fetch_assoc($selctPWData))
						{
							$selectPostFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$pwData['userid']}");
							$PostUserName = mysqli_fetch_assoc($selectPostFrom);
							$homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$PostUserName['id']} AND type = 1");
							$homeid1 = mysqli_fetch_assoc($homeid);
		                    $date1 = new DateTime($pwData['poston']);
		                    $date2 = $date1->format('H:i d.m.Y');
		                    $answers1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM answer WHERE fleesID = " . $pwData['id'] . " ORDER BY date DESC");
		     				if(mysqli_num_rows($answers1) > 0)
		     				{
		     					$ansers2 = '<br>Antworten:<div style="padding-left:20px;">';
		     				}
		     				while($answers = mysqli_fetch_assoc($answers1))
							{
								$answerID = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = " . $answers['userid']);
								$answerID1 = mysqli_fetch_assoc($answerID);
								$homeid2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$answers['userid']} AND type = 1");
								$homeid2 = mysqli_fetch_assoc($homeid2);
								$ansers2 = $ansers2 . "<a href='profile.php?p=" . $homeid2['id'] . "'>" . $answerID1['prename'] . " " . $answerID1['lastname'] . ":</a><br>" . $answers['text'] . "<br>";
							}
							if(mysqli_num_rows($answers1) > 0)
		     				{
								$ansers2 = $ansers2 . "</div>";
							}
							//Nur erlaubte User
							$profileID1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
							$lock = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `locked` WHERE `pageId` = {$pwData['postOnUserID']} AND ok = 1");
							if(mysqli_num_rows($lock) != 0) {
								$lock2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM locked WHERE pageId = {$pwData['postOnUserID']} AND member = {$_SESSION['userid']} AND ok = 1");
								if(mysqli_num_rows($lock2) != 0) {
									$read_ok = "ok";
								}else{
									$read_ok = "no";
								}
							}else{
								$read_ok = "ok";
							}
							if ($read_ok == "ok") {
		    				echo "<div class='panel panel-default'><div class='panel-heading'><a name='" . $pwData['id'] . "' href='profile.php?p=" .$homeid1['id'] ."'>" .$PostUserName['prename'] ." " .$PostUserName['lastname'] ."</a>
		    				<div style='float:right'>
		    				<div class='btn-group'>
  								<button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>
  								  Aktionen <span class='caret'></span>
  								</button>
  								<ul role='menu' style='right: 0; left: auto;'' class='dropdown-menu'>
		    						<li><a href='reflees.php?f=" . $pwData['id'] . "'>
		    							Refleesen
		    							<span style='padding-left:5px;' class='glyphicon glyphicon-share-alt'></span>
		    						</a></li>
		    						<li><a href='answer_page.php?f=" . $pwData['id'] . "'>
		    						Antworten
		    						</a></li>
		    						<li><a href='likeflees.php?f=" . $pwData['id'] . "'>
		    						Mag ich
		    						</a></li>
		    						<li><a href='profile.php?p=" . $pwData['postOnUserID'] . "#" . $pwData['id'] . "'>zum Flees</a></li>
  								</ul>
							</div>
		    				</div>
		    				</div>
		    				<div class='panel-body'>";
							echo $pwData['pwcontent'] ."<br><br><font size='1'>" .$date2  ."</font>" . $ansers2 . "</div></div>";
							}
							$ansers2 = "";
						}
						?>
		                </div>
						<div  class="col-md-6 hidden-xs hidden-sm" >
						<?php 
						 //Sind neue Nachichten vorhanden?
						 $myId = $_SESSION['userid'];
        $selctCHData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `Chat` WHERE `secondID` = " . $myId . " AND `read` = 0 ORDER BY time DESC");
        if(mysqli_num_rows($selctCHData) > 0){
           echo "<div class='panel panel-default'><div class='panel-heading'><b> Du hast " . mysqli_num_rows($selctCHData) . " neue Chatnachicht(en)</b></div><div class='panel-body'>";
           while($newchatdata = mysqli_fetch_assoc($selctCHData))
           {
              	$selectsmFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$newchatdata['firstID']}");
	             $smUserName = mysqli_fetch_assoc($selectsmFrom);
              	echo "<a href='chat.php?p=" . $newchatdata['firstID'] . "'>" . $smUserName['prename'] . " " . $smUserName['lastname']  . "</a><br>";

           }
           echo "</div></div>"; 
        }
						$p33 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1 ");
						$p43 = mysqli_fetch_assoc($p33);
						$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profileimages` WHERE 	userid = " . $p43['id']);
						if(mysqli_num_rows($result) > 0){
							$result = mysqli_fetch_assoc($result);
								echo "<div class='panel panel-default'><div class='panel-body'><img src='bilder/" . $p43['id'] . "." . $result['imgType'] . "' style='width:100%; height:auto;'></div></div>";
							}
						?>
		                <?php 
						// Profil anzeigen
						$p3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1 ");
						$p4 = mysqli_fetch_assoc($p3);
						echo "<div class='panel panel-default'><div class='panel-heading'><b>Mein Profil</b><a> [</a><a  href='edit-profile.php?p=".$p4['id']."'>Bearbeiten</a><a>]</a></div><div class='panel-body'>";
						$my_profil_info = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = {$p4['id']}");
						$my_data = mysqli_fetch_assoc($my_profil_info);
						echo $my_data['profilInfos']."</div></div>";
			            ?>	
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
						<a style="padding-left:30px" href="aboutus.html">&Uuml;ber uns</a>
					</p>
	     		</div>
    		</div>
			<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
			<script src="designImages/js/bootstrap.js"></script>
        </body>    
</html>