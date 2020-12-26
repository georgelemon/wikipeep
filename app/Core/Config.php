<?php

namespace App\Core;

use ArrayAccess;
use Illuminate\Support\Arr;

class Config implements ArrayAccess
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * 
     */
    private static $instance;

    /**
     * Create a new configuration repository.
     *
     * @param  array $items
     *
     * @return void
     */
    public function __construct(array $items = [])
    {

        if( ! self::$instance ) {    
            $this->items = $items;
            self::$instance = $this->items;

        } else {
            $this->items = self::$instance;
        }
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return Arr::has($this->items, $key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string $key
     * @param  mixed        $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }

    /**
     * Get many configuration values.
     *
     * @param  array $keys
     *
     * @return array
     */
    public function getMany($keys): array
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string $key
     * @param  mixed        $value
     *
     * @return void
     */
    public function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            // Arr::set($this->items, $key, $value);
            Arr::set(self::$instance, $key, $value);
        }

        $this->items = self::$instance;
    }    

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function prepend($key, $value): void
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function push($key, $value): void
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param  string $key
     *
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->set($key, null);
    }
}