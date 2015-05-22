<?php
$config = array(
    // When running in dev mode, some behaviors change. For instance,
    // page redirects are temporary rather than permanent
    'mode'      => 'dev',

    'db_type'   => 'sqlite',
    'db_file'   => '/var/www/data/dev.db',

    'theme'     => 'bare',

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
    )
);
