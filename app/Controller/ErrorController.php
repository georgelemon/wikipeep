<?php

namespace App\Controller;

class ErrorController extends BaseController {

    public function index()
    {   
        return $this->layout('404', 'base');
    }
}