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
 * Clockwerk bootstrap
 */
require 'spl/bootstrap.php';

use clockwerk\webservice\ClockwerkRest;

/**
 * Work directory
 */
define("ROOT_DIR", __DIR__);

/**
 * Run the system.
 */
(new ClockwerkRest($GLOBALS['CLOCKWERK_KEY'], $GLOBALS['CLOCKWERK_REQUEST']))->init();