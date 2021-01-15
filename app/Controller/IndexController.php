<?php

namespace App\Controller;

use Exception;

class IndexController extends BaseController {

    public function index()
    {

        $getSvgScreen = app()->config()->get('welcome.empty_screen');
        
        /**
         * Return view with the results
         */
        return response(
                $this->layout('index', 'base', [
                    'title' => 'Thanks for using WikiPeep',
                    'content' => 'The open source Wiki for busy developers. ' . $getSvgScreen
                ])
            );
    }
}