<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

use App\Core\{
    Router, Registry,
    Encryption\Encrypter
};
use Dotenv\Dotenv;
use Illuminate\Support\Str;

trait ApplicationSetupScope {

    /**
     * If the key starts with "base64:", we will need to decode the key before handing
     * it off to the encrypter. Keys may be base-64 encoded for presentation and we
     * want to make sure to convert them back to the raw bytes before encrypting.
     */
    private function registerEncrypter()
    {
        $config = $this->config()->get('app');

        if (Str::startsWith($key = $config['key'], 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return new Encrypter($key, $config['cipher']);
    }


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
    protected function initializeRegistry() : void
    {
        static::$registry = new Registry;
    }

    /**
     * {inheritdoc}
     */
    protected function initializeRouter() : void
    {
        static::$router = new Router;
    }

}