<?php
require_once("config.php");

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'mysql',
                'host' => DB_HOST,
                'name' => DB_NAME,
                'user' => DB_USER,
                'pass' => DB_PASSWD,
                'port' => DB_PORT,
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];