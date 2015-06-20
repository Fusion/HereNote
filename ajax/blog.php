<?php

if(!defined('RUNNING')) exit(-1);

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
case 'unpublish':
case 'publish':
    if(empty($_POST['slug'])) {
        $success = false;
        $data = array('error' => 'Missing slug');
    }
    else {
        $slug = $db->escapeString($_POST['slug']);
        $new_status = ($_POST['action'] == 'unpublish' ? 1 : 2);
        $db->exec("UPDATE mae_posts SET status=" . $new_status . " WHERE section=1 AND slug='" . $slug ."'");
        $success = true;
        $data = array();
    }
break;
default:
    $success = false;
    $data = array();
}
