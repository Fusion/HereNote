<?php
// ---------------------------------------------------------------------------
// Log in
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$loggedIn = false;

if(!empty($_POST['LogIn'])) {
    require 'config.php';
    require 'util.php';

    $stmt = $db->prepare("SELECT * from mae_users WHERE login=:login");
    $stmt->bindValue(':login', $_POST['c_username']);
    $res = $stmt->execute();
    $row = $res->fetchArray();
    if($row !== false && !strcmp($row['password'], Util::get_password_with_salt_hash($_POST['c_password'], $row['salt']))) {
        $loggedIn = true;
        $user->auth($row['login'], $row['realname'], $row['can_edit']);
        $_SESSION['user'] = $user;
        $user->set_notification('Logged in', "You are now browsing as {$row['realname']}");
    }
}
if(!$loggedIn) {
    $template->view('login');
}
