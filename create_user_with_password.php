<?php

require 'config.php';
require 'util.php';

$myname = 'create_user_with_password.php';
?>
<h1 style='color:red'>This is a very dangerous script.</h1>
<p> </p>
<?php
$created = false;
if(!empty($_POST['Create'])) {
    $db = new SQLite3($config['db_file']);
    if(empty($_POST['c_username']) || empty($_POST['c_password']) || empty($_POST['c_realname'])) {
        echo '<div><em><strong>Please provide username, password and real name. Try again:</strong></em></div>';
    }
    else {
        $salt = Util::get_onetime_salt();
        $password = Util::get_password_with_salt_hash($_POST['c_password'], $salt);
        $stmt = $db->prepare("SELECT login from mae_users WHERE login=:login");
        $stmt->bindValue(':login', $_POST['c_username']);
        $res = $stmt->execute();
        $row = $res->fetchArray();
        if($row) {
            $stmt = $db->prepare("UPDATE mae_users SET password=:password,salt=:salt,realname=:realname WHERE login=:login");
            $stmt->bindValue(':login', $_POST['c_username']);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':salt', $salt);
            $stmt->bindValue(':realname', $_POST['c_realname']);
            $stmt->execute();
        }
        else {
            $stmt = $db->prepare("INSERT INTO mae_users(login,password,salt,realname,can_edit) VALUES(:login,:passsword,:salt,:realname,1)");
            $stmt->bindValue(':login', $_POST['c_username']);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':salt', $salt);
            $stmt->bindValue(':realname', $_POST['c_realname']);
            $stmt->execute();
        }
        $created = true;
    }
}
if($created) {
?>
This user was created/updated. Now, please delete '<?=$myname?>'!
<?php
}
else {
?>
<form method="post" action="<?=$myname?>">
<label for="c_username">Login</label>
<input type="text" name="c_username" />
<label for="c_password">Password</label>
<input type="text" name="c_password" />
<label for="c_realname">Real Name</label>
<input type="text" name="c_realname" />
<input type="submit" name="Create" />
</form>
<p> </p>
<h2>Delete '<?=$myname?>' after creating your user account!</h2>
<?php
}
