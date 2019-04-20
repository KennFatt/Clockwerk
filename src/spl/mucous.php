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
 * Secret Key validation.
 * TODO: Add reserved key "key" to doc.
 */
if (SECRET_KEY !== "") {
    $dieFlag = false;
    if (!isset($parameters["key"])) {
        $dieFlag = true;
    } elseif (!is_int(stripos($parameters["key"], SECRET_KEY))) {
        $dieFlag = true;
    }
    if ($dieFlag) {
        die(json_encode([
            "code" => INVALID_RESPONSE,
            "message" => "Invalid secret key!"
        ], JSON_OPTIONS));
    }
    unset($parameters["key"]);
}

/**
 * Filtering variables input.
 */
$i = VARS_MAX_LENGTH > 0 ? 0 : null;
$filteredParams = [];
foreach ($parameters as $key => $val) {
    if ($i !== null && $i >= VARS_MAX_LENGTH) {
        break;
    }

    if (KEY_MAX_LENGTH > 0) {
        // TODO: Lanjutin ini
    }

    if ($i !== null) {
        $i++;
    }
}

$GLOBALS['REQUEST_ATTRIBUTES'] = $parameters;