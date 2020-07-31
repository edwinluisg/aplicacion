<?php

define('BASE_URL', 'http://aplicacion.test/');
// define('BASE_URL', 'http://127.0.0.1/aplicacion/public/');

define('BASE_SERVER', $_SERVER['DOCUMENT_ROOT']); /* FOR WINDOWS */
//define('BASE_SERVER',$_SERVER['DOCUMENT_ROOT'].'/'); /* FOR LINUX */

/** CONFIG DATABASE */
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'aplicacion');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
/** /CONFIG DATABASE */
