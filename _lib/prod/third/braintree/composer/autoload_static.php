<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb7a41fbf5e34d76e54e4e5e77e781dc7
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Braintree\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Braintree\\' => 
        array (
            0 => __DIR__ . '/..' . '/braintree/braintree_php/lib/Braintree',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb7a41fbf5e34d76e54e4e5e77e781dc7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb7a41fbf5e34d76e54e4e5e77e781dc7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb7a41fbf5e34d76e54e4e5e77e781dc7::$classMap;

        }, null, ClassLoader::class);
    }
}
