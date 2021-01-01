<?php

namespace App\Console\BuildConcerns;

use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

trait ArticleDetails
{

    /**
     * Determine if the given article needs update, based on
     * the latest modified date and the latest build.
     * 
     * @param  object $storedArticleIndex
     * 
     * @return boolean
     */
    protected function articleNeedsUpdate($currentMdTime, $storedMdTime)
    {
        $currentMdTime = str_replace('.000000', '', $currentMdTime['date']);
        $storedMdTime = str_replace('.000000', '', $storedMdTime->last_build_date->date);

        if ( $currentMdTime > $storedMdTime ) {
            return true;
        }
        
        return false;
    }

    /**
     * Updates an article based its ID via Flywheel
     * 
     * @param  array $articleMeta
     * @param  string $categoryId
     * @param  Symfony\Finder\SplFileInfo $article
     * 
     * @return void
     */
    protected function updateArticleById($articleMeta, $categoryId, SplFileInfo $article, $previouslyIndex)
    {
        $parsedContents = $this->getArticleParsedContents($article);

        // Update the article via Flywheel
        flywheel()->create([
            'title' => $articleMeta['title'],
            'summary' => $parsedContents['summary'] ?? null,
            'article' => serialize($parsedContents['contents']),
        ], $categoryId, $articleMeta['slug']);

        // After updating the article we need to store this change
        // in Database Index so we can keep the track of the updates.
        $this->storeInDatabaseIndex(
            // the public path of the directory/category
            $categoryId,
            
            // the public path of the article (slug)
            $articleMeta['slug'],
            
            // the markdown source path (related to project)
            $this->getMarkdownPath($article->getRealPath()),
            
            // the formatted last time modified date of the markdown
            $this->getLastTimeModifiedFormatted($article->getRealPath()),

            // the date time of the latest build related to the article
            flywheel()->getCreationDateTime(),

            // When available, it will merge the previously index with what
            // was added during the last build.
            $previouslyIndex,
        );
    }

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