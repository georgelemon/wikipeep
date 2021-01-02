<?php

namespace App\Console\EditsConcern;

use Symfony\Component\Console\Output\OutputInterface;

trait DeletesConcern
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
     * Holds the number of deleted markdown articles
     * @var integer
     */
    protected static $countingDeletes = 0;

    /**
     * Try check for deleted articles, if any.
     * 
     * @param  OutputInterface $output
     * @return void
     */
    protected function runDeletesChecker(OutputInterface $output)
    {
        $this->setCurrentIndexLocal();
        // In order to know what's new, first we need to make a 
        // list with all existing contents and their paths so we can pass
        // to Finder in order to exclude them from searching.
        $this->createListingExistingContents();

        // Try run a Finder instance and search for available markdown files.
        // If fails, it will set a console notification message and skip the process
        $this->finderFileResults = $this->finderGetDeletedFiles($this->getExistingContents());

        // Skip the process in case finder fails in finding any new contents
        if( ! $this->finderHasResults ) {
            return false;
        }
        
    }
}