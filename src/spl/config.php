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
 * Some of these form fields are important on production.
 * Fill it as you want and further information are described at documentation.
 */

/**
 * Basic Authentication (BA) username.
 * NOTE: Leave it blank to disable BA,
 *
 * @type string
 */
define("AUTH_USERNAME", "");

/**
 * Basic Authentication (BA) password.
 * NOTE: Leave it blank to disable BA,
 *
 * @type string
 */
define("AUTH_PASSWORD", "");

/**
 * A secret key for POST request.
 *
 * @type string
 */
define("POST_API_KEY", "");

/**
 * A secret key for GET request.
 *
 * @type string
 */
define("GET_API_KEY", "");

/**
 * JSON options for all result message.
 * @link http://php.net/manual/en/json.constants.php
 *
 * @type int Json option constants
 */
define("JSON_OPTIONS", JSON_PRETTY_PRINT);