<?php
require_once('config.php');
$q = strtolower($_GET["q"]);
if (!$q) return;
 
$sql = "SELECT * FROM profile WHERE profileName LIKE '%". $q . "%'";
$rsd = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
while($rs = mysqli_fetch_array($rsd)) {
    $cname = $rs['profileName'];
    echo "$cname\n";
}
?>