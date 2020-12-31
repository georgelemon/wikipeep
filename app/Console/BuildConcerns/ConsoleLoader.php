<?php

namespace App\Console\BuildConcerns;

use Symfony\Component\Console\Helper\ProgressBar;

trait ConsoleLoader
{
    /**
     * Start the console progress bar
     * 
     * @param  [type] $output [description]
     * @param  [type] $count  [description]
     * 
     * @return [type]         [description]
     */
    protected function startLoader($output, $count)
    {
        $this->progressBar = new ProgressBar($output, $count);
        $this->progressBar->start();
    }

    /**
     * A progress bar advancer, by default with 1
     * 
     * @param  integer $step
     * 
     * @return void
     */
    protected function inProgress($step = 1)
    {
        $this->progressBar->advance($step);
    }

    /**
     * Finish the current progress bar
     * @return void
     */
    protected function finishLoader()
    {
        $this->progressBar->finish();
    }
}