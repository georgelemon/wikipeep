<?php

namespace App\Core;

use ErrorException;

/**
 * error class
 *
 * @package System
 */
class ErrorExceptionHandler
{
    /**
     * Error handler
     * This will catch the php native error and treat it as a exception
     * which will provide a full back trace on all errors
     *
     * @param string $code
     * @param string $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     *
     * @throws \ErrorException
     */
    public static function native($code, $message, $file, $line, $context)
    {
        if ($code & error_reporting()) {
            static::exception(new ErrorException($message, $code, 0, $file, $line));
        }
    }

    /**
     * Exception handler
     * This will log the exception and output the exception properties
     * formatted as html or a 500 response depending on your application config
     *
     * @param \Exception The uncaught exception
     *
     * @return void
     * @throws \ErrorException
     */
    public static function exception($e)
    {
        static::log($e);

        if (app()->config()->get('error.report')) {
            // clear output buffer
            while (ob_get_level() > 1) {
                ob_end_clean();
            }

                echo '<html>
                    <head>
                        <title>Uncaught Exception</title>
                        <style>
                            body{font-family:"Open Sans",arial,sans-serif;background:white;color:black;margin:2em}
                            code{background:#D1E751;border-radius:4px;padding:2px 6px}
                        </style>
                    </head>
                    <body>
                        <h1>Uncaught Exception</h1>
                        <p><code>' . $e->getMessage() . '</code></p>
                        <h3>Origin</h3>
                        <p><code>' . substr($e->getFile(), strlen(ROOT_PATH)) . ' on line ' . $e->getLine() . '</code></p>
                        <h3>Trace</h3>
                        <pre style="background-color:antiquewhite; color:black; padding:25px; border-radius:5px;">' . $e->getTraceAsString() . '</pre>
                    </body>
                    </html>';
        } else {
            // issue a 500 response
            // response()->error(500, ['exception' => $e])->send();
        }

        exit(1);
    }

    /**
     * Exception logger
     * Log the exception depending on the application config
     *
     * @param object The exception
     */
    public static function log($e)
    {
        if (is_callable($logger = app()->config()->get('error.log'))) {
            // call_user_func($logger, $e);
        }
    }

    /**
     * Shutdown handler
     * This will catch errors that are generated at the shutdown level of execution
     *
     * @return void
     * @throws \ErrorException
     */
    public static function shutdown()
    {
        if ($error = error_get_last()) {

            /** @var string $message */
            /** @var string $type */
            /** @var string $file */
            /** @var int $line */
            extract($error);

            static::exception(new ErrorException($message, $type, 0, $file, $line));
        }
    }
}