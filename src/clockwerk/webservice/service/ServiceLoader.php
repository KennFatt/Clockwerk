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
    /** @var ServiceManager|null  */
    private $serviceManager = null;

    /**
     * Stack of valid scripts.
     *
     * @var array
     */
    private $scripts = [];

    /**
     * ServiceLoader constructor.
     *
     * @param ServiceManager $manager
     * @param string         $path Path to 'services' folder.
     */
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

    /**
     * @return ServiceManager
     */
    private function getServiceManager() : ServiceManager {
        return $this->serviceManager;
    }

    /**
     * Get all loaded scripts.
     *
     * @return array
     */
    public function getScripts() : array {
        return $this->scripts;
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

    /**
     * Registering the script into system and storing it into scripts stack.
     *
     * @param array $scannedScript
     */
    private function loadScripts(array $scannedScript) : void {
        foreach ($scannedScript as $path) {
            $info = $this->getScriptInfo($path);
            if ($info == null) {
                continue;
            }

            if (isset($info['enable']) && strtolower($info['enable']) == 0x00) {
                continue;
            }

            if (isset($info['dependencies'])) {

            }

            $raw = explode(DIRECTORY_SEPARATOR, $path);
            $scriptFileName = explode(".", $raw[count($raw) - 1])[0];
            $this->scripts[$scriptFileName] = [
                "name" => $info['name'] ?? $scriptFileName,
                "description" => $info['description'] ?? "",
                "version" => $info['version'] ?? "0.0.1",
                "enable" => true,
                "timeout" => $info['timeout'] ?? 5
            ];

            include_once $path;
        }
    }
}