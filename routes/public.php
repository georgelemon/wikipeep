<?php

$api = config()->get('api');

/**
 * Landing screen
 */
route()->get('/', 'App\Controllers\IndexController@index');

/**
 * API Endpoint for getting the Search Results.
 * For customizing endpoints go to app/config/api.php
 */
route()->get($api['base'] . DS . $api['search'], 'App\Controllers\Api\EndpointSearchController@get');

/**
 * The Category screen that can act with two different functionalities,
 * 1. Returning the index.md content from inside the category, in case exist
 * 2. Otherwise, it will create an auto screen with the index of all pages inside of it.
 */
route()->get('([a-z-A-Z0-9_-]+)', 'App\Controllers\CategoryController@index');
route()->get('([a-z-A-Z0-9_-]+)/page/([0-9])', 'App\Controllers\CategoryController@pagination');

/**
 * The Article screen
 */
route()->get('([a-z-A-Z0-9_-]+)/([a-z-A-Z0-9_-]+)', 'App\Controllers\ArticleController@index');

/**
 * 404 Error Handler
 */
route()->set404('App\Controllers\ErrorController@index');