<?php

namespace App\Console\BuildConcerns;

use Symfony\Component\Console\Output\OutputInterface;

trait DatabaseIndex
{
    /**
     * @var boolean
     */
    protected bool $databaseIndexExists = false;

    /**
     * Determine if the database index repository exists on disk.
     * 
     * @return void
     */
    protected function setDatabaseIndexStatement()
    {
        if( $databaseIndex = flywheel()->getDatabaseIndex() ) {
            $this->databaseIndexExists = true;
            $this->databaseIndexData = $databaseIndex;
        }
    }

    /**
     * Wraps multiple operations in one method, by making use of
     * the DatabaseIndex Concern and checking if there are records.
     *
     * If not, it will skip the process and print an info message via terminal.
     *
     * @param  OutputInterface $output
     *
     * @return boolean | Symfony Console Message
     */
    protected function tryConnectDatabaseRepository(OutputInterface $output)
    {
        $this->setDatabaseIndexStatement();
        
        if( ! $this->databaseIndexExists() ) {
            $this->noRecordsFound($output);
            return false;
        }

        return  true;
    }

    /**
     * Retreive the current database index stored in repository
     * by a Flywheel Instance.
     */
    protected function setCurrentIndexLocal()
    {
        $this->storedIndexes = $this->getStoredDatabaseIndex()[0]->indexes;
    }

    /**
     * Return status of database index.
     * 
     * @return boolean
     */
    protected function databaseIndexExists()
    {
        return $this->databaseIndexExists;
    }

    /**
     * Store info about what gets build.
     * 
     * @param  string $cId              The category where article belongs to
     * @param  string $aId              The article slug identifier
     * @param  string $src              The markdown source path
     * @param  string $md_ltm           The markdown last time modified
     * @param  string $bd_lt            The last time of the article build
     * 
     * @return void
     */
    protected function storeInDatabaseIndex($cId, $aId, $src, $md_ltm, $bd_lt, $prevIndex = null)
    {
        $newIndex = [
            'category_id' => $cId,
            'article_id' => $aId,
            'source' => $src,
            'markdown_last_time_modified' => $md_ltm,
            'last_build_date' => $bd_lt,
        ];

        if( $prevIndex ) {
            $this->databaseIndex = json_decode(json_encode($prevIndex), true);
            $this->databaseIndex[$cId][$aId] = $newIndex;
        } else {
            $this->databaseIndex[$cId][$aId] = $newIndex;
        }
    }

    /**
     * Retrieve all articles that have been stored
     * during build runtime in index repository database.
     * 
     * @return array
     */
    protected function getDatabaseIndex()
    {
        return $this->databaseIndex;
    }

    /**
     * Retrieve all data stored in database repository from disk.
     * 
     * @return Flywheel
     */
    protected function getStoredDatabaseIndex()
    {
        return $this->databaseIndexData->query()->execute();
    }

    /**
     * Every latest build will be stored as history.
     * 
     * In this way we can keep a track of what files have been added,
     * what's new in the next build, what is modified.
     *
     * @return  void
     */
    protected function buildDatabaseIndex()
    {
        flywheel()->create([
            'indexes' => $this->getDatabaseIndex()
        ], '___', 'meta', true);
    }


    /**
     * Creating a list with all existing contents that will be used
     * for determining what's new and whats already published.
     * 
     * @return array
     */
    private function createListingExistingContents()
    {
        foreach ($this->storedIndexes as $category => $articles) {
            // var_dump($category);
            foreach ($articles as $articleKey => $article) {
                $this->existingContents[] = $this->getFullPathOf($article->source, $prefixedSlash = true);
            }
        }
    }

    /**
     * Retreive all existing markdown files from the
     * last database index repository, that have been already published before.
     * 
     * @return array
     */
    private function getExistingContents()
    {
        return $this->existingContents;
    }

}