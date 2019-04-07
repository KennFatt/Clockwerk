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

class ServiceLoader {
    private $serviceManager = null;
    private $scripts = [];

    public function __construct(ServiceManager $manager, string $path) {
        $scannedScript = [];

        if (!is_dir($path)) {
            mkdir($path);
            $manager->getServer()->sendResult("[*] No services available.");
            return;
        } else {
            foreach (new \DirectoryIterator($path) as $file) {
                if (!$file->isFile() || $file->getFilename() == "." || $file->getFilename() == ".." || $file->getExtension() !== "php") {
                    continue;
                }

                $scannedScript[] = $file->getPathname();
            }
        }

        if ($scannedScript == []) {
            $manager->getServer()->sendResult("[**] No services available.");
            return;
        }

        $this->serviceManager = $manager;
        $this->loadScripts($scannedScript);
    }

    private function loadScripts(array $scannedScript) : void {
        foreach ($scannedScript as $path) {
            $info = $this->getScriptInfo($path);
            if ($info == null) {
                continue;
            }

            if (isset($info['enable']) && strtolower($info['enable']) == "false") {
                continue;
            }

            if (!isset($info['name']) || !isset($info['description']) || !isset($info['version'])) {
                continue;
            }

            /**
             * Storing a service into known scripts.
             *
             *  TODO:
             *  Add a checking-system before storing it into $scripts.
             *  Follow-up: Use is_a(); and filename must be equals as its class name.
             */
            $raw = explode(DIRECTORY_SEPARATOR, $path);
            $this->scripts[] = explode(".", $raw[count($raw) - 1])[0];

            include_once $path;
        }
    }

    public function getScripts() : array {
        return $this->scripts;
    }

    /**
     * Parsing script's description into structured data (array).
     * The original code was written by @shoghicp https://github.com/shoghicp thanks to him.
     *
     * Current available tags:
     * - (at)name Identify the script.
     * - (at)description Short description about your script.
     * - (at)version Script's version.
     *
     * @param string $file
     *
     * @return array|null
     */
    private function getScriptInfo(string $file) : ?array{
        $content = file($file, 1 << 1 | 1 << 2);

        $data = [];

        $insideHeader = false;
        foreach($content as $line){
            if(!$insideHeader and strpos($line, "/**") !== false){
                $insideHeader = true;
            }

            if(preg_match("/^[ \t]+\\*[ \t]+@([a-zA-Z]+)([ \t]+(.*))?$/", $line, $matches) > 0){
                $key = $matches[1];
                $content = trim($matches[3] ?? "");

                if($key === "notscript"){
                    return null;
                }

                $data[$key] = $content;
            }

            if($insideHeader and strpos($line, "*/") !== false){
                break;
            }
        }

        if($insideHeader){
            return $data;
        }

        return null;
    }
}