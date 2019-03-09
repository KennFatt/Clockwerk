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

class JsonResult extends ServiceResult
{
    /**
     * JsonResult constructor.
     *
     * @param array $data
     * @param int   $statusCode
     */
    public function __construct(array $data, int $statusCode)
    {
        $this->setResponseCode($statusCode);

        $result = [
            "code" => $this->getResponseCode(),
            "message" => $this->getResponseMessage()
        ];

        $result["params"] = $data == [] ? "null" : $data;

        $this->setResult(json_encode($result, JSON_OPTIONS));
    }

    /**
     * @return string
     */
    public function __showResult() : string
    {
        return $this->getResult();
    }
}