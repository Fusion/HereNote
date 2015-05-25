<?php
error_reporting(E_ALL);

// If possible, please relocate config.php outside your web directory and update
// the following line accordingly.
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

// On demand theme preview
// The cookie is here to propagate that value
// to redirected assets
if(!empty($_COOKIE['xxxtheme'])) {
    $config['theme'] = alphanum_only($_COOKIE['xxxtheme']);
}
else if(!empty($_GET['theme'])) {
    $config['theme'] = alphanum_only($_GET['theme']);
    setcookie('xxxtheme', $config['theme'], time()+60*60);
}

// Return plain english time delta based on (now - $timestamp)
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

function alphanum_only($txt) {
    return preg_replace('/[^\da-z]/i', '', $txt);
}

// ---------------------------------------------------------------------------
// A few delegates, just for cleanliness.
// ---------------------------------------------------------------------------

function display_header($db, $template, $config) {
    require 'display_header.php';
}

function display_footer($db, $template, $config) {
    require 'display_footer.php';
}

function display_main($db, $template, $config) {
    display_header($db, $template, $config);
    require 'display_main.php';
    display_footer($db, $template, $config);
}

function display_blog($db, $template, $config) {
    display_header($db, $template, $config);
    require 'display_blog.php';
    display_footer($db, $template, $config);
}

function display_page($db, $template, $config) {
    display_header($db, $template, $config);
    require 'display_page.php';
    display_footer($db, $template, $config);
}

// To count how many times an asset was downloaded
function display_refdirect($db, $template, $config) {
    require 'display_refdirect.php';
}

// Rewrite an asset's path to mask actual theme path
function display_asset($db, $template, $config) {
    require 'display_asset.php';
}

// Rewrite link based on db entry: migrated blog entries
// do not lose their precious permalink.
function display_rewrite($db, $template, $config) {
    require 'display_rewrite.php';
}

// Poor man's dangerous full text search
function display_search($db, $template, $config) {
    display_header($db, $template, $config);
    require 'display_search.php';
    display_footer($db, $template, $config);
}

// Features under development
function display_test($db, $template, $config) {
    display_header($db, $template, $config);
    require 'display_test.php';
    display_footer($db, $template, $config);
}

// ---------------------------------------------------------------------------
// Routes + Templating
// ---------------------------------------------------------------------------

require 'display_template.php';
$template = new Template($config['theme']);

if(!empty($_GET['blog'])) {
    display_blog($db, $template, $config);
}
else if(!empty($_GET['page'])) {
    display_page($db, $template, $config);
}
else if(!empty($_GET['refdirect'])) {
    display_refdirect($db, $template, $config);
}
else if(!empty($_GET['asset'])) {
    display_asset($db, $template, $config);
}
else if(!empty($_GET['rewrite'])) {
    display_rewrite($db, $template, $config);
}
else if(!empty($_GET['search'])) {
    display_search($db, $template, $config);
}
else if(!empty($_GET['test'])) {
    display_test($db, $template, $config);
}
else {
    display_main($db, $template, $config);
}

$template->render();
?>
