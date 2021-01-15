<?php

namespace App\Console\Commands;

use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class BuildCommand extends Command
{

    /**
     * @var Finder Instance
     */
    protected $compiler;

    /**
     * @var array
     */
    protected array $searchIndex = [];

    /**
     * @var array
     */
    // protected array $categoryHeadingMeta = [];

    /**
     * @var array
     */
    protected array $menuItems = [];

    /**
     * @var array
     */
    protected array $menuSubItems = [];

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
     * Make use of File Information data
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
     * Configuring the cli command.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('publish:all')
             ->setDescription("Builds the content of the application based on provided markdown.");
    }

    /**
     * The Builder Executer
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Setting the repository database statement
        // so we can easily track things.
        $this->setDatabaseIndexStatement();

        $this->compiler = new Compiler;

        if( $this->databaseIndexExists() ) {
            $content = $this->finderGetContents();
        } else {
            $content = $this->finderGetContents();
        }

        // Skip the process in case finder fails in finding any markdown files
        if( $content->hasResults() === false ) {
            $output->writeln($this->addBreakline(2) . "<error>Error 😓</error> Looks like there is no markdown in content directory.");
            return 1;
        }

        // Instantiate WikiPeep Parsedown
        $parsedown = new Parsedown;

        // Instantiate Progress Bar that will be displayed in terminal while compiling
        // which also shows the number of total markdown files in queue.
        $output->writeln($this->addBreakline(1));
        $this->startLoader($output, $content->count());

        foreach ($content as $key => $value) {

            // Parsing the Markdown file contents
            $parsedown->parseMarkdown($value->getContents());

            // Retrieve the entire path of the file
            $markdownStructure = $this->getIndexStructure($value->getPathName());

            // Create the structure of directories
            $directoriesUri = $this->getDirectoriesPath($markdownStructure);

            // Get the name of the article including its slugified version
            $articleMeta = $this->getArticleName( $markdownStructure );
            $articleSlug = $articleMeta['slug'];
            $articleTitle = $articleMeta['title'];

            // Getting contents summary and the full content of the article
            $contentSummary = $parsedown->getContentSummary();
            $contentArticle = $parsedown->getContent();

            // Try retrieve an excerpt of the article
            $excerpt = $this->getExcerpt($contentArticle);

            // Creating a new JSON file for each iterated article.
            // Where 'summary' represents the contents summary parsed from all anchor urls
            // found in the article content and 'body' is the article content.
            flywheel()->create([
                'title' => $articleTitle,
                'summary' => $contentSummary,
                'article' => serialize($contentArticle),
            ], $directoriesUri, $articleSlug);

            $this->storeInDatabaseIndex(
                // the public path of the directory/category
                $directoriesUri,
                
                // the public path of the article (slug)
                $articleSlug,
                
                // the markdown source path (related to project)
                $this->getMarkdownPath($value->getRealPath()),
                
                // the formatted last time modified date of the markdown
                $this->getLastTimeModifiedFormatted($value->getRealPath()),

                // the date time of the latest build related to the article
                flywheel()->getCreationDateTime(),
            );

            // Get the Article URI. In case the Article is saved as index.md
            // it will be served as a root page of its directory.
            $articleUri = $articleSlug === 'index' ? '' : $articleSlug;

            // Collecting info and creating the index for search results
            if( $contentSummary ) {

                foreach ($contentSummary as $section) {
                    // Creating the final URI that may include anchor link
                    $_anchor = $section['anchor'] ? '#' . $section['anchor'] : '';
                    $uri = $directoriesUri . $articleUri . $_anchor;

                    $this->storeInSearchIndex($articleTitle, $uri, $excerpt[1]);
                }

            } else {
                $uri = $directoriesUri  . DS . $articleUri;
                $this->storeInSearchIndex($articleTitle, $uri, $excerpt[1] ?? '');
            }


            // Store the article as subitem to navigation menu
            $this->storeInNavigationSubItems(
                $directoriesUri,
                $articleSlug === 'index' ? $directoriesUri : $articleSlug,
                $articleTitle
            );

            // Progress the Console loader for each iteration
            $this->inProgress();
        }

        // Ending the progress bar since we finished to compile the content
        // and everything is stored in flat files.
        $this->finishLoader();
        $output->writeln($this->addBreakline(1) . '<info>Success</info> Content was successfully compiled.');
        $output->writeln($this->addBreakline(1));

        // Create the Flywheel Database Repository Index that tracks all articles and categories.
        // 
        // This comes as a requirement for making builds for a specific types of content:
        // 1. artisan build:new         Will build only new contents without touching existing ones
        // 2. artisan build:edits       Will rebuild only published contents that needs update
        // 3. artisan build:all         Builds everything, no matter what.
        $this->buildDatabaseIndex();

        // Now we have to build/rebuild the main menu of application.
        // This process is made based on the main directories found in content directory.
        // Each root directory can have specific '__settings.yaml' inside that can
        // influence the way will be displayed in menu or its appearance.
        // $output->writeln('<comment>Wait...</comment>  Next we\'re going to build the main navigation menu...');

        $directories = $this->finderGetDirectories('< 5');
        $this->startLoader($output, $directories->count());
        $filesystem = new Filesystem;

        foreach ($directories as $directory) {
            
            // Checks if the current directory has specific settings declared
            if( $settings = $this->getDirectorySettings($filesystem, $directory->getRealPath()) ) {

                $label = $settings['menu']['label'] ?? $directory->getRelativePathname();

                // Checking if the current directory contains anything
                // related to the helper box so it can be parsed
                // and displayed on the main aside bar.
                if( isset($settings['aside_box']) && is_array($settings['aside_box']) ) {
                    $this->getAsideBox($settings['aside_box'], $label);
                }

                $directorySlug = Str::slug($directory->getRelativePathname());

                // Checking if there should be an external uri instead of the url
                // of the directory. When provided it will replace the default.
                $external = false;
                if( isset($settings['menu']['redirect']) ) {
                    $external = true;
                }
                $slug = $settings['menu']['redirect'] ?? $directorySlug;
                $icon = $settings['menu']['icon'] ?? null;

                // Collecting items that will be displayed
                // under the main navigation menu.
                $menuItems[$settings['menu']['order'] ?? null] = [
                    'label' => $label,
                    'slug' => $slug,
                    'icon' => $settings['menu']['icon'] ?? false,
                ];
                
                // Store it in navigation menu
                $this->storeInNavigation($settings['menu']['order'] ?? null, $label, $slug, $icon, $settings['menu']['separator'] ?? null);

                // When provided, creates specific settings
                // based on some keys that can be placed in _settings.yaml of the category.
                // 
                // Like Heading meta data (for showing a headline/lead while on page),
                // Custom button links to be displayed on top/bottom and so on.
                if( ! $external ) {
                    $specificIndex = isset($settings['index']) ? Str::slug($settings['index']) : null;
                    $specificSettings = isset($settings['settings']) ?? null;
                    $this->categorySettingsView($slug, $specificSettings, $specificIndex);
                }

                // Store it in search index
                $this->storeInSearchIndex($label, $directorySlug);
            }
            
            $this->inProgress(); // progress for each iteration
        }
    
        // This is a temporary fix to create search results.
        // 
        // @TODO In a normal world we'll have to create
        // an API Endpoint that gets content from source at every build.
        // 
        // At the same time, there will be an IndexedDB in user's browser
        // that will be served first and updated when needs a refresh.
        // $filesystem->put(STORAGE_PATH . '/search-results.json', json_encode($this->getSearchIndex()));
        $this->updateSearchResultsEndpoint();

        // Create a flat file JSON via Flywheel with all menu items found
        flywheel()->create([
            'navigation' => $this->getNavigationItems()
        ], 'settings', 'navigation');

        $this->finishLoader(); // Finish the console loader 

        $output->writeln($this->addBreakline(1) . '<info>Success</info> The navigation menu has been sucessfully built.');
        $output->writeln($this->addBreakline(1));

        return 0;
    }

    /**
     * When provided in settings.yaml, will show a note box in the main aside.
     * This will be visible on all articles that stays under the specific category.
     *
     * @param  $asideBox
     * 
     * @return [type] [description]
     */
    protected function getAsideBox(array $asideBox, $directoryName)
    {
        $label = $asideBox['label'] ?? null;
        $message = $asideBox['message'] ?? null;

        if( $label === null && $message === null ) {
            return false;
        }

        // Create a flat file JSON via Flywheel with all menu items found
        flywheel()->create([
            'label' => $label,
            'message' => $message,
            'color' => $asideBox['color'] ?? 'beige'
        ], Str::slug($directoryName), 'asidebox');
    }

}
