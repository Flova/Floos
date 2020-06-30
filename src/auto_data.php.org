<?php
require_once('config.php');
$q = strtolower($_GET["q"]);
if (!$q) return;
 
$sql = "SELECT * FROM profile WHERE profileName LIKE '%". $q . "%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
    $cname = $rs['profileName'];
    echo "$cname\n";
}
?>