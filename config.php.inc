<?php

$config = array(
    // When running in dev mode, some behaviors change. For instance,
    // page redirects are temporary rather than permanent
    'mode' => 'dev',
    'site_root' => '/',

    'site_name' => "The Nexus",
    'site_desc' => "Chris' Den Of Confusion",

    'db_type'   => 'sqlite',
    'db_file'   => '/var/www/data/dev.db',

    'theme'     => 'modern',
    'per_page'  => 12,

    // Sensitive data. If possible, relocate your config file
    // outside your web directory.
    'updaters'   => array(
        'g+'        => array(
            'api_key' => '',
            'user_id' => ''
        ),
        'github'        => array(
            'user_id' => ''
        ),
    ),

    'thirdparty' => array(
        'disqus' => array(
            'shortname' => 'nexuszteo'
        ),
    ),

    'admin_key' => ''
);

if($config['mode'] == 'dev') {
    ini_set("display_errors", "1");
    error_reporting(E_ALL);
}

define ('RUNNING', true);
