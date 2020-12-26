<?php

namespace App\Console\Commands;

use App\Core\Compiler;
use App\Core\Parsedown\Parsedown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Str;

class BuildCommand extends Command
{
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $compiler = new Compiler;
        $content = $compiler->finder(CONTENT_PATH, 'md');

        if( $content->hasResults() === false ) {
            $output->writeln("<error>😓 Error</error> Looks like there is no markdown in content directory.");
            return 1;
        }

        // Instantiate Parsedown 
        $parsedown = new Parsedown;

        // Instantiate Progress Bar that will be displayed in terminal while compiling
        // which also shows the number of total markdown files in queue.
        $progressBar = new ProgressBar($output, $content->count());
        $progressBar->start();

        foreach ($content as $key => $value) {

            $parsedown->parseMarkdown($value->getContents());

            $markdownStructure = $this->getIndexStructure($value->getPathName());
            $directoriesUri = $this->getDirectoriesPath($markdownStructure);

            flywheel()->create([
                'summary' => $parsedown->getContentSummary(),
                'article' => serialize($parsedown->getContent()),
            ], $directoriesUri, $this->getArticleName( $markdownStructure ));
            
            $progressBar->advance(1);
        }

        // Ending the progress bar since we finished to compile the content
        // and everything is stored in flat files.
        $progressBar->finish();

        $output->writeln(PHP_EOL . '<info>😎 Success</info> Content was successfully compiled.');
        return 0;

        // $output->writeln("<error>😓 Error</error> There was an error while compiling the content.");
        // return 1;
    }
}
