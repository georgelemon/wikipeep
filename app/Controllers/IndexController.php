<?php

namespace App\Controllers;

use Exception;

class IndexController extends BaseController {

    public function index()
    {
        /**
         * Return view with the results
         */
        return $this->layout('home', 'base');
    }
}