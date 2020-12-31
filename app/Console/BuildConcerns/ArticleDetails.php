<?php

namespace App\Console\BuildConcerns;

use Illuminate\Support\Str;

trait ArticleDetails
{

    /**
     * Create the name of the article based on markdown file.
     * It will slugify the name to lowercase with - separator.
     * 
     * @param  array $paths        The full path converted in array
     * 
     * @return string
     */
    protected function getArticleName($paths)
    {
        $title = str_replace('.md', '', $paths[array_key_last($paths)]);
        return ['title' => $title, 'slug' => Str::slug($title)];
    }


    /**
     * While iterating it will try to retrieve a portion from
     * the first paragraph of the article in order to add an excerpt
     * to search index for showing in search results.
     *
     * @param  string $contentArticle
     * 
     * @return 
     */
    protected function getExcerpt($contentArticle)
    {
        $excerpt = strip_tags($contentArticle);
        return explode(PHP_EOL, $excerpt);
    }

}