<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

trait ApplicationMutatorMethods {

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
     * Returns an instance of the Router
     * @see App\Core\Router
     */
    public function route()
    {
        return static::$router;
    }

}