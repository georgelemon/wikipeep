<?php

namespace App\Core;

class Compiler
{

    use Kernel\Traits\ConfigurationFinder;

    /**
     * @var Symfony\Component\Finder
     */
    protected $finder;

    /**
     * Instantiate Finder
     */
    public function __construct()
    {

    }

}