<?php
error_reporting(E_ALL);

require './config.php';

$db = new SQLite3($config['db_file']);

// Debug from command line: php index.php [asset=github.png]
if(!empty($argv)) {
    foreach($argv as $arg) {
        $pair = explode('=', $arg);
        if(count($pair) != 2)
            continue;
        $_GET[$pair[0]] = $pair[1];
    }
    $_SERVER = array(
        'HTTP_HOST' => 'bogus.com'
    );
}

function format_ago($timestamp) {
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();
    $difference     = $now - $timestamp;
    for($i = 0; $difference >= $lengths[$i] && $i < count($lengths)-1; $i++) {
        $prefdifference = $difference % $lengths[$i];
        $difference /= $lengths[$i];
        $subdifference = $prefdifference;
    }
    $difference = floor($difference);
    $txt = "$difference $periods[$i]";
    if($difference != 1) {
        $txt.= "s";
    }
    if($i >= 6 && $subdifference>0) {
        $txt.=" $subdifference {$periods[$i-1]}";
        if($subdifference != 1) {
            $txt.= "s";
        }
    }
    return "$txt ago";
}

function display_header($template) {
    $template->header('header');
}

function display_footer($template) {
    $template->footer('footer');
}

function display_main($db, $template) {
    display_header($template);
    require 'display_main.php';
    display_footer($template);
}

function display_blog($db, $template) {
    display_header($template);
    require 'display_blog.php';
    display_footer($template);
}

function display_page($db, $template) {
    display_header($template);
    require 'display_page.php';
    display_footer($template);
}

function display_refdirect($db, $template) {
    require 'display_refdirect.php';
}

function display_asset($db, $template, $config) {
    require 'display_asset.php';
}

function display_rewrite($db, $template) {
    require 'display_rewrite.php';
}

require 'display_template.php';
$template = new Template($config['theme']);

if(!empty($_GET['blog'])) {
    display_blog($db, $template);
}
else if(!empty($_GET['page'])) {
    display_page($db, $template);
}
else if(!empty($_GET['refdirect'])) {
    display_refdirect($db, $template);
}
else if(!empty($_GET['asset'])) {
    display_asset($db, $template, $config);
}
else if(!empty($_GET['rewrite'])) {
    display_rewrite($db, $template);
}
else {
    display_main($db, $template);
}

$template->render();
?>
