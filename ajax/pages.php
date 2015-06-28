<?php

if(!defined('RUNNING')) exit(-1);

switch($_POST['action']) {
case 'get_pages':
    $success = true;
    $data = array();
break;
default:
    $success = false;
    $data = array();
}
