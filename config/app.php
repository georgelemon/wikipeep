<?php

return [
    /**
     * The application name and logo.
     * When logo is set to false the default WikiPeep logo will be shown.
     */
    'name' => 'WikiPeep.',
    /**
     * In order to display it correctly,
     * the given path must be a public path to a svg/png file of your logo.
     * If you don't want to use a graphic logo, just leave it false
     */
    'logo' => false,

    /**
     * Setup your timezone.
     * Used by Compiler to add the update time on articles.
     */
    'timezone' => 'Europe/Bucharest',

    /**
     * A valid date format.
     * @see https://www.php.net/manual/en/function.date.php
     */
    'date_format' => 'l jS \of F Y h:i:s A',

    /**
     * SEO Meta tags - Where meta name is used for title tag,
     * and description for meta tag description.
     */
    'meta_name' => 'An Open Source Wiki for Busy Developers',
    'meta_description' => false,
    'meta_image' => false,

    /**
     * Appearance Settings
     */
    'theme_settings' => [
        /**
         * The name of the theme based on its directory name (lowercase).
         * @var string (Default theme is twentytwentyone)
         */
        'name' => 'twentytwentyone',
        
        /**
         * When is set true, it will try to look for the theme switcher
         * functionality in order to make the theme switchable (light/dark).
         * @var boolean
         */
        'switch_mode' => true
    ],

    /**
     * When set true, it will shows default WikiKeep copyright note.
     * Otherwise it will try to use the application_copyright text when available
     */
    'copyright' => true,
    'application_copyright' => null
];

