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
 * Clockwerk bootstrap
 */
require 'src/spl/bootstrap.php';

use clockwerk\webservice\ClockwerkRest;

/**
 * Work directory
 */
define("ROOT_DIR", __DIR__);

/**
 * Run the system.
 */
$rest = new ClockwerkRest($GLOBALS['REQUEST_ATTRIBUTES']);
$rest->finalize();