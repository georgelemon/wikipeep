<?php declare(strict_types = 1);

namespace App\Core\Kernel;

use Exception;
use Ethos\Dessert\Library;
use App\Core\Flywheel;

class Application {

    /**
     * Application protected properties
     */
    use Traits\ApplicationProperties;

    /**
     * Make use of mutator methods
     */
    use Traits\ApplicationMutatorMethods;

    /**
     * Setup Finder and register configuration files
     */
    use Traits\ConfigurationFinder;

    /**
     * Creates a singleton Instance of the Application Container
     */
    use Traits\ContainerSingleton;

    /**
     * Other things that are going to be registered with the Applicaiton
     */
    use Traits\ApplicationSetupScope;

    /**
     * Setup the app
     */
    public function setup()
    {
        /**
         * Load Environment info
         * @see Dotenv\Dotenv
         */
        $this->setupEnvironment();

        /**
         * Boot with found config files and setup the Configuration class
         * @see App\Core\Config
         */
        $this->registerConfigurationFiles();

        /**
         * Connect all SQLite databases
         */
        // $this->database();
        // $this->createUsersDatabase();

        $this->initializeRouter();
        // $this->initializeRegistry();
        $this->loadWithPublicRoutes();
        $this->loadWithProviders();
    }

    /**
     * Loadin routes provided in the web file
     */
    protected function loadWithPublicRoutes()
    {
        require ROUTES_PATH . '/public.php';
    }

    protected function loadWithProviders()
    {
        // Initialize Dessert SVG Renderer
        new Library(CONFIG_PATH . DS . 'dessert.php');

        // Configurate a Flywheel Instance
        Flywheel::instance()->flywheelConfig();
    }

    /**
     * Bootstrap with registered routes
     */
    public function bootstrap() : void
    {
        $this->route()->run();
    }

}