<?php

namespace App\Console;

class Console
{
    /**
     * @var \Core\Console\Application
     */
    protected $console;

    /**
     * @var \Core\Kernel\Application
     */
    protected $application;

    /**
     * @var array Application base command list
     */
    protected $commandList = [
        /**
         * Builds all, everything, anyway, anytime.
         */
        Commands\BuildCommand::class,
        /**
         * Build new articles
         */
        Commands\BuildNewCommand::class,
        /**
         * Build contents edited on already published articles.
         */
        Commands\BuildEditsCommand::class,
        /**
         * Determine if there are any markdown files deleted.
         */
        Commands\HasDeletesCommand::class,
        /**
         * Determine if there are any edits on published articles.
         */
        Commands\HasEditsCommand::class,
        /**
         * Determine if there are any new markdown contents ready to publish.
         */
        Commands\HasNewCommand::class,
    ];

    /**
     * @var array Application migration tool Command list
     */
    protected $migrationCommands = [
    ];

    /**
     * @var array The commands provided by your application.
     */
    protected $commands = [];

    /**
     * Set console application.
     *
     * @param \Symfony\Component\Console\Application $consoleApp
     * @param \Core\Kernel\Application $app
     *
     * @return void
     */
    function __construct($consoleApp)
    {
        $this->console = $consoleApp;
        $this->generate();
    }
    /**
     * Generate all Command class.
     *
     * @return void
     */
    public function generate()
    {
        // Create application commands
        foreach ($this->commandList as $key => $value) {
            $this->console->add(new $value());
        }

        // Create custom application commands provided by user
        foreach ($this->commands as $key => $value) {
            $this->console->add(new $value());
        }
    }

    /**
     * Run console commands.
     *
     * @return void
     * @throws
     */
    public function run()
    {
        $this->console->run();
        exit();
    }
}