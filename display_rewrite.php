<?php
// ---------------------------------------------------------------------------
// Preserve imported permanlinks
// ---------------------------------------------------------------------------

$obj = $db->escapeString($_GET['rewrite']);
$row = $db->querySingle("SELECT new_path FROM django_redirect WHERE old_path='/" . $obj . "'", true);
if(empty($row)) {
    die("Ooops. 404 and all that :(");
}

header("Location: " . $row['new_path']);
exit(0);
?>
