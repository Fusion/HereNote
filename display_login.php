<?php
// ---------------------------------------------------------------------------
// Log in
// ---------------------------------------------------------------------------

$loggedIn = false;

if(!empty($_POST['LogIn'])) {
    require 'config.php';
    require 'util.php';

    $stmt = $db->prepare("SELECT * from mae_users WHERE login=:login");
    $stmt->bindValue(':login', $_POST['c_username']);
    $res = $stmt->execute();
    $row = $res->fetchArray();
    if(!strcmp($row['password'], Util::get_password_with_salt_hash($_POST['c_password'], $row['salt']))) {
        $loggedIn = true;
        $user->auth($row['login'], $row['realname'], $row['can_edit']);
        $_SESSION['user'] = $user;
    }
}
if(!$loggedIn) {
    $template->view('login');
}
