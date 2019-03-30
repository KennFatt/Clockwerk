<?php
/**
 * Clockwerk - REST API for your life.
 * Light, fast, and easy to use.
 *
 * @author KennFatt <me@kennan.xyz>
 * @link https://kennan.xyz/
 * @copyright 2019 - Clockwerk
 */

namespace clockwerk\webservice\result;

/**
 * Class InvalidResponseResult
 *
 * This is a response for an invalid request or something is not working well.
 * By default, it just show the invalid code and additional information about an exception.
 *
 * @package clockwerk\webservice\result
 */
class InvalidResponseResult extends ServiceResult {

    public function __construct(string $message) {
        $this->setStatusCode(INVALID_RESPONSE);
        $this->setResponseMessage($message);
    }

}