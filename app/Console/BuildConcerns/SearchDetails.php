<?php

namespace App\Console\BuildConcerns;

use DateTime;

trait SearchDetails
{
    /**
     * @var string
     */
    protected $searchIndexUpdateTime;

    /**
     * Retreive the search index used for creating the search results.
     * 
     * @return array
     */
    protected function getSearchIndex()
    {
        return $this->searchIndex;
    }

    /**
     * Updates the search results repository via Flywheel.
     * 
     * @return [type] [description]
     */
    protected function updateSearchResultsEndpoint()
    {
        $getDate = flywheel()->create([
            'results' => $this->getSearchIndex()
        ], '__search', '__search-results', true, true)->getCreationDateTime();

        $previousVersion = glob(STORAGE_PATH . '/__search--version--*');
        if( $previousVersion ) {
            unlink($previousVersion[0]);
        }

        $searchUpdateTime = DateTime::createFromFormat(config()->get('app.date_format'), $getDate);
        $searchVersionFileName = sprintf('__search--version--%s', $searchUpdateTime->format('Ymdis'));
        file_put_contents(STORAGE_PATH . '/' . $searchVersionFileName, '');
    }

    /**
     * Stores relevant data for creating the search index.
     * 
     * @return void
     */
    protected function storeInSearchIndex($title, $slug, $excerpt = '')
    {
        $this->searchIndex[] = [
            'title' => $title,
            'excerpt' => $excerpt,
            'slug' => $slug
        ];
    }

    /**
     * Mark the latest search update so it can communicate
     * on front-end with the search functionality and IndexedDB feature
     * in order to update the search results database from user's browser.
     */
    protected function getLatestSearchUpdate()
    {
        return $this->searchIndexUpdateTime;
    }
    
}