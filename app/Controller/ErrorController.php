<?php

namespace App\Controller;

class ErrorController extends BaseController {

    public function index()
    {   
        // Set default title for current error screen
        $this->meta_title = 'sasa';
        return response($this->layout('404', 'public'), 404);
    }
}