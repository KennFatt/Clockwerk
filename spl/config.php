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

/**
 * Some of these form fields are important on production.
 * Fill it as you want and further information are described at documentation.
 */

/**
 * Basic Authentication (BA) username.
 *
 * @type string
 */
define("AUTH_USERNAME", "");

/**
 * Basic Authentication (BA) password.
 *
 * @type string
 */
define("AUTH_PASSWORD", "");

/**
 * A secret key for POST request.
 *
 * @type string
 */
define("POST_API_KEY", "mPostKey");

/**
 * A secret key for GET request.
 *
 * @type string
 */
define("GET_API_KEY", "mGetKey");

/**
 * JSON options for all result message.
 * @link http://php.net/manual/en/json.constants.php
 *
 * @type int Json option constants
 */
define("JSON_OPTIONS", 128);