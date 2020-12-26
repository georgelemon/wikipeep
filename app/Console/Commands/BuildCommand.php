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

    protected function configure()
    {
        $this->setName('app:build')
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
        return Str::slug(str_replace('.md', '', $paths[array_key_last($paths)]));
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

    protected function buildMainMenu()
    {

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
            $output->writeln("<error>Error 😓</error> Looks like there is no markdown in content directory.");
            return 1;
        }

        // Instantiate WikiPeep Parsedown
        $parsedown = new Parsedown;

        // Instantiate Progress Bar that will be displayed in terminal while compiling
        // which also shows the number of total markdown files in queue.
        $this->startLoader($output, $content->count());

        foreach ($content as $key => $value) {

            $parsedown->parseMarkdown($value->getContents());

            $markdownStructure = $this->getIndexStructure($value->getPathName());
            $directoriesUri = $this->getDirectoriesPath($markdownStructure);
            
            // $menuItems[] = [
            //     'label' => 
            //     'uri' => $directoriesUri
            // ];

            // Creating a new JSON file for each iterated article.
            // Where 'summary' represents the contents summary parsed from all anchor urls
            // found in the article content and 'body' is the article content.
            flywheel()->create([
                'summary' => $parsedown->getContentSummary(),
                'article' => serialize($parsedown->getContent()),
            ], $directoriesUri, $this->getArticleName( $markdownStructure ));
            
            // Progress the Console loader for each iteration
            $this->inProgress();
        }

        // Ending the progress bar since we finished to compile the content
        // and everything is stored in flat files.
        $this->finishLoader();
        $output->writeln(PHP_EOL . '<info>Success</info> Content was successfully compiled.');


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
                $menuItems[$settings['menu']['order'] ?? null] = [
                    'label' => $settings['menu']['label'] ?? $directory->getRelativePathname(),
                    'slug' => Str::slug($directory->getRelativePathname()),
                    'icon' => $settings['menu']['icon'] ?? false,
                ];
            }
            
            $this->inProgress();
        }
        
        ksort($menuItems);

        flywheel()->create([
            'navigation' => $menuItems
        ], 'settings', 'navigation');

        $this->finishLoader();
        $output->writeln(PHP_EOL . '<info>Success</info> The navigation menu has been sucessfully built.');
        return 0;
    }

    /**
     * Try retrieve the directory settings when available
     * @return array
     */
    protected function getDirectorySettings($filesystem, $path)
    {
        $settings = $path . DS . '_settings.yaml';
        if( $filesystem->isFile($settings) &&  $filesystem->isReadable($settings) ) {
            try {
                return Yaml::parse($filesystem->get($settings));
            } catch (ParseException $e) {
                throw new Exception($e->getMessage(), 1);
            }
        }
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
