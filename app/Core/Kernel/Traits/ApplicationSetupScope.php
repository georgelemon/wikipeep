<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

use Dotenv\Dotenv;
use App\Core\Router;
use Illuminate\Support\Str;

trait ApplicationSetupScope {

    /**
     * Setup and Load dot Environment file
     * @see Dotenv\Dotenv
     */
    private function setupEnvironment() : void
    {
        try {
            $env = Dotenv::createImmutable(ROOT_PATH);
            $env->load();
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }
    /**
     * {inheritdoc}
     */
    protected function initializeRouter() : void
    {
        static::$router = new Router;
    }

}