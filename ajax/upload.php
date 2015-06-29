<?php

if(!defined('RUNNING')) exit(-1);

function upload_actual_copy($src_file, $raw_file_name, $error) {
    if(UPLOAD_ERR_OK != $error) {
        return array('success' => false, 'error' => 'Upload failed', 'code' => 1);
    }
    $dst_file = uniqid() . '__' . preg_replace(
            '/[^a-zA-Z0-9-_\.]/',
            '',
            $raw_file_name);
    $res = move_uploaded_file($src_file, './data/' . $dst_file);
    if(!$res) {
        return array('success' => false, 'error' => 'Copy failed', 'code' => 2);
    }
    return array('success' => true, 'error' => '', 'file_name' => $dst_file, 'code' => 0);
}

$success = true;
$data = array();
if(is_array($_FILES['file']['error'])) {
    foreach ($_FILES['file']['error'] as $key => $error) {
        $raw_file_name = $_FILES['file']['name'][$key];
        $data_row = upload_actual_copy($_FILES['file']['tmp_name'][$key], $raw_file_name, $error);
        if(!$data_row['success'])
            $success = false;
        $data[$raw_file_name] = $data_row;
    }
}
else {
    $raw_file_name = $_FILES['file']['name'];
    $data_row = upload_actual_copy($_FILES['file']['tmp_name'], $raw_file_name, $_FILES['file']['error']);
    if(!$data_row['success'])
        $success = false;
    $data[$raw_file_name] = $data_row;
}
