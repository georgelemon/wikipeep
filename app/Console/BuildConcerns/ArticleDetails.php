<?php

namespace App\Console\BuildConcerns;

use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

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
     * Retrieve the parsed markdown article contents.
     * 
     * @return string
     */
    protected function getArticleParsedContents(SplFileInfo $finderInstance)
    {
        $this->parsedown->parseMarkdown($finderInstance->getContents());
        
        return [
            'summary' => $this->parsedown->getContentSummary(),
            'contents' => $this->parsedown->getContent()
        ];
    }

    /**
     * Retrieve the structure of the markdown file, based on its directories.
     * 
     * @param  string $path
     * 
     * @return array
     */
    protected function getIndexStructure($path)
    {
        $paths = explode('/', str_replace(CONTENT_PATH, '', $path));
        
        if( $paths[0] === '' ) array_shift($paths);

        return $paths;
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