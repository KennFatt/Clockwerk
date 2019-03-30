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
define("AUTH_USERNAME", "user");

/**
 * Basic Authentication (BA) password.
 * NOTE: Leave it blank to disable BA,
 *
 * @type string
 */
define("AUTH_PASSWORD", "user");

/**
 * This is an invalid response that represented by our system.
 */
define("INVALID_RESPONSE", 0x0);

/**
 * This is a valid response that represented by our system.
 */
define("VALID_RESPONSE", 0x1);

/**
 * JSON options for all result message.
 * @link http://php.net/manual/en/json.constants.php
 *
 * @type int Json option constants
 */
define("JSON_OPTIONS", JSON_PRETTY_PRINT);