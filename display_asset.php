<?php
// ---------------------------------------------------------------------------
// Rewrite an asset's path to mask actual theme path
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$protocol = $config['proto'];

$redirect = 'Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $template->path('assets/' . $_GET['asset']);
header($redirect, true, ($config['mode'] == 'dev' ? 302 : 301));
// Note: modern browsers should understand simply starting our url with '//'
exit(0);
?>
