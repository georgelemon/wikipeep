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

    /**
     * Symfony Console notification to be triggered
     * when running php artisan has:new and there are new contents available.
     * 
     * @param  OutputInterface $output
     * @param  $counter                     The number of articles containing edits available for publishing.
     * @return void
     */
    private function printAsHavingNewContents($output, $counter = 2)
    {
        $output->writeln($this->addBreakline(1) . "<info>You have $counter new contents ready for publishing</info>");
        $output->writeln("Publishing new contents does not affect published already contents or edits." . $this->addBreakline(1));   
    }

    /**
     * Symfony Console notification to be triggered
     * when running php artisan has:new and there are new contents available,
     * without having a database index repository.
     * 
     * @param  OutputInterface $output
     * @param  $counter                     The number of new articles ready to publish.
     * 
     * @return void
     */
    private function printAsHavingNewContentsWithoutDatabase($output, $counter)
    {
        $output->writeln($this->addBreakline(1) . "<info>Looks like this is your first build! You have $counter new contents ready for publishing</info>");
        $output->writeln("When publishing for first time you will also build the search and navigation items." . $this->addBreakline(1));   
    }

    /**
     * Symfony Console notification to be triggered
     * when running php artisan has:new and there are new contents available.
     * 
     * @param  OutputInterface $output
     * @param  $counter                     The number of new articles ready to publish.
     * 
     * @return void
     */
    private function printAsHavingNewContentsWithDatabase($output, $counter)
    {
        $plural =  $counter === 1 ? 'article' : 'articles';
        $output->writeln($this->addBreakline(1) . "<info> 👏 You have $counter new $plural ready for publishing!</info>");
        $output->writeln("Publishing can be done with <info>artisan build:new</info> command" . $this->addBreakline(1));   
    }


    /**
     * Symfony Console notification to be printed
     * when Finder fails finding any markdown contents.
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printFinderFilesNotFound($output)
    {
        $output->writeln($this->addBreakline(1) . "<error>Finder could not find any markdown contents</error>");
        $output->writeln("Be sure you write your markdown files inside of /content/ directory and save them as .md files." . $this->addBreakline(1));   
    }
}
