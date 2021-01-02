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
     * @return void | false
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
    }

    /**
     * Runs the new contents checker to determine if there
     * are any new contents available for build while running:
     * 
     * 'artisan has:new' or 'artisan build:new'
     * 
     * @return void | false
     */
    protected function runNewContentsBuilder(OutputInterface $output)
    {
        $this->setCurrentIndexLocal();

        // In order to know what's new, first we need to make a 
        // list with all existing contents and their paths so we can pass
        // to Finder in order to exclude them from searching.
        $this->createListingExistingContents();

        // Try run a Finder instance and search for available markdown files.
        // If fails, it will set a console notification message and skip the process
        $this->finderFileResults = $this->finderGetNewFiles($this->getExistingContents());

        // Skip the process in case finder fails in finding any new contents
        if( ! $this->finderHasResults ) {
            return false;
        }
        
        $this->parsedown     = new Parsedown;    // set the Parsedown handler while in build mode
        $this->startIterateContents();
    }

    /**
     * Strat the big loop where we check each NEW markdown file,
     * parse its contents, validate and build the contents
     * 
     * @return [type] [description]
     */
    private function startIterateContents()
    {
        foreach ($this->finderFileResults as $key => $article) {

            // Retrieve the markdown file path
            $markdownStructure = $this->getIndexStructure($article->getPathName());

            // Create the structure of directories
            $categoryId = $this->getDirectoriesPath($markdownStructure);

            // Get the name of the article including its slugified version
            $articleMeta = $this->getArticleName( $markdownStructure );
            // $articleSlug = $articleMeta['slug'];

            $this->updateArticleById($articleMeta, $categoryId, $article, $this->storedIndexes);
            static::$countingNewArticles++;
        }
    }
}