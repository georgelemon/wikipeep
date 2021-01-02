<?php

namespace App\Console\Commands;

use DateTime;
use App\Core\Compiler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class BuildEditsCommand extends Command
{

    /**
     * Database Repository Index
     */
    use \App\Console\BuildConcerns\DatabaseIndex;

    /**
     * Symfony\Finder Instance for getting the right files
     */
    use \App\Console\BuildConcerns\FinderInstance;

    /**
     * Various helper methods used while building contents
     */
    use \App\Console\BuildConcerns\Misc;

    /**
     * Make use of File Information
     */
    use \App\Console\BuildConcerns\FileInformation;

    /**
     * Make use of Article methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\ArticleDetails;

    /**
     * Make use of Category methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\CategoryDetails;

    /**
     * Make use of Search methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\SearchDetails;

    /**
     * Make use of Navigation methods
     */
    use \App\Console\BuildConcerns\NavigationDetails;

    /**
     * Loading AsideBox methods in order to store data for
     * showing informational boxes displayed aside (sidebar).
     */
    // use \App\Console\BuildConcerns\AsideBoxDetails;

    use \App\Console\BuildConcerns\ConsoleLoader;

    /**
     * Use global console messages
     */
    use \App\Console\ConsoleMessages;

    /**
     * Loading all patternized methods related to edits commands
     */
    use \App\Console\EditsConcern\EditsConcern;

    /**
     * Holds temporary data while in loop
     * @var object | null
     */
    protected $storedIndexes;

    /**
     * Holds an instance of Parsedown
     * @var App\Core\Parsedown
     */
    protected $parsedown;

    /**
     * Configuring the cli command for caching everything.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('publish:edits')
             ->setDescription("Builds contents only for modified articles that are already published.");
    }

    /**
     * Cache Executer
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // Try connect to database repository index
        // in order to retrieve latest informations abour current build.
        // If fails, it will skip the process.
        if( ! $this->tryConnectDatabaseRepository($output) ) {
            return 1;
        }

        $this->runCheckBuilderAndBuilds($output);
        
        // Skip the process in case finder fails in finding any contents
        if( ! $this->finderHasResults ) {
            $this->printFinderFilesNotFound($output);
            return 1;
        }

        // No edits available for building again
        if( static::$countingArticles === 0 ) {
            $this->printInfoNoUpdatesAvailable($output);
            return 1;

        // If we got something, you also must to update the database repository
        // with the latest build and dates changes.
        } else {
            $this->buildDatabaseIndex();
            $this->editsHaveBeenPublished($output);
            return 0;
        }
    }

}