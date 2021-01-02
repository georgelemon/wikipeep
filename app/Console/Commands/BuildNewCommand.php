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
     * Configuring the cli command for building new contents.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('build:new')
             ->setDescription("Build new contents only without touching edits or anything published before.");
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

    }
}