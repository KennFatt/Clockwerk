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

 // check POST or GET

$request = null;

if (!empty($_POST)) {
    $request = $_POST;
} elseif (!empty($_GET)) {
    $request = $_GET;
} else {
    // TODO: Globalization
    die(json_encode([
        "code" => 404,
        "body" => [

        ],
    ], JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING));
}