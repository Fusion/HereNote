<?php

if(!defined('RUNNING')) exit(-1);

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die("No. Ajax headers not present.");
}

if(empty($_POST['route']) || empty($_POST['action'])) {
    if(!empty($_FILES)) {
        require 'ajax/upload.php';
    }
    else {
    // pass
    }
}
else {
    switch($_POST['route']) {
    case 'blog':
        require 'ajax/blog.php';
        break;
    case 'page':
        require 'ajax/page.php';
        break;
    case 'pages':
        require 'ajax/pages.php';
        break;
    default:
        $success = false;
        $data = array();
    }
}

$response = array('success' => $success, 'data' => $data);
echo json_encode($response);
