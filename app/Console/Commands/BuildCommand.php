<?php

namespace App\Console\Commands;

use App\Core\Compiler;
use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
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
     * Configuring the cli command.
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('build:all')
             ->setDescription("Builds the content of the application based on provided markdown.");
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
     * Return directories structure path based on the markdown path.
     * 
     * @param  array $paths
     * 
     * @return string
     */
    protected function getDirectoriesPath($paths)
    {
        array_pop($paths);
        return Str::slug(implode('/', $paths));
    }

    /**
     * Retrieve a Finder instance with Markdown results
     * @return Finder
     */
    protected function finderGetResults($searchIn, $fileType, $searchType = 'files', $level = null)
    {
        return $this->compiler->finder($searchIn, $fileType, $searchType, $level);
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
     * Creates a meta heading for the current
     * category screen based on given _settings.yaml.
     *
     * @param  $key                     The category slug identifier
     * @param  array|null $heading      The category heading contents
     * 
     * @return void
     */
    protected function categorySettingsView($key, $settings)
    {
        flywheel()->create([
            'heading' => $settings['heading'] ?? null,
        ], $key, '__settings', false);
    }

    /**
     * Stores directories in order to create the main navigation menu
     * 
     * @param  string  $key             When available, is used for ordering the array
     * @param  string  $label           The name of the page, based on dir name, or by _settings.yaml
     * @param  string  $slug            The URI of the page
     * @param  string  $icon            When provided, prepends an SVG icon
     * @param  array|null $separator    When available it can add a visual separator before/after the item
     * 
     * @return  void
     */
    protected function storeInNavigation($key, $label, $slug, $icon, $separator = null)
    {
        $this->menuItems[$key] = [
            'label' => $label,
            'slug' => $slug,
            'icon' => $icon,
            'separator' => $separator
        ];
    }

    /**
     * Store articles as sub items in the main navigation menu
     * 
     * @param  [type] $parentKey [description]
     * @param  [type] $label     [description]
     * @param  [type] $slug      [description]
     * 
     * @return [type]            [description]
     */
    protected function storeInNavigationSubItems($parentKey, $slug, $label)
    {
        $this->menuSubItems[$parentKey] [] = [
            'label' => $label,
            'slug' => $slug
        ];
    }

    /**
     * Retrieve already stored and sorted items for navigation menu.
     * 
     * @return  array
     */
    protected function getNavigationItems()
    {
        ksort($this->menuItems); // Sort the items based on their specified order
        return $this->menuItems;
    }

    /**
     * Retrieve stored navigation sub items.
     * 
     * @return array
     */
    protected function getNavigationSubItems($parent)
    {
        return $this->menuSubItems[$parent] ?? null;
    }

    /**
     * Retrieve meta headgins of a specific category/directory screen.
     * 
     * @param  string $key          The category slug identifier
     * 
     * @return array|null
     */
    protected function getMetaHeadingByKey($key)
    {
        return $this->categoryHeadingMeta[$key] ?? null;
    }

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

    /**
     * Add a specific numbers of breaklines using PHP_EOL
     */
    protected function addBreakline($counts)
    {
        $breaks = '';
        for ($i=0; $i < $counts; $i++) { 
            $breaks .= PHP_EOL;
        }

        return $breaks;
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

        $this->compiler = new Compiler;
        $content = $this->finderGetResults(CONTENT_PATH, 'md');

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

        // var_dump($this->getNavigationSubItems('getting-started'));
        // die;

        // Ending the progress bar since we finished to compile the content
        // and everything is stored in flat files.
        $this->finishLoader();
        $output->writeln($this->addBreakline(1) . '<info>Success</info> Content was successfully compiled.');
        $output->writeln($this->addBreakline(1));

        // Now we have to build/rebuild the main menu of application.
        // This process is made based on the main directories found in content directory.
        // Each root directory can have specific '__settings.yaml' inside that can
        // influence the way will be displayed in menu or its appearance.
        // $output->writeln('<comment>Wait...</comment>  Next we\'re going to build the main navigation menu...');

        $directories = $this->finderGetResults(CONTENT_PATH, null, 'directories', '< 5');
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
                // Like Heading meta data (for showing a headline/lead while on page),
                // Custom button links to be displayed on top/bottom and so on.
                if( isset($settings['settings'])) {
                    $this->categorySettingsView($slug, $settings['settings']);
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
        $filesystem->put(STORAGE_PATH . '/search-results.json', json_encode($this->getSearchIndex()));

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
     * Try retrieve the directory settings when available.
     * 
     * @param  Filesystem  $filesystem
     * @param  string  $path
     * 
     * @return array
     * @throws ParseException
     */
    protected function getDirectorySettings($filesystem, $path)
    {
        $settings = $path . DS . '_settings.yaml';
        if( $filesystem->isFile($settings) &&  $filesystem->isReadable($settings) ) {
            try {
                return Yaml::parse($filesystem->get($settings));
            } catch (ParseException $e) {
                throw new ParseException($e->getMessage());
            }
        }
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

    /**
     * Start the console progress bar
     * 
     * @param  [type] $output [description]
     * @param  [type] $count  [description]
     * 
     * @return [type]         [description]
     */
    protected function startLoader($output, $count)
    {
        $this->progressBar = new ProgressBar($output, $count);
        $this->progressBar->start();
    }

    /**
     * A progress bar advancer, by default with 1
     * 
     * @param  integer $step
     * 
     * @return void
     */
    protected function inProgress($step = 1)
    {
        $this->progressBar->advance($step);
    }

    /**
     * Finish the current progress bar
     * @return void
     */
    protected function finishLoader()
    {
        $this->progressBar->finish();
    }
}
