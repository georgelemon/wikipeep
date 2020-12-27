<?php

namespace App\Core;

use DateTime;
use JamesMoss\Flywheel\{
    Config, Repository, Document
};

class Flywheel
{
    /**
     * Creates a singleton Instance of the Application Container
     */
    use Kernel\Traits\ContainerSingleton;

    /**
     * @var JamesMoss\Flywheel\Config
     */
    protected $flyConfig;

    /**
     * Setup the Flywheel instance
     * @return void
     */
    public function flywheelConfig(bool $returnConfig = false)
    {
        $this->flyConfig = new Config(STORAGE_PATH . DS . 'database');

        if( $returnConfig ) {
            return $this->flyConfig;
        }
    }

    /**
     * Try retrieve a article by ID.
     * 
     * @param  string $articleId
     * @param  string $repoName
     * 
     * @return mixed (array|false)
     */
    public function getById(string $articleId, string $repoName)
    {
        if( $article = $this->getRepository($repoName)->findById($articleId)) {
            return ['content' => unserialize($article->article), 'summary' => $article->summary];
        }

        return false;
    }

    /**
     * Retrieve the main navigation menu
     * @return array | null
     */
    public function getNavigation()
    {
        if( $nav = $this->getRepository('settings')->findById('navigation')) {
            return $nav->navigation;
        }        
    }

    /**
     * When available, retrieves the helper aside box.
     * 
     * @return 
     */
    public function getAsideBox()
    {
        if( $box = $this->getRepository('getting-started')->findById('asidebox')) {
            return ['label' => $box->label, 'message' => $box->message, '_boxColor' => $box->color];
        }
    }

    /**
     * Query for retrieving documents.
     * 
     * @param  string $repoName
     * 
     * @return mixed
     */
    public function query(string $repoName)
    {
        return $this->getRepository($repoName)->query();
    }

    /**
     * Callable when creating a new article.
     * 
     * @param  array  $content
     * @param  string $repoName
     * @param  string $articleId
     * 
     * @return void
     */
    public function create(array $content, string $repoName, $articleId) : void
    {
        // Set current date based on date zone
        $content['__update'] = date("Y-m-d H:i:s");

        // Instantiate Flywheel Document 
        $article = new Document($content);

        // Set the ID of the article
        $article->setId($articleId);

        // Retrieve an already created repository or create a new one
        // and store the compiled article inside.
        $this->getRepository($repoName)->store($article);
    }

    /**
     * Get Flywheel repository
     * @return [type] [description]
     */
    protected function getRepository($repoName)
    {
        return new Repository($repoName, $this->flyConfig ?? $this->flywheelConfig(true));
    }
}