 <head>
     <meta charset="utf-8">
     <meta content="IE=edge" http-equiv="X-UA-Compatible">
     <meta content="width=device-width, initial-scale=1" name="viewport">

     <!-- Bootstrap core CSS -->
     <link rel="stylesheet" href="http://flova.de/floos_debug/designImages/css/bootstrap.min.css">

     <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
     <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
     <script src="http://flova.de/floos_debug/designImages/js/ie-emulation-modes-warning.js"></script>

     <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
     <script src="http://flova.de/floos_debug/designImages/js/ie10-viewport-bug-workaround.js"></script>

     <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
     <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 </head>
 <?php
require 'config.php';
//Pinwandausgabe
$selctPWData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  pinnwand WHERE postOnUserID = {$_GET['p']} ORDER BY poston DESC");
$user = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE id = {$_GET['p']}");
$user = mysqli_fetch_assoc($user);
echo "<h1>" . $user['profileName'] . "<div style='float:right'><a target='_blank' href='http://floos.flova.de'><img height='30px' src='floos_logo.png'></a></div></h1>";
while ($pwData = mysqli_fetch_assoc($selctPWData)) {
    $ansers2 = "";
    $selectPostFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$pwData['userid']}");
    $PostUserName = mysqli_fetch_assoc($selectPostFrom);
    $homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$PostUserName['id']} AND type = 1");
    $homeid1 = mysqli_fetch_assoc($homeid);
    $date1 = new DateTime($pwData['poston']);
    $date2 = $date1->format('H:i:s d.m.Y');
    $answers1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM answer WHERE fleesID = " . $pwData['id'] . " ORDER BY date DESC");
    if (mysqli_num_rows($answers1) > 0) {
        $ansers2 = '<br>Antworten:<div style="padding-left:20px;">';
    }
    while ($answers = mysqli_fetch_assoc($answers1)) {
        $answerID = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = " . $answers['userid']);
        $answerID1 = mysqli_fetch_assoc($answerID);
        $homeid2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$answers['userid']} AND type = 1");
        $homeid2 = mysqli_fetch_assoc($homeid2);
        $ansers2 = $ansers2 . "<a target='_blank' href='profile.php?p=" . $homeid2['id'] . "'>" . $answerID1['prename'] . " " . $answerID1['lastname'] . ":</a><br>" . $answers['text'] . "<br>";
    }
    if (mysqli_num_rows($answers1) > 0) {
        $ansers2 = $ansers2 . "</div>";
    }
    echo "<div class='panel panel-default'><div class='panel-heading'><a target='_blank' name='" . $pwData['id'] . "' href='profile.php?p=" . $homeid1['id'] . "'>" . $PostUserName['prename'] . " " . $PostUserName['lastname'] . "</a>
		    				</div>
		    				<div class='panel-body'>";
    echo $pwData['pwcontent'] . "<br><br><font size='1'>" . $date2 . "</font>" . $ansers2 . "</div></div>";
}
?>
