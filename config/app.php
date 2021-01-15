<?php

return [
    /**
     * The name of your Lowless Application
     */
    'name' => env('APP_NAME', 'Lowless'),

    /**
     * Set the application URL mainly used for getting assets
     */
    'url' => env('APP_URL'),

    /**
     * The path to your .svg, .png logo.
     */
    'logo' => false,

    /**
     * To be served with or without https protocol
     */
    'https' => env('SSL'),

    /**
     * Setup your timezone.
     * Used by Compiler to add the update time on articles.
     */
    'timezone' => env('TIME_ZONE'),

    /**
     * A valid date format to be displayed at the bottom of your contents.
     * @see https://www.php.net/manual/en/function.date.php
     */
    'date_format' => env('DATE_FORMAT', 'l jS \of F Y h:i:s A'),

    /**
     * Appearance Settings
     */
    'theme_settings' => [
        /**
         * The name of the theme based on its directory name (lowercase).
         * @var string (Default theme is twentytwentyone)
         */
        'name' => 'twentytwentyone'
    ]
];