<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0d829bd0434af9af759886d31e25cb44
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
        'L' => 
        array (
            'LINE\\' => 5,
        ),
        'K' => 
        array (
            'KS\\HTTP\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
        'KS\\HTTP\\' => 
        array (
            0 => __DIR__ . '/..' . '/kittinan/php-http/src/KS/HTTP',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0d829bd0434af9af759886d31e25cb44::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0d829bd0434af9af759886d31e25cb44::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
