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
 * Class ValidResponseResult
 *
 * This is a response for a valid request.
 * All the $data would be encoded into json format.
 *
 * @package clockwerk\webservice\result
 */
class ValidResponseResult extends ServiceResult {

    public function __construct(array $data, string $message = "OK") {
        $this->setStatusCode(VALID_RESPONSE);
        $this->setResponseMessage($message);
        $this->setResult($data);
    }

}