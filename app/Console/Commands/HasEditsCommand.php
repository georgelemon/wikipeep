<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HasEditsCommand extends Command
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
    use \App\Console\EditsConcern\EditsConcern;

    /**
     * Holds temporary data while in loop
     * @var object | null
     */
    protected $storedIndexes;

    /**
     * Configuring the cli command for checking if there are
     * any unpublished edits.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('has:edits')
             ->setDescription("Determine if there are any unpublished edits, in case you forgot what you did last night.");
    }

    /**
     * Edits Check Executer
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

        $this->runCheckerBuilder($output);

        // Skip the process in case finder fails in finding any contents
        if( ! $this->finderHasResults ) {
            return 1;
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