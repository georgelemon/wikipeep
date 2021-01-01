<?php

namespace App\Console;

trait ConsoleMessages
{
    /**
     * Symfony Console to print notification after edits have been published
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function editsHaveBeenPublished($output)
    {
        $output->writeln($this->addBreakline(1) . "All your edits have been published!");
        $output->writeln("Everything is up to date 👌" . $this->addBreakline(1));
    }

    /**
     * Symfony Console to print errors while no records found.
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function noRecordsFound($output)
    {
        $output->writeln($this->addBreakline(1) . "<error>😓 No records found.</error>");
        $output->writeln("<info>Looks like the database index repository is missing, most probably because you forgot to run the build for new contents.</info>");
        $output->writeln("1. Use artisan build:new to build your first contents.");
        $output->writeln("2. Use artisan build:all to build new contents & rebuild anything previously published." . $this->addBreakline(1));
    }

    /**
     * Symfony Console Error that gets printed when
     * there are no markdown files in /content/ directory
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printErrorNoMarkdownFiles($output)
    {
        $output->writeln($this->addBreakline(1) . "<error>Something Wrong 😵 Finder couldn't find any contents.</error>");
        $output->writeln("<info>Write your markdown contents inside content directory.</info>" . $this->addBreakline(1));
    }

    /**
     * Symfony Console info message that gets printed when
     * there are no available updates on articles.
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printInfoNoUpdatesAvailable($output)
    {
        $output->writeln($this->addBreakline(1) . "<info>There are no edits available 👌</info>");
        $output->writeln("Up to date! There is nothing new, yet." . $this->addBreakline(1));   
    }

    /**
     * Symfony Console notification to be printed
     * when there are no unpublished edits.
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printInfoNoEditsAvailable($output)
    {
        $output->writeln($this->addBreakline(1) . "Everything is up to date 👌");
        $output->writeln("<info>All your edits are published.</info>" . $this->addBreakline(1));   
    }

    /**
     * Symfony Console notification to be triggered
     * when running php artisan has:edits and there are edits available.
     * 
     * @param  OutputInterface $output
     * @param  $counter                     The number of articles containing edits available for publishing.
     * @return void
     */
    private function printAsHavingEditsReadyForBuild($output, $counter)
    {
        $output->writeln($this->addBreakline(1) . "<info>You have $counter edits available for publishing</info>");
        $output->writeln("Publishing edits will not affect any other contents." . $this->addBreakline(1));   
    }
}
