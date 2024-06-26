<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbd810f3a6fb10b157cda8a986ee3542c
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Utils\\' => 6,
        ),
        'M' => 
        array (
            'MySQL\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Utils\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../../crud/Utils',
        ),
        'MySQL\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../../crud/MySQL',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../src/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbd810f3a6fb10b157cda8a986ee3542c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbd810f3a6fb10b157cda8a986ee3542c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbd810f3a6fb10b157cda8a986ee3542c::$classMap;

        }, null, ClassLoader::class);
    }
}
