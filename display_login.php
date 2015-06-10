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
    $loggedIn = !strcmp($row['password'], Util::get_password_with_salt_hash($_POST['c_password'], $row['salt']));
}
if(!$loggedIn) {
    $template->view('login');
}
