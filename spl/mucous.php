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

if (AUTH_USERNAME !== "" || AUTH_PASSWORD !== "") {
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        die(json_encode([
            "code" => 203,
            "message" => "Non-Authoritative Information"
        ], JSON_OPTIONS));
    }

    if ($_SERVER['PHP_AUTH_USER'] !== AUTH_USERNAME || $_SERVER['PHP_AUTH_PW'] !== AUTH_PASSWORD) {
        die(json_encode([
            "code" => 401,
            "message" => "Unauthorized"
        ], JSON_OPTIONS));
    }
}

/**
 * Validating method request.
 *
 * @param array $request
 */
function validateRequest(array $request = []) : void {
    if ($request == [] || !isset($request['key'])) {
        die(json_encode([
            "code" => 400,
            "message" => "Bad Request"
        ], JSON_OPTIONS));
    }

    switch ($request['key']) {
        case GET_API_KEY:
        case POST_API_KEY:
        $GLOBALS['REQUEST_ATTRIBUTES'] = $request;
            break;

        default:
            die(json_encode([
                "code" => 400,
                "message" => "Bad Request"
            ], JSON_OPTIONS));
            break;
    }
}

validateRequest($_GET == [] ? $_POST : $_GET);