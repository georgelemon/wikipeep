<?php

namespace App\Controllers;

class CategoryController extends BaseController
{

    /**
     * The main method that handles GET request.
     * 
     * @return Response View
     */
    public function index()
    {
        $repository = request()->segment(1);

        // First, try look if the current category has an index.json stored
        // in repository. This index.json is by default automatically created
        // whenever you create an index.md inside a directory.
        if( $article = flywheel()->getById('index', $repository)) {
            return $this->layout('home', 'base', $article);

        // Otherwise, it auto creates an index page
        // containing a list with all the page screens.
        } else {
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
            return $results->orderBy('__update DESC')->execute();
        } else {
            // return $this->getNotFoundContentNotice();
            return null;
        }
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