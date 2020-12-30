<?php

namespace App\Controllers;

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
     * @var bool
     */
    protected $hasHeading = false;

    /**
     * The main method that handles GET request.
     * 
     * @return Response View
     */
    public function index()
    {
        $repository = request()->segment(1);
        $this->categoryId = $repository;

        // First, try look if the current category has an index.json stored
        // in repository. This index.json is by default automatically created
        // whenever you create an index.md inside a directory.
        if( $article = flywheel()->getById('index', $repository)) {
            return $this->layout('home', 'base', $article);

        // Otherwise, it will treat the root page of the category with
        // page an auto-index containing a list with all the page screens.
        // @todo pagination
        } else {
            
            $this->setCategorySettingsIfAny();
            $getArticles = $this->getContent($repository);

            return $getArticles ? $this->layout('category', 'base', $getArticles) : $this->layout('404', 'base');
        }
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
            // By default, Flywheel it will make a basic query,
            // ignoring possible __settings.json that is related to category screen.
            // Also, when has results will show them in desending order based on update time
            return $results->orderBy('__update DESC')->where('__id', '!=', '__settings')->execute();
        } else {
            return $this->getNotFoundContentNotice();
        }
    }

    /**
     * Retrieve from available __settings.json relevant data
     * related to category heading. 
     */
    protected function setCategorySettingsIfAny()
    {
        $this->categorySettings = flywheel()->getById('__settings', $this->categoryId, 'category');

        if( $this->categorySettings->heading ) {
            $this->hasHeading = true;

            $this->categorySettings->heading->title ? $this->hasHeadingTitle = true : null;
            $this->categorySettings->heading->lead ? $this->hasHeadingLead = true : null;
        }
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
     * Retrieve the Headline if any
     * @return string|null
     */
    protected function getCategoryHeadingTitle()
    {

    }

    /**
     * Retrieve the lead of the heading, if any
     * @return string|null
     */
    protected function getCategoryHeadingLead()
    {

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