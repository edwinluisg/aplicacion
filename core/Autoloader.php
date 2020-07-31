<?php

class Autoloader
{

    public function __construct()
    {

        $this->loadApp();
        $this->loadVendor();
        $this->loadDatabase();
        $this->loadAppClasses();
    }
    private function loadApp()
    {
        require_once CORE_PATH . "App.php";
    }

    private function loadAppClasses()
    {
        spl_autoload_register(function ($className) {
            $class = substr($className, 0, 3);
            if ($class == 'cor' or $class == 'app' or $class == 'lib') {
                require_once preg_replace("/\\\\/", "/", $className) . ".php";
            }
        });
    }

    private function loadVendor()
    {
        require_once VENDOR_PATH . 'autoload.php';
    }

    private function loadDatabase()
    {
        require_once CORE_PATH . "Database.php";
    }

}

new Autoloader();
