<?php

namespace App\Console\BuildConcerns;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Illuminate\Support\Str;

trait CategoryDetails
{
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

}