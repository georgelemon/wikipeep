<?php

namespace App\Console\BuildConcerns;

trait Misc
{
    /**
     * Add a specific numbers of breaklines using PHP_EOL
     */
    protected function addBreakline($counts)
    {
        $breaks = '';
        for ($i=0; $i < $counts; $i++) { 
            $breaks .= PHP_EOL;
        }

        return $breaks;
    }
}