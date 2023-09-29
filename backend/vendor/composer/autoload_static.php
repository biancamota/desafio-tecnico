<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit244fae041ea0f93181657ef170275f8b
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bm\\Store\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bm\\Store\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit244fae041ea0f93181657ef170275f8b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit244fae041ea0f93181657ef170275f8b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit244fae041ea0f93181657ef170275f8b::$classMap;

        }, null, ClassLoader::class);
    }
}
