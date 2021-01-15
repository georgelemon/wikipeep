<?php
define('ENV', 'local');
define('DS', DIRECTORY_SEPARATOR);
define('APP_VERSION', '1.0.0');
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

require_once __DIR__ . DS . 'vendor/autoload.php';

// Initialize the Application with the current setup
$app = App\Application::instance();
$app->setup();

// Error handling
set_exception_handler(['Loopless\Kernel\ErrorExceptionHandler', 'exception']);
set_error_handler(['Loopless\Kernel\ErrorExceptionHandler', 'native']);
register_shutdown_function(['Loopless\Kernel\ErrorExceptionHandler', 'shutdown']);

// The debug handler
require_once ROOT_PATH . 'app/debug.php';

// Set default timezone based on application config
date_default_timezone_set(config()->get('app.timezone')); 

// Bootstrap the app with routes and other depedencies
$app->bootstrap();