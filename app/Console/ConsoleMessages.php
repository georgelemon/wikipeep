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
        $output->writeln($this->addBreakline(1) . "<error>😓 No records found related to published articles.</error>");
        $output->writeln("<info>Use artisan build:new to build your first contents.</info>" . $this->addBreakline(1));
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
}