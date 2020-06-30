<?php
//Diese Datei zeigt das Profil an

//PHP Session starten
session_start();

require 'urlconv.php';

//Ist man eingellogt?
if (!isset($_SESSION['userid'])) {
    //Weiterleitung
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/index.php");
    exit;
}
//Mit Datenbank verbinden
require 'config.php';

//Nur erlaubte User
$profileID1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
$lock = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `locked` WHERE `pageId` = {$profileID1} AND ok = 1");
if (mysqli_num_rows($lock) != 0) {
    $lock2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM locked WHERE pageId = {$profileID1} AND member = {$_SESSION['userid']} AND ok = 1");
    if (mysqli_num_rows($lock2) != 0) {
        $read_ok = "ok";
    } else {
        $read_ok = "no";
    }
} else {
    $read_ok = "ok";
}
//An Pinnwand posten
//Sind die Daten fuer die Pinnwand verwerndbar
if (isset($_POST['pinnwand']) && $_POST['pinnwand'] != "" && $_POST['pinnwand'] != "Poste an die Pinnwand") {
    //Mit Datenbank verbinden
    require 'config.php';
    //Zeitzone festlegene
    date_default_timezone_set("Europe/Berlin");
    //Datum und Zeit abfragen
    $date = date("Y-m-d H:i:s");
    //Eingeben vor SQL-Injection sichern
    $pwe = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pinnwand']);
    $pw = make_clickable(htmlspecialchars($pwe));
    $var = array(
        'ä' => '&auml;',
        'Ä' => '&Auml;',
        'ü' => '&uuml;',
        'Ü' => '&Uuml;',
        'ö' => '&ouml;',
        'Ö' => '&Ouml;',
        'ß' => '&szlig;');
    $pw1 = str_replace(array_keys($var), array_values($var), $pw);
    $uid = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
    $postOnID = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['profileID']);

    //Werte in Datenbank schreiben
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pinnwand VALUES('','{$pw1}','{$uid}','{$postOnID}','{$date}')");
}
//Profilinfos auslesen
//Gucken, ob der Profil-ID Parameter gesetzt ist
if (isset($_GET['p'])) {
    //Mit Datenbank verbinden
    require 'config.php';
    //ID vor SQL-Injection absichern
    $p = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
    //Werte aus Datenbank auslesen
    $selcte_profil_info = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE id = {$p}");
    //Ist ein Profil mit der ID vorhanden
    if (mysqli_num_rows($selcte_profil_info) != 0) {
        //Datenbankwerte aufbereiten
        $user_data = mysqli_fetch_assoc($selcte_profil_info);
        //Profildaten auslesen
        $selcte_user_info = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$user_data['administraedFrom']}");
        $name = $user_data['profileName'];
        //Denn Profildetaislstring auteilen, um diesen getrennt auszugeben
        $profileInfo = str_replace("-_-_-_:-_:->|-#*##", "", $user_data['profilInfos']);
        //Ist man befreundet
        $homeid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE administraedFrom = {$_SESSION['userid']} AND type = 1");
        $homeid1 = mysqli_fetch_assoc($homeid);
        if ($user_data['type'] == 1) {

            $paopr = "<b>&Uuml;ber mich</b>";
            $type1 = "1";

            if ($homeid1['id'] != $p) {
                $is_friendship = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE (firstid = {$_SESSION['userid']} OR secondid = {$_SESSION['userid']}) AND (firstid = {$user_data['administraedFrom']} OR secondid = {$user_data['administraedFrom']})");
                if (mysqli_num_rows($is_friendship) != 0) {
                    //Abfrage nach der Freundschaft
                    $is_friendship = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE (firstid = {$_SESSION['userid']} OR secondid = {$_SESSION['userid']}) AND (firstid = {$user_data['administraedFrom']} OR secondid = {$user_data['administraedFrom']})");
                    //Man ist befreundet
                    if (mysqli_num_rows($is_friendship) != 0) {
                        $isfriend = mysqli_fetch_assoc($is_friendship);
                        //Ist Freundschaft angenommen
                        if ($isfriend['confired'] == 1) {
                            $frindlink = '<a href="#">Ist schon dein Kontakt</a>';
                            $selcte_user_info1 = mysqli_fetch_assoc($selcte_user_info);
                            $chatlink = '<div class="panel panel-default"><div class="panel-heading"><a href="chat.php?p=' . $user_data['administraedFrom'] . '">Mit ' . $selcte_user_info1['prename'] . " " . $selcte_user_info1['lastname'] . ' chatten</a></div></div>';
                        } else {
                            $frindlink = '<a href="#">Kontaktanfrage versendet</a>';
                        }
                    }
                } else {
                    $adminid = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  profile WHERE id = {$p}");
                    $adminid1 = mysqli_fetch_assoc($adminid);
                    $frindlink = '<a href="friend.php?p=' . $adminid1['administraedFrom'] . '">In Kontaktliste aufnehmen</a>';
                }
            } else {
                $frindlink = "Du befindest dich auf deiner Seite";
            }
        } elseif ($user_data['type'] == 2) {
            $paopr = "<b>&Uuml;ber diese Seite:</b>";
            //Abfrage ob ein die Seite gefaellt
            $is_like = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  likes WHERE userID = {$_SESSION['userid']} AND pageID = {$p}");
            //Wie vielen gefaellt diese Seite
            $n_like1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  likes WHERE pageID = {$p}");
            $n_like = mysqli_num_rows($n_like1);
            //Gefaellt einen
            if (mysqli_num_rows($is_like) != 0) {
                if ($n_like > 1) {
                    $n_like = $n_like - 1;
                    $frindlink = 'Du + ' . $n_like . ' m&ouml;gen diese Seite';
                } elseif ($n_like == 1) {
                    $frindlink = 'Du magst diese Seite';
                }

            }
            //Gefaellt einen nicht
            else {
                if ($n_like > 1) {
                    $frindlink = '<a href="like.php?p=' . $p . '">Mag ich</a> (' . $n_like . ' m&ouml;gen das schon)';
                } elseif ($n_like == 0) {
                    $frindlink = '<a href="like.php?p=' . $p . '">Mag ich</a>';
                } elseif ($n_like == 1) {
                    $frindlink = '<a href="like.php?p=' . $p . '">Mag ich</a> (Einer mag das schon)';
                }
            }
        } else {
            $frindlink = 'Fehler: <b><br>FehlerId = 222 <br> Profil nicht vorhanden<br><a href="serach.php">Profil Suchen</a> <br></b>';
        }

    }
}
//Guckt, ob Freundschaftsanfragen vorhanden sind
$select_friedship_requersts = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  friendship WHERE secondid = {$_SESSION['userid']} AND confired = 0");
$open_friendship_request = mysqli_num_rows($select_friedship_requersts);
//Gibt einen Link aus,  falls Anfragen vorhanden sind
if ($open_friendship_request > 0) {
    $friendship_request = '<a href="requerst_anwser.php">' . $open_friendship_request . ' Kontaktanfrage(n)</a>';
}

