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
     * Retreive the actual path of the project.
     *
     * @param  bool $slashed      Whether to add a slash between content path and the file path.
     * 
     * @return string 
     */
    protected function getFullPathOf($file, $slashed = false)
    {
        return $slashed ? CONTENT_PATH . DS . $file : CONTENT_PATH . $file;
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
     * @param  array|null $excludes     When available, an array with markdown paths that must be
     *                                  excluded from Finder search instance
     * 
     * @return bool | Symfony\Finder
     */
    protected function finderGetNewFiles($excludes = null)
    {
        if( $excludes ) {
            
            $contents = $this->finderGetContents();
            if( ! $contents->hasResults() ) {
                return false;
            }

            $newContents = [];
            foreach ($contents as $key => $markdown) {
                $markdown->getRealPath();
                
                if( ! in_array($markdown->getRealPath(), $excludes) ) {
                    $newContents[] = $markdown;
                    static::$countingNewArticles++;
                }
            }

            static::$countingNewArticles > 0 ?  $this->finderHasResults = true : $this->finderHasResults = false;

            return $newContents;
        }
        
        // When there are no contents published before we just return
        // the original get contents finder instance.
        return $this->finderGetContents();
    }
}