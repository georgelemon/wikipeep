<?php declare(strict_types = 1);

namespace App\Core\Kernel\Traits;

use Exception;
use App\Core\Config;
use Symfony\Component\Finder\Finder;

trait ConfigurationFinder {

    /**
     * A multidimensional array that holds all the configuration files
     * @var array
     */
    protected array $config = [];

    /**
     * Booting with available configuration files.
     *
     * @todo add the registered configs to a registry file for quick response
     * @todo registry file should be available only when the environment is set as TEST/PRODUCTION
     */
    protected function registerConfigurationFiles(string $_storagePath = null, string $_configPath = null) {

        if( $_storagePath ) {
            $directory = $_storagePath;
        } else {
            $directory = STORAGE_PATH . DS;
        }

        if( $_configPath ) {
            $config_path = $_configPath;
        } else {
            $config_path = CONFIG_PATH . DS;
        }

        try {

            if (file_exists($directory . 'config.php')) {
                $this->config = require $directory . 'config.php';
            } else {
                $this->loadConfigurationFiles($config_path);
            }

        } catch (Exception $e) {
            die(printf(
                "Configuration information could not be retrieved properly.\nError Message: %s",
                $e->getMessage()
            ));
        }

        new Config($this->config);

    }

    /**
     * Initialize an instance of Finder
     * @see Symfony\Component\Finder\Finder
     */
    public function finder(string $directory, $fileType = 'php')
    {
        $finder = new Finder;

        return $finder->files()->in($directory)
                      ->name('*.' . $fileType)
                      ->sortByName();
    }

    /**
     * Loads application configuration files using a Finder instance
     */
    protected function loadConfigurationFiles($directory) : void
    {

        /**
         * Call Finder to parse all the configuration files from any depth level.
         */
        $configs = $this->finder($directory);

        foreach ($configs as $key => $config) {
            
            $keyName = strtolower(str_replace([$directory, '.php'], '', $key));

            $file = $config->getRealPath();
            $this->config[ $keyName ] = require $file;

        }

    }
}