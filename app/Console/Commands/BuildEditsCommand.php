<?php

namespace App\Console\Commands;

use DateTime;
use App\Core\Compiler;
use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;


class BuildEditsCommand extends Command
{

    /**
     * Database Repository Index
     */
    use \App\Console\BuildConcerns\DatabaseIndex;

    /**
     * Symfony\Finder Instance for getting the right files
     */
    use \App\Console\BuildConcerns\FinderInstance;

    /**
     * Various helper methods used while building contents
     */
    use \App\Console\BuildConcerns\Misc;

    /**
     * Make use of File Information
     */
    use \App\Console\BuildConcerns\FileInformation;

    /**
     * Make use of Article methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\ArticleDetails;

    /**
     * Make use of Category methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\CategoryDetails;

    /**
     * Make use of Search methods to retrieve related details 
     */
    use \App\Console\BuildConcerns\SearchDetails;

    /**
     * Make use of Navigation methods
     */
    use \App\Console\BuildConcerns\NavigationDetails;

    /**
     * Loading AsideBox methods in order to store data for
     * showing informational boxes displayed aside (sidebar).
     */
    // use \App\Console\BuildConcerns\AsideBoxDetails;

    use \App\Console\BuildConcerns\ConsoleLoader;

    /**
     * Holds temporary data while in loop
     * @var object | null
     */
    protected $storedIndexes;

    /**
     * Holds an instance of Parsedown
     * @var App\Core\Parsedown
     */
    protected $parsedown;

    /**
     * When updates available it will count how many articles
     * needs to be updated in order to create the Console Loader
     * @var int
     */
    protected static int $countingArticles = 0;

    /**
     * Configuring the cli command for caching everything.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('build:edits')
             ->setDescription("Builds contents only for modified articles that are already published.");
    }

    /**
     * Cache Executer
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setDatabaseIndexStatement();

        // Checking if the meta repository exists
        if( $this->databaseIndexExists() ) {

            // Retrieve the stored index from repository
            $storedIndexes = $this->getStoredDatabaseIndex()[0];

            // Finder gets all the markdowns placed in contents directory
            $contents = $this->finderGetContents();

            // In case there are no results will print an error
            // and guide the dev to use first build:all command
            if( ! $contents->hasResults() ) {
                $this->printErrorNoMarkdownFiles($output);
                return 1;
            }

            $this->parsedown = new Parsedown;

            foreach ($contents as $key => $article) {

                // Retrieve the entire path of the file
                $markdownStructure = $this->getIndexStructure($article->getPathName());
                $ltm = (array) $this->getLastTimeModifiedFormatted($article->getRealPath());
                // Create the structure of directories
                $categoryId = $this->getDirectoriesPath($markdownStructure);
                $this->storedIndexes = $storedIndexes->indexes;


                // Now, check if the category of the current iterated article
                // has been already published previously.
                if( $this->hasPublicCategory($categoryId)) {
                    // Get the name of the article including its slugified version
                    $articleMeta = $this->getArticleName( $markdownStructure );
                    $articleSlug = $articleMeta['slug'];
                    // $articleTitle = $articleMeta['title'];

                    $itsCategory = $this->storedIndexes->$categoryId;

                        foreach ($itsCategory as $aKey => $storedArticleIndex) {

                            if( $storedArticleIndex->article_id === $articleSlug ) {
                                // Determine if the article needs to be updated
                                if( $this->articleNeedsUpdate($ltm, $storedArticleIndex) ) {
                                    echo 'YES: ' . $categoryId . ' @ ' . $articleSlug . PHP_EOL;
                                    $this->updateArticleById($articleMeta, $categoryId, $article);
                                    static::$countingArticles++;
                                    break;
                                } else {
                                    // echo 'NO: ' . $categoryId . ' @ ' . $articleSlug . PHP_EOL;
                                    break;
                                }
                            }
                        }
                }
            }

            if( static::$countingArticles === 0 ) {
                $this->printInfoNoUpdatesAvailable($output);
                return 1;
            } else {
                // Create the Flywheel Database Repository Index that tracks all articles and categories.
                // 
                // This comes as a requirement for making builds for a specific types of content:
                // 1. artisan build:new         Will build only new contents without touching existing ones
                // 2. artisan build:edits       Will rebuild only published contents that needs update
                // 3. artisan build:all         Builds everything, no matter what.
                $this->buildDatabaseIndex();
            }

            return 0;

        // Print error in case there are no records found related to edits and published
        } else {
            $output->writeln($this->addBreakline(1) . "<error>😓 No records found related to published articles.</error>");
            $output->writeln("<info>Use artisan build:new to build your first contents.</info>" . $this->addBreakline(1));
            return 1;
        }
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
    protected function updateArticleById($articleMeta, $categoryId, SplFileInfo $article)
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
            flywheel()->getCreationDateTime()
        );
    }

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
        $currentMdTime = $currentMdTime['date'];
        $storedMdTime = $storedMdTime->last_build_date->date;

        if ( $currentMdTime > $storedMdTime ) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine if the given category is already published on public.
     * 
     * @param  string  $categoryId
     * 
     * @return boolean
     */
    protected function hasPublicCategory($categoryId)
    {
        return isset($this->storedIndexes->$categoryId);
    }

    /**
     * Symfony Console Error that gets printed when
     * there are no markdown files in /content/ directory
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printErrorNoMarkdownFiles($output)
    {
        $output->writeln($this->addBreakline(1) . "<error>Something Wrong 😵 Finder couldn't find any contents.</error>");
        $output->writeln("<info>Write your markdown contents inside content directory.</info>" . $this->addBreakline(1));
    }

    /**
     * Symfony Console info message that gets printed when
     * there are no available updates on articles.
     * 
     * @param  OutputInterface $output
     * 
     * @return void
     */
    private function printInfoNoUpdatesAvailable($output)
    {
        $output->writeln($this->addBreakline(1) . "<error>There are no edits available 👌</error>");
        $output->writeln("<info>None of the articles have been edited so far.</info>" . $this->addBreakline(1));   
    }

}