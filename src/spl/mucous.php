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
if (ENABLE_VARS_CONTROL) {
    $maxInputHandler = function(int &$current, bool &$flag, int $maxVars) : void {
        ++$current;
        $flag = $current < $maxVars ? false : true;
    };
    $lengthHandler = function(string $k, string $v, bool &$flag, int $maxKeyLength, int $maxValLength) : void {
        if ($maxKeyLength > 0 && strlen($k) > $maxKeyLength) {
            $flag = false;
        }
        if ($maxValLength > 0 && strlen($v) > $maxValLength) {
            $flag = false;
        }
    };

    $tmp = 0;
    $validEntry = true;
    $newParameters = [];
    foreach ($parameters as $k => $v) {
        if (VARS_MAX_LENGTH > 0) {
            $maxInputHandler($tmp, $validEntry, VARS_MAX_LENGTH);
        }
        $lengthHandler($k, $v, $validEntry, KEY_MAX_LENGTH, VALUE_MAX_LENGTH);

        if (!$validEntry) {
            $validEntry = true;
            continue;
        }
        $newParameters[$k] = $v;
    }
    $parameters = $newParameters;
}

$GLOBALS['REQUEST_ATTRIBUTES'] = $parameters;