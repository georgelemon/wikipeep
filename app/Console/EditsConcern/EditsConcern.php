<?php

namespace App\Console\EditsConcern;

use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Edits Trait is currently used by two commands
 * 
 * Building Edits with 'artisan build:edits'
 * Which determine if there are any contents edited that needs to be published,
 * if so it will update the specific pages and recreated the database repository index.
 * 
 * Checking for edits with 'artisan has:edits'
 * Which is the boolean version of build:edits, and only checks if there are
 * any edited files that needs publishing.
 */
trait EditsConcern
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
    protected static int $countingArticles = 0;

    /**
     * Wraps multiple operations in one method, by making use of
     * the DatabaseIndex Concern and checking if there are records.
     *
     * If not, it will skip the process and print an info message via terminal.
     *
     * @param  OutputInterface $output
     *
     * @return boolean | Symfony Console Message
     */
    protected function tryConnectDatabaseRepository(OutputInterface $output)
    {
        $this->setDatabaseIndexStatement();
        
        if( ! $this->databaseIndexExists() ) {
            $this->noRecordsFound($output);
            return false;
        }

        return  true;
    }

    /**
     * Retreive the current database index stored in repository
     * by a Flywheel Instance.
     */
    protected function setCurrentIndexLocal()
    {
        $this->storedIndexes = $this->getStoredDatabaseIndex()[0]->indexes;
    }

    /**
     * Try retreive markdown files stored in /content/ directory
     *
     * @param  OutputInterface $output
     * 
     * @return void;
     */
    protected function finderGetMarkdownFiles(OutputInterface $output)
    {
        // Finder gets all the markdowns placed in contents directory
        $contents = $this->finderGetContents();

        // In case there are no results will print an error
        // and guide the dev to use first build:all command
        if( ! $contents->hasResults() ) {
            
            $this->printErrorNoMarkdownFiles($output);
            return $this->finderHasResults; // return default false
        }

        $this->finderHasResults  = true;             // set as having results
        $this->finderFileResults = $contents;        // set the results locally
        
        if( $this->inBuildMode ) {
            $this->parsedown     = new Parsedown;    // set the Parsedown handler while in build mode
        }
    }

    /**
     * Strat the big loop where we check each markdown file, parse its contents,
     * validate and so on.
     * 
     * @return [type] [description]
     */
    protected function startIterateContents()
    {
        foreach ($this->finderFileResults as $key => $article) {

            // Retrieve the markdown file path
            $markdownStructure = $this->getIndexStructure($article->getPathName());

            // Retrieve the last time modified info from file
            $ltm = (array) $this->getLastTimeModifiedFormatted($article->getRealPath());

            // Create the structure of directories
            $categoryId = $this->getDirectoriesPath($markdownStructure);

            // Now, check if the category of the current iterated article
            // has been already published previously.
            if( $this->hasPublicCategory($categoryId)) {

                // Get the name of the article including its slugified version
                $articleMeta = $this->getArticleName( $markdownStructure );
                $articleSlug = $articleMeta['slug'];

                $itsCategory = $this->storedIndexes->$categoryId;

                foreach ($itsCategory as $aKey => $storedArticleIndex) {

                    if( $storedArticleIndex->article_id === $articleSlug ) {
                        
                        // Determine if the article needs to be updated
                        if( $this->articleNeedsUpdate($ltm, $storedArticleIndex) ) {
                            
                            static::$countingArticles++;

                            // When in build mode we are going to update the
                            // articles containing edits that should be published
                            if( $this->inBuildMode ) {
                                $this->updateArticleById($articleMeta, $categoryId, $article, $this->storedIndexes);

                            // Otherwise, will just check which files are avilable
                            // and print them nicely via terminal
                            } else {

                            }

                        } else {
                            // While in build mode but still there are no edits available
                            if( $this->inBuildMode ) {

                            // While in checking mode...
                            } else {

                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Runs the checker builder and builds the contents.
     * 
     * @return void
     */
    protected function runCheckBuilderAndBuilds(OutputInterface $output)
    {
        $this->setCurrentIndexLocal();
        $this->inBuildMode = true;                  // mark as build mode

        // Try run a Finder instance and search for available markdown files.
        // If fails, it will set a console notification message and skip the process
        $this->finderGetMarkdownFiles($output);

        // Skip the process in case finder fails in finding any contents
        if( ! $this->finderHasResults ) {
            return false;
        }

        $this->startIterateContents();

    }

    /**
     * Runs the checker builder only. Mainly used when running
     * artisan has:edits, and artisan build:edits
     * 
     * @return void
     */
    protected function runCheckerBuilder(OutputInterface $output)
    {
        $this->setCurrentIndexLocal();

        // Try run a Finder instance and search for available markdown files.
        // If fails, it will set a console notification message and skip the process
        $this->finderGetMarkdownFiles($output);

        // Skip the process in case finder fails in finding any contents
        if( ! $this->finderHasResults ) {
            return false;
        }

        $this->startIterateContents();
    }
}