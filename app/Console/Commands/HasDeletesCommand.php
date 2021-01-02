<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class HasDeletesCommand extends Command
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
     * Loading the Console Loader feature
     */
    use \App\Console\BuildConcerns\ConsoleLoader;

    /**
     * Use global console messages
     */
    use \App\Console\ConsoleMessages;

    /**
     * Loading all patternized methods related to edits commands
     */
    use \App\Console\EditsConcern\DeletesConcern;

    /**
     * Configuring the cli command
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('has:deletes')
             ->setDescription("Determine if there are any markdown files deleted from content directory.");
    }

    /**
     * The Executer
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Try connect to database repository with indexes.
        // In case is missing then skip the process and prints info notification.
        if( ! $this->tryConnectDatabaseRepository($output) ) {
            $this->noRecordsFound($output);
            return 1;
        }

        $this->runDeletesChecker($output);

        // Skip with a specific info message in case finder
        // has not found any deleted articles.
        if( ! $this->finderHasResults ) {
            $this->printFinderDeletedFilesNotFound($output);
            return 1;
        }

        $this->printAvailableDeletesForUpdate($output, static::$countingDeletes);
        return 0;
    }
}