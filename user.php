<?php
class User {

    function __construct() {
        $this->reset();
    }

    function auth($user_name) {
        if($user_name == 'chris') {
            $this->user_name = 'chris';
            $this->real_name = 'Chris Ravenscroft';
            $this->is_auth  = true;
            $this->can_edit = true;
        }
    }

    function reset() {
        $this->user_name = false;
        $this->real_name = 'Guest';
        $this->is_auth  = false;
        $this->can_edit = false;
    }

}
?>
