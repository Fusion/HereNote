<?php
// ---------------------------------------------------------------------------
// Preserve imported permanlinks
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$obj = $db->escapeString($_GET['rewrite']);
$row = $db->querySingle("SELECT new_path FROM mae_redirect WHERE old_path='/" . $obj . "'", true);
if(empty($row)) {
    http_error(404, 'Path equivalence not found');
}

header("Location: " . $row['new_path']);
exit(0);
?>
