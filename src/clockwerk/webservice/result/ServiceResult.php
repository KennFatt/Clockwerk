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

namespace clockwerk\webservice\result;

/**
 * Class ServiceResult
 * @package clockwerk\webservice\result
 *
 * This class is used for response the request.
 * Default format:
 * [
 *  "code": $statusCode,
 *  "message": $responseMessage,
 *  "data":
 *   [
 *    ...datum
 *   ]
 * ]
 */
abstract class ServiceResult {
    /**
     * Status code, by default it was flagged as invalid response.
     *
     * @var int
     */
    private $statusCode = 0x0;

    /**
     * Given extra information or message.
     *
     * @var string
     */
    private $responseMessage = "";

    /**
     * Store the final data and ready to be collected.
     *
     * @var array|string
     */
    private $finalResult = null;

    /**
     * Get current response status code.
     *
     * @return int
     */
    public function getStatusCode() : int {
        return $this->statusCode;
    }

    /**
     * Set a status of response, This is already defined in config.
     *
     * @param int $code
     */
    public function setStatusCode(int $code) : void {
        $this->statusCode = $code;
    }

    /**
     * Get current response message.
     *
     * @return string
     */
    public function getResponseMessage() : string {
        return $this->responseMessage;
    }

    /**
     * Set response message to client.
     *
     * @param string $message
     */
    public function setResponseMessage(string $message) : void {
        $this->responseMessage = $message;
    }

    /**
     * Getting the final data.
     *
     * @return null|string
     */
    public function getResult() : ?string {
        return $this->finalResult;
    }

    /**
     * Update the final result field.
     * Final result is also known as a final data that the services given from.
     *
     * @param array $finalResult
     */
    public function setResult(array $finalResult) : void {
        $this->finalResult = $finalResult;
    }

    /**
     * Show the result.
     *
     * @return string
     */
    public function __showResult() : string {
        return json_encode([
            "code" => $this->statusCode,
            "message" => $this->responseMessage,
            "data" => $this->finalResult ?? []
        ], JSON_OPTIONS);
    }
}