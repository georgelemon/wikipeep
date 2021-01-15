<?php

namespace App\Controller;

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

        // When the category has a specific article set as index,
        // we need to prevent accessing the specific article from being
        // accessed as standalone. So, instead of redirect, or access that, it will throw a 404
        if( $articleId === $directory ) {
            return response($this->layout('404', 'base'), 404);
        }

        // Try retrieve the article based on the ID provided from Request
        if( $this->article = flywheel()->getById($articleId, $directory)) {
            return response($this->layout('article-screen', 'base', $this->article));
        }

        return response($this->layout('404', 'base'), 404);
    }

    protected function getPublishedDate()
    {
        return get_formatted_date($this->article['__update']->date, 'Y-m-d H:i:s.u', 'Y-m-d');
    }

}