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

use clockwerk\webservice\result\InvalidResponseResult;
use clockwerk\webservice\result\ServiceResult;
use clockwerk\webservice\result\ValidResponseResult;
use clockwerk\webservice\service\ServiceManager;

class ClockwerkRest {
    /** @var ServiceManager|null */
    private $serviceManager = null;

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
     * Requested service of the client.
     *
     * @var string
     */
    private $requestedService = "";

    /**
     * ClockwerkRest constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes) {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->putParams($attributes);
        $this->serviceManager = new ServiceManager($this);

        $this->finalize();
    }

    /**
     * Put extra parameters to its field.
     *
     * @param array $params
     */
    private function putParams(array $params) : void {
        unset($GLOBALS['REQUEST_ATTRIBUTES']);

        if (isset($params['service'])) {
            $this->requestedService = $params['service'];
            unset($params['service']);
        }

        $this->params = $params;
    }

    /**
     * Finalizing the service.
     */
    private function finalize() : void {
        /**
         * Until this step, the main goal was achieved.
         * But there is so much things to add later.
         * Such a security purpose, compatibility, documentation, and others things to ready for production.
         *
         * TODO: If there is no given service, it means to load all the services and getting the final result.
         * Also, this method is look more fancier that the "?service=" way.
         */
        if ($this->getRequestedService() == "") {

        } else {
            $finalResult = $this->serviceManager->dispatchService($this->getRequestedService());
        }

        $this->sendResult($finalResult == null ? "Something went wrong with the service, try again later!" : $finalResult);
    }

    /**
     * Get requested service of the client.
     *
     * @return string
     */
    public function getRequestedService() : string {
        return $this->requestedService;
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

    /**
     * Send the final result to user and close the system.
     * TODO: Remove this.
     *
     * @param string     $message
     * @param array|null $data
     */
    public function sendResult(string $message, ?array $data = null) : void {
        $res = $data == null ? new InvalidResponseResult($message) : new ValidResponseResult($data, $message);
        $this->close($res);
    }

    /**
     * Close the Web Service.
     * TODO: Do some refactor.
     *
     * @param ServiceResult $result
     */
    private function close(ServiceResult $result) : void {
        die($result->__showResult());
    }
}