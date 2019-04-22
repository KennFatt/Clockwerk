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
 *
 * @type string|int
 */
define("INVALID_RESPONSE", 0x00);

/**
 * This is a valid response that represented by our system.
 *
 * @type string|int
 */
define("VALID_RESPONSE", 0x01);

/**
 * JSON options for all result message.
 * @link http://php.net/manual/en/json.constants.php
 *
 * @type int Json option constants
 */
define("JSON_OPTIONS", JSON_PRETTY_PRINT);

/**
 * Path to service folder.
 *
 * @type string
 */
define("SERVICES_FOLDER_PATH", ROOT_DIR . DIRECTORY_SEPARATOR . "services" . DIRECTORY_SEPARATOR);

/**
 * Secret Key between client and server.
 * Note: Plain text as secret key is NOT recommended! Please put encrypted string.
 * Leave it blank if you want to skip Secret Key validation.
 *
 * @type string
 */
define("SECRET_KEY", "");

/**
 * This is an option to allow controlling all variables input.
 */
define("ENABLE_VARS_CONTROL", true);

/**
 * Maximum length of variables input.
 * @see \ENABLE_VARS_CONTROL
 */
define("VARS_MAX_LENGTH", 100);

/**
 * Maximum length of key variable.
 * @see \ENABLE_VARS_CONTROL
 */
define("KEY_MAX_LENGTH", 16);

/**
 * Maximum length of value variable.
 * @see \ENABLE_VARS_CONTROL
 */
define("VALUE_MAX_LENGTH", 16);