//Besuch in Datenbank notieren
$uid1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_SESSION['userid']);
$postOnID1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['p']);
//Zeitzone festlegene
date_default_timezone_set("Europe/Berlin");
//Datum und Zeit abfragen
$date1 = date("Y-m-d H:i:s");
$insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO visit VALUES('','{$uid1}','{$postOnID1}','{$date1}')");

//Gruppenaufnahme
$loadantraege = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `locked` WHERE `pageId` = {$profileID1} AND ok = 0");
if (mysqli_num_rows($loadantraege) != 0) {
    $amembers = "";
    while ($antragsnehmer = mysqli_fetch_assoc($loadantraege)) {
        $antragsnehmer1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$antragsnehmer['member']}");
        $antragsnehmer1 = mysqli_fetch_assoc($antragsnehmer1);
        $amembers = $amembers . " " . $antragsnehmer1['prename'] . " " . $antragsnehmer1['lastname'] . "<br><a href='member_accept.php?u=" . $antragsnehmer['member'] . "&p=" . $profileID1 . "'>Annehmen</a><br><br>";
    }
    $annehmen = '  <div class="panel panel-default"><div class="panel-heading"><b>Aufnahmeantrag</b></div><div class="panel-body">' . $amembers . '</div></div>';
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

    <title>Floos - <?php echo $name ?></title>
    <meta http-equiv="expires" content="0">
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
            <div class="col-md-2">
                <div class="panel panel-default hidden-xs hidden-sm">
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
            <div class="col-md-10" style="padding-left:5; background-color:#e9e9e9;">
                <div class="col-md-12">
                    <h2><?php
