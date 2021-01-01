<?php

namespace App\Console\BuildConcerns;

use DateTime, DateTimeZone;

trait FileInformation
{

    /**
     * Retrieve the inside path of the Markdown file.
     * @return string
     */
    protected function getMarkdownPath($path)
    {
        return explode('/content/', $path)[1];
    }

    /**
     * Determine if the current Markdown has been already published before,
     * so it can be updated in case there are any modifications.
     * 
     * @return boolean
     */
    protected function getLastTimeModifiedFormatted($path)
    {
        $ltm = $this->getLastTimeModified($path);

        // Create an UNIX format of the provided date
        $ltm = $this->formatDateTime($ltm);

        // Set the timezone according to application
        // timezone configuration to we can avoid the time differences.
        return $ltm->setTimezone($this->getApplicationTimezone());
    }

    /**
     * Create an Unix format of the date based on application time zone.
     * @return string
     */
    protected function formatDateTime($ltm)
    {
        return DateTime::createFromFormat("U", $ltm);
    }

    /**
     * Retrieve the time zone of the application.
     * 
     * @return string
     */
    protected function getApplicationTimezone()
    {
        return new DateTimeZone(config()->get('app.timezone'));
    }

    /**
     * Retrieve the last time modified date of a json file.
     * 
     * @param  string $file
     * @return  string
     */
    protected function getLastTimeModified($file)
    {
        return app()->filesystem()->lastModified($file);
    }

}