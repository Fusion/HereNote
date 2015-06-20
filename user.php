<?php
/*
 * This is an extremely temporary implementation -- it is bad.
 * Everything here is hardcoded.
 */

if(!defined('RUNNING')) exit(-1);

class User {

    function __construct() {
        $this->reset();
    }

    function auth($login, $realname, $can_edit) {
        $this->user_name = $login;
        $this->real_name = $realname;
        $this->is_auth  = true;
        $this->can_edit = $can_edit;
    }

    function reset() {
        $this->user_name = false;
        $this->real_name = 'Guest';
        $this->is_auth  = false;
        $this->can_edit = false;
    }

    /* Session variables */

    function set($space, $name, $value) {
        if(!isset($_SESSION[$space]))
            $_SESSION[$space] = array();

        $_SESSION[$space][$name] = $value;
    }

    function delete($space, $name) {
        if(!isset($_SESSION[$space]) || !isset($_SESSION[$space][$name]))
            return;

        unset($_SESSION[$space][$name]);
    }

    function get($space, $name) {
        if(!isset($_SESSION[$space]) || !isset($_SESSION[$space][$name]))
            return false;

        return $_SESSION[$space][$name];
    }

    function get_and_delete($space, $name) {
        if(!isset($_SESSION[$space]) || !isset($_SESSION[$space][$name]))
            return false;
        $notification = $this->get($space, $name);
        $this->delete($space, $name);
        return $notification;
    }

    /* notify */

    function set_notification($title, $msg, $type='success') {
        $this->set('notifications', 'note', array(
            'type' => $type,
            'title' => $title,
            'msg' => $msg
        ));
    }

    function get_notification() {
        return $this->get_and_delete('notifications', 'note');
    }
}
?>
