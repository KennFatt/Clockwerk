<?php

/**
 * Clockwerk - REST API for your life.
 * Light, fast, and easy to use.
 *
 * @author KennFatt <me@kennan.xyz>
 * @link https://kennan.xyz/
 * @copyright 2019 - Clockwerk
 */

declare(strict_types=1);

/**
 * Basic Authentication section.
 * Validates all information of BA.
 */
if (AUTH_USERNAME !== "" || AUTH_PASSWORD !== "") {
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        die(json_encode([
            "code" => INVALID_RESPONSE,
            "message" => "Non-Authorized."
        ], JSON_OPTIONS));
    }

    if ($_SERVER['PHP_AUTH_USER'] !== AUTH_USERNAME || $_SERVER['PHP_AUTH_PW'] !== AUTH_PASSWORD) {
        die(json_encode([
            "code" => INVALID_RESPONSE,
            "message" => "Authentication failed!"
        ], JSON_OPTIONS));
    }
}

/**
 * Store the parameters into local variable.
 */
$parameters = $_GET == [] ? $_POST : $_GET;

/**
 * Close the system when parameters is zero given.
 */
if ($parameters == []) {
    die(json_encode([
        "code" => INVALID_RESPONSE,
        "message" => "There is no such parameters."
    ], JSON_OPTIONS));
}

$GLOBALS['REQUEST_ATTRIBUTES'] = $parameters;