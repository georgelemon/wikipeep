<?php

namespace App\Controllers;

use Exception;

class ArticleController extends BaseController {

    public function index()
    {

        $directory = str_replace('@', '', strip_tags(request()->segment(1)));
        $articleId = strip_tags(request()->segment(2));

        // Try retrieve the article based on the ID provided from Request
        if( $article = flywheel()->getById($articleId, $directory)) {
            return $this->layout('home', 'base', [
                'content' => $article['content'], 'summary' => $article['summary']
            ]);
        }

        return $this->layout('404', 'base');
    }
}