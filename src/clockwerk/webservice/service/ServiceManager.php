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

    
    private $dependencies = [];

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
     * @return ServiceLoader
     */
    private function getLoader() : ServiceLoader {
        return $this->loader;
    }

    /**
     * Load all the scripts by ServiceLoader.
     * Then, create new instance of each services.
     *
     * @return void
     */
    private function init() : void {
        if ($this->loader == null) {
            $this->loader = new ServiceLoader($this, ROOT_DIR . DIRECTORY_SEPARATOR . SERVICES_FOLDER . DIRECTORY_SEPARATOR);
        }

        foreach ($this->getLoader()->getScripts() as $scriptName => $scriptMeta) {
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

    public function serveRequest(string $serviceName) : ?array {
        if (!isset($this->services[$serviceName])) {
            return null;
        }

        /** @var ServiceBase $service */
        $service = $this->services[$serviceName];
        $startTime = microtime(true);
        while (!$service->isCollectible()) {
            if (!$service->isExecuted()) {
                $service->onExecute();
            }

            $currentTime = microtime(true);
            $elapsedTime = (int) ($currentTime - $startTime);
            if ($elapsedTime >= $service->getTimeout()) {
                return null;
            }
        }

        return $service->getCollection();
    }
}