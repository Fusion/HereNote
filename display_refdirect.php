<?php
// ---------------------------------------------------------------------------
// Increment a counter upon returning a resource
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$obj = $db->escapeString($_GET['refdirect']);
$row = $db->querySingle("SELECT * FROM mae_refdirect_counter WHERE obj='" . $obj . "'", true);
if(empty($row)) {
    die("Rewrite Ooops. 404 and all that :(");
}
$downloads = intval($row['downloads']) + 1;
$db->exec("UPDATE mae_refdirect_counter SET downloads=" . $downloads . " WHERE obj='" . $obj . "'");

header("Location: " . $row['newurl']);
exit(0);
?>
