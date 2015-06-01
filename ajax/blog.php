<?php
switch($_POST['action']) {
case 'choose_source_type':
    if(empty($_POST['slug'])) {
        $success = false;
        $data = array('error' => 'Missing slug');
    }
    else {
        $success = true;
        $data = array();
    }
break;
default:
    $success = false;
    $data = array();
}
