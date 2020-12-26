<?php

$get = app()->config()->get('controllers');

/**
 * Landing page
 */
route()->get('/', $get['index'] . '@index');

route()->get('([a-z-A-Z0-9_-]+)/([a-z-A-Z0-9_-]+)', 'App\Controllers\ArticleController@index');

// 404 Route Handler
route()->set404($get['404'] . '@index');