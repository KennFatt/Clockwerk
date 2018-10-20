<?php

/**
 * Clockwerk - RESTful API for your life.
 * Light, fast, and easy to use.
 *
 * @author KennFatt <me@kennan.xyz>
 * @link https://kennan.xyz/
 * @copyright 2018 KennFatt - Clockwerk
 */

declare(strict_types=1);

spl_autoload_register(function($class) : bool {
    $prefix = 'clockwerk\\';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return false;
    }

    $baseDir = ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'clockwerk' . DIRECTORY_SEPARATOR;

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }

    return true;
});