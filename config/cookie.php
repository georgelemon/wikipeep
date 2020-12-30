<?php

return [

    /**
     * When set false, it will completely disable the light/dark theme switcher,
     * and all javascript related to cookie will not be loaded anymore.
     *
     * If you want to disable this functionality but in the same time
     * you want to use the dark theme instead of light you can simply
     * add the CSS class 'theme-light' to the <body> element.
     */
    'enabled' => true,
    
    'settings' => [
        'secure' => true,   // Available only for https
        'expires' => 7,     // Expiration time (in days)
        'path' => '/'       // The cookie path
    ],
    
    /**
     * Set a kindly disclaimer when using cookies.
     * This message will be always visible in footer without disturbing the reader.
     */
    'disclaimer' => "Hey, we're using cookies to ensure you get the best experience while reading the documentation<br>WikiPeep does not have any kind of analytics tracking in background. :)",

];