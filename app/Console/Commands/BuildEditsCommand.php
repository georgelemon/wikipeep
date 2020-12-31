<?php

namespace App\Console\Commands;

use App\Core\Compiler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
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
     * Configuring the cli command for caching everything.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('build:edits')
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
        $this->setDatabaseIndexStatement();

        // Checking if the meta repository exists
        if( $this->databaseIndexExists() ) {

            // Retrieve the stored index from repository
            $indexes = $this->getStoredDatabaseIndex()[0];
            var_dump($indexes);
            return 0;

        // Print error in case there are no records found related to edits and published
        } else {
            $output->writeln($this->addBreakline(1) . "<error>😓 No records found related to published articles.</error>");
            $output->writeln("<info>Use artisan build:new to build your first contents.</info>" . $this->addBreakline(1));
            return 1;
        }
    }

}