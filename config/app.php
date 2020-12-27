<?php

return [
    /**
     * The application name and logo.
     * When logo is set to false the default WikiPeep logo will be shown.
     */
    'name' => 'WikiPeep',
    'logo' => false,

    /**
     * SEO Meta tags - Where meta name is used for title tag,
     * and description for meta tag description.
     */
    'meta_name' => 'A simple markdown wiki for busy devs',
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

