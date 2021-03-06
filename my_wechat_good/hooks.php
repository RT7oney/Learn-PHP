<?php

add_action('load_side_menus', function () {
    load_side_menu(
        [
            'name' => '微信公众平台',
            'icon' => 'icon file',
            'link' => 'javascript:;',
        ],
        [
            [
                'name' => '用户统计',
                'link' => '',
            ],
            [
                'name' => '设置',
                'link' => '',
            ],
        ]);
});

//设置数据库连接
add_connection('ximu_wechat',
    [
        'driver' => 'mysql',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 3306),
        'database' => 'ximuop',
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => 'xi_',
        'timezone' => env('DB_TIMEZONE', '+00:00'),
        'strict' => false,
    ]
);
