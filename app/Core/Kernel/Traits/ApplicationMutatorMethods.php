<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

trait ApplicationMutatorMethods {

    /**
     * Initialize the Application with a blind setup used for Cron tasks
     * @see App\Core\Config
     */
    public function blindSetup($_storagePath, $_configPath) : void
    {
        $this->registerConfigurationFiles($_storagePath, $_configPath);
        new Config($this->config);
    }

    /**
     * Returns an instance of the Registry
     * @see App\Core\Registry
     */
    public function registry()
    {
        return static::$registry;
    }

    /**
     * Returns an instance of Str Helper
     * @see Illuminate\Support\Str
     */
    public function support()
    {
        return new \Illuminate\Support\Str;
    }

    public function config()
    {
        return new \App\Core\Config;
    }

    /**
     * @return an Instance of Fileystem
     */
    public function filesystem()
    {
        return new \Illuminate\Filesystem\Filesystem;
    }

    /**
     * @return an instance of Collection
     */
    public function collection($array = [])
    {
        return new \Illuminate\Support\Collection($array);
    }

    /**
     * @return an instance of Collection
     */
    public function encrypter($array = [])
    {
        return new \App\Core\Encryption\Encrypter;
    }

    /**
     * Retrieve the contents
     */
    public function getContents()
    {
        return static::$articleIds;
    }

    public function validator()
    {
        return new \App\Core\Components\Validator;
    }

    /**
     * Returns an instance of the Router
     * @see App\Core\Router
     */
    public function route()
    {
        return static::$router;
    }

}