$ver = '<a href="#" data-toggle="modal" data-target="#myModal" ><span class="glyphicon glyphicon-ok-circle" style="margin-left:10px;font-size: 0.5em;"></span></a>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Verifizierung</h4>
		</div>
		<div class="modal-body">
		Dieser Nutzer ist Verifiziert.<br>Das heist er hat keine Fake E-Mail Adresse.
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
	</div>
</div>';
$ver2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM ver WHERE userId = " . $selcte_user_info1['id']);
$ver2 = mysqli_fetch_assoc($ver2);
if ($ver2['ver'] == 1) {
    $ver1 = $ver;
}
echo $name . $ver1;
?></h2>
                    <form action="profile.php?p=<?php echo $p ?>" method="post">
                        <input class="form-control" type="text" value="An die Flooswall fleesen" name="pinnwand"
                            style="width:100%;" onFocus="if(this.value == 'An die Flooswall fleesen') this.value = ''"
                            onBlur="if(this.value == '') this.value = 'An die Flooswall fleesen'" />
                        <input type="hidden" name="profileID" value="<?php echo $p ?>" />
                    </form>
                </div>
                <div class="col-md-6 hidden-lg hidden-md">
                    <?php
echo $annehmen;
if ($read_ok == "ok") {
    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profileimages` WHERE 	userid = " . $_GET['p']);
    if (mysqli_num_rows($result) > 0) {
        $result = mysqli_fetch_assoc($result);
        echo "<div class='panel panel-default'><div class='panel-body'><img src='bilder/" . $_GET['p'] . "." . $result['imgType'] . " ' style='width:100%; height:auto;'></div></div>";
    }
}

?>
                    <div class='panel panel-default'>
                        <?php
if ($read_ok == "ok") {
    echo "<div class='panel-heading'>" . $paopr;
    //Holt sich Werte des Aktuellen Nutzers
    $selectIsUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND id = {$p}");
    //Guckt, ob es der Richtige Nutzer ist, der Daten abfragt
    //Wenn ja, darf er die Werte bearbeiten
    if (mysqli_num_rows($selectIsUserProfile) > 0) {
        echo "&nbsp;<a>[</a><a href='edit-profile.php?p={$_GET['p']}'>Bearbeiten</a><a>]</a>";
    }
    echo "</div><div class='panel-body'>" . $profileInfo . "</div>";
}
?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if ($read_ok == "ok") {echo $frindlink;}?>
                        </div>
                    </div>
                    <?php
if ($read_ok == "ok") {
    echo $chatlink;
    if ($type1 == "1") {
        echo '<div class="panel panel-default"><div class="panel-heading"><b>Gemeinsame Kontakte:</b></div>';
        echo '<div class="panel-body">';
        $a = "(0";
        $selectMyFrinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE firstid = {$_SESSION['userid']} AND confired = 1");
        while ($selectMyFrinds1 = mysqli_fetch_assoc($selectMyFrinds)) {
            $a = $a . ", " . $selectMyFrinds1['secondid'];
        }
        $selectMyFrinds2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE secondid = {$_SESSION['userid']} AND confired = 1");
        while ($selectMyFrinds3 = mysqli_fetch_assoc($selectMyFrinds2)) {
            $a = $a . ", " . $selectMyFrinds3['firstid'];
        }
        $a = $a . ")";
        $selectUserFrinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE ( firstid IN " . $a . " AND secondid = " . $selcte_user_info1['id'] . " ) AND confired = 1");
        while ($selectUserFrinds1 = mysqli_fetch_assoc($selectUserFrinds)) {
            $username = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `user` WHERE id = " . $selectUserFrinds1['firstid']);
            $username1 = mysqli_fetch_assoc($username);
            $userlink3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$selectUserFrinds1['firstid']} AND type = 1 ");
            $userlink4 = mysqli_fetch_assoc($userlink3);
            echo "<a href='profile.php?p=" . $userlink4['id'] . "'>" . $username1['prename'] . " " . $username1['lastname'] . "</a><br>";
        }
        $selectUserFrinds6 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE ( secondid IN " . $a . " AND firstid = " . $selcte_user_info1['id'] . " ) AND confired = 1");
        while ($selectUserFrinds5 = mysqli_fetch_assoc($selectUserFrinds6)) {
            $username4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `user` WHERE id = " . $selectUserFrinds5['secondid']);
            $username6 = mysqli_fetch_assoc($username4);
            $userlink1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$selectUserFrinds5['secondid']} AND type = 1 ");
            $userlink2 = mysqli_fetch_assoc($userlink1);
            echo "<a href='profile.php?p=" . $userlink2['id'] . "'>" . $username6['prename'] . " " . $username6['lastname'] . "</a><br>";
        }
        if (mysqli_num_rows($selectUserFrinds) == 0 && mysqli_num_rows($selectUserFrinds6) == 0) {
            echo "Es konnten keine &Uuml;bereinstimmungen gefunden werden";
        }
        echo "</div></div>";
    }
}
?>
                </div>
                <div class="col-md-6">
                    <div class="hidden-lg hidden-md">
                        <div class='panel panel-default'>
                            <div class='panel-heading'><b>Fleeses</b></div>
                        </div>
                    </div>
                    <?php
//Pinwandausgabe
if ($read_ok == "ok") {
    $selctPWData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM  pinnwand WHERE postOnUserID = {$p} ORDER BY poston DESC");
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
            $id1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $homeid2['id']);
            $ansers2 = $ansers2 . "<a href='profile.php?p=" . $id1 . "'>" . $answerID1['prename'] . " " . $answerID1['lastname'] . ":</a><br>" . $answers['text'] . "<br>";
        }
        if (mysqli_num_rows($answers1) > 0) {
            $ansers2 = $ansers2 . "</div>";
        }
        $id2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $homeid1['id']);
        if ($user_data['administraedFrom'] == $_SESSION['userid']) {

            $admin = "<li><a href='delflees.php?f=" . $pwData['id'] . "'>
		    							L&ouml;schen
		    							</a></li>";

        }
        echo "<div class='panel panel-default'><div class='panel-heading'><a name='" . $pwData['id'] . "' href='profile.php?p=" . $id2 . "'>" . $PostUserName['prename'] . " " . $PostUserName['lastname'] . "</a>
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
		    							" . $admin . "
  									</ul>
								</div>
		    					</div>
		    					</div>
		    					<div class='panel-body'>";
        echo $pwData['pwcontent'] . "<br><br><font size='1'>" . $date2 . "</font>" . $ansers2 . "</div></div>";
    }
} else {
    echo '<div class="panel-default panel">
									<div class="panel-heading">
										<b>Geschlossene Gruppe</b>
									</div>
									<div class="panel-body">
										<a href="member.php?p=' . $profileID1 . '">Mitglied werden</a>
									</div>
								</div>';

}
?>
                </div>
                <div class="col-md-6 hidden-xs hidden-sm">
                    <?php
echo $annehmen;
if ($read_ok == "ok") {
    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `profileimages` WHERE 	userid = " . $_GET['p']);
    if (mysqli_num_rows($result) > 0) {
        $result = mysqli_fetch_assoc($result);
        echo "<div class='panel panel-default'><div class='panel-body'><img src='bilder/" . $_GET['p'] . "." . $result['imgType'] . " ' style='width:100%; height:auto;'></div></div>";
    }
}

?>
                    <div class='panel panel-default'>
                        <?php if ($read_ok == "ok") {
    echo "<div class='panel-heading'>" . $paopr;
    //Holt sich Werte des Aktuellen Nutzers
    $selectIsUserProfile = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$_SESSION['userid']} AND id = {$p}");
    //Guckt, ob es der Richtige Nutzer ist, der Daten abfragt
    //Wenn ja, darf er die Werte bearbeiten
    if (mysqli_num_rows($selectIsUserProfile) > 0) {
        echo "&nbsp;<a>[</a><a href='edit-profile.php?p={$_GET['p']}'>Bearbeiten</a><a>]</a>";
    }
    echo "</div><div class='panel-body'>" . $profileInfo . "</div>";}
?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if ($read_ok == "ok") {echo $frindlink;}?>
                        </div>
                    </div>
                    <?php
if ($read_ok == "ok") {
    echo $chatlink;
    if ($type1 == "1") {
        echo '<div class="panel panel-default"><div class="panel-heading"><b>Gemeinsame Kontakte:</b></div>';
        echo '<div class="panel-body">';
        $a = "(0";
        $selectMyFrinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE firstid = {$_SESSION['userid']} AND confired = 1");
        while ($selectMyFrinds1 = mysqli_fetch_assoc($selectMyFrinds)) {
            $a = $a . ", " . $selectMyFrinds1['secondid'];
        }
        $selectMyFrinds2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE secondid = {$_SESSION['userid']} AND confired = 1");
        while ($selectMyFrinds3 = mysqli_fetch_assoc($selectMyFrinds2)) {
            $a = $a . ", " . $selectMyFrinds3['firstid'];
        }
        $a = $a . ")";
        $selectUserFrinds = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE ( firstid IN " . $a . " AND secondid = " . $selcte_user_info1['id'] . " ) AND confired = 1");
        while ($selectUserFrinds1 = mysqli_fetch_assoc($selectUserFrinds)) {
            $username = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `user` WHERE id = " . $selectUserFrinds1['firstid']);
            $username1 = mysqli_fetch_assoc($username);
            $userlink3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$selectUserFrinds1['firstid']} AND type = 1 ");
            $userlink4 = mysqli_fetch_assoc($userlink3);
            echo "<a href='profile.php?p=" . $userlink4['id'] . "'>" . $username1['prename'] . " " . $username1['lastname'] . "</a><br>";
        }
        $selectUserFrinds6 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `friendship` WHERE ( secondid IN " . $a . " AND firstid = " . $selcte_user_info1['id'] . " ) AND confired = 1");
        while ($selectUserFrinds5 = mysqli_fetch_assoc($selectUserFrinds6)) {
            $username4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `user` WHERE id = " . $selectUserFrinds5['secondid']);
            $username6 = mysqli_fetch_assoc($username4);
            $userlink1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM profile WHERE administraedFrom = {$selectUserFrinds5['secondid']} AND type = 1 ");
            $userlink2 = mysqli_fetch_assoc($userlink1);
            echo "<a href='profile.php?p=" . $userlink2['id'] . "'>" . $username6['prename'] . " " . $username6['lastname'] . "</a><br>";
        }
        if (mysqli_num_rows($selectUserFrinds) == 0 && mysqli_num_rows($selectUserFrinds6) == 0) {
            echo "Es konnten keine &Uuml;bereinstimmungen gefunden werden";
        }
        echo "</div></div>";
    }
    echo '<div class="panel panel-default">
												<div class="panel-heading">
													<b>Widget erstellen</b>
												</div>
												<div class="panel-body">
													<!-- Button trigger modal -->
													<button data-target="#myModal" data-toggle="modal" class="btn btn-default">
													  	Widget erstellen
													</button>

													<!-- Modal -->
													<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
													 	<div class="modal-dialog">
													    	<div class="modal-content">
													      		<div class="modal-header">
													        		<button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
													        		<h4 id="myModalLabel" class="modal-title">Widget</h4>
													      		</div>
													     		<div class="modal-body"><p>Den folgenden Html Code einfach in die eigene Website oder den eigenen Blog einf&uuml;gen und die Fleeses dieser Seite auf der eigenen Seite anzeigen.<br></p>
													     		  	' . htmlspecialchars('<iframe frameborder="0" src="http://floos.flova.de/wi.php?p=' . $_GET['p'] . '" width="500px" height="600px"></iframe>') . ' <p><br><br>Vorschau:</p><br><iframe frameborder="0" src="http://floos.flova.de/wi.php?p=' . $_GET['p'] . '" width="500px" height="600px"></iframe>
													     		</div>
													     		<div class="modal-footer">
													        		<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
													      		</div>
													    	</div>
													  	</div>
													</div>
												</div>
											</div>';
}
?>
                </div>
                <p style="clear:both"></p>
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
