<?php

namespace App\Console\BuildConcerns;

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
    protected function storeInDatabaseIndex($cId, $aId, $src, $md_ltm, $bd_lt)
    {
        $this->databaseIndex[$cId] [] = [
            'category_id' => $cId,
            'article_id' => $aId,
            'source' => $src,
            'markdown_last_time_modified' => $md_ltm,
            'last_build_date' => $bd_lt
        ];
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

}