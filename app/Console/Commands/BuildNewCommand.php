<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class BuildNewCommand extends Command
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
     * Loading all patternized methods related to new commands
     */
    use \App\Console\EditsConcern\NewConcern;
    
    /**
     * Configuring the cli command for building new contents.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('build:new')
             ->setDescription("Builds new contents only without touching edits or anything published before.");
    }

    /**
     * Build new executer
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Checking for new contents while the
        // database index repository has not been built yet.
        if( $this->tryConnectDatabaseRepository($output) ) {

            $this->runNewContentsBuilder($output);
            
            // Skip the process in case finder fails in finding any contents
            if( ! $this->finderHasResults ) {
                $this->printFinderNewFilesNotFound($output);
                return 1;
            }

            // When there are no new contents available for publishing
            if( static::$countingNewArticles === 0 ) {
                $this->printInfoNoEditsAvailable($output);
                return 1;

            } else {
                // rebuild database index repository with latest changes
                $this->buildDatabaseIndex();
                // print console notification related to update
                $this->printAsBuiltNewContents($output, static::$countingNewArticles);
                return 0;
            }

        } else {
            $this->printAsHavingNewContentsWithoutDatabase($output, 0);
            return 1;
        }
    }
}