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

use clockwerk\webservice\ClockwerkRest;

class ServiceManager {
    /** @var ClockwerkRest|null */
    private $server = null;

    /** @var ServiceLoader|null */
    private $loader = null;

    /**
     * Stack of loaded services.
     *
     * @var array
     */
    private $services = [];

    /**
     * TODO: Implement dependencies
     *
     * @var array
     */
    private $dependencies = [];

    private $executedServices = [];

    private $resultPool = [];

    /**
     * ServiceManager constructor.
     *
     * @param ClockwerkRest $server
     */
    public function __construct(ClockwerkRest $server) {
        $this->server = $server;

        $this->init();
    }

    /**
     * @return ClockwerkRest|null
     */
    public function getServer() : ?ClockwerkRest {
        return $this->server;
    }

    /**
     * Load all the scripts by ServiceLoader.
     * Then, create new instance of each services.
     *
     * @return void
     */
    private function init() : void {
        if ($this->loader == null) {
            $this->loader = new ServiceLoader($this, SERVICES_FOLDER_PATH);
        }

        foreach ($this->loader->getScripts() as $scriptName => $scriptMeta) {
            /**
             * TODO:
             *
             * This is a condition where same script name is already loaded.
             * So, I need to compare its version. And should load newest version. ffs version.
             */
            if (isset($this->services[$scriptName])) {
                continue;
            }

            /** @var ServiceBase $service */
            $service = new $scriptName($scriptMeta['name'], count($this->services), $this->getServer()->getParams(), $scriptMeta['timeout']);

            if (is_a($service, ServiceBase::class)) {
                $this->services[$scriptName] = $service;
            }
        }
    }

    public function dispatchService(string $serviceName) {
        /** @var ServiceBase|null $service */
        $service = $this->services[$serviceName];

        if ($service == null) {
            return null;
        }

        $timeoutHandler = function(float $startTime) use ($service) : bool {
            $deltaTime = (int) (microtime(true) - $startTime);
            if ($deltaTime >= $service->getTimeout()) {
                return true;
            }
            return false;
        };

        $startTime = microtime(true);
        while (!$service->isCollectible()) {
            if (!isset($this->executedServices[$serviceName])) {
                $service->onExecute();
                $this->executedServices[$serviceName] = true;
            }

            if ($timeoutHandler($startTime)) {
                return null;
            }
        }
        $this->executedServices[$serviceName] = null;

        $collection = $service->getCollection();
        $this->resultPool[$serviceName] = $collection;

        return $collection;
    }
}