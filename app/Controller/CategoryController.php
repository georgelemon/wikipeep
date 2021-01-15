<?php

namespace App\Controller;

use Loopless\Support\Paginator;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{

    /**
     * Holds the current category settings
     * @var array
     */
    protected $categorySettings;

    /**
     * Holds the current category articles
     * @var array
     */
    protected $categoryArticles;

    /**
     * Grabs default configurations provided in config/category.php
     * @var array
     */
    protected $categoryConfigs;

    /**
     * @var boolean
     */
    protected $hasHeading = false;

    /**
     * @var boolean
     */
    protected $withPagination = true;

    /**
     * Holds the current page number based on request URI
     * @var integer
     */
    protected $currentPage = 1;

    /**
     * @var object App\Core\Paginator
     */
    protected $paginator;

    /**
     * Holds the total number of published articles
     * @var int
     */
    protected int $total = 0;

    /**
     * Holds the current count of articles based on pagination
     * @var integer
     */
    protected int $count = 0;

    /**
     * Holds data when the category has a specific index markdown to show
     * @var array
     */
    protected $singleArticle;

    /**
     * The main method that handles GET request.
     * 
     * @return Response View
     */
    public function index()
    {
        $this->categoryId = request()->segment(1);;
        $this->categoryConfigs = config()->get('category');

        if( $contents = $this->getCategoryListing() ) {
            // return the view according to view type, whether is a listing type
            // or, with a specific index page via _settings.yaml
            $screenType = $this->hasIndexPage() ? 'article-screen' : 'category';
            return response($this->layout($screenType, 'base', $contents));
        }

        return response($this->layout('404', 'public'), 404);
    }

    /**
     * The pagination method that handles GET request
     * @return [type] [description]
     */
    public function pagination()
    {
        $this->categoryId = request()->segment(1);
        $this->currentPage = request()->segment(3);
        $this->categoryConfigs = config()->get('category');
        return $this->getCategoryListing();
    }

    /**
     * When available it will print the pagination
     * @return string | null
     */
    public function getPaginationElement()
    {
        return $this->withPagination ? $this->paginator->getPagination() : null;
    }

    /**
     * Retrieve the listing of the category
     */
    protected function getCategoryListing()
    {
        
        $this->categorySettings = flywheel()->getById('__settings', $this->categoryId, 'category');

        if( $this->hasIndexPage() ) {
            
            if( $this->singleArticle = flywheel()->getById($this->getIndexPage(), $this->categoryId) ) {
                return $this->singleArticle;
            }

        } else {
            
            $this->setCategorySettingsIfAny();
            $articles = $this->getContent($this->categoryId);

            if( $articles ) {

                $this->total = $articles->total();
                $this->count = $articles->count();

                if( $this->total > 0 && $this->count > 0 ) {
                    $this->hasPaginationConfig();
                    return $articles;
                }
            }
        }

        return false;
    }

    /**
     * Determine if the application has pagination set up.
     * 
     * @return boolean
     */
    protected function hasPaginationConfig()
    {
        if( !isset($this->categoryConfigs['per_page']) ) {
            $this->withPagination = false;
            return false;
        }

        if( $this->categoryConfigs['per_page'] === 0 || ! is_int($this->categoryConfigs['per_page']) ) {
            $this->withPagination = false;
            return false;
        }

        $baseUrl = $this->categoryId . DS . $this->categoryConfigs['base_url'] ?? 'page';

        $this->paginator = new Paginator($this->getTotal(), $this->getCurrentPage(), $this->getPerPage(), $baseUrl);

        return true;
    }

    /**
     * Retreive the configuration for pagination list.
     * 
     * @return integer
     */
    protected function getPerPage()
    {
        return $this->categoryConfigs['per_page'];
    }

    /**
     * Retrieve the current page based on request
     * @return int
     */
    protected function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Create an offset for Flywheel query based on current page,
     * and posts per page preference.
     * 
     * @return int
     */
    protected function getOffset()
    {
        if( $this->getCurrentPage() > 1 ) {
            return $this->getPerPage() * $this->getCurrentPage() - $this->getPerPage();
        }

        return 0;
    }

    /**
     * Try retrieve the content of the category or show the default notice
     *
     * @param  $repository  The name of the repository from request
     * 
     * @return string
     */
    protected function getContent($repository)
    {
        if( $results = flywheel()->query($repository)) {
            
            // Retrieve articles paginated based on given preferences
            if( $this->withPagination ) {
                
                $items = $results->orderBy('__update DESC')
                               ->where('__id', '!=', '__settings')                  // ignore __settings.json
                               ->limit($this->getPerPage(), $this->getOffset())
                               ->execute();

            // Otherwise list all articles
            } else {
                $items = $results->orderBy('__update DESC')->where('__id', '!=', '__settings')->execute();
            }

            return $items;

        }
        
        return false;
    }

    /**
     * Retrieve from available __settings.json relevant data
     * related to category heading. 
     */
    protected function setCategorySettingsIfAny()
    {
        if( ! $this->hasSettings('heading') )  {
            return false;
        }

        $this->hasHeading = true;
        isset($this->categorySettings->heading->title) ? $this->hasHeadingTitle = true : null;
        isset($this->categorySettings->heading->lead) ? $this->hasHeadingLead = true : null;
    }

    /**
     * Determine if the current category has any specific settings
     * provided via _settings.yaml.
     * 
     * @return boolean 
     */
    protected function hasSettings($key)
    {
        if( ! $this->categorySettings ) {
            return false;
        }

        if( $key ) {
            return $this->categorySettings->$key ? true : false;
        } else {
            return $this->categorySettings ? true : false;
        }
    }

    /**
     * Retrieve the available settings.
     * 
     * @return array
     */
    protected function getSettings($key)
    {
        if( $key ) {            
            return $this->categorySettings->$key ?? null;
        }

        return $this->categorySettings;
    }

    /**
     * When available in _settings.yaml, retrieves
     * the specific markdown page that should be displayed as index.
     * 
     * @return string
     */
    protected function getIndexPage()
    {
        return $this->getSettings('index');
    }

    /**
     * Determine if the current category has a specific index markdown
     * specified in _settings.yaml.
     * 
     * @return boolean
     */
    protected function hasIndexPage()
    {
        return $this->hasSettings('index');
    }

    /**
     * When available, it will show a heading and lead (both or one of them)
     * at the start of the page.
     * 
     * @return string
     */
    public function getCategoryHeading()
    {
        if( $this->hasHeading ) {
            
            $heading = '';
            if( $this->hasHeadingTitle ) {
                $heading = sprintf('<h1 class="mb-1">%s</h1>', $this->categorySettings->heading->title);
            }

            if( $this->hasHeadingLead ) {
                $heading .= sprintf('<p class="h4 font-weight-normal mb-4">%s</p>', $this->categorySettings->heading->lead);
            }

            return $heading;
        }
    }

    /**
     * Retrieve the total number of the articles
     * 
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Retrieve the current category slug
     * @return string
     */
    public function getCategorySlug()
    {
        return $this->categoryId;
    }

    /**
     * Retrieve the article permalink containing its category slug.
     *
     * @param  $articleId
     * 
     * @return string
     */
    public function getArticlePermalink( string $articleId )
    {
        return $this->getCategorySlug() . DS . $articleId;
    }

    /**
     * Retrieve the current counter of the article based on offset/pagination
     * @return integer
     */
    protected function getCounter()
    {
        return $this->count;
    }

    protected function getPublishedDate()
    {
        return get_formatted_date($this->singleArticle['__update']->date, 'Y-m-d H:i:s.u', 'Y-m-d');
    }

    /**
     * Get notification screen in case the content could not be retrieved
     *  
     * @return string 
     */
    protected function getNotFoundContentNotice()
    {
        return 'Hey, looks like this page does not have any content yet.';
    }
}