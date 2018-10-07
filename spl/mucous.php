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
            "body" => [
                "message" => "Non-Authoritative Information"
            ],
        ], JSON_OPTIONS));
    }

    if ($_SERVER['PHP_AUTH_USER'] !== AUTH_USERNAME || $_SERVER['PHP_AUTH_PW'] !== AUTH_PASSWORD) {
        die(json_encode([
            "code" => 401,
            "body" => [
                "message" => "Unauthorized"
            ],
        ], JSON_OPTIONS));
    }
}

/**
 * Validating $_GET and $_POST request.
 *
 * @param array $get
 * @param array $post
 */
function validateRequest(array $get = [], array $post = []) : void {
    $request = $get == [] ? $post : $get;

    if ($request == [] || !isset($request['key'])) {
        die(json_encode([
            "code" => 400,
            "body" => [
                "message" => "Bad Request"
            ],
        ], JSON_OPTIONS));
    }

    switch ($request['key']) {
        case POST_API_KEY:
            $GLOBALS['CLOCKWERK_KEY'] = $request['key'];
            $GLOBALS['CLOCKWERK_REQUEST'] = $request;
            break;

        case GET_API_KEY:
            $GLOBALS['CLOCKWERK_KEY'] = $request['key'];
            $GLOBALS['CLOCKWERK_REQUEST'] = $request;
            break;

        default:
            die(json_encode([
                "code" => 400,
                "body" => [
                    "message" => "Bad Request"
                ],
            ], JSON_OPTIONS));
            break;
    }
}

validateRequest($_GET, $_POST);