<?php

namespace App;

use Loopless\Kernel\Application as BaseApplication;

class Application extends BaseApplication
{

    /**
     * @var App\Flywheel
     */
    protected $flywheel;

    /**
     * Application services that gets called on boot.
     * 
     * @return void
     */
    protected function bootApplicationServices()
    {
        $this->flywheel = Flywheel::instance();

        require APP_PATH . '/helper.php';
    }

    /**
     * Used by Symfony Console. Using only
     * the configuration files so it can be used via terminal.
     * 
     * @return void
     */
    public function headless()
    {
        $this->setupEnvironment();
        $this->bootApplicationServices();
        $this->registerConfigurationFiles();
    }

    /**
     * Return the instantited Flywheel.
     * 
     * @return App\Flywheel
     */
    public function flywheel()
    {
        return $this->flywheel;
    }
}