<?php

namespace App\Core;

use Exception;
use Illuminate\Filesystem\Filesystem;

class Theme
{
    /**
     * Creates a singleton Instance
     */
    use Kernel\Traits\ContainerSingleton;

    /**
     * @var boolean
     */
    protected bool $themeSwitcher = false;

    /**
     * @var string
     */
    protected string $themeName = 'default';

    /**
     * @var Illuminate\Filesystem\Filesystem
     */
    protected ?object $filesystem;

    /**
     * Holds the path of themes directories on disk
     * @var string
     */
    protected $themesPath;

    /**
     * Configurate Theme instance.
     * 
     * @param  array $theme        A valid array with all settings related to theme functionality
     * 
     * @return void
     */
    public function configurate(array $theme) : void
    {
        $this->filesystem = new Filesystem;
        $this->themeSwitcher = $theme['switch_mode'] ?? true;
        $this->themeName = $theme['name'] ?? $this->themeName;
        $this->themesPath = THEMES_PATH;

        // Gets fired when the root of themes is missing or not readable
        if( ! $this->themesDirectoryExist() ) {
            throw new Exception("The 'themes' directory is missing from root of the application or is not readable.");
        }

        // Gets fired when the requested theme does not exist or is not readable
        if( ! $this->themeExist() ) {
            throw new Exception("The requested theme with '$this->themeName' name does not exist on disk or is not readable (Missing read/write permissions).", 1);
        }
    }

    /**
     * Try retrieve the theme directory based on its name
     * @return [type] [description]
     */
    protected function getTheme()
    {
        try {
            
        } catch (Exception $e) {
            throw new Exception("Could not retrieve the theme.");
            
        }
    }

    /**
     * Determine if the directory root of themes exist and is readable.
     * 
     * @return boolean
     */
    protected function themesDirectoryExist()
    {
        return $this->directoryExist($this->themesPath);
    }

    /**
     * Determine if the requested theme exist on disk.
     * 
     * @return boolean
     */
    protected function themeExist()
    {
        return $this->directoryExist($this->getCurrentTheme());
    }

    /**
     * A common method that tells if a directory exist and if is also readable.
     * 
     * @param  string $path
     * 
     * @return boolean
     */
    protected function directoryExist($path)
    {
        return $this->filesystem->isDirectory($path) &&
               $this->filesystem->isReadable($path);
    }

    /**
     * Retrieve the current theme based on current configurations.
     * 
     * @return string
     */
    public function getCurrentTheme()
    {
        return $this->themesPath . DS . $this->themeName;
    }

}