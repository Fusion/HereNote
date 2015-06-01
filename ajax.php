<?php

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die("No. Ajax headers not present.");
}

if(empty($_POST['route']) || empty($_POST['action'])) {
    // pass
}
else {
    switch($_POST['route']) {
    case 'blog':
        require 'ajax/blog.php';
        break;
    default:
        $success = false;
        $data = array();
    }
}

$response = array('success' => $success, 'data' => $data);
