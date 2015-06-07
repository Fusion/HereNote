<?php
// ---------------------------------------------------------------------------
// Preserve imported permanlinks
// ---------------------------------------------------------------------------

$obj = $db->escapeString($_GET['rewrite']);
$row = $db->querySingle("SELECT new_path FROM mae_redirect WHERE old_path='/" . $obj . "'", true);
if(empty($row)) {
    die("Location Ooops. 404 and all that :(\n($obj)");
}

header("Location: " . $row['new_path']);
exit(0);
?>
