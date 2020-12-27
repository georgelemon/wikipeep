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

        // Checking if the current theme is correctly setup
        // and it stylesheet is public available.
        // 
        // If not, it will try to automatically
        // move the stylesheets to the correct path.
        if( ! $this->isThemePublicAvailable() ) {
            $this->moveStylesheetFromSource();
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
     * Retrieve the current theme
     * based on current configurations.
     *
     * @param  string $file  A file name including its extension
     * 
     * @return string
     */
    public function getCurrentTheme($file = null)
    {
        $baseThemePath = $this->themesPath . DS . $this->themeName;
        return $file ? $baseThemePath . DS . $file : $baseThemePath;
    }

    /**
     * Retrive the the media link to the stylesheet including HTML link tag
     * @return string
     */
    public function getStylesheetTag()
    {
        return sprintf('<link rel="stylesheet" href="%s">', $this->getCurrentThemeStylesheet(true)) . PHP_EOL;
    }

    /**
     * Get public path of the current theme stylesheet
     * 
     * @return string
     */
    protected function getCurrentThemeStylesheet($getAsPublic = true)
    {
        $themePath = (DS .'assets/themes' . DS . $this->themeName . DS . 'style.css');
        return $getAsPublic ? $themePath : ROOT_PATH . DS . 'public' . $themePath;
    }

    /**
     * Try retreive the current theme stylesheet from source.
     * 
     * @return string
     * 
     * @throws Exception
     */
    protected function getStylesheetFromSource()
    {
        return $this->getCurrentTheme('style.css'); 
    }

    /**
     * Determine if the current theme
     * style is available to public.
     * 
     * @return boolean
     */
    protected function isThemePublicAvailable()
    {
        return $this->fileExist($this->getCurrentThemeStylesheet(false));
    }

    /**
     * When not found it will automatically move the
     * current theme stylesheet to public path.
     * 
     * @return void
     */
    protected function moveStylesheetFromSource()
    {
        $stylePath = $this->getStylesheetFromSource();
        if( ! $this->fileExist($stylePath) ) {
            throw new Exception("Error while trying to move the stylesheet of '$this->themeName' theme.<br>Looks like it does not have a style.css file or the file is not readable.");
        }

        $this->filesystem->move($stylePath, $this->getCurrentThemeStylesheet(false));
    }

    /**
     * A common method that tells if
     * a directory exist and if is also readable.
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
     * A common method that tells if a specific
     * file exist on disk or if is readable.
     * 
     * @param  string $path
     * 
     * @return boolean
     */
    protected function fileExist($path)
    {
        return $this->filesystem->isFile($path) &&
                $this->filesystem->isReadable($path);
    }

}