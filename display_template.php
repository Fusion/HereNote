<?php
// ---------------------------------------------------------------------------
// This class handles very basic template management
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

class Template {
    function __construct($theme = 'bare') {
        $this->site_name = '';
        $this->site_desc = '';
        $this->site_root = '/';
        $this->theme = $theme;
        $this->view = false;
        $this->header = false;
        $this->header_extra = '';
        $this->footer = false;
        $this->footer_extra = '';
        $this->user = false;
        $this->notification = false;
        $this->vars = array();
    }

    function __destruct() {
        unset($this->vars);
    }

    function view($view) {
        $this->view = $view;
    }

    function header($header) {
        $this->header = $header;
    }

    function header_append($header_extra) {
        $this->header_extra .= $header_extra . "\n";
    }

    function footer($footer) {
        $this->footer = $footer;
    }

    function footer_append($footer_extra) {
        $this->footer_extra .= $footer_extra . "\n";
    }

    function set_name($name) {
        $this->site_name = $name;
    }

    function set_desc($desc) {
        $this->site_desc = $desc;
    }

    function set_notification($notification) {
        $this->notification = $notification;
    }

    function set_root($root) {
        $this->site_root = $root;
    }

    function set_user($user_obj) {
        $this->user = $user_obj;
    }

    function set($name, $value) {
        $this->vars[$name] = $value;
    }

    function get($name) {
        if(isset($this->vars[$name])) {
            return $this->vars[$name];
        } 
        return false;
    }

    function path($asset = '') {
        return 'themes/' . $this->theme . '/' . $asset;
    }

    function fragment($fragment_name) {
        require $this->path($fragment_name . '.php');
    }

    function render() {
        if($this->view === false) {
            return;
        }

        if($this->header !== false) {
            require $this->path($this->header . '.php');
        }

        if(is_callable($this->view)) {
            $this->view($this);
        }
        else {
            require $this->path($this->view . '.php');
        }

        if($this->footer !== false) {
            require $this->path($this->footer . '.php');
        }
    }
}
?>
