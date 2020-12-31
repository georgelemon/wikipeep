<?php

namespace App\Console\BuildConcerns;

use Symfony\Component\Finder\Finder;

trait FinderInstance
{

    /**
     * Get the content directory path.
     * 
     * @var string
     */
    protected static $CNTSPTH = CONTENT_PATH;

    /**
     * The Finder Instance
     * 
     * @return Symfony\Finder
     */
    private function finder()
    {
        return new Finder;
    }

    /**
     * Get all contents with Finder.
     * 
     * @return Symfony\Finder
     */
    protected function finderGetContents()
    {
        return $this->finder()->files()->in(self::$CNTSPTH)->name('*.md')->sortByName();
    }

    /**
     * Get directory structure with Finder.
     * 
     * @param  string $level     The maximum depth level where Finder can go
     * 
     * @return Symfony\Finder
     */
    protected function finderGetDirectories($level = null)
    {
        return $level ? $this->finder()->directories()->in(self::$CNTSPTH)->sortByName()->depth($level) :
                        $this->finder()->directories()->in(self::$CNTSPTH)->sortByName();
    }

    /**
     * Get new contents with Finder by excluding existing ones.
     * 
     * @return Symfony\Finder
     */
    protected function finderGetNewFiles()
    {
        $this->finder()->files()->notName();
    }
}