<?php

namespace App\Console\EditsConcern;

use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Output\OutputInterface;

trait NewConcern
{
    /**
     * Holds the current results from Symfony Finder
     * @var Symfony Finder object
     */
    protected $finderFileResults;

    /**
     * Holds a local status of the latest Finder search instance.
     * @var boolean
     */
    protected $finderHasResults = false;

    /**
     * Determine if this is a build mode instance, otherwise a checking mode
     * @var boolean
     */
    protected $inBuildMode = false;

    /**
     * When updates available it will count how many articles
     * needs to be updated in order to create the Console Loader
     * @var int
     */
    protected static int $countingNewArticles = 0;

    /**
     * Holds the existing (published already) markdown files paths
     * @var array
     */
    protected array $existingContents = [];

    /**
     * Runs the new contents checker to determine if there
     * are any new contents available for build while running:
     * 
     * 'artisan has:new' or 'artisan build:new'
     * 
     * @return void
     */
    protected function runNewContentsChecker(OutputInterface $output)
    {
        $this->setCurrentIndexLocal();

        // In order to know what's new, first we need to make a 
        // list with all existing contents and their paths so we can pass
        // to Finder in order to exclude them from searching.
        $this->createListingExistingContents();

        // Try run a Finder instance and search for available markdown files.
        // If fails, it will set a console notification message and skip the process
        $newContents = $this->finderGetNewFiles($this->getExistingContents());

        // Skip the process in case finder fails in finding any new contents
        if( ! $this->finderHasResults ) {
            return false;
        }

        // $this->startIterateContents();
    }

    /**
     * Creating a list with all existing contents that will be used
     * for determining what's new and whats already published.
     * 
     * @return array
     */
    private function createListingExistingContents()
    {
        foreach ($this->storedIndexes as $category => $articles) {
            // var_dump($category);
            foreach ($articles as $articleKey => $article) {
                $this->existingContents[] = $this->getFullPathOf($article->source, $prefixedSlash = true);
            }
        }
    }

    /**
     * Retreive all existing markdown files from the
     * last database index repository, that have been already published before.
     * 
     * @return array
     */
    private function getExistingContents()
    {
        return $this->existingContents;
    }
}