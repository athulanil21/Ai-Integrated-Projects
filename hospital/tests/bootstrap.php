<?php

use CodeIgniter\CLI\CLI;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Path constants
if (!defined('HOMEPATH')) {
    define('HOMEPATH', realpath(rtrim(getcwd(), '\\/ ')) . DIRECTORY_SEPARATOR);
}

if (!defined('CONFIGPATH')) {
    define('CONFIGPATH', realpath(HOMEPATH . 'app/Config') . DIRECTORY_SEPARATOR);
}

if (!defined('PUBLICPATH')) {
    define('PUBLICPATH', realpath(HOMEPATH . 'public') . DIRECTORY_SEPARATOR);
}

// Get our framework constants
require_once HOMEPATH . 'app/Config/Constants.php';

if (file_exists(HOMEPATH . 'vendor/autoload.php')) {
    require_once HOMEPATH . 'vendor/autoload.php';
}

require_once SYSTEMPATH . 'Test/bootstrap.php';
