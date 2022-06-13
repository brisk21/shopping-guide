<?php
// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 驱动方式,支持的缓存类型包括file、memcache、memcached、redis、sqlite、wincache和xcache，complex-混合。

    'type' => 'complex',
    'default' => [
        'type' => 'File',
        // 缓存保存目录
        'path' => CACHE_PATH,
        // 缓存前缀
        'prefix' => 'bs_',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
        //多少天自动清除
        'max_files' => 30
    ],
    'redis' => [
        'type' => 'redis',
        // 缓存前缀
        'prefix' => 'bs_',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'timeout' => 0,
        'persistent' => false,
    ],
    'memcached' => [
        'type' => 'memcached',
        'host' => '127.0.0.1',
        'port' => 11211,
        'expire' => 0,
        'timeout' => 0, // 超时时间（单位：毫秒）
        'prefix' => 'bs_',
        'username' => '', //账号
        'password' => '', //密码
        'option' => [],
    ],
    // 缓存保存目录
    'path' => CACHE_PATH,
    // 缓存前缀
    'prefix' => 'bs_',
    // 缓存有效期 0表示永久缓存
    'expire' => 0,
    //多少天自动清除
    'max_files' => 30
];