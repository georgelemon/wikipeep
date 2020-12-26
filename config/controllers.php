<?php

return [
    /**
     * Auth / Sign up / Confirm / Manage & Delete
     */
    'auth' => App\Controllers\Auth\AuthController::class,

    /**
     * Landing Page for authenticated users
     */
    'index' => App\Controllers\IndexController::class,

    /**
     * Make your feed view
     */
    'update' => App\Controllers\UpdateController::class,

    /**
     * Single page for viewing/reading entries
     */
    'view' => App\Controllers\ArticleController::class,

    /**
     * Global 404
     */
    '404' => App\Controllers\ErrorController::class,
];