<?php

namespace App\Controller;

use Exception;

class IndexController extends BaseController {

    public function index()
    {

        $getSvgScreen = app()->config()->get('welcome.empty_screen');
        
        return response($this->layout('index', 'base', [
                    'title' => 'Thanks for using WikiPeep',
                    'content' => 'OpenSource Wiki for Busy Devs. ' . $getSvgScreen
                ])
            );
    }
}