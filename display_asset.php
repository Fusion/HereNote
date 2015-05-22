<?php
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'])=='ON') {
            $protocol='https';
    }
    else {
        $protocol = 'http';
    }
    $redirect = 'Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $template->path('assets/' . $_GET['asset']);
    header($redirect, true, 302);
    // Note: modern browsers should understand simply starting our url with '//'
    exit(0);
?>
