<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class SampleCommand extends Command
{
    /**
     * Configuring the cli command
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('type:command')
             ->setDescription("A short description that tells what is this about");
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
        
    }
}