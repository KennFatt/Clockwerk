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

namespace clockwerk\webservice;

use clockwerk\webservice\result\ServiceResult;
use clockwerk\webservice\result\ValidResponseResult;

class ClockwerkRest {
    /** @var ClockwerkRest|null */
    private static $instance = null;

    /**
     * Request method as a string.
     *
     * @default GET|POST
     * @var string
     */
    private $requestMethod = "";

    /**
     * Parameters that can be modified or used by any services.
     *
     * @var array
     */
    private $params = [];

    /**
     * ClockwerkRest constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        self::$instance = $this;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->putParams($attributes);
    }

    /**
     * Put extra parameters to its field.
     *
     * @param array $params
     */
    private function putParams(array $params) : void {
        unset($GLOBALS['REQUEST_ATTRIBUTES']);
        $this->params = $params;
    }

    /**
     * Getting instance.
     *
     * @return ClockwerkRest|null
     */
    public static function getInstance() : ?ClockwerkRest {
        return self::$instance;
    }

    /**
     * Finalizing the service.
     */
    public function finalize() : void {
        // TODO: Initiate system workers.

        $this->close(new ValidResponseResult([]));
    }

    /**
     * Close the Web Service.
     *
     * @param ServiceResult $result
     */
    public function close(ServiceResult $result) : void {
        // TODO: Cleanup
        $this->requestMethod = "";
        $this->params = [];

        die($result->__showResult());
    }

    /**
     * Request method getter.
     *
     * @return string
     */
    public function getRequestMethod() : string {
        return $this->requestMethod;
    }

    /**
     * Get request parameters.
     *
     * @return array
     */
    public function getParams() : array {
        return $this->params;
    }

}