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

use clockwerk\webservice\result\JsonResult;
use clockwerk\webservice\result\ServiceResult;

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
     * Encrypted API key.
     *
     * @var string
     */
    private $key = "";

    /**
     * User session name.
     *
     * @var string
     */
    private $userSession = "";

    /**
     * ClockwerkRest constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        self::$instance = $this;
        if ($this->validateAttributes($attributes)) {
            $this->close(new JsonResult(["Attributes is not fulfilled!"], 400));
        }

        $this->userSession = $attributes['user'];
        $this->key = $attributes['key'];
        $this->putParams($attributes);

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    private function validateAttributes(array $attributes) : bool {
        return !isset($attributes['user']) || !isset($attributes['key']);
    }

    /**
     * Put extra parameters to its field.
     *
     * @param array $params
     */
    private function putParams(array $params): void {
        unset($GLOBALS['REQUEST_ATTRIBUTES']);

        unset($params['user']);
        unset($params['key']);

        $this->params = $params;
    }

    /**
     * Getting instance.
     *
     * @return ClockwerkRest|null
     */
    public static function getInstance(): ?ClockwerkRest {
        return self::$instance;
    }

    /**
     * Web Service initiator.
     */
    public function init(): void {
        // TODO
    }

    /**
     * Request method getter.
     *
     * @return string
     */
    public function getRequestMethod(): string {
        return $this->requestMethod;
    }

    /**
     * Get request parameters.
     *
     * @return array
     */
    public function getParams(): array {
        return $this->params;
    }

    /**
     * Get request API Key.
     *
     * @return string
     */
    public function getApiKey(): string {
        return $this->key;
    }

    /**
     * Close the Web Service.
     *
     * @param ServiceResult|null $result
     */
    public function close(?ServiceResult $result): void {
        // TODO: Cleanup
        $this->requestMethod = "";
        $this->params = [];
        $this->key = "";

        die($result->__showResult());
    }

}
