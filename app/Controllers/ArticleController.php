<?php

namespace App\Controllers;

use Exception;

class ArticleController extends BaseController {

    /**
     * Holds the article contents
     * @var array
     */
    protected $article;

    public function index()
    {

        $directory = request()->segment(1);
        $articleId = request()->segment(2);

        // In case the article id is /index it will redirect to root of the category
        // in order to prevent duplicated contents.
        if( $articleId === 'index' ) {
            return response()->redirect($directory);
        }

        // Try retrieve the article based on the ID provided from Request
        if( $this->article = flywheel()->getById($articleId, $directory)) {
            return $this->layout('home', 'base', $this->article);
        }

        return $this->layout('404', 'base');
    }

    protected function getPublishedDate()
    {
        return get_formatted_date($this->article['__update']->date, 'Y-m-d H:i:s.u', 'Y-m-d');
    }

}