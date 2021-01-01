<?php

namespace App\Core;

use DateTime, DateTimeZone;
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
     * Holds temporary the last article id.
     * @var string
     */
    protected $articleCreationDateTime;

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
     * Try retrieve database index from disk.
     */
    public function getDatabaseIndex()
    {
        if( $repository = $this->getRepository('___', 'read')) {
            return $repository;
        }

        return false;
    }

    /**
     * Try retrieve a article by ID.
     * 
     * @param  string $articleId
     * @param  string $repoName
     * @param  string $screentype       Available options: 'article', 'category'
     * 
     * @return mixed (array|false)
     */
    public function getById(string $articleId, string $repoName, $screentype = 'article')
    {
        if( $repository = $this->getRepository($repoName, 'read')) {

            $data = $repository->findById($articleId);

            // Catching requests for non existing indexes that
            // should be treat as automatically generated indexes.
            // 
            // The generated category page is handled by CategoryController
            if( $articleId === 'index' && $data === false ) {
                return false;
            }

            if( $screentype === 'article' ) {
                return [
                    'content' => unserialize($data->article),
                    'summary' => $data->summary,
                    '__update' => $data->__update
                ];
            }

            return $data;
        }

        return false;
    }

    /**
     * Retrieve the main navigation menu
     * @return array | null
     */
    public function getNavigation()
    {
        if( $nav = $this->getRepository('settings', 'read')) {
            $nav = $nav->findById('navigation');
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
        if( $box = $this->getRepository('getting-started', 'read')) {
            $box = $box->findById('asidebox');

            if( $box ) return ['label' => $box->label, 'message' => $box->message, '_boxColor' => $box->color];
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
        if( $results = $this->getRepository($repoName, 'read')) {
            return $results->query();
        }
    }

    /**
     * Callable when creating a new article.
     * 
     * @param  array   $content
     * @param  string  $repoName
     * @param  string  $articleId
     * @param  bool    $withDate        Whether to add the update time or not
     * 
     * @return void
     */
    public function create(array $content, string $repoName, string $articleId, bool $withDate = true, bool $returnData = false)
    {
        // Set current date based on date zone
        if( $withDate === true ) {
            
            $timezone = config()->get('app.timezone');
            $uptm = DateTime::createFromFormat('Y-m-d H:i:s.u', date('Y-m-d H:i:s.u'));
            $uptm = $uptm->setTimezone( new DateTimeZone( $timezone ) );
            $content['__update'] = $uptm;

            $this->articleCreationDateTime = $content['__update'];
        }

        // Instantiate Flywheel Document 
        $article = new Document($content);

        // Set the ID of the article
        $article->setId($articleId);

        // Retrieve an already created repository or create a new one
        // and store the compiled article inside.
        $this->getRepository($repoName, 'write')->store($article);

        if( $returnData ) {
            return $this;
        }
    }

    /**
     * Retrieve the creation date of the previously created article.
     * Used by Symfony Console after article has been created in order to store
     * in a separate Flywheel Repository for tracking.
     * 
     * @return string
     */
    public function getCreationDateTime()
    {
        return $this->articleCreationDateTime;
    }

    /**
     * Flywheel repository
     * 
     * @param  string $repoName         the name of the repository
     * @param  string $mode             the type of the operation. available read|write
     * 
     * @return [type]           [description]
     */
    protected function getRepository($repoName, $mode)
    {
        // Prevent Flywheel creating a new repository when we just try to read data
        // In this case will use the second param $mode to determine the operation type
        if( $mode === 'read' ) {

            $this->flyConfig ?? $this->flywheelConfig(true);
            
            if( app()->filesystem()->isDirectory($this->flyConfig->getPath() . DS . $repoName) ) {
                return new Repository($repoName, $this->flyConfig);
            } else {
                return false;
            }

        } elseif( $mode === 'write' ) {
            return new Repository($repoName, $this->flyConfig ?? $this->flywheelConfig(true));
        }

    }
}