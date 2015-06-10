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

function ajax($db, $template, $config, $user) {
    require 'ajax.php';
}

function display_header($db, $template, $config, $user) {
    require 'display_header.php';
}

function display_footer($db, $template, $config, $user) {
    require 'display_footer.php';
}

function display_main($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_main.php';
    display_footer($db, $template, $config, $user);
}

function display_pages($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_pages.php';
    display_footer($db, $template, $config, $user);
}

function display_blog($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_blog.php';
    display_footer($db, $template, $config, $user);
}

function display_blog_edit($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_blog_edit.php';
    display_footer($db, $template, $config, $user);
}

function display_page($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_page.php';
    display_footer($db, $template, $config, $user);
}

function display_page_edit($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_page_edit.php';
    display_footer($db, $template, $config, $user);
}

// To count how many times an asset was downloaded
function display_refdirect($db, $template, $config, $user) {
    require 'display_refdirect.php';
}

// Rewrite an asset's path to mask actual theme path
function display_asset($db, $template, $config, $user) {
    require 'display_asset.php';
}

// Rewrite link based on db entry: migrated blog entries
// do not lose their precious permalink.
function display_rewrite($db, $template, $config, $user) {
    require 'display_rewrite.php';
}

// Poor man's dangerous full text search
function display_search($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_search.php';
    display_footer($db, $template, $config, $user);
}

// Features under development
function display_test($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_test.php';
    display_footer($db, $template, $config, $user);
}

// This little backdoor has to disappear ASAP
function attempt_auth($db, $template, $config, $user) {
    if($_GET['auth'] == $config['admin_key']) {
        if($user->is_auth) {
            $user->reset();
            unset($_SESSION['user']);
        }
        else {
            $user->auth('chris');
            $_SESSION['user'] = $user;
        }
    }
}

function update_setting($db, $template, $config, $user) {
    $action = $_GET['setting'];
    switch($action) {
        case 'display':
            if(!empty($_GET['show'])) {
                switch($_GET['show']) {
                    case 'unpublished':
                        $user->set('display', 'unpublished', true);
                    break;
                    case 'published':
                        $user->delete('display', 'unpublished');
                    break;
                }
            }
        break;
    } 
}

// ---------------------------------------------------------------------------
// Session Management
// ---------------------------------------------------------------------------

require 'user.php';
session_start();
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
else {
    $user = new User();
}

// ---------------------------------------------------------------------------
// Routes + Templating
// ---------------------------------------------------------------------------

require 'display_template.php';
$template = new Template($config['theme']);
$template->set_root($config['site_root']);
$template->set_name($config['site_name']);
$template->set_desc($config['site_desc']);

if(!empty($_GET['blog'])) {
    display_blog($db, $template, $config, $user);
}
else if(!empty($_GET['blog_edit'])) {
    display_blog_edit($db, $template, $config, $user);
}
else if(!empty($_GET['page'])) {
    display_page($db, $template, $config, $user);
}
else if(!empty($_GET['page_edit'])) {
    display_page_edit($db, $template, $config, $user);
}
else if(!empty($_GET['refdirect'])) {
    display_refdirect($db, $template, $config, $user);
}
else if(!empty($_GET['asset'])) {
    display_asset($db, $template, $config, $user);
}
else if(!empty($_GET['rewrite'])) {
    display_rewrite($db, $template, $config, $user);
}
else if(!empty($_GET['search'])) {
    display_search($db, $template, $config, $user);
}
else if(!empty($_GET['test'])) {
    display_test($db, $template, $config, $user);
}
else if(!empty($_GET['ajax'])) {
    ajax($db, $template, $config, $user);
}
else if(!empty($_GET['pages'])) {
    display_pages($db, $template, $config, $user);
}
else {
    if(!empty($_GET['auth'])) {
        attempt_auth($db, $template, $config, $user);
    }
    if(!empty($_GET['setting'])) {
        update_setting($db, $template, $config, $user);
    }
    display_main($db, $template, $config, $user);
}

$template->set_user($user);
$template->render();
?>
