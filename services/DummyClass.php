<?php
/**
 * @name DummyClass
 * @description Just a dummy script
 * @version 1.0
 * @enable true
 */

use clockwerk\webservice\service\ServiceBase;

class DummyClass extends ServiceBase {
    public function execute() : void {
        $this->setTimeout(5);
    }
}