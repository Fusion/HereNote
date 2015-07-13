<?php

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

if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'])=='ON') {
    $config['proto'] = 'https';
}

$allheaders = getallheaders();
if(isset($allheaders['X-Forwarded-Proto']) && $allheaders['X-Forwarded-Proto'] == 'https') {
    $config['site_root'] = str_replace('http://', 'https://', $config['site_root']);
    $config['proto'] = 'https';
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

// Used to sanitize cookies if necessary
function alphanum_only($txt) {
    return preg_replace('/[^\da-z]/i', '', $txt);
}

// Return dynamic version of URL based on current proto
function dynurl($url) {
global $config;

    if($config['proto'] != 'http') {
        if(strncmp($url, $config['site_root'], strlen($config['site_root']))) {
            return str_replace('http://', $config['proto'] . '://', $url);
        }
    }
    return $url;
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

function display_notes($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_notes.php';
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

function display_note($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_note.php';
    display_footer($db, $template, $config, $user);
}

function display_note_edit($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_note_edit.php';
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

// No registration through the web interface (yet)
function display_login($db, $template, $config, $user) {
    require 'display_login.php';
    if($loggedIn)
        return true;
    display_header($db, $template, $config, $user);
    display_footer($db, $template, $config, $user);
    return false;
}

// Features under development
function display_test($db, $template, $config, $user) {
    display_header($db, $template, $config, $user);
    require 'display_test.php';
    display_footer($db, $template, $config, $user);
}

// ---------------------------------------------------------------------------
// A few utilities
// ---------------------------------------------------------------------------

class HttpException extends Exception {}

function http_error($code=404, $msg="Page not found") {
    throw new HttpException($msg, $code);
}

// This little backdoor has to disappear ASAP
// UPDATE: gone!
function attempt_auth($db, $template, $config, $user) {
/* Dead!
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
*/
}

function perform_redirect($new_url) {
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'])=='ON') {
        $protocol='https';
    }
    else {
        $protocol='http';
    }
    $redirect = 'Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . $new_url;
    header($redirect, true);
    exit(0);
}

function update_setting($db, $template, $config, $user) {
    $action = $_GET['setting'];
    switch($action) {
        case 'display':
            if(!empty($_GET['show'])) {
                switch($_GET['show']) {
                    case 'unpublished':
                        $user->set('display', 'unpublished', true);
                        if(strpos($_SERVER['REQUEST_URI'], 'unpublished') !== false)
                            perform_redirect(str_replace('/unpublished', '', $_SERVER['REQUEST_URI']));
                    break;
                    case 'published':
                        $user->delete('display', 'unpublished');
                        if(strpos($_SERVER['REQUEST_URI'], 'published') !== false)
                            perform_redirect(str_replace('/published', '', $_SERVER['REQUEST_URI']));
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
    $_SESSION['user'] = $user;
}

// ---------------------------------------------------------------------------
// Routes + Templating
// ---------------------------------------------------------------------------

require 'display_template.php';
$template = new Template($config['theme']);
$template->set_root($config['site_root']);
$template->set_name($config['site_name']);
$template->set_desc($config['site_desc']);

if(!empty($_GET['setting'])) {
    update_setting($db, $template, $config, $user);
}

try {
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
    else if(!empty($_GET['note'])) {
        display_note($db, $template, $config, $user);
    }
    else if(!empty($_GET['note_edit'])) {
        display_note_edit($db, $template, $config, $user);
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
    else if(!empty($_GET['notes'])) {
        display_notes($db, $template, $config, $user);
    }
    else if(!empty($_GET['login'])) {
        if($_GET['login'] == 'no') {
            unset($_SESSION['user']);
            $user->reset();
            $_SESSION['user'] = $user;
            $user->set_notification('Logged out', "You are now browsing as a guest.");
            display_main($db, $template, $config, $user);
        }
        else {
            if(display_login($db, $template, $config, $user)) {
                display_main($db, $template, $config, $user);
            }
        }
    }
    else {
        if(!empty($_GET['auth'])) {
            attempt_auth($db, $template, $config, $user);
        }
        display_main($db, $template, $config, $user);
    }
}
catch(Exception $ex) {
    if(is_a($ex, 'HttpException')) {
        $template->view('4xx');
        $template->header(false);
        $template->footer(false);
        $template->set('code', $ex->getCode());
        $template->set('message', $ex->getMessage());
    }
    else {
        print "<pre>\n";
        die($ex);
    }
}

$template->set_user($user);
$template->set_notification($user->get_notification());
$template->render();
?>
