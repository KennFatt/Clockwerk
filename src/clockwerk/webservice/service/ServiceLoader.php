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

use DirectoryIterator;

class ServiceLoader {
    /** @var ServiceManager|null  */
    private $serviceManager = null;

    /**
     * Stack of valid scripts.
     *
     * @var array
     */
    private $scripts = [];

    private $scriptsFile = [];

    /**
     * ServiceLoader constructor.
     *
     * @param ServiceManager $manager
     * @param string         $path Path to 'services' folder.
     */
    public function __construct(ServiceManager $manager, string $path) {
        $this->serviceManager = $manager;
        if (!is_dir($path)) {
            mkdir($path);
            $manager->getServer()->sendResult("[*] No services available.");
            return;
        }
        $this->filterScriptsFile($path);
        if ($this->scriptsFile == []) {
            $manager->getServer()->sendResult("[**] No services available.");
            return;
        }

        $requestedService = $manager->getServer()->getRequestedService();
        if (is_string($requestedService) && strlen($requestedService) > 0) {
            $this->loadScript($requestedService);
        } else {
            $this->loadScripts();
        }
    }

    /**
     * Get all loaded scripts.
     *
     * @return array
     */
    public function getScripts() : array {
        return $this->scripts;
    }

    private function filterScriptsFile(string $path) : void {
        foreach (new DirectoryIterator($path) as $file) {
            if (!$file->isFile() || $file->getFilename() == "." || $file->getFilename() == ".." || $file->getExtension() !== "php") {
                continue;
            }
            $fileName = substr($file->getFilename(), 0, strpos($file->getFilename(), "."));
            $this->scriptsFile[$fileName] = $file->getPathname();
        }
    }

    private function isValidScript(string $scriptFile) : bool {
        $info = $this->getScriptInfo($scriptFile);
        if ($info == null) {
            return false;
        }

        if (isset($info['enable']) && strtolower($info['enable']) == 0x00) {
            return false;
        }

        return true;
    }

    private function loadScript(string $scriptName, bool $loadDependencies = true) : bool {
        $scriptInfo = $this->getScriptInfo($this->scripts[$scriptName]);
        if ($scriptInfo == null) {
            return false;
        }
        if ($loadDependencies && !empty($scriptInfo['depends'])) {
            // TODO: Load each dependencies
            foreach ($scriptInfo['depends'] as $depend) {
                if (!isset($this->scriptsFile[$depend])) {
                    continue;
                }

                $this->loadScript($depend, false);
            }
        }

        return true;
    }

    /**
     * Registering the script into system and storing it into scripts stack.
     */
    private function loadScripts() : void {
        $scannedScript = $this->scriptsFile;
        foreach ($scannedScript as $fileName => $path) {
            $info = $this->getScriptInfo($path);


            $this->scripts[$fileName] = [
                "name" => $fileName,
                "description" => $info['description'] ?? "",
                "version" => $info['version'] ?? "0.0.1",
                "enable" => true,
                "timeout" => $info['timeout'] ?? 5,
                "depends" => $info['depends'] ?? []
            ];

            include_once $path;
        }
    }

    /**
     * Parsing script's description into structured data (array).
     * The original code was written by @shoghicp https://github.com/shoghicp thanks to him.
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
                if($key === "notscript"){
                    return null;
                }

                $content = trim($matches[3] ?? "");
                if (strtolower($content) == "false") {
                    $content = false;
                } elseif (strtolower($content) == "true") {
                    $content = true;
                }

                if (!stripos($content, ",")) {
                    $content = explode(",", $content);
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