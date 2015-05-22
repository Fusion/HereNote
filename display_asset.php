<?php
// ---------------------------------------------------------------------------
// Rewrite an asset's path to mask actual theme path
// ---------------------------------------------------------------------------

if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'])=='ON') {
        $protocol='https';
}
else {
    $protocol = 'http';
}
$redirect = 'Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $template->path('assets/' . $_GET['asset']);
header($redirect, true, ($config['mode'] == 'dev' ? 302 : 301));
// Note: modern browsers should understand simply starting our url with '//'
exit(0);
?>
