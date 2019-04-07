<?php
/**
 * Clockwerk - REST API for your life.
 * Light, fast, and easy to use.
 *
 * @author KennFatt <me@kennan.xyz>
 * @link https://kennan.xyz/
 * @copyright 2019 - Clockwerk
 */

namespace clockwerk\webservice\service;

abstract class ServiceBase {
    private $serviceName = "";
    private $serviceRuntimeId = 0;
    private $timeout = 60;
    private $message = "";
    private $result = null;
    private $collectible = false;
    private $executed = false;

    public function __construct(string $name, int $runtimeId) {
        $this->serviceName = $name;
        $this->serviceRuntimeId = $runtimeId;
    }

    public function execute() : void {}

    public function isExecuted() : bool {
        return $this->executed;
    }

    public function setResult(string $message, ?array $data = null) {
        $this->result = $data;
        $this->message = $message;
        $this->collectible = true;
    }

    public function isCollectible() : bool {
        return $this->collectible;
    }

    public function getCollection() : array {
        return [
            "message" => $this->message,
            "data" => $this->result
        ];
    }

    public function getTimeout() : int {
        return $this->timeout;
    }

    public function setTimeout(int $timeout) : void {
        $this->timeout = $timeout;
    }
}