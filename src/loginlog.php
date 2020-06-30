<?php
//Mit Datenbank verbinden
require 'config.php';
//Chatausgabe
$myId = $_SESSION['userid'];
if ($_GET['p'] == 321) {
    $selctuserData = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `loginlog` ORDER BY id DESC LIMIT 0 , 50 ");
    while ($userData = mysqli_fetch_assoc($selctuserData)) {
        $selectsmFrom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM user WHERE id = {$userData['userId']}");
        $smUserName = mysqli_fetch_assoc($selectsmFrom);
        echo "<b>" . $smUserName['prename'] . " " . $smUserName['lastname'] . "</b><br> " . $userData['date'] . "<hr>";
    }
}
