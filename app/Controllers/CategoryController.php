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
        $categorySlug = request()->segment(1);

        // First, try look if the current category has an index.json stored
        // in repository. This index.json is by default automatically created
        // whenever you create an index.md inside a directory.
        if( $article = flywheel()->getById('index', $categorySlug)) {
            return $this->layout('home', 'base', [
                'content' => $article['content'], 'summary' => $article['summary']
            ]);

        // Otherwise, it auto creates an index page
        // containing a list with all the page screens.
        } else {
            return $this->layout('home', 'base', [
                'title' => 'Getting Started',
                'content' => $this->getContent(),
                'summary' => null
            ]);
        }
    }

    /**
     * Try retrieve the content of the category or show the default notice
     * 
     * @return string
     */
    protected function getContent()
    {
        return $article['content'] ?? $this->getNotFoundContentNotice();
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