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
        if( is_file(ROOT_PATH . '/.env') ) {
            $env = Dotenv::createImmutable(ROOT_PATH);
            $env->load();     
        } else {
            print 'The <code>.env</code> file is missing from your project. Copy from <code>.env.sample</code> to <code>.env</code>';
            exit;
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