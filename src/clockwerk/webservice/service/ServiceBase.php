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
    /**
     * Indicate service name.
     *
     * @var string
     */
    private $serviceName = "";

    /**
     * Service Runtime ID.
     *
     * @var int
     */
    private $serviceRuntimeId = 0;

    /**
     * Maximum time for the system to wait the service.
     *
     * @var int
     */
    private $timeout = 5;

    /**
     * An informative message for client.
     *
     * @var string
     */
    private $message = "";

    /**
     * The rest result of the service.
     *
     * @var null
     */
    private $result = [];

    /**
     * Determine the service is ready to be collected.
     *
     * @var bool
     */
    private $collectible = false;

    /**
     * Determine the service is has been executed.
     *
     * @var bool
     */
    private $executed = false;

    /**
     * Given parameters to the service.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * ServiceBase constructor.
     *
     * @param string $name
     * @param int    $runtimeId
     * @param array  $parameters
     * @param int    $timeout
     */
    public function __construct(string $name, int $runtimeId, array $parameters, int $timeout) {
        $this->serviceName = $name;
        $this->serviceRuntimeId = $runtimeId;
        $this->parameters = $parameters;
        $this->timeout = $timeout;
        $this->onLoad();
    }

    public function onLoad() : void {}

    public function onExecute() : void {}

    /**
     * Determine that the service has been executed.
     *
     * @return bool
     */
    public function isExecuted() : bool {
        return $this->executed;
    }

    /**
     * Determine that the service is ready to be collected.
     *
     * @return bool
     */
    public function isCollectible() : bool {
        return $this->collectible;
    }

    /**
     * Set result and ready to be collected.
     *
     * @param string     $message
     * @param array|null $data
     */
    public function setResult(string $message, ?array $data = null) {
        $this->result = $data;
        $this->message = $message;
        $this->collectible = true;
    }

    /**
     * Get final collection data.
     *
     * @return array
     */
    public function getCollection() : array {
        return [
            "message" => $this->message,
            "data" => $this->result
        ];
    }

    /**
     * The service's maximum execute time.
     *
     * @return int
     */
    public function getTimeout() : int {
        return $this->timeout;
    }
}