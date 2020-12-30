<?php

/**
 * Category settings that applies for all categories.
 */
return [
    /**
     * Creates pagination at the bottom of category screen based on you input.
     * For unlimited items listing without pagination leave 0.
     * 
     * @var integer
     */
    'per_page' => 2,

    /**
     * The pagination links are based on this specific base_url.
     * Default is 'page' so your paginated links will look like /nice-category/page/7
     * 
     * @var  string
     */
    'base_url' => 'page'
];