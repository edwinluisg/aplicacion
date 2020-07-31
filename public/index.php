<?php

chdir(dirname(__DIR__));

define("APP_PATH", "app/");
define("CORE_PATH", "core/");
define("VENDOR_PATH", "vendor/");
define("LIBRARY_PATH", "library/");
define("CONTROLLERS_PATH", "app/controllers/");
define("MODELS_PATH", "app/models/");
define("VIEWS_PATH", "app/views/");
session_start();
require_once CORE_PATH . "Config.php";
require_once CORE_PATH . "Autoloader.php";
$app = new App();

