<?php
class Util {
    // Do not use this function in a cyptographic-minded app, as we are using urandom
    // which will try to make up for any lack of actual entropy
    static function get_onetime_salt($verbose = false) {
        if(function_exists('mcrypt_create_iv')) {
            if($verbose) echo "Generating onetime salt using mcrypt_create_iv\n";
            $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        }
        else {
            if($verbose) echo "Generating onetime salt using /dev/urandom directly\n";
            $salt = file_get_contents('/dev/urandom', false, null, 0, 22);
        }
        return $salt;
    }

    // Salt is used, even if using password_hash(), in the hope that when upgrading
    // PHP old crypt() passwords will remain usable.
    static function get_password_with_salt_hash($password, $salt, $verbose = false) {
        if(function_exists('password_hash')) {
            if($verbose) echo "Hashing password and salt using password_hash\n";
            $hash = password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt));
        }
        else {
            if($verbose) echo "Hashing password and salt using crypt\n";
            $hash = crypt($password, $salt);
        }
        return $hash;
    }
}
?>
