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
    private $server = null;
    private $services = [];

    public function __construct(ClockwerkRest $server) {
        $this->server = $server;

        $this->init();
    }

    private function init() : void {
        $loader = new ServiceLoader($this, ROOT_DIR . DIRECTORY_SEPARATOR . SERVICES_FOLDER . DIRECTORY_SEPARATOR);
        foreach ($loader->getScripts() as $script) {
            /** @var ServiceBase $service */
            $service = new $script($script, count($this->services));

            if (is_a($service, ServiceBase::class)) {
                $this->services[$script] = $service;
            }
        }
    }

    public function serveRequest(string $requestName) : ?array {
        if (!isset($this->services[$requestName])) {
            return null;
        }

        /** @var ServiceBase $service */
        $service = $this->services[$requestName];
        $startTime = microtime(true);
        while (!$service->isCollectible()) {
            if (!$service->isExecuted()) {
                $service->execute();
            }

            $currentTime = microtime(true);
            $elapsedTime = (int) ($currentTime - $startTime);
            if ($elapsedTime >= $service->getTimeout()) {
                return null;
            }
        }

        return $service->getCollection();
    }

    public function getServer() : ?ClockwerkRest {
        return $this->server;
    }
}