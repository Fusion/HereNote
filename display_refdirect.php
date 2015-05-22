<?php
    $obj = $db->escapeString($_GET['refdirect']);
    $row = $db->querySingle("SELECT * FROM refdirect_counter WHERE obj='" . $obj . "'", true);
    if(empty($row)) {
        die("Ooops. 404 and all that :(");
    }
    $downloads = intval($row['downloads']) + 1;
    $db->exec("UPDATE refdirect_counter SET downloads=" . $downloads . " WHERE obj='" . $obj . "'");

    header("Location: " . $row['newurl']);
    exit(0);
?>
