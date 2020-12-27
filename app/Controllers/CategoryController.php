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
                'content' => 'Index',
                'summary' => null
            ]);
        }
    }
}