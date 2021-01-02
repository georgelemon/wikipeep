<?php

/**
 * Define the current environment (default: production).
 * @see !IMPORTANT: Do not leave the app with local env in production
 */ 
define('ENV', 'local');

// Directory Separator shortcut
define('DS', DIRECTORY_SEPARATOR);

// Autoloading namespaces & package dependencies
require_once __DIR__ . DS . 'vendor/autoload.php';

// Error handling
set_exception_handler(['App\Core\ErrorExceptionHandler', 'exception']);
set_error_handler(['App\Core\ErrorExceptionHandler', 'native']);
register_shutdown_function(['App\Core\ErrorExceptionHandler', 'shutdown']);

require_once __DIR__ . DS . 'app/helper.php';
require_once __DIR__ . DS . 'app/debug.php';

define('APP_VERSION', '1.0.0');
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . DS . 'app');
define('CONFIG_PATH', ROOT_PATH . DS . 'config');
define('STORAGE_PATH', ROOT_PATH . DS . 'storage');
define('DATABASE_PATH', ROOT_PATH . DS . 'storage/database/');
define('ROUTES_PATH', ROOT_PATH . DS . 'routes');
define('VIEWS_PATH', APP_PATH . DS . 'Views');
define('PUBLIC_PATH', $_SERVER['HTTP_HOST']);
define('VENDOR_PATH', ROOT_PATH . DS . 'vendor');
define('THEMES_PATH', ROOT_PATH . DS . 'themes');
define('CONTENT_PATH', ROOT_PATH . DS . 'content');

// Initialize the Application with the current setup
$app = App\Core\Kernel\Application::instance();
$app->setup();

// Set default timezone based on application config
date_default_timezone_set(config()->get('app.timezone')); 

// Bootstrap the app with routes and other depedencies
$app->bootstrap();