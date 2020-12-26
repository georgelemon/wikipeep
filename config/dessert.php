<?php

return [

    /**
     * Set the path where Finder should look for svg libraries
     */
    'resources_directory' => STORAGE_PATH . DS . 'dessert/library',
    
    /**
     * Set the path wheret it should save the output
     */
    'saving_directory' => STORAGE_PATH . DS . 'dessert/collection',


    /**
     * Set default library.
     * Useful when using multiple libraries at the same time
     */
    'default_library' => 'feather',

    /**
     * Define your libraries, paths & default styles.
     *
     * Note that, the key name provided in array
     * must match with the directory of the library.
     *
     * Default styles attributes provided should be a valid CSS syntax
     */
    'libraries' => [
        'feather' => [
            'width' => '14px',
            'height' => '14px',
            'stroke' => 'black',
            'stroke-width' => '1.4',
            'stroke-linecap' => 'round',
            'stroke-linejoin' => 'round',
            'fill' => 'none'
        ]
    ]
];
