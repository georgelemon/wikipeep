<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HasNewCommand extends Command
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
     * Configuring the cli command.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('has:new')
             ->setDescription("Checking if there are any new contents that must be published");
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
        // Checking for new contents while the
        // database index repository has not been built yet.
        if( $this->tryConnectDatabaseRepository($output) ) {

            $this->runNewContentsChecker($output);
            
            // Skip the process in case finder fails in finding any contents
            if( ! $this->finderHasResults ) {
                $this->printFinderFilesNotFound($output);
                return 1;
            }

            // No edits available for building again
            if( static::$countingNewArticles === 0 ) {
                $this->printInfoNoEditsAvailable($output);
                return 1;

            // If we got something, you also must to update the database repository
            // with the latest build and dates changes.
            } else {
                $this->printAsHavingNewContentsWithDatabase($output, static::$countingNewArticles);
                return 0;
            }

            $this->printAsHavingNewContentsWithoutDatabase($output);
            return 0;
        }


        // No edits available for building again
        if( static::$countingArticles === 0 ) {
            $this->printInfoNoEditsAvailable($output);
            return 1;

        // If we got something, you also must to update the database repository
        // with the latest build and dates changes.
        } else {
            $this->printAsHavingEditsReadyForBuild($output, static::$countingArticles);
            // $this->buildDatabaseIndex();
            // $this->editsHaveBeenPublished($output);
            return 0;
        }
    }
}