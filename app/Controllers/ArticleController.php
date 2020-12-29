<?php

namespace App\Controllers;

use Exception;

class ArticleController extends BaseController {

    public function index()
    {

        $directory = strip_tags(request()->segment(1));
        $articleId = strip_tags(request()->segment(2));

        // In case the article id is /index it will redirect to root of the category
        // in order to prevent duplicated contents.
        if( $articleId === 'index' ) {
            return response()->redirect($directory);
        }

        // Try retrieve the article based on the ID provided from Request
        if( $article = flywheel()->getById($articleId, $directory)) {
            return $this->layout('home', 'base', $article);
        }

        return $this->layout('404', 'base');
    }

    /**
     * Retrieve the aside helper box when available.
     * 
     * @return string | null
     */
    protected function getAsideHelperBox()
    {

    }
}