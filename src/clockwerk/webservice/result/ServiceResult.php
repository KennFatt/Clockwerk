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

namespace clockwerk\webservice\result;

/**
 * Class ServiceResult
 * @package clockwerk\webservice\result
 *
 * This class is used for response the request.
 * Default format:
 * [
 *  "code": $responseCode,
 *  "message": $responseMessage,
 *  "params":
 *   [
 *    ...parameters
 *   ]
 * ]
 */
abstract class ServiceResult
{
    /**
     * By default response code is 200.
     *
     * @var int
     */
    private $responseCode = 200;

    /**
     * Given extra information or message.
     *
     * @var string
     */
    private $responseMessage = "";

    /**
     * Final result field.
     *
     * @var array|string
     */
    private $finalResult = null;

    /**
     * Get status code message.
     *
     * @param int $code
     *
     * @return string
     */
    private function parseResponseCode(int $code) : string
    {
        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text = 'Switching Protocols'; break;
            case 200: $text = 'OK'; break;
            case 201: $text = 'Created'; break;
            case 202: $text = 'Accepted'; break;
            case 203: $text = 'Non-Authoritative Information'; break;
            case 204: $text = 'No Content'; break;
            case 205: $text = 'Reset Content'; break;
            case 206: $text = 'Partial Content'; break;
            case 300: $text = 'Multiple Choices'; break;
            case 301: $text = 'Moved Permanently'; break;
            case 302: $text = 'Moved Temporarily'; break;
            case 303: $text = 'See Other'; break;
            case 304: $text = 'Not Modified'; break;
            case 305: $text = 'Use Proxy'; break;
            case 400: $text = 'Bad Request'; break;
            case 401: $text = 'Unauthorized'; break;
            case 402: $text = 'Payment Required'; break;
            case 403: $text = 'Forbidden'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 406: $text = 'Not Acceptable'; break;
            case 407: $text = 'Proxy Authentication Required'; break;
            case 408: $text = 'Request Time-out'; break;
            case 409: $text = 'Conflict'; break;
            case 410: $text = 'Gone'; break;
            case 411: $text = 'Length Required'; break;
            case 412: $text = 'Precondition Failed'; break;
            case 413: $text = 'Request Entity Too Large'; break;
            case 414: $text = 'Request-URI Too Large'; break;
            case 415: $text = 'Unsupported Media Type'; break;
            case 500: $text = 'Internal Server Error'; break;
            case 501: $text = 'Not Implemented'; break;
            case 502: $text = 'Bad Gateway'; break;
            case 503: $text = 'Service Unavailable'; break;
            case 504: $text = 'Gateway Time-out'; break;
            case 505: $text = 'HTTP Version not supported'; break;
            default: $text = 'Unknown http status code "' . htmlentities($code) . '""'; break;
        }

        return $text;
    }

    /**
     * Get status code.
     *
     * @return int
     */
    public function getResponseCode() : int
    {
        return $this->responseCode;
    }

    /**
     * Update new status code.
     *
     * @param int $code
     */
    public function setResponseCode(int $code) : void
    {
        http_response_code($code);

        $this->responseCode = $code;
        $this->responseMessage = $this->parseResponseCode($code);
    }

    /**
     * Response message.
     *
     * @return string
     */
    public function getResponseMessage() : string
    {
        return $this->responseMessage;
    }

    /**
     * Get the final result.
     *
     * @return null|string
     */
    public function getResult() : ?string
    {
        return $this->finalResult;
    }

    /**
     * Update the final result field.
     *
     * @param $finalResult
     */
    public function setResult($finalResult) : void
    {
        $this->finalResult = $finalResult;
    }

    /**
     * Show the result.
     *
     * @return string
     */
    public function __showResult() : string {
        return "";
    }
}